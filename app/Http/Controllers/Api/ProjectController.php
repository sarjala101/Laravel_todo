<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    // Get all projects of the logged-in user
    public function index(Request $request)
    {
        $projects = $request->user()
            ->projects()
            ->latest()
            ->get();

        return response()->json([
            'message' => 'Projects retrieved successfully',
            'data' => $projects,
        ], 200);
    }

    // Create a new project
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'link' => 'nullable|string|max:500',
        ]);

        $project = $request->user()->projects()->create([
            'title' => $request->title,
            'description' => $request->description,
            'link' => $request->link,
        ]);

        return response()->json([
            'message' => 'Project created successfully',
            'data' => $project,
        ], 201);
    }

    // Update a project
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'link' => 'nullable|string|max:500',
        ]);

        // Find only the logged-in user's project
        $project = $request->user()
            ->projects()
            ->findOrFail($id);

        $project->update([
            'title' => $request->title,
            'description' => $request->description,
            'link' => $request->link,
        ]);

        return response()->json([
            'message' => 'Project updated successfully',
            'data' => $project,
        ], 200);
    }

    // Delete a project
    public function destroy(Request $request, $id)
    {
        // Find only the logged-in user's project
        $project = $request->user()
            ->projects()
            ->findOrFail($id);

        $project->delete();

        return response()->json([
            'message' => 'Project deleted successfully',
        ], 200);
    }
}