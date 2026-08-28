<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\SensorReading;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DeviceWebController extends Controller
{
    /**
     * Device dashboard.
     */
    public function index()
    {
        $devices = Device::where('doctor_id', auth()->id())
            ->latest()
            ->get();

        return view('devices.index', compact('devices'));
    }

    /**
     * Registration form.
     */
    public function create()
    {
        return view('devices.create');
    }

    /**
     * Register device.
     */
    public function store(Request $request)
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

        return redirect()
            ->route('devices.show', $device)
            ->with('success', 'ESP32 registered successfully.');
    }

    /**
     * Device details.
     */
    public function show(Device $device)
    {
        abort_unless(
            $device->doctor_id === auth()->id(),
            403
        );

        $latestReading = $device->readings()
            ->latest('recorded_at')
            ->first();

        return view(
            'devices.show',
            compact('device', 'latestReading')
        );
    }

    /**
     * Device readings.
     */
    public function readings(Device $device)
    {
        abort_unless(
            $device->doctor_id === auth()->id(),
            403
        );

        $readings = $device->readings()
            ->latest('recorded_at')
            ->paginate(20);

        return view(
            'devices.readings',
            compact('device', 'readings')
        );
    }

    /**
     * Test sensor reading manually.
     */
    public function storeReading(
        Request $request,
        Device $device
    ) {
        abort_unless(
            $device->doctor_id === auth()->id(),
            403
        );

        $validated = $request->validate([
            'heart_rate' => 'nullable|integer|min:0|max:250',
            'spo2' => 'nullable|integer|min:0|max:100',
            'body_temperature' => 'nullable|numeric|between:20,50',
            'ambient_temperature' => 'nullable|numeric|between:-20,80',
            'battery_level' => 'nullable|integer|between:0,100',
        ]);

        SensorReading::create([
            'device_id' => $device->id,
            'heart_rate' => $validated['heart_rate'] ?? null,
            'spo2' => $validated['spo2'] ?? null,
            'body_temperature' =>
                $validated['body_temperature'] ?? null,
            'ambient_temperature' =>
                $validated['ambient_temperature'] ?? null,
            'battery_level' =>
                $validated['battery_level'] ?? null,
            'recorded_at' => now(),
        ]);

        $device->update([
            'last_seen_at' => now(),
        ]);

        return back()->with(
            'success',
            'Test sensor reading added.'
        );
    }

    /**
     * Delete device.
     */
    public function destroy(Device $device)
    {
        abort_unless(
            $device->doctor_id === auth()->id(),
            403
        );

        $device->delete();

        return redirect()
            ->route('devices.index')
            ->with('success', 'Device deleted.');
    }
}