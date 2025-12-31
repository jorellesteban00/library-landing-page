<?php

namespace App\Http\Controllers;

use App\Models\NewsItem;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(Request $request): View
    {
        $query = NewsItem::latest();

        if ($request->has('search') && $request->search != '') {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $newsItems = $query->get();
        return view('staff.news.index', compact('newsItems'));
    }

    public function create(): View
    {
        return view('staff.news.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'published_date' => 'nullable|date',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('news', 'public');
        }

        $validated['user_id'] = $request->user()->id;
        NewsItem::create($validated);

        return redirect()->route('staff.news.index')->with('status', 'News added successfully!');
    }

    public function edit(NewsItem $news): View
    {
        return view('staff.news.edit', compact('news'));
    }

    public function update(Request $request, NewsItem $news): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'published_date' => 'nullable|date',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('news', 'public');
        }

        $news->update($validated);

        return redirect()->route('staff.news.index')->with('status', 'News updated successfully!');
    }

    public function destroy(NewsItem $news): RedirectResponse
    {
        $news->delete();
        return redirect()->route('staff.news.index')->with('status', 'News deleted successfully!');
    }

    public function reorder(Request $request): JsonResponse
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:news_items,id',
        ]);

        foreach ($request->ids as $index => $id) {
            NewsItem::where('id', $id)->update(['sort_order' => $index + 1]);
        }

        return response()->json(['status' => 'success', 'message' => 'Order updated']);
    }

    public function show(NewsItem $news): View
    {
        return view('news.show', compact('news'));
    }
}
