<?php

namespace App\Console\Commands;

use App\Services\FirebaseNotificationService;
use Illuminate\Console\Command;
use Throwable;

class SendFcmTestNotification extends Command
{
    protected $signature = 'fcm:test
                            {token : The FCM registration token}
                            {--title=Test Notification : Notification title}
                            {--body=Hello from Laravel! : Notification body}';

    protected $description = 'Send a test Firebase Cloud Messaging notification';

    public function handle(FirebaseNotificationService $firebase): int
    {
        try {
            $messageId = $firebase->sendToToken(
                $this->argument('token'),
                $this->option('title'),
                $this->option('body')
            );

            $this->info('Notification sent successfully.');
            $this->line('Firebase message ID: '.$messageId);

            return self::SUCCESS;
        } catch (Throwable $e) {
            $this->error('Failed to send notification.');
            $this->error($e->getMessage());

            return self::FAILURE;
        }
    }
}