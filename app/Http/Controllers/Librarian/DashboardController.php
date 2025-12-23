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
        return view('librarian.dashboard', compact('users'));
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
        $user->delete();
        return back()->with('status', 'User deleted successfully!');
    }
}
