<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::with('parent', 'children')
            ->topLevel()
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get();

        // Get all pages flat for sidebar count
        $allPages = Page::all();
        $stats = [
            'total' => $allPages->count(),
            'published' => $allPages->where('is_published', true)->filter(fn($p) => $p->isLive())->count(),
            'scheduled' => $allPages->filter(fn($p) => $p->isScheduled())->count(),
            'drafts' => $allPages->where('is_published', false)->count(),
        ];

        return view('staff.pages.index', compact('pages', 'stats'));
    }

    public function create()
    {
        $parentPages = Page::topLevel()->orderBy('title')->get();
        return view('staff.pages.create', compact('parentPages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:pages',
            'content' => 'nullable|string',
            'meta_description' => 'nullable|string|max:255',
            'featured_image' => 'nullable|image|max:2048',
            'is_published' => 'sometimes|boolean',
            'publish_at' => 'nullable|date',
            'parent_id' => 'nullable|exists:pages,id',
        ]);

        $validated['is_published'] = $request->boolean('is_published');

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }
        $validated['slug'] = Str::slug($validated['slug']);

        // Make slug unique if it already exists
        $originalSlug = $validated['slug'];
        $counter = 1;
        while (Page::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('pages', 'public');
        }

        // Handle scheduled publishing
        if (!empty($validated['publish_at'])) {
            $validated['publish_at'] = Carbon::parse($validated['publish_at']);
        }

        // Set sort order
        $validated['sort_order'] = Page::where('parent_id', $validated['parent_id'] ?? null)->max('sort_order') + 1;

        $page = Page::create($validated);

        // Auto-create menu item if requested
        if ($request->boolean('add_to_menu')) {
            Menu::create([
                'label' => $page->title,
                'url' => route('pages.show', $page->slug, false),
                'link_type' => 'internal',
                'order' => Menu::max('order') + 1,
                'is_visible' => true,
                'target' => '_self'
            ]);
        }

        return redirect()->route('staff.pages.index')->with('success', 'Page created successfully.');
    }

    public function edit(Page $page)
    {
        $parentPages = Page::topLevel()
            ->where('id', '!=', $page->id)
            ->orderBy('title')
            ->get();
        return view('staff.pages.edit', compact('page', 'parentPages'));
    }

    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:pages,slug,' . $page->id,
            'content' => 'nullable|string',
            'meta_description' => 'nullable|string|max:255',
            'featured_image' => 'nullable|image|max:2048',
            'is_published' => 'sometimes|boolean',
            'publish_at' => 'nullable|date',
            'parent_id' => 'nullable|exists:pages,id',
        ]);

        $validated['is_published'] = $request->boolean('is_published');

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }
        $validated['slug'] = Str::slug($validated['slug']);

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($page->featured_image) {
                Storage::disk('public')->delete($page->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('pages', 'public');
        }

        // Handle featured image removal
        if ($request->input('remove_featured_image') == '1') {
            if ($page->featured_image) {
                Storage::disk('public')->delete($page->featured_image);
                $validated['featured_image'] = null;
            }
        }

        // Handle scheduled publishing
        if (!empty($validated['publish_at'])) {
            $validated['publish_at'] = Carbon::parse($validated['publish_at']);
        } else {
            $validated['publish_at'] = null;
        }

        // Prevent page from being its own parent
        if (isset($validated['parent_id']) && $validated['parent_id'] == $page->id) {
            $validated['parent_id'] = null;
        }

        $page->update($validated);

        return redirect()->route('staff.pages.index')->with('success', 'Page updated successfully.');
    }

    public function destroy(Page $page)
    {
        // Move children to parent level
        Page::where('parent_id', $page->id)->update(['parent_id' => $page->parent_id]);

        // Delete featured image
        if ($page->featured_image) {
            Storage::disk('public')->delete($page->featured_image);
        }

        $page->delete();
        return redirect()->route('staff.pages.index')->with('success', 'Page deleted successfully.');
    }

    /**
     * Public page view
     */
    public function show(Page $page)
    {
        // Check if page is viewable
        $canView = $page->isLive() || (auth()->check() && in_array(auth()->user()->role, ['librarian', 'staff']));

        if (!$canView) {
            abort(404);
        }

        return view('pages.show', compact('page'));
    }

    /**
     * Preview page (for staff/librarian)
     */
    public function preview(Page $page)
    {
        return view('pages.preview', compact('page'));
    }

    /**
     * Reorder pages via AJAX
     */
    public function reorder(Request $request)
    {
        $ids = $request->input('ids');
        if (is_array($ids)) {
            foreach ($ids as $index => $id) {
                Page::where('id', $id)->update(['sort_order' => $index]);
            }
        }
        return response()->json(['status' => 'success']);
    }

    /**
     * Upload image for WYSIWYG editor
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|max:5120', // 5MB max
        ]);

        $path = $request->file('file')->store('page-images', 'public');

        return response()->json([
            'location' => asset('storage/' . $path)
        ]);
    }
}
