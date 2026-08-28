<?php

namespace App\Http\Controllers;

use App\Models\SensorReading;
use Illuminate\Http\Request;

class SensorReadingController extends Controller
{
    /**
     * Receive a sensor reading from an ESP32 device.
     */
    public function store(Request $request)
    {
        // Device is added to the request by AuthenticateDevice middleware
        $device = $request->attributes->get('device');

        if (!$device) {
            return response()->json([
                'success' => false,
                'message' => 'Device authentication required.',
            ], 401);
        }

        $validated = $request->validate([
            'heart_rate' => [
                'nullable',
                'integer',
                'min:0',
                'max:250',
            ],

            'spo2' => [
                'nullable',
                'integer',
                'between:0,100',
            ],

            'body_temperature' => [
                'nullable',
                'numeric',
                'between:20,50',
            ],

            'ambient_temperature' => [
                'nullable',
                'numeric',
                'between:-20,80',
            ],

            'battery_level' => [
                'nullable',
                'integer',
                'between:0,100',
            ],

            'recorded_at' => [
                'nullable',
                'date',
            ],
        ]);

        $reading = SensorReading::create([
            'device_id' => $device->id,
            'heart_rate' => $validated['heart_rate'] ?? null,
            'spo2' => $validated['spo2'] ?? null,
            'body_temperature' => $validated['body_temperature'] ?? null,
            'ambient_temperature' => $validated['ambient_temperature'] ?? null,
            'battery_level' => $validated['battery_level'] ?? null,
            'recorded_at' => $validated['recorded_at'] ?? now(),
        ]);
        // Update device status whenever the ESP32 successfully sends data
        $device->update([
            'status' => 'active',
            'last_seen_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Sensor reading stored successfully.',
            'reading' => $reading,
        ], 201);
    }


    /**
     * Get the latest reading from the authenticated ESP32.
     */
    public function latest(Request $request)
    {
        $device = $request->attributes->get('device');

        if (!$device) {
            return response()->json([
                'success' => false,
                'message' => 'Device authentication required.',
            ], 401);
        }

        $reading = $device->readings()
            ->latest('recorded_at')
            ->first();

        return response()->json([
            'success' => true,
            'reading' => $reading,
        ]);
    }
}