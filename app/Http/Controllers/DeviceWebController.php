<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Patient;
use App\Models\SensorReading;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DeviceWebController extends Controller
{
    /**
     * =========================================================
     * DEVICE DASHBOARD
     * =========================================================
     */
    public function index()
    {
        $devices = Device::with(['patient.user'])
            ->where('doctor_id', auth()->id())
            ->latest()
            ->get();

        return view(
            'doctor.devices.index',
            compact('devices')
        );
    }


    /**
     * =========================================================
     * REGISTRATION FORM
     * =========================================================
     */
public function create()
{
    $patients = Patient::with('user')
        ->where('doctor_id', auth()->id())
        ->latest()
        ->get();

    return view(
        'doctor.devices.create',
        compact('patients')
    );
}


    /**
     * =========================================================
     * REGISTER DEVICE
     * =========================================================
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'device_uid' =>
                'required|string|max:255|unique:devices,device_uid',

            'mac_address' =>
                'required|string|max:255|unique:devices,mac_address',

            'device_name' =>
                'nullable|string|max:255',

            'device_type' =>
                'nullable|string|max:100',

            'firmware_version' =>
                'nullable|string|max:100',

            'patient_id' =>
                'nullable|exists:patients,id',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Verify patient belongs to logged-in doctor
        |--------------------------------------------------------------------------
        */

        if (!empty($validated['patient_id'])) {

            $patient = Patient::where(
                'id',
                $validated['patient_id']
            )
                ->where(
                    'doctor_id',
                    auth()->id()
                )
                ->firstOrFail();
        }


        /*
        |--------------------------------------------------------------------------
        | Create device
        |--------------------------------------------------------------------------
        */

        $device = Device::create([

            'doctor_id' =>
                auth()->id(),

            'patient_id' =>
                $validated['patient_id'] ?? null,

            'device_uid' =>
                $validated['device_uid'],

            'mac_address' =>
                $validated['mac_address'],

            'device_name' =>
                $validated['device_name'] ?? null,

            'device_type' =>
                $validated['device_type'] ?? null,

            'firmware_version' =>
                $validated['firmware_version'] ?? null,

            'auth_token' =>
                Str::random(64),

            'status' =>
                'active',

            'last_seen_at' =>
                now(),

            'registered_at' =>
                now(),
        ]);


        return redirect()
            ->route('doctor.devices.show', $device)
            ->with(
                'success',
                'ESP32 registered successfully.'
            );
    }


    /**
     * =========================================================
     * DEVICE DETAILS
     * =========================================================
     */
    public function show(Device $device)
    {
        // abort_unless(
        //     $device->doctor_id === auth()->id(),
        //     403
        // );


        /*
        |--------------------------------------------------------------------------
        | Load patient + readings
        |--------------------------------------------------------------------------
        */

        $device->load([
            'patient.user',
        ]);


        $latestReading = $device
            ->sensorReadings()
            ->latest('recorded_at')
            ->first();


        return view(
            'doctor.devices.show',
            compact(
                'device',
                'latestReading'
            )
        );
    }


    /**
     * =========================================================
     * DEVICE READINGS
     * =========================================================
     */
    public function readings(Device $device)
    {
        abort_unless(
            $device->doctor_id === auth()->id(),
            403
        );


        $readings = $device
            ->sensorReadings()
            ->latest('recorded_at')
            ->paginate(20);


        return view(
            'doctor.devices.readings',
            compact(
                'device',
                'readings'
            )
        );
    }


    /**
     * =========================================================
     * TEST SENSOR READING
     * =========================================================
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

            'heart_rate' =>
                'nullable|integer|min:0|max:250',

            'spo2' =>
                'nullable|integer|min:0|max:100',

            'body_temperature' =>
                'nullable|numeric|between:20,50',

            'ambient_temperature' =>
                'nullable|numeric|between:-20,80',

            'battery_level' =>
                'nullable|integer|between:0,100',
        ]);


        SensorReading::create([

            'device_id' =>
                $device->id,

            'heart_rate' =>
                $validated['heart_rate'] ?? null,

            'spo2' =>
                $validated['spo2'] ?? null,

            'body_temperature' =>
                $validated['body_temperature'] ?? null,

            'ambient_temperature' =>
                $validated['ambient_temperature'] ?? null,

            'battery_level' =>
                $validated['battery_level'] ?? null,

            'recorded_at' =>
                now(),
        ]);


        /*
        |--------------------------------------------------------------------------
        | Update device last seen
        |--------------------------------------------------------------------------
        */

        $device->update([
            'last_seen_at' => now(),
            'status' => 'active',
        ]);


        return back()->with(
            'success',
            'Test sensor reading added.'
        );
    }


    /**
     * =========================================================
     * ASSIGN DEVICE TO PATIENT
     * =========================================================
     */
    public function assignPatient(
        Request $request,
        Device $device
    ) {
        abort_unless(
            $device->doctor_id === auth()->id(),
            403
        );


        $validated = $request->validate([
            'patient_id' =>
                'required|exists:patients,id',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Make sure patient belongs to this doctor
        |--------------------------------------------------------------------------
        */

        $patient = Patient::where(
            'id',
            $validated['patient_id']
        )
            ->where(
                'doctor_id',
                auth()->id()
            )
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | Assign device
        |--------------------------------------------------------------------------
        */

        $device->update([
            'patient_id' =>
                $patient->id,
        ]);


        return back()->with(
            'success',
            'Device assigned to patient successfully.'
        );
    }


    /**
     * =========================================================
     * UNASSIGN DEVICE FROM PATIENT
     * =========================================================
     */
    public function unassignPatient(Device $device)
    {
        abort_unless(
            $device->doctor_id === auth()->id(),
            403
        );


        $device->update([
            'patient_id' => null,
        ]);


        return back()->with(
            'success',
            'Device unassigned from patient.'
        );
    }


    /**
     * =========================================================
     * DELETE DEVICE
     * =========================================================
     */
    public function destroy(Device $device)
    {
        abort_unless(
            $device->doctor_id === auth()->id(),
            403
        );


        $device->delete();


        return redirect()
            ->route('doctor.devices.index')
            ->with(
                'success',
                'Device deleted.'
            );
    }
}