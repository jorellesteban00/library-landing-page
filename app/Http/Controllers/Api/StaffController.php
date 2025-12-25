<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StaffProfile;
use Illuminate\Http\JsonResponse;

class StaffController extends Controller
{
    /**
     * Display a listing of staff profiles.
     */
    public function index(): JsonResponse
    {
        $staff = StaffProfile::orderBy('sort_order')
            ->get()
            ->map(function ($profile) {
                return [
                    'id' => $profile->id,
                    'name' => $profile->name,
                    'position' => $profile->position,
                    'bio' => $profile->bio,
                    'email' => $profile->email,
                    'phone' => $profile->phone,
                    'image_url' => $profile->image_path ? asset('storage/' . $profile->image_path) : null,
                ];
            });

        return response()->json(['data' => $staff]);
    }

    /**
     * Display the specified staff profile.
     */
    public function show(StaffProfile $staff): JsonResponse
    {
        return response()->json([
            'data' => [
                'id' => $staff->id,
                'name' => $staff->name,
                'position' => $staff->position,
                'bio' => $staff->bio,
                'email' => $staff->email,
                'phone' => $staff->phone,
                'image_url' => $staff->image_path ? asset('storage/' . $staff->image_path) : null,
            ]
        ]);
    }
}
