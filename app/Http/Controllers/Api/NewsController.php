<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NewsItem;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class NewsController extends Controller
{
    /**
     * Display a listing of news items.
     */
    public function index(Request $request): JsonResponse
    {
        $query = NewsItem::orderBy('published_date', 'desc');

        if ($request->boolean('published', true)) {
            $query->whereNotNull('published_date')
                ->where('published_date', '<=', now());
        }

        $news = $query->paginate($request->input('per_page', 15));

        return response()->json($news);
    }

    /**
     * Display the specified news item.
     */
    public function show(NewsItem $news): JsonResponse
    {
        return response()->json([
            'data' => [
                'id' => $news->id,
                'title' => $news->title,
                'content' => $news->content,
                'image_path' => $news->image_path ? asset('storage/' . $news->image_path) : null,
                'published_date' => $news->published_date,
                'created_at' => $news->created_at,
                'updated_at' => $news->updated_at,
            ]
        ]);
    }

    /**
     * Store a newly created news item.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'published_date' => 'nullable|date',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('news', 'public');
        }

        unset($validated['image']);
        $news = NewsItem::create($validated);

        return response()->json([
            'data' => $news,
            'message' => 'News created successfully'
        ], 201);
    }

    /**
     * Update the specified news item.
     */
    public function update(Request $request, NewsItem $news): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
            'published_date' => 'nullable|date',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('news', 'public');
        }

        unset($validated['image']);
        $news->update($validated);

        return response()->json([
            'data' => $news,
            'message' => 'News updated successfully'
        ]);
    }

    /**
     * Remove the specified news item.
     */
    public function destroy(NewsItem $news): JsonResponse
    {
        $news->delete();

        return response()->json([
            'message' => 'News deleted successfully'
        ]);
    }
}
