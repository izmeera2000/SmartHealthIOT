<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DeviceController extends Controller
{
    /**
     * =========================================================
     * DOCTOR: LIST DEVICES
     * =========================================================
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
     * =========================================================
     * ESP32: REQUEST PAIRING
     * =========================================================
     *
     * ESP32 sends:
     *
     * {
     *     "device_uid": "ESP32-001",
     *     "pairing_code": "481927"
     * }
     *
     * This does NOT register the device yet.
     *
     * It only tells Laravel:
     *
     * "This ESP32 is waiting to be paired."
     */
    public function pairRequest(Request $request)
    {
        $validated = $request->validate([
            'device_uid' => 'required|string|max:255',
            'pairing_code' => 'required|string|size:6',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Check if device is already registered
        |--------------------------------------------------------------------------
        */

        $existingDevice = Device::where(
            'device_uid',
            $validated['device_uid']
        )->first();


        if ($existingDevice) {

            return response()->json([
                'success' => false,
                'registered' => true,
                'message' => 'This device is already registered.',
            ], 409);
        }


        /*
        |--------------------------------------------------------------------------
        | Store temporary pairing information
        |--------------------------------------------------------------------------
        |
        | We are using cache so you DON'T need another database table yet.
        |
        | Pairing expires after 10 minutes.
        |
        */

        $cacheKey =
            'esp32_pairing_' .
            $validated['device_uid'];


        cache()->put(
            $cacheKey,
            [
                'device_uid' =>
                    $validated['device_uid'],

                'pairing_code' =>
                    $validated['pairing_code'],

                'created_at' =>
                    now()->toDateTimeString(),
            ],
            now()->addMinutes(10)
        );


        // Allow doctor to find device using pairing code
        cache()->put(
            'esp32_pairing_code_' .
            $validated['pairing_code'],
            $validated['device_uid'],
            now()->addMinutes(10)
        );

        return response()->json([
            'success' => true,
            'message' => 'ESP32 is waiting for registration.',
            'device_uid' => $validated['device_uid'],
            'pairing_code' => $validated['pairing_code'],
            'expires_in' => 600,
        ]);
    }


    /**
     * =========================================================
     * ESP32: CHECK PAIRING STATUS
     * =========================================================
     *
     * ESP32 repeatedly calls:
     *
     * GET /api/device/pair/status
     *
     * Example:
     *
     * ?device_uid=ESP32-001&pairing_code=481927
     */
    public function pairStatus(Request $request)
    {
        $validated = $request->validate([
            'device_uid' => 'required|string|max:255',
            'pairing_code' => 'required|string|size:6',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Find temporary pairing request
        |--------------------------------------------------------------------------
        */

        $cacheKey =
            'esp32_pairing_' .
            $validated['device_uid'];


        $pairing =
            cache()->get($cacheKey);


        /*
        |--------------------------------------------------------------------------
        | No pairing request
        |--------------------------------------------------------------------------
        */

        if (!$pairing) {

            return response()->json([
                'success' => true,
                'paired' => false,
                'message' => 'No active pairing request.',
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Verify pairing code
        |--------------------------------------------------------------------------
        */

        if (
            !hash_equals(
                (string) $pairing['pairing_code'],
                (string) $validated['pairing_code']
            )
        ) {

            return response()->json([
                'success' => false,
                'paired' => false,
                'message' => 'Invalid pairing code.',
            ], 403);
        }


        /*
        |--------------------------------------------------------------------------
        | Check whether doctor has approved it
        |--------------------------------------------------------------------------
        |
        | The doctor dashboard will eventually call:
        *
        * POST /api/device/pair/approve
        *
        * Once approved, this cache entry will contain:
        *
        * doctor_id
        * approved = true
        *
        */

        if (
            empty($pairing['approved']) ||
            $pairing['approved'] !== true
        ) {

            return response()->json([
                'success' => true,
                'paired' => false,
                'message' => 'Waiting for doctor approval.',
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Create device
        |--------------------------------------------------------------------------
        */

        $device = Device::create([

            'doctor_id' =>
                $pairing['doctor_id'],

            'device_uid' =>
                $validated['device_uid'],

            /*
             * ESP32 currently doesn't send MAC address.
             *
             * We temporarily generate one.
             *
             * Later we can change the ESP32 to send
             * its real MAC address.
             */
            'mac_address' =>
                $pairing['mac_address']
                ?? $validated['device_uid'],

            'device_name' =>
                $pairing['device_name']
                ?? 'ESP32 Device',

            'firmware_version' =>
                $pairing['firmware_version']
                ?? null,

            'auth_token' =>
                Str::random(64),

            'status' =>
                'active',

            'last_seen_at' =>
                now(),
        ]);


        /*
        |--------------------------------------------------------------------------
        | Delete pairing request
        |--------------------------------------------------------------------------
        */

        cache()->forget(
            $cacheKey
        );


        /*
        |--------------------------------------------------------------------------
        | Return permanent device token
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'success' => true,
            'paired' => true,
            'message' => 'ESP32 registered successfully.',

            'device' => $device,

            'device_token' =>
                $device->auth_token,
        ]);
    }


    /**
     * =========================================================
     * DOCTOR: APPROVE ESP32 PAIRING
     * =========================================================
     *
     * Doctor enters the 6-digit code.
     *
     * Example:
     *
     * POST /api/device/pair/approve
     *
     * {
     *     "pairing_code": "481927",
     *     "device_name": "Patient Monitor"
     * }
     */
    public function pairApprove(Request $request)
    {
        $validated = $request->validate([
            'pairing_code' => 'required|string|size:6',
            'device_name' => 'nullable|string|max:255',
            'firmware_version' => 'nullable|string|max:100',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Find pairing request
        |--------------------------------------------------------------------------
        */

        $pairingKey = null;

        $pairing = null;


        /*
         * Laravel cache does not provide an easy way to
         * search all cache keys on every cache driver.
         *
         * Therefore, we use the pairing code lookup key
         * created below.
         */

        $codeKey =
            'esp32_pairing_code_' .
            $validated['pairing_code'];


        $deviceUid =
            cache()->get($codeKey);


        if (!$deviceUid) {

            return response()->json([
                'success' => false,
                'message' => 'Pairing code not found or expired.',
            ], 404);
        }


        $pairingKey =
            'esp32_pairing_' .
            $deviceUid;


        $pairing =
            cache()->get($pairingKey);


        if (!$pairing) {

            return response()->json([
                'success' => false,
                'message' => 'Pairing request expired.',
            ], 404);
        }


        /*
        |--------------------------------------------------------------------------
        | Approve
        |--------------------------------------------------------------------------
        */

        $pairing['approved'] = true;

        $pairing['doctor_id'] =
            auth()->id();


        if (
            !empty(
            $validated['device_name']
        )
        ) {
            $pairing['device_name'] =
                $validated['device_name'];
        }


        if (
            !empty(
            $validated['firmware_version']
        )
        ) {
            $pairing['firmware_version'] =
                $validated['firmware_version'];
        }


        /*
        |--------------------------------------------------------------------------
        | Save approval
        |--------------------------------------------------------------------------
        */

        cache()->put(
            $pairingKey,
            $pairing,
            now()->addMinutes(10)
        );


        return response()->json([
            'success' => true,
            'message' => 'ESP32 pairing approved.',
            'device_uid' => $deviceUid,
            'pairing_code' =>
                $validated['pairing_code'],
        ]);
    }


    /**
     * =========================================================
     * DOCTOR: REGISTER DEVICE MANUALLY
     * =========================================================
     *
     * Keep this method for manual registration.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'device_uid' =>
                'required|string|max:255|unique:devices,device_uid',

            'mac_address' =>
                'required|string|max:255|unique:devices,mac_address',

            'device_name' =>
                'nullable|string|max:255',

            'firmware_version' =>
                'nullable|string|max:100',
        ]);


        $device = Device::create([

            'doctor_id' =>
                auth()->id(),

            'device_uid' =>
                $validated['device_uid'],

            'mac_address' =>
                $validated['mac_address'],

            'device_name' =>
                $validated['device_name'] ?? null,

            'firmware_version' =>
                $validated['firmware_version'] ?? null,

            'auth_token' =>
                Str::random(64),

            'status' =>
                'active',

            'last_seen_at' =>
                now(),
        ]);


        return response()->json([
            'success' => true,

            'message' =>
                'ESP32 registered successfully.',

            'device' =>
                $device,

            'device_token' =>
                $device->auth_token,
        ], 201);
    }


    /**
     * =========================================================
     * DOCTOR: SHOW DEVICE
     * =========================================================
     */
    public function show($deviceId)
    {
        $device =
            Device::where(
                'doctor_id',
                auth()->id()
            )->findOrFail($deviceId);


        return response()->json([
            'success' => true,
            'device' => $device,
        ]);
    }


    /**
     * =========================================================
     * DOCTOR: UPDATE DEVICE
     * =========================================================
     */
    public function update(
        Request $request,
        $deviceId
    ) {
        $device =
            Device::where(
                'doctor_id',
                auth()->id()
            )->findOrFail($deviceId);


        $validated = $request->validate([
            'device_name' =>
                'nullable|string|max:255',

            'firmware_version' =>
                'nullable|string|max:100',

            'status' =>
                'nullable|in:active,inactive',
        ]);


        $device->update(
            $validated
        );


        return response()->json([
            'success' => true,

            'message' =>
                'Device updated successfully.',

            'device' =>
                $device,
        ]);
    }


    /**
     * =========================================================
     * DOCTOR: DELETE DEVICE
     * =========================================================
     */
    public function destroy(
        $deviceId
    ) {
        $device =
            Device::where(
                'doctor_id',
                auth()->id()
            )->findOrFail($deviceId);


        $device->delete();


        return response()->json([
            'success' => true,

            'message' =>
                'Device deleted successfully.',
        ]);
    }


    /**
     * =========================================================
     * DOCTOR: GET READINGS
     * =========================================================
     */
    public function readings(
        $deviceId
    ) {
        $device =
            Device::where(
                'doctor_id',
                auth()->id()
            )->findOrFail($deviceId);


        $readings =
            $device->readings()
                ->latest('recorded_at')
                ->get();


        return response()->json([
            'success' => true,

            'device' =>
                $device,

            'readings' =>
                $readings,
        ]);
    }
}