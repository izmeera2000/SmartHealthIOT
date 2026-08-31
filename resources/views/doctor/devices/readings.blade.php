@extends('layouts.app')

@section('content')

<section class="section">

    {{-- HEADER --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">

        <div>

            <h5 class="mb-1">
                Sensor Readings
            </h5>

            <small class="text-muted">
                {{ $device->device_name ?: 'Unnamed Device' }}
                · {{ $device->device_uid }}
            </small>

        </div>

        <a href="{{ route('doctor.devices.show', $device) }}"
           class="btn btn-outline-secondary">

            <i class="bi bi-arrow-left"></i>
            Device

        </a>

    </div>


    {{-- DEVICE INFO --}}
    <div class="card mb-4">

        <div class="card-body">

            <div class="row align-items-center">

                <div class="col-md-4">

                    <small class="text-muted d-block">
                        Patient
                    </small>

                    <strong>

                        @if($device->patient?->user)
                            {{ $device->patient->user->name }}
                        @else
                            Unassigned
                        @endif

                    </strong>

                </div>

                <div class="col-md-4">

                    <small class="text-muted d-block">
                        Device Status
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


    {{-- READINGS TABLE --}}
    <div class="card">

        <div class="card-header">

            <h6 class="mb-0">
                Reading History
            </h6>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead>

                        <tr>
                            <th>Recorded</th>
                            <th>Heart Rate</th>
                            <th>SpO₂</th>
                            <th>Body Temp</th>
                            <th>Ambient Temp</th>
                            <th>Battery</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($readings as $reading)

                            <tr>

                                {{-- TIME --}}
                                <td>

                                    <div class="fw-semibold">
                                        {{ $reading->recorded_at->format('d M Y') }}
                                    </div>

                                    <small class="text-muted">
                                        {{ $reading->recorded_at->format('h:i:s A') }}
                                    </small>

                                </td>


                                {{-- HEART RATE --}}
                                <td>

                                    @if($reading->heart_rate !== null)

                                        <strong>
                                            {{ $reading->heart_rate }}
                                        </strong>

                                        <small class="text-muted">
                                            BPM
                                        </small>

                                    @else
                                        -
                                    @endif

                                </td>


                                {{-- SPO2 --}}
                                <td>

                                    @if($reading->spo2 !== null)

                                        <strong>
                                            {{ $reading->spo2 }}
                                        </strong>

                                        <small class="text-muted">
                                            %
                                        </small>

                                    @else
                                        -
                                    @endif

                                </td>


                                {{-- BODY TEMP --}}
                                <td>

                                    @if($reading->body_temperature !== null)

                                        <strong>
                                            {{ number_format($reading->body_temperature, 2) }}
                                        </strong>

                                        <small class="text-muted">
                                            °C
                                        </small>

                                    @else
                                        -
                                    @endif

                                </td>


                                {{-- AMBIENT TEMP --}}
                                <td>

                                    @if($reading->ambient_temperature !== null)

                                        <strong>
                                            {{ number_format($reading->ambient_temperature, 2) }}
                                        </strong>

                                        <small class="text-muted">
                                            °C
                                        </small>

                                    @else
                                        -
                                    @endif

                                </td>


                                {{-- BATTERY --}}
                                <td>

                                    @if($reading->battery_level !== null)

                                        <strong>
                                            {{ $reading->battery_level }}
                                        </strong>

                                        <small class="text-muted">
                                            %
                                        </small>

                                    @else
                                        -
                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6"
                                    class="text-center py-5">

                                    <i class="bi bi-activity fs-1 text-muted"></i>

                                    <h6 class="mt-3">
                                        No readings found
                                    </h6>

                                    <p class="text-muted mb-0">
                                        This device has not submitted any sensor readings yet.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- PAGINATION --}}
            @if($readings->hasPages())

                <div class="d-flex justify-content-center mt-4">

                    {{ $readings->links() }}

                </div>

            @endif

        </div>

    </div>

</section>

@endsection
 