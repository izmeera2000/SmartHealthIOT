<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Pusher\PushNotifications\PushNotifications;

class BeamsTestController extends Controller
{
    public function send()
    {
        $beams = new PushNotifications([
            'instanceId' => env('PUSHER_BEAMS_INSTANCE_ID'),
            'secretKey' => env('PUSHER_BEAMS_SECRET_KEY'),
        ]);

        $beams->publishToInterests(
            ['debug-doctor-' . auth()->id()],
            [
                'web' => [
                    'notification' => [
                        'title' => 'Smart Health IoT',
                        'body' => 'Beams test notification received!',
                    ],
                ],
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Beams notification sent.',
        ]);
    }
}