<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Page;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::whereNull('parent_id')->orderBy('order')->with('children')->get();
        return view('staff.menus.index', compact('menus'));
    }

    public function create()
    {
        $parentMenus = Menu::whereNull('parent_id')->orderBy('order')->get();
        $pages = Page::orderBy('title')->get();
        return view('staff.menus.create', compact('parentMenus', 'pages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'link_type' => 'required|in:internal,external',
            'description' => 'nullable|string',
            'target' => 'required|in:_self,_blank',
            'is_visible' => 'boolean',
            'icon' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:menus,id',
            'order' => 'integer',
        ]);

        $validated['is_visible'] = $request->has('is_visible');

        if (!isset($validated['order'])) {
            $validated['order'] = Menu::max('order') + 1;
        }

        Menu::create($validated);

        return redirect()->route('staff.menus.index')->with('success', 'Menu item created successfully.');
    }

    public function edit(Menu $menu)
    {
        $parentMenus = Menu::whereNull('parent_id')
            ->where('id', '!=', $menu->id)
            ->orderBy('order')
            ->get();
        $pages = Page::orderBy('title')->get();
        return view('staff.menus.edit', compact('menu', 'parentMenus', 'pages'));
    }

    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'link_type' => 'required|in:internal,external',
            'description' => 'nullable|string',
            'target' => 'required|in:_self,_blank',
            'is_visible' => 'boolean',
            'icon' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:menus,id',
            'order' => 'integer',
        ]);

        $validated['is_visible'] = $request->has('is_visible');

        $menu->update($validated);

        return redirect()->route('staff.menus.index')->with('success', 'Menu item updated successfully.');
    }

    public function destroy(Menu $menu)
    {
        // Also delete child menu items
        $menu->children()->delete();
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

    public function toggleVisibility(Menu $menu)
    {
        $menu->update(['is_visible' => !$menu->is_visible]);
        return redirect()->route('staff.menus.index')->with('success', 'Menu visibility updated.');
    }
}
