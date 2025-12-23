<?php

namespace App\Http\Controllers;

use App\Models\SiteContent;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SiteContentController extends Controller
{
    public function index(): View
    {
        $content = SiteContent::all()->pluck('value', 'key');
        return view('staff.site-content.index', compact('content'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'hero_title' => 'nullable|string',
            'hero_subtitle' => 'nullable|string',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
        ]);

        foreach ($validated as $key => $value) {
            SiteContent::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->route('home')->with('status', 'Content updated successfully!');
    }
}
