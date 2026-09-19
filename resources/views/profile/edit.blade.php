@extends('layouts.app')

@section('title', $pageTitle)

@section('content')

    <section class="section profile">




        {{-- ========================================================= --}}
        {{-- COMMON ACCOUNT INFORMATION --}}
        {{-- ========================================================= --}}

        <div class="row">

            <div class="col-xl-4">

                <div class="profile-card">

                    <div class="profile-card-avatar">

                        <img src="{{ $user->profile_photo
        ? asset('storage/' . $user->profile_photo)
        : asset('assets/img/profile-img.webp') }}" alt="{{ $user->name }}">

                    </div>

                    <div class="profile-card-info">

                        <h2>
                            {{ $user->name }}
                        </h2>

                        <p class="profile-role">

                            @if($user->hasRole('doctor'))

                                Doctor

                            @elseif($user->hasRole('patient'))

                                Patient

                            @elseif($user->hasRole('admin'))

                                Administrator

                            @else

                                User

                            @endif

                        </p>

                        <p class="profile-location">

                            <i class="bi bi-envelope"></i>

                            {{ $user->email }}

                        </p>

                    </div>

                </div>

            </div>


            <div class="col-xl-8">

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">

                    @csrf
                    @method('PATCH')


                    {{-- ================================================= --}}
                    {{-- ACCOUNT INFORMATION --}}
                    {{-- ================================================= --}}

                    <div class="profile-section">

                        <div class="profile-section-header">

                            <h3>
                                Account Information
                            </h3>

                            <p>
                                Update your basic account information.
                            </p>

                        </div>


                        <div class="profile-section-body">

                            <div class="row g-3">

                                {{-- Name --}}
                                <div class="col-md-6">

                                    <label class="form-label">
                                        Full Name
                                    </label>

                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name', $user->name) }}" required>

                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>


                                {{-- Email --}}
                                <div class="col-md-6">

                                    <label class="form-label">
                                        Email
                                    </label>

                                    <input type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email', $user->email) }}" required>

                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>


                                {{-- Profile Photo --}}
                                <div class="col-12">

                                    <label class="form-label">
                                        Profile Photo
                                    </label>

                                    <input type="file" name="profile_photo"
                                        class="form-control @error('profile_photo') is-invalid @enderror"
                                        accept=".jpg,.jpeg,.png,.webp">

                                    @error('profile_photo')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                    <small class="text-muted">
                                        JPG, JPEG, PNG or WEBP. Maximum 2MB.
                                    </small>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- DOCTOR ONLY --}}
                    {{-- ================================================= --}}

                    @if($user->hasRole('doctor') && $doctor)

                        <div class="profile-section mt-4">

                            <div class="profile-section-header">

                                <h3>
                                    Doctor Information
                                </h3>

                                <p>
                                    Update your professional information.
                                </p>

                            </div>


                            <div class="profile-section-body">

                                <div class="row g-3">

                                    {{-- Doctor ID --}}
                                    <div class="col-md-6">

                                        <label class="form-label">
                                            Doctor ID
                                        </label>

                                        <input type="text" class="form-control" value="{{ $doctor->doctor_id }}" readonly>

                                        <small class="text-muted">
                                            Doctor ID cannot be changed.
                                        </small>

                                    </div>


                                    {{-- Specialization --}}
                                    <div class="col-md-6">

                                        <label class="form-label">
                                            Specialization
                                        </label>

                                        <input type="text" name="specialization" class="form-control"
                                            value="{{ old('specialization', $doctor->specialization) }}">

                                    </div>


                                    {{-- Phone --}}
                                    <div class="col-md-6">

                                        <label class="form-label">
                                            Phone
                                        </label>

                                        <input type="text" name="phone" class="form-control"
                                            value="{{ old('phone', $doctor->phone) }}">

                                    </div>

                                </div>

                            </div>

                        </div>

                    @endif


                    {{-- ================================================= --}}
                    {{-- PATIENT ONLY --}}
                    {{-- ================================================= --}}

                    @if($user->hasRole('patient') && $patient)

                                    <div class="profile-section mt-4">

                                        <div class="profile-section-header">

                                            <h3>
                                                Patient Information
                                            </h3>

                                            <p>
                                                Update your personal health profile.
                                            </p>

                                        </div>


                                        <div class="profile-section-body">

                                            <div class="row g-3">

                                                {{-- Patient ID --}}
                                                <div class="col-md-6">

                                                    <label class="form-label">
                                                        Patient ID
                                                    </label>

                                                    <input type="text" class="form-control" value="{{ $patient->patient_id }}" readonly>

                                                    <small class="text-muted">
                                                        Patient ID cannot be changed.
                                                    </small>

                                                </div>


                                                {{-- IC Number --}}
                                                <div class="col-md-6">

                                                    <label class="form-label">
                                                        IC Number
                                                    </label>

                                                    <input type="text" name="ic_number" class="form-control"
                                                        value="{{ old('ic_number', $patient->ic_number) }}">

                                                </div>


                                                {{-- Date of Birth --}}
                                                <div class="col-md-6">

                                                    <label class="form-label">
                                                        Date of Birth
                                                    </label>

                                                    <input type="date" name="date_of_birth" class="form-control" value="{{ old(
                            'date_of_birth',
                            $patient->date_of_birth?->format('Y-m-d')
                        ) }}">

                                                </div>


                                                {{-- Gender --}}
                                                <div class="col-md-6">

                                                    <label class="form-label">
                                                        Gender
                                                    </label>

                                                    <select name="gender" class="form-select">

                                                        <option value="">
                                                            Select Gender
                                                        </option>

                                                        <option value="male" @selected(old('gender', $patient->gender) === 'male')>
                                                            Male
                                                        </option>

                                                        <option value="female" @selected(old('gender', $patient->gender) === 'female')>
                                                            Female
                                                        </option>

                                                        <option value="other" @selected(old('gender', $patient->gender) === 'other')>
                                                            Other
                                                        </option>

                                                    </select>

                                                </div>


                                                {{-- Phone --}}
                                                <div class="col-md-6">

                                                    <label class="form-label">
                                                        Phone
                                                    </label>

                                                    <input type="text" name="phone" class="form-control"
                                                        value="{{ old('phone', $patient->phone) }}">

                                                </div>


                                                {{-- Blood Type --}}
                                                <div class="col-md-6">

                                                    <label class="form-label">
                                                        Blood Type
                                                    </label>

                                                    <select name="blood_type" class="form-select">

                                                        <option value="">
                                                            Select Blood Type
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
                                                            ] as $bloodType)

                                                            <option value="{{ $bloodType }}" @selected(old('blood_type', $patient->blood_type) === $bloodType)>
                                                                {{ $bloodType }}
                                                            </option>

                                                        @endforeach

                                                    </select>

                                                </div>


                                                {{-- Height --}}
                                                <div class="col-md-6">

                                                    <label class="form-label">
                                                        Height (cm)
                                                    </label>

                                                    <input type="number" step="0.01" name="height" class="form-control"
                                                        value="{{ old('height', $patient->height) }}">

                                                </div>


                                                {{-- Weight --}}
                                                <div class="col-md-6">

                                                    <label class="form-label">
                                                        Weight (kg)
                                                    </label>

                                                    <input type="number" step="0.01" name="weight" class="form-control"
                                                        value="{{ old('weight', $patient->weight) }}">

                                                </div>


                                                {{-- Address --}}
                                                <div class="col-12">

                                                    <label class="form-label">
                                                        Address
                                                    </label>

                                                    <textarea name="address" rows="3"
                                                        class="form-control">{{ old('address', $patient->address) }}</textarea>

                                                </div>


                                                {{-- Emergency Contact --}}
                                                <div class="col-12">

                                                    <hr>

                                                    <h5 class="mb-3">
                                                        Emergency Contact
                                                    </h5>

                                                </div>


                                                <div class="col-md-4">

                                                    <label class="form-label">
                                                        Contact Name
                                                    </label>

                                                    <input type="text" name="emergency_contact_name" class="form-control" value="{{ old(
                            'emergency_contact_name',
                            $patient->emergency_contact_name
                        ) }}">

                                                </div>


                                                <div class="col-md-4">

                                                    <label class="form-label">
                                                        Contact Phone
                                                    </label>

                                                    <input type="text" name="emergency_contact_phone" class="form-control" value="{{ old(
                            'emergency_contact_phone',
                            $patient->emergency_contact_phone
                        ) }}">

                                                </div>


                                                <div class="col-md-4">

                                                    <label class="form-label">
                                                        Relationship
                                                    </label>

                                                    <input type="text" name="emergency_contact_relationship" class="form-control" value="{{ old(
                            'emergency_contact_relationship',
                            $patient->emergency_contact_relationship
                        ) }}">

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                    @endif


                    {{-- ================================================= --}}
                    {{-- ACTIONS --}}
                    {{-- ================================================= --}}

                    <div class="d-flex justify-content-end gap-2 mt-4">

                        <a href="{{ route('profile.index') }}" class="btn btn-secondary">
                            Cancel
                        </a>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i>
                            Save Changes
                        </button>

                    </div>

                </form>



                {{-- ========================================================= --}}
                {{-- CHANGE PASSWORD --}}
                {{-- ========================================================= --}}

                <div class="card mb-4 mt-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Change Password</h5>
                    </div>

                    <div class="card-body">

                        <div class="alert alert-info d-flex align-items-center mb-3">
                            <i class="bi bi-info-circle me-2"></i>
                            <div>
                                Enter your current password and choose a new password
                                to update your account password.
                            </div>
                        </div>

                        <form method="POST" action="{{ route('profile.password.update') }}">
                            @csrf
                            @method('PATCH')

                            <div class="row">

                                {{-- Current Password --}}
                                <div class="col-md-12 mb-3">
                                    <label for="current_password" class="form-label">
                                        Current Password
                                    </label>

                                    <div class="input-group">
                                        <input type="password" id="current_password" name="current_password"
                                            class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                                            placeholder="Enter current password" autocomplete="current-password">

                                        <button type="button" class="btn btn-outline-secondary password-toggle"
                                            data-target="current_password">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>

                                    @error('current_password', 'updatePassword')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                {{-- New Password --}}
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">
                                        New Password
                                    </label>

                                    <div class="input-group">
                                        <input type="password" id="password" name="password"
                                            class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                                            placeholder="Enter new password" autocomplete="new-password">

                                        <button type="button" class="btn btn-outline-secondary password-toggle"
                                            data-target="password">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>

                                    @error('password', 'updatePassword')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                {{-- Confirm Password --}}
                                <div class="col-md-6 mb-3">
                                    <label for="password_confirmation" class="form-label">
                                        Confirm Password
                                    </label>

                                    <div class="input-group">
                                        <input type="password" id="password_confirmation" name="password_confirmation"
                                            class="form-control" placeholder="Confirm new password"
                                            autocomplete="new-password">

                                        <button type="button" class="btn btn-outline-secondary password-toggle"
                                            data-target="password_confirmation">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>

                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-key me-1"></i>
                                    Change Password
                                </button>
                            </div>
                        </form>

                    </div>
                </div>


                {{-- ========================================================= --}}
                {{-- DANGER ZONE --}}
                {{-- ========================================================= --}}

                <div class="settings-card settings-card-danger mb-4">

                    <div class="settings-card-header">
                        <h3>Danger Zone</h3>
                        <p>Irreversible and destructive actions.</p>
                    </div>

                    <div class="settings-card-body">

                        <div class="settings-toggle-row">

                            <div class="settings-toggle-info">
                                <label class="settings-label">
                                    Delete account
                                </label>

                                <p class="settings-hint">
                                    Permanently delete your account and all of your data.
                                </p>
                            </div>

                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                data-bs-target="#deleteAccountModal">
                                Delete account
                            </button>

                        </div>

                    </div>
                </div>



            </div>

        </div>

    </section>

@endsection

@push('scripts')

    <script>
        document.querySelectorAll('.password-toggle').forEach(button => {
            button.addEventListener('click', function () {
                const input = document.getElementById(this.dataset.target);
                const icon = this.querySelector('i');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('bi-eye');
                    icon.classList.add('bi-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('bi-eye-slash');
                    icon.classList.add('bi-eye');
                }
            });
        });
    </script>

@endpush