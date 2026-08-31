@extends('layouts.app')

@section('content')

    <section class="section">



        <div class="row">

            {{-- ========================================================== --}}
            {{-- LEFT COLUMN --}}
            {{-- ========================================================== --}}

            <div class="col-xl-4">

                {{-- Patient Profile --}}
                <div class="card">

                    <div class="card-header">

                        <h5 class="card-title mb-0">
                            Patient Profile
                        </h5>

                    </div>


                    <div class="card-body text-center">

                        <img src="{{ asset('assets/img/avatars/avatar-1.webp') }}" alt="{{ $patient->user?->name }}"
                            class="rounded-circle mb-3" width="120" height="120">


                        <h4 class="mb-1">

                            {{ $patient->user?->name ?? 'Unknown Patient' }}

                        </h4>


                        <div class="text-muted mb-3">

                            {{ $patient->patient_id }}

                        </div>


                        @if($patient->gender)

                            <span class="badge bg-light ">

                                <i class="bi bi-person me-1"></i>

                                {{ ucfirst($patient->gender) }}

                            </span>

                        @endif


                        @if($patient->date_of_birth)

                            <span class="badge bg-light  ">

                                <i class="bi bi-calendar me-1"></i>

                                {{ $patient->date_of_birth->age }} years old

                            </span>

                        @endif

                    </div>

                </div>


                {{-- Account Information --}}
                <div class="card">

                    <div class="card-header">

                        <h5 class="card-title mb-0">
                            Account Information
                        </h5>

                    </div>


                    <div class="card-body">

                        <div class="mb-3">

                            <div class="text-muted small">
                                Name
                            </div>

                            <div class="fw-semibold">

                                {{ $patient->user?->name ?? '-' }}

                            </div>

                        </div>


                        <div class="mb-3">

                            <div class="text-muted small">
                                Email
                            </div>

                            <div class="fw-semibold">

                                {{ $patient->user?->email ?? '-' }}

                            </div>

                        </div>


                        <div>

                            <div class="text-muted small">
                                Account Created
                            </div>

                            <div class="fw-semibold">

                                {{ $patient->user?->created_at?->format('d M Y, h:i A') ?? '-' }}

                            </div>

                        </div>

                    </div>

                </div>


                {{-- Patient ID --}}
                <div class="card">

                    <div class="card-header">

                        <h5 class="card-title mb-0">
                            Patient ID
                        </h5>

                    </div>


                    <div class="card-body">

                        <div class="d-flex align-items-center justify-content-between">

                            <div>

                                <div class="text-muted small">
                                    Patient Identifier
                                </div>

                                <div class="fw-bold fs-5">

                                    {{ $patient->patient_id }}

                                </div>

                            </div>


                            <i class="bi bi-person-vcard fs-2 text-primary"></i>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ========================================================== --}}
            {{-- RIGHT COLUMN --}}
            {{-- ========================================================== --}}

            <div class="col-xl-8">

                {{-- Personal Information --}}
                <div class="card">

                    <div class="card-header">

                        <h5 class="card-title mb-0">
                            Personal Information
                        </h5>

                    </div>


                    <div class="card-body">

                        <div class="row">

                            {{-- Full Name --}}
                            <div class="col-md-6 mb-4">

                                <div class="text-muted small mb-1">
                                    Full Name
                                </div>

                                <div class="fw-semibold">
                                    {{ $patient->user?->name ?? '-' }}
                                </div>

                            </div>


                            {{-- Email --}}
                            <div class="col-md-6 mb-4">

                                <div class="text-muted small mb-1">
                                    Email Address
                                </div>

                                <div class="fw-semibold">
                                    {{ $patient->user?->email ?? '-' }}
                                </div>

                            </div>


                            {{-- IC Number --}}
                            <div class="col-md-6 mb-4">

                                <div class="text-muted small mb-1">
                                    IC Number
                                </div>

                                <div class="fw-semibold">
                                    {{ $patient->ic_number ?: '-' }}
                                </div>

                            </div>


                            {{-- Date of Birth --}}
                            <div class="col-md-6 mb-4">

                                <div class="text-muted small mb-1">
                                    Date of Birth
                                </div>

                                <div class="fw-semibold">

                                    {{ $patient->date_of_birth
        ? $patient->date_of_birth->format('d M Y')
        : '-'
                                    }}

                                </div>

                            </div>


                            {{-- Age --}}
                            <div class="col-md-6 mb-4">

                                <div class="text-muted small mb-1">
                                    Age
                                </div>

                                <div class="fw-semibold">

                                    {{ $patient->date_of_birth
        ? $patient->date_of_birth->age . ' years'
        : '-'
                                    }}

                                </div>

                            </div>


                            {{-- Gender --}}
                            <div class="col-md-6 mb-4">

                                <div class="text-muted small mb-1">
                                    Gender
                                </div>

                                <div class="fw-semibold">

                                    {{ $patient->gender
        ? ucfirst($patient->gender)
        : '-'
                                    }}

                                </div>

                            </div>


                            {{-- Phone --}}
                            <div class="col-md-6 mb-4">

                                <div class="text-muted small mb-1">
                                    Phone Number
                                </div>

                                <div class="fw-semibold">

                                    {{ $patient->phone ?: '-' }}

                                </div>

                            </div>


                            {{-- Blood Type --}}
                            <div class="col-md-6 mb-4">

                                <div class="text-muted small mb-1">
                                    Blood Type
                                </div>

                                <div class="fw-semibold">

                                    @if($patient->blood_type)

                                        <span class="badge bg-danger-subtle text-danger">

                                            {{ $patient->blood_type }}

                                        </span>

                                    @else

                                        -

                                    @endif

                                </div>

                            </div>


                            {{-- Height --}}
                            <div class="col-md-6 mb-4">

                                <div class="text-muted small mb-1">
                                    Height
                                </div>

                                <div class="fw-semibold">

                                    {{ $patient->height
        ? $patient->height . ' cm'
        : '-'
                                    }}

                                </div>

                            </div>


                            {{-- Weight --}}
                            <div class="col-md-6 mb-4">

                                <div class="text-muted small mb-1">
                                    Weight
                                </div>

                                <div class="fw-semibold">

                                    {{ $patient->weight
        ? $patient->weight . ' kg'
        : '-'
                                    }}

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- Address --}}
                <div class="card">

                    <div class="card-header">

                        <h5 class="card-title mb-0">
                            Address
                        </h5>

                    </div>


                    <div class="card-body">

                        @if($patient->address)

                            <div class="d-flex gap-3">

                                <i class="bi bi-geo-alt fs-4 text-primary"></i>

                                <div>

                                    {{ $patient->address }}

                                </div>

                            </div>

                        @else

                            <span class="text-muted">
                                No address provided.
                            </span>

                        @endif

                    </div>

                </div>


                {{-- Emergency Contact --}}
                <div class="card">

                    <div class="card-header">

                        <h5 class="card-title mb-0">
                            Emergency Contact
                        </h5>

                    </div>


                    <div class="card-body">

                        <div class="row">

                            {{-- Name --}}
                            <div class="col-md-4 mb-3">

                                <div class="text-muted small mb-1">
                                    Contact Name
                                </div>

                                <div class="fw-semibold">

                                    {{ $patient->emergency_contact_name ?: '-' }}

                                </div>

                            </div>


                            {{-- Phone --}}
                            <div class="col-md-4 mb-3">

                                <div class="text-muted small mb-1">
                                    Contact Phone
                                </div>

                                <div class="fw-semibold">

                                    {{ $patient->emergency_contact_phone ?: '-' }}

                                </div>

                            </div>


                            {{-- Relationship --}}
                            <div class="col-md-4 mb-3">

                                <div class="text-muted small mb-1">
                                    Relationship
                                </div>

                                <div class="fw-semibold">

                                    {{ $patient->emergency_contact_relationship ?: '-' }}

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- Record Information --}}
                <div class="card">

                    <div class="card-header">

                        <h5 class="card-title mb-0">
                            Record Information
                        </h5>

                    </div>


                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-6">

                                <div class="text-muted small mb-1">
                                    Patient Created
                                </div>

                                <div class="fw-semibold">

                                    {{ $patient->created_at?->format('d M Y, h:i A') ?? '-' }}

                                </div>

                            </div>


                            <div class="col-md-6">

                                <div class="text-muted small mb-1">
                                    Last Updated
                                </div>

                                <div class="fw-semibold">

                                    {{ $patient->updated_at?->format('d M Y, h:i A') ?? '-' }}

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- Assigned Device --}}

                {{-- Assigned Devices --}}

                <div class="card">

                    <div class="card-header">

                        <h5 class="card-title mb-0">
                            Assigned Devices
                        </h5>

                    </div>

                    <div class="card-body">

                        @forelse($patient->devices as $device)

                            <div class="d-flex align-items-center justify-content-between
                               {{ !$loop->last ? 'border-bottom pb-3 mb-3' : '' }}">

                                <div class="d-flex align-items-center gap-3">

                                    {{-- Device Icon --}}

                                    <div class="rounded-circle bg-primary-subtle
                                       d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">

                                        <i class="bi bi-cpu fs-4 text-primary"></i>

                                    </div>


                                    {{-- Device Information --}}

                                    <div>

                                        <div class="fw-semibold">

                                            {{ $device->device_name ?: 'Unnamed Device' }}

                                        </div>

                                        <div class="text-muted small">

                                            {{ $device->device_uid }}

                                        </div>

                                    </div>

                                </div>


                                {{-- Status --}}

                                <div>

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

                            </div>


                            {{-- Device Details --}}

                            <div class="row mt-2 {{ !$loop->last ? 'mb-3' : '' }}">

                                <div class="col-md-6">

                                    <div class="text-muted small">
                                        Device UID
                                    </div>

                                    <div class="fw-semibold">
                                        {{ $device->device_uid }}
                                    </div>

                                </div>


                                <div class="col-md-6">

                                    <div class="text-muted small">
                                        Last Seen
                                    </div>

                                    <div class="fw-semibold">

                                        {{ $device->last_seen_at?->diffForHumans() ?? 'Never' }}

                                    </div>

                                </div>

                            </div>

                        @empty

                            <div class="text-center py-4">

                                <i class="bi bi-cpu fs-2 text-muted"></i>

                                <div class="fw-semibold mt-2">
                                    No Devices Assigned
                                </div>

                                <small class="text-muted">
                                    This patient does not currently have any devices.
                                </small>

                            </div>

                        @endforelse

                    </div>

                </div>



                {{-- Actions --}}
                <div class="d-flex justify-content-end gap-2 mb-4">

                    <a href="{{ route('doctor.patients.index') }}" class="btn btn-secondary">

                        <i class="bi bi-arrow-left me-1"></i>

                        Back to Patients

                    </a>


                    <a href="{{ route('doctor.patients.edit', $patient) }}" class="btn btn-primary">

                        <i class="bi bi-pencil me-1"></i>

                        Edit Patient

                    </a>

                </div>

            </div>

        </div>

    </section>

@endsection