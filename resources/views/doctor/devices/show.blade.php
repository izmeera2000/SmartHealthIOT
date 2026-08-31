@extends('layouts.app')

@section('content')

<section class="section">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h5 class="mb-1">
                {{ $device->device_name ?: 'Unnamed Device' }}
            </h5>

            <small class="text-muted">
                {{ $device->device_uid }}
            </small>
        </div>

        <div class="d-flex gap-2">

            <a href="{{ route('doctor.devices.readings', $device) }}"
               class="btn btn-success">

                <i class="bi bi-activity"></i>
                View Readings

            </a>

            <a href="{{ route('doctor.devices.index') }}"
               class="btn btn-outline-secondary">

                <i class="bi bi-arrow-left"></i>
                Back

            </a>

        </div>

    </div>


    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif


    {{-- DEVICE INFORMATION --}}
    <div class="card mb-4">

        <div class="card-header">
            <h6 class="mb-0">
                Device Information
            </h6>
        </div>

        <div class="card-body">

            <div class="row g-4">

                <div class="col-md-4">
                    <small class="text-muted d-block">
                        Device UID
                    </small>

                    <strong>
                        {{ $device->device_uid }}
                    </strong>
                </div>

                <div class="col-md-4">
                    <small class="text-muted d-block">
                        MAC Address
                    </small>

                    <strong>
                        {{ $device->mac_address }}
                    </strong>
                </div>

                <div class="col-md-4">
                    <small class="text-muted d-block">
                        Device Type
                    </small>

                    <strong>
                        {{ $device->device_type ?: '-' }}
                    </strong>
                </div>

                <div class="col-md-4">
                    <small class="text-muted d-block">
                        Firmware
                    </small>

                    <strong>
                        {{ $device->firmware_version ?: '-' }}
                    </strong>
                </div>

                <div class="col-md-4">
                    <small class="text-muted d-block">
                        Status
                    </small>

                    @if($device->status === 'active')

                        <span class="badge bg-success">
                            Active
                        </span>

                    @else

                        <span class="badge bg-secondary">
                            Inactive
                        </span>

                    @endif
                </div>

                <div class="col-md-4">
                    <small class="text-muted d-block">
                        Last Seen
                    </small>

                    <strong>
                        {{ $device->last_seen_at?->diffForHumans() ?? 'Never' }}
                    </strong>
                </div>

            </div>

        </div>

    </div>


    {{-- PATIENT --}}
    <div class="card mb-4">

        <div class="card-header">
            <h6 class="mb-0">
                Assigned Patient
            </h6>
        </div>

        <div class="card-body">

            @if($device->patient && $device->patient->user)

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <h6 class="mb-1">
                            {{ $device->patient->user->name }}
                        </h6>

                        <small class="text-muted">
                            Patient
                        </small>

                    </div>

                </div>

            @else

                <span class="text-muted">
                    No patient assigned to this device.
                </span>

            @endif

        </div>

    </div>


    {{-- LATEST READING --}}
    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h6 class="mb-0">
                Latest Reading
            </h6>

            <a href="{{ route('doctor.devices.readings', $device) }}"
               class="btn btn-sm btn-outline-primary">

                View History

            </a>

        </div>

        <div class="card-body">

            @if($latestReading)

                <div class="row g-3">

                    {{-- HEART RATE --}}
                    <div class="col-md-4 col-lg-2">

                        <div class="border rounded p-3 h-100">

                            <small class="text-muted">
                                Heart Rate
                            </small>

                            <h4 class="mb-0 mt-2">
                                {{ $latestReading->heart_rate ?? '-' }}

                                @if($latestReading->heart_rate !== null)
                                    <small class="fs-6">BPM</small>
                                @endif
                            </h4>

                        </div>

                    </div>


                    {{-- SPO2 --}}
                    <div class="col-md-4 col-lg-2">

                        <div class="border rounded p-3 h-100">

                            <small class="text-muted">
                                SpO₂
                            </small>

                            <h4 class="mb-0 mt-2">
                                {{ $latestReading->spo2 ?? '-' }}

                                @if($latestReading->spo2 !== null)
                                    <small class="fs-6">%</small>
                                @endif
                            </h4>

                        </div>

                    </div>


                    {{-- BODY TEMP --}}
                    <div class="col-md-4 col-lg-2">

                        <div class="border rounded p-3 h-100">

                            <small class="text-muted">
                                Body Temperature
                            </small>

                            <h4 class="mb-0 mt-2">
                                {{ $latestReading->body_temperature ?? '-' }}

                                @if($latestReading->body_temperature !== null)
                                    <small class="fs-6">°C</small>
                                @endif
                            </h4>

                        </div>

                    </div>


                    {{-- AMBIENT TEMP --}}
                    <div class="col-md-4 col-lg-2">

                        <div class="border rounded p-3 h-100">

                            <small class="text-muted">
                                Ambient Temperature
                            </small>

                            <h4 class="mb-0 mt-2">
                                {{ $latestReading->ambient_temperature ?? '-' }}

                                @if($latestReading->ambient_temperature !== null)
                                    <small class="fs-6">°C</small>
                                @endif
                            </h4>

                        </div>

                    </div>


                    {{-- BATTERY --}}
                    <div class="col-md-4 col-lg-2">

                        <div class="border rounded p-3 h-100">

                            <small class="text-muted">
                                Battery
                            </small>

                            <h4 class="mb-0 mt-2">
                                {{ $latestReading->battery_level ?? '-' }}

                                @if($latestReading->battery_level !== null)
                                    <small class="fs-6">%</small>
                                @endif
                            </h4>

                        </div>

                    </div>


                    {{-- TIME --}}
                    <div class="col-md-4 col-lg-2">

                        <div class="border rounded p-3 h-100">

                            <small class="text-muted">
                                Recorded
                            </small>

                            <div class="fw-semibold mt-2">
                                {{ $latestReading->recorded_at->diffForHumans() }}
                            </div>

                        </div>

                    </div>

                </div>

            @else

                <div class="text-center py-4">

                    <i class="bi bi-activity fs-1 text-muted"></i>

                    <p class="text-muted mt-2 mb-0">
                        No sensor readings available yet.
                    </p>

                </div>

            @endif

        </div>

    </div>

</section>

@endsection

