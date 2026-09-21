<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class FirebaseNotificationService
{
    public function sendToToken(
        string $token,
        string $title,
        string $body,
        array $data = []
    ): string {
        $credentials = (string) config('services.firebase.credentials');

        $factory = (new Factory())->withServiceAccount($credentials);
        $messaging = $factory->createMessaging();

        $notification = Notification::create(
            $title,
            $body
        );

        $message = CloudMessage::new()
            ->withToken($token)
            ->withNotification($notification);

        if (!empty($data)) {
            /** @var array<string, string> $stringData */
            $stringData = [];

            foreach ($data as $key => $value) {
                $stringData[(string) $key] = (string) $value;
            }

            $message = $message->withData($stringData);
        }

        $result = $messaging->send($message);

        // Extract and return the message ID string
        return $result['name'] ?? '';
    }
}