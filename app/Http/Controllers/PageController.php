<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::latest()->get();
        return view('staff.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('staff.pages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:pages',
            'content' => 'nullable|string',
            'is_published' => 'boolean',
        ]);

        // Checkbox handling hack if needed, but validation handles it if not present?
        // Actually, $request->boolean('is_published') is better.
        $validated['is_published'] = $request->boolean('is_published');

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $validated['slug'] = Str::slug($validated['slug']); // Ensure slug format

        Page::create($validated);

        return redirect()->route('staff.pages.index')->with('success', 'Page created successfully.');
    }

    public function edit(Page $page)
    {
        return view('staff.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:pages,slug,' . $page->id,
            'content' => 'nullable|string',
            'is_published' => 'sometimes|boolean',
        ]);

        $validated['is_published'] = $request->boolean('is_published');

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }
        $validated['slug'] = Str::slug($validated['slug']);

        $page->update($validated);

        return redirect()->route('staff.pages.index')->with('success', 'Page updated successfully.');
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()->route('staff.pages.index')->with('success', 'Page deleted successfully.');
    }

    public function show(Page $page)
    {
        if (!$page->is_published && !auth()->check()) {
            abort(404);
        }
        return view('pages.show', compact('page'));
    }
}
