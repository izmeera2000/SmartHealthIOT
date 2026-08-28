@extends('layouts.app')

@section('content')

<section class="section">

    @if(session('success'))

        <div class="alert alert-success">
            <i class="bi bi-check-circle me-1"></i>

            {{ session('success') }}
        </div>

    @endif


    @if ($errors->any())

        <div class="alert alert-danger">

            <strong>Please fix the following:</strong>

            <ul class="mb-0 mt-2">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    <form
        method="POST"
        action="{{ route('doctor.patients.update', $patient) }}"
    >

        @csrf

        @method('PUT')


        <div class="row">

            {{-- ========================================================= --}}
            {{-- LEFT COLUMN --}}
            {{-- ========================================================= --}}

            <div class="col-xl-4">

                {{-- Patient Information --}}

                <div class="card">

                    <div class="card-header">

                        <h5 class="card-title mb-0">
                            Patient Information
                        </h5>

                    </div>


                    <div class="card-body">

                        <div class="mb-3">

                            <label class="form-label">
                                Patient ID
                            </label>

                            <input
                                type="text"
                                name="patient_id"
                                class="form-control"
                                value="{{ old('patient_id', $patient->patient_id) }}"
                                required
                            >

                        </div>


                        <div class="mb-3">

                            <label class="form-label">
                                IC Number
                            </label>

                            <input
                                type="text"
                                name="ic_number"
                                class="form-control"
                                value="{{ old('ic_number', $patient->ic_number) }}"
                            >

                        </div>


                        <div class="mb-3">

                            <label class="form-label">
                                Blood Type
                            </label>

                            <select
                                name="blood_type"
                                class="form-select"
                            >

                                <option value="">
                                    Select...
                                </option>

                                @foreach([
                                    'A+',
                                    'A-',
                                    'B+',
                                    'B-',
                                    'AB+',
                                    'AB-',
                                    'O+',
                                    'O-'
                                ] as $type)

                                    <option
                                        value="{{ $type }}"
                                        @selected(old('blood_type', $patient->blood_type) === $type)
                                    >
                                        {{ $type }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        <div class="row">

                            <div class="col-6 mb-3">

                                <label class="form-label">
                                    Height (cm)
                                </label>

                                <input
                                    type="number"
                                    name="height"
                                    step="0.01"
                                    min="0"
                                    class="form-control"
                                    value="{{ old('height', $patient->height) }}"
                                >

                            </div>


                            <div class="col-6 mb-3">

                                <label class="form-label">
                                    Weight (kg)
                                </label>

                                <input
                                    type="number"
                                    name="weight"
                                    step="0.01"
                                    min="0"
                                    class="form-control"
                                    value="{{ old('weight', $patient->weight) }}"
                                >

                            </div>

                        </div>

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

                        <div class="mb-3">

                            <label class="form-label">
                                Contact Name
                            </label>

                            <input
                                type="text"
                                name="emergency_contact_name"
                                class="form-control"
                                value="{{ old(
                                    'emergency_contact_name',
                                    $patient->emergency_contact_name
                                ) }}"
                            >

                        </div>


                        <div class="mb-3">

                            <label class="form-label">
                                Contact Phone
                            </label>

                            <input
                                type="tel"
                                name="emergency_contact_phone"
                                class="form-control"
                                value="{{ old(
                                    'emergency_contact_phone',
                                    $patient->emergency_contact_phone
                                ) }}"
                            >

                        </div>


                        <div>

                            <label class="form-label">
                                Relationship
                            </label>

                            <input
                                type="text"
                                name="emergency_contact_relationship"
                                class="form-control"
                                value="{{ old(
                                    'emergency_contact_relationship',
                                    $patient->emergency_contact_relationship
                                ) }}"
                            >

                        </div>

                    </div>

                </div>


                {{-- Danger Zone --}}

                <div class="card border-danger">

                    <div class="card-header bg-danger-light">

                        <h5 class="card-title mb-0 text-danger">

                            Danger Zone

                        </h5>

                    </div>


                    <div class="card-body">

                        <p class="text-muted small mb-3">

                            Deleting this patient will also delete
                            their user account.

                        </p>


                        <button
                            type="button"
                            class="btn btn-outline-danger w-100"
                            data-bs-toggle="modal"
                            data-bs-target="#deletePatientModal"
                        >

                            <i class="bi bi-trash me-1"></i>

                            Delete Patient

                        </button>

                    </div>

                </div>

            </div>


            {{-- ========================================================= --}}
            {{-- RIGHT COLUMN --}}
            {{-- ========================================================= --}}

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

                            @php
                                $nameParts = explode(
                                    ' ',
                                    $patient->user->name,
                                    2
                                );
                            @endphp


                            {{-- First Name --}}

                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    First Name

                                    <span class="text-danger">
                                        *
                                    </span>

                                </label>

                                <input
                                    type="text"
                                    name="first_name"
                                    class="form-control"
                                    value="{{ old(
                                        'first_name',
                                        $nameParts[0] ?? ''
                                    ) }}"
                                    required
                                >

                            </div>


                            {{-- Last Name --}}

                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Last Name

                                    <span class="text-danger">
                                        *
                                    </span>

                                </label>

                                <input
                                    type="text"
                                    name="last_name"
                                    class="form-control"
                                    value="{{ old(
                                        'last_name',
                                        $nameParts[1] ?? ''
                                    ) }}"
                                    required
                                >

                            </div>


                            {{-- Email --}}

                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Email Address

                                    <span class="text-danger">
                                        *
                                    </span>

                                </label>

                                <input
                                    type="email"
                                    name="email"
                                    class="form-control"
                                    value="{{ old(
                                        'email',
                                        $patient->user->email
                                    ) }}"
                                    required
                                >

                            </div>


                            {{-- Phone --}}

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Phone Number
                                </label>

                                <input
                                    type="tel"
                                    name="phone"
                                    class="form-control"
                                    value="{{ old(
                                        'phone',
                                        $patient->phone
                                    ) }}"
                                >

                            </div>


                            {{-- Date of Birth --}}

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Date of Birth
                                </label>

                                <input
                                    type="date"
                                    name="date_of_birth"
                                    class="form-control"
                                    value="{{ old(
                                        'date_of_birth',
                                        $patient->date_of_birth?->format('Y-m-d')
                                    ) }}"
                                >

                            </div>


                            {{-- Gender --}}

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Gender
                                </label>

                                <select
                                    name="gender"
                                    class="form-select"
                                >

                                    <option value="">
                                        Select...
                                    </option>

                                    <option
                                        value="male"
                                        @selected(
                                            old(
                                                'gender',
                                                $patient->gender
                                            ) === 'male'
                                        )
                                    >
                                        Male
                                    </option>

                                    <option
                                        value="female"
                                        @selected(
                                            old(
                                                'gender',
                                                $patient->gender
                                            ) === 'female'
                                        )
                                    >
                                        Female
                                    </option>

                                    <option
                                        value="other"
                                        @selected(
                                            old(
                                                'gender',
                                                $patient->gender
                                            ) === 'other'
                                        )
                                    >
                                        Other
                                    </option>

                                    <option
                                        value="prefer-not"
                                        @selected(
                                            old(
                                                'gender',
                                                $patient->gender
                                            ) === 'prefer-not'
                                        )
                                    >
                                        Prefer not to say
                                    </option>

                                </select>

                            </div>


                            {{-- Address --}}

                            <div class="col-12 mb-3">

                                <label class="form-label">
                                    Address
                                </label>

                                <textarea
                                    name="address"
                                    class="form-control"
                                    rows="4"
                                >{{ old(
                                    'address',
                                    $patient->address
                                ) }}</textarea>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- Actions --}}

                <div class="d-flex justify-content-end gap-2">

                    <a
                        href="{{ route('doctor.patients.index') }}"
                        class="btn btn-secondary"
                    >
                        Cancel
                    </a>


                    <button
                        type="submit"
                        class="btn btn-primary"
                    >

                        <i class="bi bi-check-lg me-1"></i>

                        Save Changes

                    </button>

                </div>

            </div>

        </div>

    </form>

</section>


{{-- ============================================================= --}}
{{-- DELETE MODAL --}}
{{-- ============================================================= --}}

<div
    class="modal fade"
    id="deletePatientModal"
    tabindex="-1"
>

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header border-0">

                <h5 class="modal-title text-danger">

                    <i class="bi bi-exclamation-triangle me-2"></i>

                    Delete Patient

                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>

            </div>


            <div class="modal-body">

                <p>

                    Are you sure you want to delete

                    <strong>
                        {{ $patient->user->name }}
                    </strong>?

                </p>

                <p class="text-muted mb-0">

                    This will permanently remove the patient
                    and their user account.

                </p>

            </div>


            <div class="modal-footer border-0">

                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal"
                >
                    Cancel
                </button>


                <form
                    method="POST"
                    action="{{ route('doctor.patients.destroy', $patient) }}"
                >

                    @csrf

                    @method('DELETE')

                    <button
                        type="submit"
                        class="btn btn-danger"
                    >

                        Delete Patient

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection