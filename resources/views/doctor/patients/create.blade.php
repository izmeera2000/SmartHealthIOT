@extends('layouts.app')

@section('content')

<section class="section">

    {{-- Validation Errors --}}
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
        action="{{ route('doctor.patients.store') }}"
    >

        @csrf

        <div class="row">

            {{-- ========================================================= --}}
            {{-- LEFT COLUMN --}}
            {{-- ========================================================= --}}

            <div class="col-xl-4">

                {{-- Patient ID --}}
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
                                value="{{ old('patient_id') }}"
                                placeholder="Leave empty to generate automatically"
                            >

                            <div class="form-text">
                                Example: PT-8F3A21BC
                            </div>

                        </div>


                        <div class="mb-3">

                            <label class="form-label">
                                IC Number
                            </label>

                            <input
                                type="text"
                                name="ic_number"
                                class="form-control"
                                value="{{ old('ic_number') }}"
                                placeholder="e.g. 900315101234"
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
                                        @selected(old('blood_type') === $type)
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
                                    value="{{ old('height') }}"
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
                                    value="{{ old('weight') }}"
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
                                value="{{ old('emergency_contact_name') }}"
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
                                value="{{ old('emergency_contact_phone') }}"
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
                                value="{{ old('emergency_contact_relationship') }}"
                                placeholder="e.g. Mother"
                            >

                        </div>

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
                                    value="{{ old('first_name') }}"
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
                                    value="{{ old('last_name') }}"
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
                                    value="{{ old('email') }}"
                                    required
                                >

                            </div>


                            {{-- Password --}}

                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Password

                                    <span class="text-danger">
                                        *
                                    </span>

                                </label>

                                <input
                                    type="password"
                                    name="password"
                                    class="form-control"
                                    required
                                >

                                <div class="form-text">
                                    Minimum 8 characters.
                                </div>

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
                                    value="{{ old('phone') }}"
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
                                    value="{{ old('date_of_birth') }}"
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
                                        @selected(old('gender') === 'male')
                                    >
                                        Male
                                    </option>

                                    <option
                                        value="female"
                                        @selected(old('gender') === 'female')
                                    >
                                        Female
                                    </option>

                                    <option
                                        value="other"
                                        @selected(old('gender') === 'other')
                                    >
                                        Other
                                    </option>

                                    <option
                                        value="prefer-not"
                                        @selected(old('gender') === 'prefer-not')
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
                                >{{ old('address') }}</textarea>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- Form Actions --}}

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

                        <i class="bi bi-person-plus me-1"></i>

                        Create Patient

                    </button>

                </div>

            </div>

        </div>

    </form>

</section>

@endsection