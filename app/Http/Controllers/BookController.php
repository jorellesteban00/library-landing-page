<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BookController extends Controller
{
    public function index(Request $request): View
    {
        $query = Book::orderBy('sort_order')->orderBy('created_at', 'desc');

        if ($request->has('search') && $request->search != '') {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%")
                    ->orWhere('isbn', 'like', "%{$search}%")
                    ->orWhere('genre', 'like', "%{$search}%");
            });
        }

        $books = $query->get();
        $activeLoansCount = Borrowing::active()->count();
        return view('staff.books.index', compact('books', 'activeLoansCount'));
    }

    public function create(): View
    {
        return view('staff.books.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:20',
            'genre' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'status' => 'required|in:available,borrowed,reserved',
            'cover_image' => 'nullable|image|max:2048',
            'total_quantity' => 'required|integer|min:1',
            'available_quantity' => 'required|integer|min:0|lte:total_quantity',
        ]);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('books', 'public');
        }

        Book::create($validated);

        return redirect()->route('staff.books.index')->with('status', 'Book added successfully!');
    }

    public function edit(Book $book): View
    {
        return view('staff.books.edit', compact('book'));
    }

    public function update(Request $request, Book $book): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:20',
            'genre' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'status' => 'required|in:available,borrowed,reserved',
            'cover_image' => 'nullable|image|max:2048',
            'total_quantity' => 'required|integer|min:1',
            'available_quantity' => 'required|integer|min:0|lte:total_quantity',
        ]);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('books', 'public');
        }

        $book->update($validated);

        return redirect()->route('staff.books.index')->with('status', 'Book updated successfully!');
    }

    public function destroy(Book $book): RedirectResponse
    {
        $book->delete();
        return redirect()->route('staff.books.index')->with('status', 'Book deleted successfully!');
    }

    public function reorder(Request $request): JsonResponse
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:books,id',
        ]);

        foreach ($request->ids as $index => $id) {
            Book::where('id', $id)->update(['sort_order' => $index + 1]);
        }

        return response()->json(['status' => 'success', 'message' => 'Order updated']);
    }

    public function show(Book $book): View
    {
        return view('books.show', compact('book'));
    }

    public function catalogue(Request $request): View
    {
        $query = Book::where('status', 'available');

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%")
                    ->orWhere('isbn', 'like', "%{$search}%")
                    ->orWhere('genre', 'like', "%{$search}%");
            });
        }

        if ($request->has('genre') && $request->genre != '') {
            $query->where('genre', $request->genre);
        }

        $books = $query->orderBy('created_at', 'desc')->paginate(12);

        // Get all unique genres for the filter dropdown
        $genres = Book::select('genre')->distinct()->whereNotNull('genre')->pluck('genre');

        return view('books.catalogue', compact('books', 'genres'));
    }
}
