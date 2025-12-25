<?php

namespace App\Http\Controllers;

use App\Models\StaffProfile;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class StaffProfileController extends Controller
{
    public function index(): View
    {
        $staffProfiles = StaffProfile::orderBy('sort_order')->orderBy('created_at')->get();
        return view('staff.profiles.index', compact('staffProfiles'));
    }

    public function create(): View
    {
        return view('staff.profiles.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role_text' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('staff', 'public');
        }

        StaffProfile::create($validated);

        return redirect()->route('staff.staff-profiles.index')->with('status', 'Staff member added successfully!');
    }

    public function edit(StaffProfile $staffProfile): View
    {
        return view('staff.profiles.edit', compact('staffProfile'));
    }

    public function update(Request $request, StaffProfile $staffProfile): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role_text' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('staff', 'public');
        }

        $staffProfile->update($validated);

        return redirect()->route('staff.staff-profiles.index')->with('status', 'Staff member updated successfully!');
    }

    public function destroy(StaffProfile $staffProfile): RedirectResponse
    {
        $staffProfile->delete();
        return redirect()->route('staff.staff-profiles.index')->with('status', 'Staff member deleted successfully!');
    }

    public function reorder(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:staff_profiles,id',
        ]);

        foreach ($validated['ids'] as $index => $id) {
            StaffProfile::where('id', $id)->update(['sort_order' => $index + 1]);
        }

        return response()->json(['status' => 'success', 'message' => 'Order updated']);
    }
}
