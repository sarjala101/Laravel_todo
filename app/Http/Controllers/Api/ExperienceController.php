<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    /**
     * Get all experiences of the authenticated user.
     */
    public function index(Request $request)
    {
        $experiences = $request->user()
            ->experiences()
            ->latest()
            ->get();

        return response()->json([
            'message' => 'Experiences retrieved successfully',
            'data' => $experiences,
        ], 200);
    }

    /**
     * Store a new experience.
     */
    public function store(Request $request)
    {
        $request->validate([
            'organization' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'is_current' => 'nullable|boolean',
        ]);

        $experience = $request->user()->experiences()->create([
            'organization' => $request->organization,
            'position' => $request->position,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->is_current ? null : $request->end_date,
            'is_current' => $request->is_current ?? false,
        ]);

        return response()->json([
            'message' => 'Experience added successfully',
            'data' => $experience,
        ], 201);
    }

    /**
     * Update an existing experience.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'organization' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'is_current' => 'nullable|boolean',
        ]);

        $experience = $request->user()
            ->experiences()
            ->findOrFail($id);

        $experience->update([
            'organization' => $request->organization,
            'position' => $request->position,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->is_current ? null : $request->end_date,
            'is_current' => $request->is_current ?? false,
        ]);

        return response()->json([
            'message' => 'Experience updated successfully',
            'data' => $experience,
        ], 200);
    }

    /**
     * Delete an experience.
     */
    public function destroy(Request $request, $id)
    {
        $experience = $request->user()
            ->experiences()
            ->findOrFail($id);

        $experience->delete();

        return response()->json([
            'message' => 'Experience deleted successfully',
        ], 200);
    }
}
