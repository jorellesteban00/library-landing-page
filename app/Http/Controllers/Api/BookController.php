<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BookController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Book::all());
    }

    public function show(Book $book): JsonResponse
    {
        return response()->json($book);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'status' => 'required|in:available,borrowed,reserved',
        ]);

        $book = Book::create($validated);
        return response()->json($book, 201);
    }

    public function update(Request $request, Book $book): JsonResponse
    {
        $book->update($request->all());
        return response()->json($book);
    }

    public function destroy(Book $book): JsonResponse
    {
        $book->delete();
        return response()->json(['message' => 'Book deleted']);
    }
}
