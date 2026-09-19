<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('doctor')) {
            return view('doctor.dashboard');
        }

        if ($user->hasRole('patient')) {

            $patient = $user->patient;

            $device = null;
            $sensorReadings = collect();

            if ($patient) {

                $device = $patient->devices()
                    ->with('latestSensorReading')
                    ->latest()
                    ->first();

                if ($device) {

                    $sensorReadings = $device->sensorReadings()
                        ->where(
                            'recorded_at',
                            '>=',
                            now()->subDays(90)
                        )
                        ->orderBy('recorded_at')
                        ->get([
                            'heart_rate',
                            'spo2',
                            'body_temperature',
                            'ambient_temperature',
                            'recorded_at',
                        ]);
                }
            }

            return view('patient.dashboard', compact(
                'patient',
                'device',
                'sensorReadings'
            ));
        }

        abort(403, 'Unauthorized role.');
    }
}