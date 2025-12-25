<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PageController extends Controller
{
    /**
     * Display a listing of published pages.
     */
    public function index(): JsonResponse
    {
        $pages = Page::where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->get(['id', 'title', 'slug', 'meta_description', 'created_at']);

        return response()->json(['data' => $pages]);
    }

    /**
     * Display the specified page.
     */
    public function show(Page $page): JsonResponse
    {
        if (!$page->is_published && !auth('sanctum')->check()) {
            return response()->json(['message' => 'Page not found'], 404);
        }

        return response()->json([
            'data' => [
                'id' => $page->id,
                'title' => $page->title,
                'slug' => $page->slug,
                'content' => $page->content,
                'meta_description' => $page->meta_description,
                'is_published' => $page->is_published,
                'created_at' => $page->created_at,
                'updated_at' => $page->updated_at,
            ]
        ]);
    }

    /**
     * Store a newly created page.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:pages,slug',
            'content' => 'nullable|string',
            'meta_description' => 'nullable|string|max:255',
            'is_published' => 'boolean',
        ]);

        $validated['created_by'] = auth()->id();
        $page = Page::create($validated);

        return response()->json([
            'data' => $page,
            'message' => 'Page created successfully'
        ], 201);
    }

    /**
     * Update the specified page.
     */
    public function update(Request $request, Page $page): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'slug' => 'sometimes|string|max:255|unique:pages,slug,' . $page->id,
            'content' => 'nullable|string',
            'meta_description' => 'nullable|string|max:255',
            'is_published' => 'boolean',
        ]);

        $page->update($validated);

        return response()->json([
            'data' => $page,
            'message' => 'Page updated successfully'
        ]);
    }

    /**
     * Remove the specified page.
     */
    public function destroy(Page $page): JsonResponse
    {
        $page->delete();

        return response()->json([
            'message' => 'Page deleted successfully'
        ]);
    }
}
