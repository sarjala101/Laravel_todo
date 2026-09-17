<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Get the authenticated user's complete profile.
     */
    public function show(Request $request)
    {
        $user = $request->user();

        $user->load([
            'profile',
            'academicQualifications',
            'experiences',
            'skills',
            'projects',
            'achievements',
            'courseworks',
            'interests',
        ]);

        return response()->json([
            'message' => 'Profile retrieved successfully',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'created_at' => $user->created_at,
                    'updated_at' => $user->updated_at,
                ],
                'profile' => $user->profile,
                'academic_qualifications' => $user->academicQualifications,
                'experiences' => $user->experiences,
                'skills' => $user->skills,
                'projects' => $user->projects,
                'achievements' => $user->achievements,
                'courseworks' => $user->courseworks,
                'interests' => $user->interests,
            ],
        ], 200);
    }

    /**
     * Create or update the authenticated user's general profile information.
     */
    public function update(Request $request)
    {
        $request->validate([
            'role' => 'nullable|string|max:255',
            'current_status' => 'nullable|string|max:255',
            'affiliated_organization' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'phone' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'profile_image' => 'nullable|string|max:500',
        ]);

        $user = $request->user();

        $profile = Profile::updateOrCreate(
            [
                'user_id' => $user->id,
            ],
            [
                'role' => $request->role,
                'current_status' => $request->current_status,
                'affiliated_organization' => $request->affiliated_organization,
                'date_of_birth' => $request->date_of_birth,
                'phone' => $request->phone,
                'description' => $request->description,
                'location' => $request->location,
                'profile_image' => $request->profile_image,
            ]
        );

        return response()->json([
            'message' => 'Profile updated successfully',
            'data' => $profile,
        ], 200);
    }
}