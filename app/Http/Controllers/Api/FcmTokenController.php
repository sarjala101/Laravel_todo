<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FcmToken;
use App\Services\FirebaseNotificationService; // 1. Import Service
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FcmTokenController extends Controller
{
    public function store(
        Request $request, 
        FirebaseNotificationService $firebase // 2. Inject Service
    ): JsonResponse {
        $validated = $request->validate([
            'token' => ['required', 'string'],
        ]);

        $user = $request->user();

        $fcmToken = FcmToken::updateOrCreate(
            [
                'user_id' => $user->id,
                'token' => $validated['token'],
            ],
            [
                'token' => $validated['token'],
            ]
        );

        // 3. Send Notification automatically when token is saved/registered
        try {
            $firebase->sendToToken(
                $fcmToken->token,
                'Login Successful',
                "Hello {$user->name}, you have successfully logged in!"
            );
        } catch (\Throwable $e) {
            // Log or ignore error so API response doesn't fail
        }

        return response()->json([
            'message' => 'FCM token saved successfully.',
            'data' => [
                'id' => $fcmToken->id,
            ],
        ]);
    }

    public function destroy(
        Request $request,
        FirebaseNotificationService $firebase
    ): JsonResponse {
        $validated = $request->validate([
            'token' => ['required', 'string'],
        ]);

        $user = $request->user();

        // 1. Send Logout notification BEFORE deleting token
        try {
            $firebase->sendToToken(
                $validated['token'],
                'Logged Out',
                'You have been logged out of your session.'
            );
        } catch (\Throwable $e) {
            // Ignore error
        }

        // 2. Delete token
        FcmToken::where('user_id', $user->id)
            ->where('token', $validated['token'])
            ->delete();

        return response()->json([
            'message' => 'FCM token removed successfully.',
        ]);
    }
}