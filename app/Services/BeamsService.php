<?php

namespace App\Services;

use Pusher\PushNotifications\PushNotifications;

class BeamsService
{
    protected PushNotifications $beams;

    public function __construct()
    {
        $this->beams = new PushNotifications([
            'instanceId' => env('PUSHER_BEAMS_INSTANCE_ID'),
            'secretKey' => env('PUSHER_BEAMS_SECRET_KEY'),
        ]);
    }

    public function sendToInterest(
        string $interest,
        string $title,
        string $body
    ) {
        return $this->beams->publishToInterests(
            [$interest],
            [
                'web' => [
                    'notification' => [
                        'title' => $title,
                        'body' => $body,
                    ],
                ],
            ]
        );
    }
}
