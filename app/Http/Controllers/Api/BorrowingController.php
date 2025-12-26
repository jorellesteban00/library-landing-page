<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class BorrowingController extends Controller
{
    /**
     * List user's borrowings
     */
    public function index(Request $request): JsonResponse
    {
        $user = Auth::user();

        // If staff/librarian, can see all (with filter). Otherwise only own.
        // For simplicity API, let's just return current user's borrowings.

        $borrowings = Borrowing::with('book')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        return response()->json($borrowings);
    }

    /**
     * Create a new borrowing (Reservation)
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'due_date' => 'nullable|date|after:today',
        ]);

        $book = Book::findOrFail($validated['book_id']);

        if ($book->available_quantity < 1) {
            return response()->json(['message' => 'Book not available'], 400);
        }

        // Logic to create borrowing
        $borrowing = Borrowing::create([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'borrowed_at' => now(),
            'due_date' => $validated['due_date'] ?? now()->addDays(14),
            'status' => 'borrowed',
        ]);

        // Decrement book quantity
        $book->decrement('available_quantity');
        if ($book->available_quantity === 0) {
            $book->update(['status' => 'borrowed']);
        }

        return response()->json($borrowing, 201);
    }

    /**
     * Get details of a borrowing
     */
    public function show(Borrowing $borrowing): JsonResponse
    {
        if ($borrowing->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($borrowing->load('book'));
    }

    /**
     * Mark as returned (optional self-return logic, can be restricted)
     */
    public function returnBook(Borrowing $borrowing): JsonResponse
    {
        if ($borrowing->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if ($borrowing->status !== 'borrowed') {
            return response()->json(['message' => 'Borrowing already processed'], 400);
        }

        $borrowing->markAsReturned();

        return response()->json(['message' => 'Book returned successfully', 'borrowing' => $borrowing]);
    }
}
