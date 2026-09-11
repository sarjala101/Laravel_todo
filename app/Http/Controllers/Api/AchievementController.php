<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AchievementController extends Controller
{
    // Get all achievements
    public function index(Request $request)
    {
        $achievements = $request->user()
            ->achievements()
            ->latest()
            ->get();

        return response()->json([
            'message' => 'Achievements retrieved successfully',
            'data' => $achievements,
        ], 200);
    }

    // Create achievement
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'nullable|date',
        ]);

        $achievement = $request->user()->achievements()->create([
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
        ]);

        return response()->json([
            'message' => 'Achievement created successfully',
            'data' => $achievement,
        ], 201);
    }

    // Update achievement
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'nullable|date',
        ]);

        $achievement = $request->user()
            ->achievements()
            ->findOrFail($id);

        $achievement->update([
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
        ]);

        return response()->json([
            'message' => 'Achievement updated successfully',
            'data' => $achievement,
        ], 200);
    }

    // Delete achievement
    public function destroy(Request $request, $id)
    {
        $achievement = $request->user()
            ->achievements()
            ->findOrFail($id);

        $achievement->delete();

        return response()->json([
            'message' => 'Achievement deleted successfully',
        ], 200);
    }
}