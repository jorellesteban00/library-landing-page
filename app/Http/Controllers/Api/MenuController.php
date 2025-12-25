<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\JsonResponse;

class MenuController extends Controller
{
    /**
     * Display the navigation menu structure.
     */
    public function index(): JsonResponse
    {
        $menus = Menu::whereNull('parent_id')
            ->orderBy('display_order')
            ->with([
                'children' => function ($query) {
                    $query->orderBy('display_order');
                }
            ])
            ->get()
            ->map(function ($menu) {
                return $this->formatMenu($menu);
            });

        return response()->json(['data' => $menus]);
    }

    /**
     * Format menu item for API response.
     */
    private function formatMenu(Menu $menu): array
    {
        $formatted = [
            'id' => $menu->id,
            'label' => $menu->label,
            'url' => $menu->url,
            'target' => $menu->target ?? '_self',
        ];

        if ($menu->children->isNotEmpty()) {
            $formatted['children'] = $menu->children->map(function ($child) {
                return $this->formatMenu($child);
            })->toArray();
        }

        return $formatted;
    }
}
