<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CourseworkController extends Controller
{
    // Get all courseworks
    public function index(Request $request)
    {
        $courseworks = $request->user()
            ->courseworks()
            ->latest()
            ->get();

        return response()->json([
            'message' => 'Courseworks retrieved successfully',
            'data' => $courseworks,
        ], 200);
    }

    // Create coursework
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $coursework = $request->user()->courseworks()->create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return response()->json([
            'message' => 'Coursework created successfully',
            'data' => $coursework,
        ], 201);
    }

    // Update coursework
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $coursework = $request->user()
            ->courseworks()
            ->findOrFail($id);

        $coursework->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return response()->json([
            'message' => 'Coursework updated successfully',
            'data' => $coursework,
        ], 200);
    }

    // Delete coursework
    public function destroy(Request $request, $id)
    {
        $coursework = $request->user()
            ->courseworks()
            ->findOrFail($id);

        $coursework->delete();

        return response()->json([
            'message' => 'Coursework deleted successfully',
        ], 200);
    }
}