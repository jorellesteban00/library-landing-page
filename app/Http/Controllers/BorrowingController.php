<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BorrowingController extends Controller
{
    /**
     * Display borrowings for the logged-in user (member dashboard).
     */
    public function index()
    {
        $borrowings = Borrowing::where('user_id', auth()->id())
            ->with('book')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('borrowings.index', compact('borrowings'));
    }

    /**
     * Display all borrowings for staff/librarian.
     */
    public function manage()
    {
        $borrowings = Borrowing::with(['user', 'book'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('staff.borrowings.index', compact('borrowings'));
    }

    /**
     * Show borrow form for a book.
     */
    public function create(Book $book)
    {
        if ($book->available_quantity < 1) {
            return back()->with('error', 'This book is not available for borrowing.');
        }

        return view('borrowings.create', compact('book'));
    }

    /**
     * Store a new borrowing request.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'due_date' => 'required|date|after:today',
        ]);

        $book = Book::findOrFail($validated['book_id']);

        if ($book->available_quantity < 1) {
            return back()->with('error', 'This book is no longer available.');
        }

        // Check if user already has this book borrowed or pending
        $existingBorrow = Borrowing::where('user_id', auth()->id())
            ->where('book_id', $book->id)
            ->whereIn('status', ['borrowed', 'pending'])
            ->exists();

        if ($existingBorrow) {
            return back()->with('error', 'You already have a pending request or active borrow for this book.');
        }

        Borrowing::create([
            'user_id' => auth()->id(),
            'book_id' => $book->id,
            'due_date' => $validated['due_date'],
            'status' => 'pending',
        ]);

        return redirect()->route('borrowings.index')
            ->with('success', 'Borrow request submitted successfully! Please wait for admin approval.');
    }

    /**
     * Return a borrowed book.
     */
    public function return(Borrowing $borrowing)
    {
        // Only allow returning own books or if librarian
        if ($borrowing->user_id !== auth()->id() && auth()->user()->role !== 'librarian') {
            abort(403);
        }

        if ($borrowing->status === 'returned') {
            return back()->with('error', 'This book has already been returned.');
        }

        $borrowing->markAsReturned();

        return back()->with('success', 'Book returned successfully!');
    }

    /**
     * Show borrowing details.
     */
    public function show(Borrowing $borrowing)
    {
        // Only allow viewing own borrowings or if staff/librarian
        if ($borrowing->user_id !== auth()->id() && !in_array(auth()->user()->role, ['librarian', 'staff'])) {
            abort(403);
        }

        return view('borrowings.show', compact('borrowing'));
    }

    /**
     * Approve a pending borrowing request.
     */
    public function approve(Borrowing $borrowing)
    {
        // Only staff/librarian can approve
        if (!in_array(auth()->user()->role, ['librarian', 'staff'])) {
            abort(403);
        }

        if ($borrowing->status !== 'pending') {
            return back()->with('error', 'This request has already been processed.');
        }

        // Check if book is still available
        if ($borrowing->book->available_quantity < 1) {
            return back()->with('error', 'This book is no longer available.');
        }

        $borrowing->update([
            'status' => 'borrowed',
            'borrowed_at' => now(),
        ]);

        // Decrement available quantity
        $borrowing->book->decrement('available_quantity');

        return back()->with('success', 'Borrow request approved successfully!');
    }

    /**
     * Reject a pending borrowing request.
     */
    public function reject(Borrowing $borrowing)
    {
        // Only staff/librarian can reject
        if (!in_array(auth()->user()->role, ['librarian', 'staff'])) {
            abort(403);
        }

        if ($borrowing->status !== 'pending') {
            return back()->with('error', 'This request has already been processed.');
        }

        $borrowing->update([
            'status' => 'rejected',
        ]);

        return back()->with('success', 'Borrow request rejected.');
    }
}
