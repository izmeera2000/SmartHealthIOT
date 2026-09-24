<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Device;
use App\Models\SensorReading;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Facades\DataTables;

class PatientUserController extends Controller
{

    /**
     * Display the patient's sensor readings.
     */
    public function devices(Request $request): View
    {
        $patient = $request->user()
            ->patient()
            ->with([
                'devices.latestSensorReading',
            ])
            ->firstOrFail();

        return view('patient.devices.index', [
            'pageTitle' => 'My Devices',
            'patient' => $patient,
            'devices' => $patient->devices,
        ]);
    }


    public function readings(
        Request $request,

        Device $device
    ): View {

        $patient = $request->user()
            ->patient()
            ->firstOrFail();

        // Make sure this device belongs to the logged-in patient.
        abort_unless(
            $device->patient_id === $patient->id,
            403
        );

        $readingCount = $device->sensorReadings()->count();

        return view('patient.devices.readings', [
            'pageTitle' => 'Device Readings',
            'patient' => $patient,
            'device' => $device,
            'readingCount' => $readingCount,
        ]);
    }




    public function readingsData(
        Request $request,
        Device $device
    ): JsonResponse {

        $patient = $request->user()
            ->patient()
            ->firstOrFail();

        // Security check:
        // Only allow the patient to access their own device.
        abort_unless(
            $device->patient_id === $patient->id,
            403
        );

        $query = $device->sensorReadings()
            ->select([
                'id',
                'device_id',
                'heart_rate',
                'body_temperature',
                'ambient_temperature',
                'battery_level',
                'recorded_at',
            ])
            ->latest('recorded_at')
            ->limit(100);
        return DataTables::of($query)

            /*
            |--------------------------------------------------------------------------
            | Recorded At
            |--------------------------------------------------------------------------
            */

            ->editColumn('recorded_at', function ($reading) {

                if (!$reading->recorded_at) {
                    return '--';
                }

                return '
                <div class="fw-semibold">
                    ' . $reading->recorded_at->format('M d, Y') . '
                </div>

                <small class="text-muted">
                    ' . $reading->recorded_at->format('h:i:s A') . '
                </small>
            ';
            })


            /*
            |--------------------------------------------------------------------------
            | Heart Rate
            |--------------------------------------------------------------------------
            */

            ->editColumn('heart_rate', function ($reading) {

                if ($reading->heart_rate === null) {
                    return '--';
                }

                return '
                <span class="fw-semibold">
                    ' . $reading->heart_rate . '
                </span>

                <small class="text-muted">
                    BPM
                </small>
            ';
            })


            /*
            |--------------------------------------------------------------------------
            | Body Temperature
            |--------------------------------------------------------------------------
            */

            ->editColumn('body_temperature', function ($reading) {

                if ($reading->body_temperature === null) {
                    return '--';
                }

                return '
                <span class="fw-semibold">
                    ' . number_format($reading->body_temperature, 2) . '
                </span>

                <small class="text-muted">
                    °C
                </small>
            ';
            })


            /*
            |--------------------------------------------------------------------------
            | Ambient Temperature
            |--------------------------------------------------------------------------
            */

            ->editColumn('ambient_temperature', function ($reading) {

                if ($reading->ambient_temperature === null) {
                    return '--';
                }

                return '
                <span class="fw-semibold">
                    ' . number_format($reading->ambient_temperature, 2) . '
                </span>

                <small class="text-muted">
                    °C
                </small>
            ';
            })


            /*
            |--------------------------------------------------------------------------
            | Battery
            |--------------------------------------------------------------------------
            */

            ->editColumn('battery_level', function ($reading) {

                if ($reading->battery_level === null) {
                    return '--';
                }

                return '
                <div class="d-flex align-items-center gap-2">

                    <i class="bi bi-battery-half"></i>

                    <span class="fw-semibold">
                        ' . $reading->battery_level . '%
                    </span>

                </div>
            ';
            })


            /*
            |--------------------------------------------------------------------------
            | Allow HTML
            |--------------------------------------------------------------------------
            */

            ->rawColumns([
                'recorded_at',
                'heart_rate',
                'body_temperature',
                'ambient_temperature',
                'battery_level',
            ])

            ->make(true);
    }



    /**
     * Display patient's activity logs.
     */
    public function activity(Request $request): View
    {
        $user = $request->user();

        $activities = $user->activities()
            ->latest()
            ->paginate(20);

        return view('patient.activity.index', [
            'pageTitle' => 'Activity',
            'activities' => $activities,
        ]);
    }

    /**
     * Display patient's notifications.
     */
    public function notifications(Request $request): View
    {
        $notifications = $request->user()
            ->notifications()
            ->latest()
            ->paginate(20);

        $unreadCount = $request->user()
            ->unreadNotifications()
            ->count();

        return view('patient.notifications.index', [
            'pageTitle' => 'Notifications',
            'notifications' => $notifications,
            'unreadCount' => $unreadCount,
        ]);
    }

    /**
     * Mark one notification as read.
     */
    public function markNotificationRead(
        Request $request,
        string $notification
    ) {
        $user = $request->user();

        $item = $user->notifications()
            ->where('id', $notification)
            ->firstOrFail();

        $item->markAsRead();

        return back();
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllNotificationsRead(Request $request)
    {
        $request->user()
            ->unreadNotifications
            ->markAsRead();

        return back();
    }
}