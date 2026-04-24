<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use Str;

class DeviceController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'uid' => 'required|string'
        ]);

        $device = Device::firstOrCreate(
            ['uid' => $request->uid],
            ['pairing_code' => strtoupper(Str::random(6))]
        );

        if (!$device->user_id) {
            $device->pairing_code = strtoupper(Str::random(6));
            $device->save();
        }

        return response()->json([
            'pairing_code' => $device->pairing_code
        ]);
    }

    public function status(Request $request)
    {
        $request->validate([
            'uid' => 'required'
        ]);

        $device = Device::where('uid', $request->uid)->first();

        return response()->json([
            'paired' => $device && $device->user_id !== null
        ]);
    }


    public function storeData(Request $request)
    {
        $request->validate([
            'uid' => 'required'
        ]);

        $device = Device::where('uid', $request->uid)->first();

        if (!$device || !$device->user_id) {
            return response()->json([
                'message' => 'Device not paired'
            ], 403);
        }

        $device->readings()->create([
            'heart_rate' => $request->heart_rate,
            'spo2' => $request->spo2,
            'temp' => $request->temp,
            'lat' => $request->lat,
            'lng' => $request->lng,
        ]);

        return response()->json(['ok' => true]);
    }


    public function sos(Request $request)
{
    $device = Device::where('uid', $request->uid)->first();

    if (!$device) return response()->json(['error' => 'invalid'], 404);

    // store alert
    $device->alerts()->create([
        'type' => 'SOS',
        'lat' => $request->lat,
        'lng' => $request->lng,
        'temp' => $request->temp,
        'data' => json_encode($request->all())
    ]);

    return response()->json(['ok' => true]);
}
}
