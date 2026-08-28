<?php

namespace App\Http\Middleware;

use App\Models\Device;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DeviceAuth
{
    /**
     * Handle an incoming request.
     */
    public function handle(
        Request $request,
        Closure $next
    ): Response {

        /*
        |--------------------------------------------------------------------------
        | Get Authorization header
        |--------------------------------------------------------------------------
        |
        | ESP32 sends:
        |
        | Authorization: Bearer DEVICE_TOKEN
        |
        */

        $authorization =
            $request->header('Authorization');


        if (!$authorization) {
            return response()->json([
                'success' => false,
                'message' => 'Device authentication required.',
            ], 401);
        }


        /*
        |--------------------------------------------------------------------------
        | Extract Bearer token
        |--------------------------------------------------------------------------
        */

        if (!str_starts_with(
            $authorization,
            'Bearer '
        )) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid authorization format.',
            ], 401);
        }


        $token =
            substr(
                $authorization,
                7
            );


        if (empty($token)) {
            return response()->json([
                'success' => false,
                'message' => 'Device token missing.',
            ], 401);
        }


        /*
        |--------------------------------------------------------------------------
        | Find device
        |--------------------------------------------------------------------------
        */

        $device =
            Device::where(
                'auth_token',
                $token
            )->first();


        if (!$device) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid device token.',
            ], 401);
        }


        /*
        |--------------------------------------------------------------------------
        | Check device status
        |--------------------------------------------------------------------------
        */

        if ($device->status !== 'active') {
            return response()->json([
                'success' => false,
                'message' => 'Device is inactive.',
            ], 403);
        }


        /*
        |--------------------------------------------------------------------------
        | Update last seen
        |--------------------------------------------------------------------------
        */

        $device->update([
            'last_seen_at' => now(),
        ]);


        /*
        |--------------------------------------------------------------------------
        | Make device available to controller
        |--------------------------------------------------------------------------
        |
        | Your SensorReadingController can now use:
        |
        | $request->attributes->get('device')
        |
        */

        $request->attributes->set(
            'device',
            $device
        );


        /*
        |--------------------------------------------------------------------------
        | Continue request
        |--------------------------------------------------------------------------
        */

        return $next($request);
    }
}