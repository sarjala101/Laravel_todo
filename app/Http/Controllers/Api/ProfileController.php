<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserProfile;
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
                ],

                'profile' => $user->profile,

                'skills' => $user->skills,

                'projects' => $user->projects,

                'achievements' => $user->achievements,

                'courseworks' => $user->courseworks,

                'interests' => $user->interests,
            ],
        ], 200);
    }


    /**
     * Create or update the authenticated user's profile.
     */
    public function update(Request $request)
    {
        $request->validate([
            'role' => 'nullable|string|max:255',

            'dob' => 'nullable|date',

            'phone' => 'nullable|string|max:30',

            'description' => 'nullable|string',

            'academic_qualification' => 'nullable|string|max:255',

            'location' => 'nullable|string|max:255',

            'semester' => 'nullable|string|max:100',
        ]);

        $user = $request->user();

        $profile = UserProfile::updateOrCreate(
            [
                'user_id' => $user->id,
            ],
            [
                'role' => $request->role,
                'dob' => $request->dob,
                'phone' => $request->phone,
                'description' => $request->description,
                'academic_qualification' => $request->academic_qualification,
                'location' => $request->location,
                'semester' => $request->semester,
            ]
        );

        return response()->json([
            'message' => 'Profile updated successfully',
            'data' => $profile,
        ], 200);
    }
}