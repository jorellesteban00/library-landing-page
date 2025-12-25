<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $resources = Resource::ordered()->paginate(15);
        return view('staff.resources.index', compact('resources'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('staff.resources.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:link,document,video,image',
            'url' => 'nullable|url|required_if:type,link,video',
            'file' => 'nullable|file|max:10240|required_if:type,document,image',
            'is_published' => 'boolean',
        ]);

        $validated['is_published'] = $request->boolean('is_published');
        $validated['created_by'] = auth()->id();

        if ($request->hasFile('file')) {
            $validated['file_path'] = $request->file('file')->store('resources', 'public');
        }

        unset($validated['file']);
        Resource::create($validated);

        return redirect()->route('staff.resources.index')
            ->with('success', 'Resource created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Resource $resource)
    {
        return view('staff.resources.edit', compact('resource'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Resource $resource)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:link,document,video,image',
            'url' => 'nullable|url',
            'file' => 'nullable|file|max:10240',
            'is_published' => 'boolean',
        ]);

        $validated['is_published'] = $request->boolean('is_published');

        if ($request->hasFile('file')) {
            // Delete old file
            if ($resource->file_path) {
                Storage::disk('public')->delete($resource->file_path);
            }
            $validated['file_path'] = $request->file('file')->store('resources', 'public');
        }

        unset($validated['file']);
        $resource->update($validated);

        return redirect()->route('staff.resources.index')
            ->with('success', 'Resource updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Resource $resource)
    {
        if ($resource->file_path) {
            Storage::disk('public')->delete($resource->file_path);
        }

        $resource->delete();

        return redirect()->route('staff.resources.index')
            ->with('success', 'Resource deleted successfully.');
    }

    /**
     * Reorder resources.
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer|exists:resources,id',
        ]);

        foreach ($request->order as $index => $id) {
            Resource::where('id', $id)->update(['sort_order' => $index]);
        }

        return response()->json(['success' => true]);
    }
}
