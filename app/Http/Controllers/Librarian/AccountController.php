<?php

namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::orderBy('name');

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->get();
        return view('librarian.accounts.index', compact('users'));
    }

    public function update(Request $request, User $account): RedirectResponse
    {
        $validated = $request->validate([
            'role_selection' => 'required|string|in:user,librarian,staff_books,staff_news',
        ]);

        $role = 'user';
        $staffType = null;

        switch ($validated['role_selection']) {
            case 'librarian':
                $role = 'librarian';
                break;
            case 'staff_books':
                $role = 'staff';
                $staffType = 'books';
                break;
            case 'staff_news':
                $role = 'staff';
                $staffType = 'news';
                break;
            case 'user':
            default:
                $role = 'user';
                break;
        }

        // Prevent self-demotion from admin/librarian if it's the only one (optional safety, but for now simple update)
        // Basic protection: if updating self, handle carefully? 
        // For now, allow simple updates as per request.

        $account->update([
            'role' => $role,
            'staff_type' => $staffType,
        ]);

        return redirect()->route('librarian.accounts.index')->with('status', 'Account permissions updated successfully!');
    }
}
