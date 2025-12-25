<?php

namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $users = User::all();

        // Stats for Dashboard
        $stats = [
            'total_pages' => \App\Models\Page::count(),
            'published_pages' => \App\Models\Page::where('is_published', true)->count(),
            'total_news' => \App\Models\NewsItem::count(),
            'total_staff' => \App\Models\StaffProfile::count(),
            'total_books' => \App\Models\Book::count(), // Distinct titles
            'copies_available' => \App\Models\Book::sum('available_quantity'),
            'active_loans' => \App\Models\Borrowing::where('status', 'borrowed')->count(),
        ];

        $recentPages = \App\Models\Page::latest('updated_at')->take(4)->get();

        return view('librarian.dashboard', compact('users', 'stats', 'recentPages'));
    }

    public function updateRole(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'role' => 'required|in:librarian,staff,user',
            'staff_type' => 'nullable|string',
        ]);

        $user->update($validated);

        return back()->with('status', 'User role updated successfully!');
    }

    public function destroy(User $user): RedirectResponse
    {
        // Prevent deletion of 'admin' or 'librarian'
        if (in_array($user->role, ['admin', 'librarian'])) {
            return back()->with('error', 'You cannot delete Admins or Librarians.');
        }

        $user->delete();
        return back()->with('status', 'User deleted successfully!');
    }
}
