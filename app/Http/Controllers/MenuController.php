<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::orderBy('order')->get();
        return view('staff.menus.index', compact('menus'));
    }

    public function create()
    {
        return view('staff.menus.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'order' => 'integer',
        ]);

        if (!isset($validated['order'])) {
            $validated['order'] = Menu::max('order') + 1;
        }

        Menu::create($validated);

        return redirect()->route('staff.menus.index')->with('success', 'Menu item created successfully.');
    }

    public function edit(Menu $menu)
    {
        return view('staff.menus.edit', compact('menu'));
    }

    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'order' => 'integer',
        ]);

        $menu->update($validated);

        return redirect()->route('staff.menus.index')->with('success', 'Menu item updated successfully.');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->route('staff.menus.index')->with('success', 'Menu item deleted successfully.');
    }

    public function reorder(Request $request)
    {
        $ids = $request->input('ids');
        if (is_array($ids)) {
            foreach ($ids as $index => $id) {
                Menu::where('id', $id)->update(['order' => $index]);
            }
        }
        return response()->json(['status' => 'success']);
    }
}
