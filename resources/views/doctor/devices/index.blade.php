@extends('layouts.app')

@section('content')

<section class="section">

    {{-- HEADER --}}
    <div class="card">
        <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-3">

            <div>
                <h5 class="card-title mb-1">
                    Devices
                </h5>

                <small class="text-muted">
                    Manage your registered ESP32 devices
                </small>
            </div>

            <a href="{{ route('doctor.devices.create') }}"
               class="btn btn-primary">
                <i class="bi bi-plus-lg"></i>
                Register Device
            </a>

        </div>

        <div class="card-body">

            {{-- SUCCESS MESSAGE --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead>
                        <tr>
                            <th>Device</th>
                            <th>Device UID</th>
                            <th>Patient</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Last Seen</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($devices as $device)

                            <tr>

                                {{-- DEVICE --}}
                                <td>
                                    <div class="fw-semibold">
                                        {{ $device->device_name ?: 'Unnamed Device' }}
                                    </div>

                                    <small class="text-muted">
                                        {{ $device->mac_address }}
                                    </small>
                                </td>

                                {{-- UID --}}
                                <td>
                                    <code>
                                        {{ $device->device_uid }}
                                    </code>
                                </td>

                                {{-- PATIENT --}}
                                <td>

                                    @if($device->patient && $device->patient->user)

                                        <div class="fw-semibold">
                                            {{ $device->patient->user->name }}
                                        </div>

                                        <small class="text-muted">
                                            Patient
                                        </small>

                                    @else

                                        <span class="text-muted">
                                            Unassigned
                                        </span>

                                    @endif

                                </td>

                                {{-- TYPE --}}
                                <td>
                                    {{ $device->device_type ?: '-' }}
                                </td>

                                {{-- STATUS --}}
                                <td>

                                    @if($device->status === 'active')

                                        <span class="badge bg-success">
                                            Active
                                        </span>

                                    @else

                                        <span class="badge bg-secondary">
                                            Inactive
                                        </span>

                                    @endif

                                </td>

                                {{-- LAST SEEN --}}
                                <td>

                                    @if($device->last_seen_at)

                                        <span title="{{ $device->last_seen_at }}">
                                            {{ $device->last_seen_at->diffForHumans() }}
                                        </span>

                                    @else

                                        <span class="text-muted">
                                            Never
                                        </span>

                                    @endif

                                </td>

                                {{-- ACTIONS --}}
                                <td class="text-end">

                                    <div class="btn-group">

                                        <a href="{{ route('doctor.devices.show', $device) }}"
                                           class="btn btn-sm btn-outline-primary"
                                           title="View Device">

                                            <i class="bi bi-eye"></i>

                                        </a>
{{-- 
                                        <a href="{{ route('doctor.devices.readings', $device) }}"
                                           class="btn btn-sm btn-outline-success"
                                           title="View Readings">

                                            <i class="bi bi-activity"></i>

                                        </a> --}}

                                        <form action="{{ route('doctor.devices.destroy', $device) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Delete this device?');">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-sm btn-outline-danger"
                                                    title="Delete">

                                                <i class="bi bi-trash"></i>

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="7"
                                    class="text-center py-5">

                                    <div class="mb-3">
                                        <i class="bi bi-cpu fs-1 text-muted"></i>
                                    </div>

                                    <h6>
                                        No devices registered
                                    </h6>

                                    <p class="text-muted mb-3">
                                        Register an ESP32 device to start monitoring sensor readings.
                                    </p>

                                    <a href="{{ route('doctor.devices.create') }}"
                                       class="btn btn-primary">

                                        <i class="bi bi-plus-lg"></i>
                                        Register Device

                                    </a>

                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>
    </div>

</section>

@endsection
 