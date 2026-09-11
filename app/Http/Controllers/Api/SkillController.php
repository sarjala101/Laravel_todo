<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    // Get all skills of logged-in user
    public function index(Request $request)
    {
        $skills = $request->user()
            ->skills()
            ->latest()
            ->get();

        return response()->json([
            'message' => 'Skills retrieved successfully',
            'data' => $skills,
        ], 200);
    }

    // Create a new skill
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $skill = $request->user()->skills()->create([
            'name' => $request->name,
        ]);

        return response()->json([
            'message' => 'Skill created successfully',
            'data' => $skill,
        ], 201);
    }

    // Update a skill
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Only find the skill belonging to logged-in user
        $skill = $request->user()
            ->skills()
            ->findOrFail($id);

        $skill->update([
            'name' => $request->name,
        ]);

        return response()->json([
            'message' => 'Skill updated successfully',
            'data' => $skill,
        ], 200);
    }

    // Delete a skill
    public function destroy(Request $request, $id)
    {
        // Only find the skill belonging to logged-in user
        $skill = $request->user()
            ->skills()
            ->findOrFail($id);

        $skill->delete();

        return response()->json([
            'message' => 'Skill deleted successfully',
        ], 200);
    }
}