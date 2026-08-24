<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DeviceController extends Controller
{
    /**
     * Display all devices belonging to the logged-in doctor.
     */
    public function index()
    {
        $devices = Device::where('doctor_id', auth()->id())
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'devices' => $devices,
        ]);
    }

    /**
     * Register a new ESP32 device.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'device_uid' => 'required|string|max:255|unique:devices,device_uid',
            'mac_address' => 'required|string|max:255|unique:devices,mac_address',
            'device_name' => 'nullable|string|max:255',
            'firmware_version' => 'nullable|string|max:100',
        ]);

        $device = Device::create([
            'doctor_id' => auth()->id(),
            'device_uid' => $validated['device_uid'],
            'mac_address' => $validated['mac_address'],
            'device_name' => $validated['device_name'] ?? null,
            'firmware_version' => $validated['firmware_version'] ?? null,
            'auth_token' => Str::random(64),
            'status' => 'active',
            'last_seen_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'ESP32 registered successfully.',
            'device' => $device,
            'device_token' => $device->auth_token,
        ], 201);
    }

    /**
     * Show a specific device.
     */
    public function show($deviceId)
    {
        $device = Device::where('doctor_id', auth()->id())
            ->findOrFail($deviceId);

        return response()->json([
            'success' => true,
            'device' => $device,
        ]);
    }

    /**
     * Update device information.
     */
    public function update(Request $request, $deviceId)
    {
        $device = Device::where('doctor_id', auth()->id())
            ->findOrFail($deviceId);

        $validated = $request->validate([
            'device_name' => 'nullable|string|max:255',
            'firmware_version' => 'nullable|string|max:100',
            'status' => 'nullable|in:active,inactive',
        ]);

        $device->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Device updated successfully.',
            'device' => $device,
        ]);
    }

    /**
     * Delete a device.
     */
    public function destroy($deviceId)
    {
        $device = Device::where('doctor_id', auth()->id())
            ->findOrFail($deviceId);

        $device->delete();

        return response()->json([
            'success' => true,
            'message' => 'Device deleted successfully.',
        ]);
    }

    /**
     * Get readings for a device.
     */
    public function readings($deviceId)
    {
        $device = Device::where('doctor_id', auth()->id())
            ->findOrFail($deviceId);

        $readings = $device->readings()
            ->latest('recorded_at')
            ->get();

        return response()->json([
            'success' => true,
            'device' => $device,
            'readings' => $readings,
        ]);
    }
}
