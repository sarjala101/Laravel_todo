<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InterestController extends Controller
{
    // Get all interests
    public function index(Request $request)
    {
        $interests = $request->user()
            ->interests()
            ->latest()
            ->get();

        return response()->json([
            'message' => 'Interests retrieved successfully',
            'data' => $interests,
        ], 200);
    }

    // Create interest
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $interest = $request->user()->interests()->create([
            'name' => $request->name,
        ]);

        return response()->json([
            'message' => 'Interest created successfully',
            'data' => $interest,
        ], 201);
    }

    // Update interest
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $interest = $request->user()
            ->interests()
            ->findOrFail($id);

        $interest->update([
            'name' => $request->name,
        ]);

        return response()->json([
            'message' => 'Interest updated successfully',
            'data' => $interest,
        ], 200);
    }

    // Delete interest
    public function destroy(Request $request, $id)
    {
        $interest = $request->user()
            ->interests()
            ->findOrFail($id);

        $interest->delete();

        return response()->json([
            'message' => 'Interest deleted successfully',
        ], 200);
    }
}