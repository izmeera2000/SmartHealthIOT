@extends('layouts.app')

 
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
                    src="{{ $patient->user?->profile_photo
                        ? asset('storage/' . $patient->user->profile_photo)
                        : asset('assets/img/profile-img.webp') }}"
                    alt="{{ $patient->user?->name ?? 'Patient' }}"
                >

            </div>


            {{-- Basic Information --}}

            <div class="profile-card-info">

                <h2>
                    {{ $patient->user?->name ?? 'Unknown Patient' }}
                </h2>

                <p class="profile-role">
                    Patient
                </p>

                <p class="profile-location">

                    <i class="bi bi-person-vcard"></i>

                    {{ $patient->patient_id }}

                </p>

            </div>


            {{-- Stats --}}

            <div class="profile-card-stats">


                {{-- Age --}}

                <div class="profile-stat">

                    <span class="profile-stat-value">

                        {{ $patient->date_of_birth
                            ? $patient->date_of_birth->age
                            : '—' }}

                    </span>

                    <span class="profile-stat-label">
                        Age
                    </span>

                </div>


                {{-- Devices --}}

                <div class="profile-stat">

                    <span class="profile-stat-value">
                        {{ $patient->devices?->count() ?? 0 }}
                    </span>

                    <span class="profile-stat-label">
                        Devices
                    </span>

                </div>


                {{-- Gender --}}

                <div class="profile-stat">

                    <span class="profile-stat-value">

                        {{ $patient->gender
                            ? ucfirst($patient->gender)
                            : '—' }}

                    </span>

                    <span class="profile-stat-label">
                        Gender
                    </span>

                </div>

            </div>


            {{-- Account Status --}}

            <div class="text-center mt-3">

                @php

                    $isActive = method_exists($patient->user, 'isActive')
                        ? $patient->user->isActive()
                        : ($patient->user->is_active ?? true);

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


                {{-- Overview --}}

                <button
                    type="button"
                    class="profile-tab active"
                    data-tab="overview"
                >

                    <i class="bi bi-person"></i>

                    <span>Overview</span>

                </button>


                {{-- Devices --}}

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


                {{-- ================================================= --}}
                {{-- PERSONAL INFORMATION --}}
                {{-- ================================================= --}}

                <div class="profile-section">

                    <div class="profile-section-header">

                        <h3>
                            Personal Information
                        </h3>

                    </div>


                    <div class="profile-section-body">

                        <div class="profile-info-grid">


                            {{-- Patient ID --}}

                            <div class="profile-info-item">

                                <span class="profile-info-label">
                                    Patient ID
                                </span>

                                <span class="profile-info-value">

                                    {{ $patient->patient_id }}

                                </span>

                            </div>


                            {{-- Full Name --}}

                            <div class="profile-info-item">

                                <span class="profile-info-label">
                                    Full Name
                                </span>

                                <span class="profile-info-value">

                                    {{ $patient->user?->name ?? '—' }}

                                </span>

                            </div>


                            {{-- Email --}}

                            <div class="profile-info-item">

                                <span class="profile-info-label">
                                    Email
                                </span>

                                <span class="profile-info-value">

                                    {{ $patient->user?->email ?? '—' }}

                                </span>

                            </div>


                            {{-- IC Number --}}

                            <div class="profile-info-item">

                                <span class="profile-info-label">
                                    IC Number
                                </span>

                                <span class="profile-info-value">

                                    {{ $patient->ic_number ?: 'Not specified' }}

                                </span>

                            </div>


                            {{-- Date of Birth --}}

                            <div class="profile-info-item">

                                <span class="profile-info-label">
                                    Date of Birth
                                </span>

                                <span class="profile-info-value">

                                    {{ $patient->date_of_birth
                                        ? $patient->date_of_birth->format('d M Y')
                                        : 'Not specified' }}

                                </span>

                            </div>


                            {{-- Age --}}

                            <div class="profile-info-item">

                                <span class="profile-info-label">
                                    Age
                                </span>

                                <span class="profile-info-value">

                                    {{ $patient->date_of_birth
                                        ? $patient->date_of_birth->age . ' years'
                                        : 'Not specified' }}

                                </span>

                            </div>


                            {{-- Gender --}}

                            <div class="profile-info-item">

                                <span class="profile-info-label">
                                    Gender
                                </span>

                                <span class="profile-info-value">

                                    {{ $patient->gender
                                        ? ucfirst($patient->gender)
                                        : 'Not specified' }}

                                </span>

                            </div>


                            {{-- Phone --}}

                            <div class="profile-info-item">

                                <span class="profile-info-label">
                                    Phone
                                </span>

                                <span class="profile-info-value">

                                    {{ $patient->phone ?: 'Not specified' }}

                                </span>

                            </div>


                            {{-- Blood Type --}}

                            <div class="profile-info-item">

                                <span class="profile-info-label">
                                    Blood Type
                                </span>

                                <span class="profile-info-value">

                                    @if($patient->blood_type)

                                        <span class="badge bg-danger-subtle text-danger">

                                            {{ $patient->blood_type }}

                                        </span>

                                    @else

                                        Not specified

                                    @endif

                                </span>

                            </div>


                            {{-- Height --}}

                            <div class="profile-info-item">

                                <span class="profile-info-label">
                                    Height
                                </span>

                                <span class="profile-info-value">

                                    {{ $patient->height
                                        ? $patient->height . ' cm'
                                        : 'Not specified' }}

                                </span>

                            </div>


                            {{-- Weight --}}

                            <div class="profile-info-item">

                                <span class="profile-info-label">
                                    Weight
                                </span>

                                <span class="profile-info-value">

                                    {{ $patient->weight
                                        ? $patient->weight . ' kg'
                                        : 'Not specified' }}

                                </span>

                            </div>


                            {{-- Account Created --}}

                            <div class="profile-info-item">

                                <span class="profile-info-label">
                                    Account Created
                                </span>

                                <span class="profile-info-value">

                                    {{ $patient->user?->created_at?->format('d M Y') ?? '—' }}

                                </span>

                            </div>

                        </div>

                    </div>

                </div>



                {{-- ================================================= --}}
                {{-- ADDRESS --}}
                {{-- ================================================= --}}

                <div class="profile-section">

                    <div class="profile-section-header">

                        <h3>
                            Address
                        </h3>

                    </div>


                    <div class="profile-section-body">

                        @if($patient->address)

                            <div class="d-flex align-items-start gap-3">

                                <i class="bi bi-geo-alt fs-4 text-primary"></i>

                                <div class="profile-info-value">

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



                {{-- ================================================= --}}
                {{-- EMERGENCY CONTACT --}}
                {{-- ================================================= --}}

                <div class="profile-section">

                    <div class="profile-section-header">

                        <h3>
                            Emergency Contact
                        </h3>

                    </div>


                    <div class="profile-section-body">

                        <div class="profile-info-grid">


                            {{-- Contact Name --}}

                            <div class="profile-info-item">

                                <span class="profile-info-label">
                                    Contact Name
                                </span>

                                <span class="profile-info-value">

                                    {{ $patient->emergency_contact_name ?: 'Not specified' }}

                                </span>

                            </div>


                            {{-- Contact Phone --}}

                            <div class="profile-info-item">

                                <span class="profile-info-label">
                                    Contact Phone
                                </span>

                                <span class="profile-info-value">

                                    {{ $patient->emergency_contact_phone ?: 'Not specified' }}

                                </span>

                            </div>


                            {{-- Relationship --}}

                            <div class="profile-info-item">

                                <span class="profile-info-label">
                                    Relationship
                                </span>

                                <span class="profile-info-value">

                                    {{ $patient->emergency_contact_relationship ?: 'Not specified' }}

                                </span>

                            </div>

                        </div>

                    </div>

                </div>



                {{-- ================================================= --}}
                {{-- ACCOUNT --}}
                {{-- ================================================= --}}

                <div class="profile-section">

                    <div class="profile-section-header">

                        <h3>
                            Account
                        </h3>

                    </div>


                    <div class="profile-section-body">

                        <div class="profile-info-grid">


                            {{-- Role --}}

                            <div class="profile-info-item">

                                <span class="profile-info-label">
                                    Role
                                </span>

                                <span class="profile-info-value">

                                    @if($patient->user?->hasRole('patient'))

                                        <span class="badge bg-primary">
                                            Patient
                                        </span>

                                    @else

                                        <span class="badge bg-secondary">

                                            {{ $patient->user?->getRoleNames()->implode(', ') ?: '—' }}

                                        </span>

                                    @endif

                                </span>

                            </div>


                            {{-- Email Verification --}}

                            <div class="profile-info-item">

                                <span class="profile-info-label">
                                    Email Verified
                                </span>

                                <span class="profile-info-value">

                                    @if($patient->user?->email_verified_at)

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



                {{-- ================================================= --}}
                {{-- RECORD INFORMATION --}}
                {{-- ================================================= --}}

                <div class="profile-section">

                    <div class="profile-section-header">

                        <h3>
                            Record Information
                        </h3>

                    </div>


                    <div class="profile-section-body">

                        <div class="profile-info-grid">


                            <div class="profile-info-item">

                                <span class="profile-info-label">
                                    Patient Created
                                </span>

                                <span class="profile-info-value">

                                    {{ $patient->created_at?->format('d M Y, h:i A') ?? '—' }}

                                </span>

                            </div>


                            <div class="profile-info-item">

                                <span class="profile-info-label">
                                    Last Updated
                                </span>

                                <span class="profile-info-value">

                                    {{ $patient->updated_at?->format('d M Y, h:i A') ?? '—' }}

                                </span>

                            </div>

                        </div>

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
                            Devices currently assigned to this patient.
                        </p>

                    </div>


                    <div class="profile-section-body">


                        @forelse($patient->devices as $device)


                            <div
                                class="d-flex align-items-center justify-content-between
                                {{ !$loop->last ? 'border-bottom pb-3 mb-3' : '' }}"
                            >


                                {{-- Device Information --}}

                                <div class="d-flex align-items-center gap-3">


                                    {{-- Device Icon --}}

                                    <div
                                        class="rounded-circle bg-primary-subtle
                                        d-flex align-items-center justify-content-center"
                                        style="width: 50px; height: 50px;"
                                    >

                                        <i class="bi bi-cpu fs-4 text-primary"></i>

                                    </div>


                                    {{-- Details --}}

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

                            <div class="profile-info-grid mt-3
                                {{ !$loop->last ? 'mb-4' : '' }}"
                            >


                                <div class="profile-info-item">

                                    <span class="profile-info-label">
                                        Device UID
                                    </span>

                                    <span class="profile-info-value">

                                        {{ $device->device_uid }}

                                    </span>

                                </div>


                                <div class="profile-info-item">

                                    <span class="profile-info-label">
                                        Last Seen
                                    </span>

                                    <span class="profile-info-value">

                                        {{ $device->last_seen_at?->diffForHumans() ?? 'Never' }}

                                    </span>

                                </div>


                                <div class="profile-info-item">

                                    <span class="profile-info-label">
                                        Firmware
                                    </span>

                                    <span class="profile-info-value">

                                        {{ $device->firmware_version ?: 'Not specified' }}

                                    </span>

                                </div>


                                <div class="profile-info-item">

                                    <span class="profile-info-label">
                                        MAC Address
                                    </span>

                                    <span class="profile-info-value">

                                        {{ $device->mac_address ?: 'Not specified' }}

                                    </span>

                                </div>

                            </div>


                        @empty


                            <div class="text-center py-5">

                                <i class="bi bi-cpu fs-1 text-muted"></i>

                                <p class="fw-semibold mt-3 mb-1">
                                    No Devices Assigned
                                </p>

                                <p class="text-muted mb-0">
                                    This patient does not currently have any devices.
                                </p>

                            </div>


                        @endforelse

                    </div>

                </div>

            </div>


        </div>

    </div>

</div>
 
</section>
@endsection

{{-- ============================================================= --}}
{{-- PROFILE TAB JAVASCRIPT --}}
{{-- ============================================================= --}}

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

