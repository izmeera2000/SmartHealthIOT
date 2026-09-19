@extends('layouts.app')

@section('title', $pageTitle)

@section('content')

 

<section class="section profile">

 
<div class="row">

    {{-- ========================================================= --}}
    {{-- PROFILE SIDEBAR --}}
    {{-- ========================================================= --}}

    <div class="col-xl-4">

        <div class="profile-card">

            {{-- Avatar --}}

            <div class="profile-card-avatar">

                <img
                    src="{{ $doctor->user?->profile_photo
                        ? asset('storage/' . $doctor->user->profile_photo)
                        : asset('assets/img/profile-img.webp') }}"
                    alt="{{ $doctor->user?->name ?? 'Doctor' }}"
                >

            </div>


            {{-- Basic Information --}}

            <div class="profile-card-info">

                <h2>
                    {{ $doctor->user?->name ?? 'Unknown Doctor' }}
                </h2>

                <p class="profile-role">
                    {{ $doctor->specialization ?: 'Doctor' }}
                </p>

                <p class="profile-location">

                    <i class="bi bi-person-badge"></i>

                    {{ $doctor->doctor_id }}

                </p>

            </div>


            {{-- Stats --}}

            <div class="profile-card-stats">

                <div class="profile-stat">

                    <span class="profile-stat-value">
                        {{ $doctor->patients_count ?? 0 }}
                    </span>

                    <span class="profile-stat-label">
                        Patients
                    </span>

                </div>


                <div class="profile-stat">

                    <span class="profile-stat-value">
                        {{ $doctor->devices_count ?? 0 }}
                    </span>

                    <span class="profile-stat-label">
                        Devices
                    </span>

                </div>


                <div class="profile-stat">

                    <span class="profile-stat-value">

                        @if($doctor->user?->hasRole('doctor'))
                            Doctor
                        @else
                            —
                        @endif

                    </span>

                    <span class="profile-stat-label">
                        Role
                    </span>

                </div>

            </div>


            {{-- Account Status --}}

            <div class="text-center mt-3">

                @php
                    $isActive = method_exists($doctor->user, 'isActive')
                        ? $doctor->user->isActive()
                        : ($doctor->user->is_active ?? true);
                @endphp

                @if($isActive)

                    <span class="badge bg-success">
                        <i class="bi bi-check-circle me-1"></i>
                        Active
                    </span>

                @else

                    <span class="badge bg-secondary">
                        <i class="bi bi-pause-circle me-1"></i>
                        Inactive
                    </span>

                @endif

            </div>

        </div>


        {{-- Quick Actions --}}

        <div class="profile-actions">

            <a
                href="{{ route('profile.edit') }}"
                class="profile-action-btn bg-white text-black"
            >

                <i class="bi bi-pencil"></i>

                <span>Edit Profile</span>

            </a>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- PROFILE CONTENT --}}
    {{-- ========================================================= --}}

    <div class="col-xl-8">


        {{-- ===================================================== --}}
        {{-- TABS --}}
        {{-- ===================================================== --}}

        <div class="profile-tabs-wrapper">

            <div class="profile-tabs">

                <button
                    type="button"
                    class="profile-tab active"
                    data-tab="overview"
                >

                    <i class="bi bi-person"></i>

                    <span>Overview</span>

                </button>


                <button
                    type="button"
                    class="profile-tab"
                    data-tab="patients"
                >

                    <i class="bi bi-people"></i>

                    <span>Patients</span>

                </button>


                <button
                    type="button"
                    class="profile-tab"
                    data-tab="devices"
                >

                    <i class="bi bi-cpu"></i>

                    <span>Devices</span>

                </button>

            </div>

        </div>


        {{-- ===================================================== --}}
        {{-- TAB CONTENT --}}
        {{-- ===================================================== --}}

        <div class="profile-tab-content">


            {{-- ================================================= --}}
            {{-- OVERVIEW --}}
            {{-- ================================================= --}}

            <div
                class="profile-tab-pane active"
                id="tab-overview"
            >


                {{-- Doctor Information --}}

                <div class="profile-section">

                    <div class="profile-section-header">

                        <h3>
                            Doctor Information
                        </h3>

                    </div>


                    <div class="profile-section-body">

                        <div class="profile-info-grid">


                            <div class="profile-info-item">

                                <span class="profile-info-label">
                                    Doctor ID
                                </span>

                                <span class="profile-info-value">
                                    {{ $doctor->doctor_id }}
                                </span>

                            </div>


                            <div class="profile-info-item">

                                <span class="profile-info-label">
                                    Full Name
                                </span>

                                <span class="profile-info-value">
                                    {{ $doctor->user?->name ?? '—' }}
                                </span>

                            </div>


                            <div class="profile-info-item">

                                <span class="profile-info-label">
                                    Specialization
                                </span>

                                <span class="profile-info-value">
                                    {{ $doctor->specialization ?: 'Not specified' }}
                                </span>

                            </div>


                            <div class="profile-info-item">

                                <span class="profile-info-label">
                                    Email
                                </span>

                                <span class="profile-info-value">
                                    {{ $doctor->user?->email ?? '—' }}
                                </span>

                            </div>


                            <div class="profile-info-item">

                                <span class="profile-info-label">
                                    Phone
                                </span>

                                <span class="profile-info-value">
                                    {{ $doctor->phone ?: 'Not specified' }}
                                </span>

                            </div>


                            <div class="profile-info-item">

                                <span class="profile-info-label">
                                    Account Created
                                </span>

                                <span class="profile-info-value">
                                    {{ $doctor->user?->created_at?->format('d M Y') ?? '—' }}
                                </span>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- Account --}}

                <div class="profile-section">

                    <div class="profile-section-header">

                        <h3>
                            Account
                        </h3>

                    </div>


                    <div class="profile-section-body">

                        <div class="profile-info-grid">


                            <div class="profile-info-item">

                                <span class="profile-info-label">
                                    Role
                                </span>

                                <span class="profile-info-value">

                                    @if($doctor->user?->hasRole('doctor'))

                                        <span class="badge bg-primary">
                                            Doctor
                                        </span>

                                    @else

                                        <span class="badge bg-secondary">
                                            {{ $doctor->user?->getRoleNames()->implode(', ') ?: '—' }}
                                        </span>

                                    @endif

                                </span>

                            </div>


                            <div class="profile-info-item">

                                <span class="profile-info-label">
                                    Email Verified
                                </span>

                                <span class="profile-info-value">

                                    @if($doctor->user?->email_verified_at)

                                        <span class="text-success">

                                            <i class="bi bi-check-circle"></i>

                                            Verified

                                        </span>

                                    @else

                                        <span class="text-muted">
                                            Not verified
                                        </span>

                                    @endif

                                </span>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ================================================= --}}
            {{-- PATIENTS --}}
            {{-- ================================================= --}}

            <div
                class="profile-tab-pane"
                id="tab-patients"
            >

                <div class="profile-section">

                    <div class="profile-section-header">

                        <h3>
                            Assigned Patients
                        </h3>

                        <p>
                            Patients currently assigned to this doctor.
                        </p>

                    </div>


                    <div class="profile-section-body">

                        @if(isset($patients) && $patients->count())

                            <div class="table-responsive">

                                <table class="table align-middle">

                                    <thead>

                                        <tr>

                                            <th>
                                                Patient
                                            </th>

                                            <th>
                                                Patient ID
                                            </th>

                                            <th>
                                                Gender
                                            </th>

                                            <th>
                                                Device
                                            </th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        @foreach($patients as $patient)

                                            <tr>

                                                <td>

                                                    <strong>
                                                        {{ $patient->user?->name ?? 'Unknown' }}
                                                    </strong>

                                                    <div class="small text-muted">
                                                        {{ $patient->user?->email ?? '—' }}
                                                    </div>

                                                </td>


                                                <td>
                                                    {{ $patient->patient_id }}
                                                </td>


                                                <td>
                                                    {{ ucfirst($patient->gender ?? '—') }}
                                                </td>


                                                <td>

                                                    @if($patient->devices && $patient->devices->count())

                                                        {{ $patient->devices->first()->device_name
                                                            ?: $patient->devices->first()->device_uid }}

                                                    @else

                                                        <span class="text-muted">
                                                            No device
                                                        </span>

                                                    @endif

                                                </td>

                                            </tr>

                                        @endforeach

                                    </tbody>

                                </table>

                            </div>

                        @else

                            <div class="text-center py-5">

                                <i class="bi bi-people fs-1 text-muted"></i>

                                <p class="text-muted mt-3 mb-0">
                                    No patients assigned to this doctor.
                                </p>

                            </div>

                        @endif

                    </div>

                </div>

            </div>


            {{-- ================================================= --}}
            {{-- DEVICES --}}
            {{-- ================================================= --}}

            <div
                class="profile-tab-pane"
                id="tab-devices"
            >

                <div class="profile-section">

                    <div class="profile-section-header">

                        <h3>
                            Assigned Devices
                        </h3>

                        <p>
                            Devices managed by this doctor.
                        </p>

                    </div>


                    <div class="profile-section-body">

                        @if(isset($devices) && $devices->count())

                            <div class="table-responsive">

                                <table class="table align-middle">

                                    <thead>

                                        <tr>

                                            <th>
                                                Device
                                            </th>

                                            <th>
                                                Device UID
                                            </th>

                                            <th>
                                                Status
                                            </th>

                                            <th>
                                                Last Seen
                                            </th>

                                        </tr>

                                    </thead>


                                    <tbody>

                                        @foreach($devices as $device)

                                            <tr>

                                                <td>

                                                    <strong>
                                                        {{ $device->device_name ?: 'Unnamed Device' }}
                                                    </strong>

                                                </td>


                                                <td>
                                                    {{ $device->device_uid }}
                                                </td>


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


                                                <td>
                                                    {{ $device->last_seen_at?->diffForHumans() ?? 'Never' }}
                                                </td>

                                            </tr>

                                        @endforeach

                                    </tbody>

                                </table>

                            </div>

                        @else

                            <div class="text-center py-5">

                                <i class="bi bi-cpu fs-1 text-muted"></i>

                                <p class="text-muted mt-3 mb-0">
                                    No devices assigned to this doctor.
                                </p>

                            </div>

                        @endif

                    </div>

                </div>

            </div>


        </div>

    </div>

</div>
 
</section>

{{-- ============================================================= --}}
{{-- PROFILE TAB JAVASCRIPT --}}
{{-- ============================================================= --}}
@endsection

@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const tabs = document.querySelectorAll('.profile-tab');

    const panes = document.querySelectorAll('.profile-tab-pane');


    tabs.forEach(function (tab) {

        tab.addEventListener('click', function () {

            const target = this.dataset.tab;


            tabs.forEach(function (item) {

                item.classList.remove('active');

            });


            panes.forEach(function (pane) {

                pane.classList.remove('active');

            });


            this.classList.add('active');


            const targetPane =
                document.getElementById('tab-' + target);


            if (targetPane) {

                targetPane.classList.add('active');

            }

        });

    });

});

</script>

@endpush

