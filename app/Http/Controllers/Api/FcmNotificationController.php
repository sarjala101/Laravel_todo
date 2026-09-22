<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FcmToken;
use App\Services\FirebaseNotificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class FcmNotificationController extends Controller
{
    public function test(
        Request $request,
        FirebaseNotificationService $firebase
    ): JsonResponse {
        $token = FcmToken::where(
            'user_id',
            $request->user()->id
        )->latest()->first();

        if (!$token) {
            return response()->json([
                'message' => 'No FCM token found for this user.',
            ], 404);
        }

        try {
            $messageId = $firebase->sendToToken(
                $token->token,
                'Test Notification',
                'Your Laravel application successfully sent this notification!',
                [
                    'type' => 'test',
                ]
            );

            return response()->json([
                'message' => 'Notification sent successfully.',
                'message_id' => $messageId,
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'message' => 'Notification failed.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}