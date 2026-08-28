<?php

namespace App\Http\Middleware;

use App\Models\Device;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateDevice
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {

        $token = $request->bearerToken();

        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Device token required.',
            ], 401);
        }

        $device = Device::where(
            'auth_token',
            $token
        )->first();

        if (!$device) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid device token.',
            ], 401);
        }

        if ($device->status !== 'active') {
            return response()->json([
                'success' => false,
                'message' => 'Device is inactive.',
            ], 403);
        }

        // Make device available to controllers
        $request->attributes->set('device', $device);

        // Update last communication time
        $device->update([
            'last_seen_at' => now(),
        ]);

        return $next($request);
    }
}