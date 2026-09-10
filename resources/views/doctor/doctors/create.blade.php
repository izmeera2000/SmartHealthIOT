@extends('layouts.app')

@section('content')

    <section class="section">

        {{-- Alerts --}}
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


        <form method="POST" action="{{ route('doctor.doctors.store') }}" enctype="multipart/form-data">

            @csrf

            <div class="row">

                {{-- ===================================================== --}}
                {{-- LEFT COLUMN --}}
                {{-- ===================================================== --}}

                <div class="col-xl-4">

                    {{-- Doctor Information --}}

                    <div class="card">

                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                Profile Image
                            </h5>
                        </div>

                        <div class="card-body text-center">

                            {{-- Profile Preview --}}
                            <div class="mb-3">

                                <img src="{{ asset('assets/img/avatars/avatar-1.webp') }}" alt="Profile Preview"
                                    class="rounded-circle border" width="120" height="120" id="profilePreview"
                                    style="object-fit: cover;">

                            </div>


                            {{-- File Input --}}
                            <div class="mb-3">

                                <input type="file" name="profile_photo"
                                    class="form-control @error('profile_photo') is-invalid @enderror" id="profileImage"
                                    accept="image/jpeg,image/png,image/webp">

                                @error('profile_photo')
                                    <div class="invalid-feedback text-start">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>


                            <div class="small text-muted">
                                Allowed formats: JPG, PNG, WEBP. Max size: 2MB.
                            </div>

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

                                <label class="form-label">
                                    Email Address
                                    <span class="text-danger">*</span>
                                </label>

                                <input type="email" name="email" class="form-control" value="{{ old('email') }}"
                                    placeholder="doctor@example.com" required>

                            </div>


                            <div class="mb-3">

                                <label class="form-label">
                                    Password
                                    <span class="text-danger">*</span>
                                </label>

                                <input type="password" name="password" class="form-control" required>

                                <small class="text-muted">
                                    Password must be at least 8 characters.
                                </small>

                            </div>


                            <div>

                                <label class="form-label">
                                    Confirm Password
                                    <span class="text-danger">*</span>
                                </label>

                                <input type="password" name="password_confirmation" class="form-control" required>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- ===================================================== --}}
                {{-- RIGHT COLUMN --}}
                {{-- ===================================================== --}}

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
                                        <span class="text-danger">*</span>
                                    </label>

                                    <input type="text" name="first_name" class="form-control"
                                        value="{{ old('first_name') }}" required>

                                </div>


                                {{-- Last Name --}}

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        Last Name
                                        <span class="text-danger">*</span>
                                    </label>

                                    <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}"
                                        required>

                                </div>





                            </div>

                        </div>

                    </div>
      <div class="card">

                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                Doctor Information
                            </h5>
                        </div>

                        <div class="card-body">

                            <div class="mb-3">

                                <label class="form-label">
                                    Doctor ID
                                    <span class="text-danger">*</span>
                                </label>

                                <input type="text" name="doctor_id" class="form-control" value="{{ old('doctor_id') }}"
                                    placeholder="e.g. DOC-0001" required>

                            </div>


                            <div class="mb-3">

                                <label class="form-label">
                                    Specialization
                                    <span class="text-danger">*</span>
                                </label>

                                <input type="text" name="specialization" class="form-control"
                                    value="{{ old('specialization') }}" placeholder="e.g. Cardiology" required>

                            </div>


                            <div class="mb-3">

                                <label class="form-label">
                                    Phone Number
                                </label>

                                <input type="tel" name="phone" class="form-control" value="{{ old('phone') }}"
                                    placeholder="e.g. 012-3456789">

                            </div>

                        </div>

                    </div>


                    {{-- Actions --}}

                    <div class="d-flex justify-content-end gap-2">

                        <a href="{{ route('doctor.doctors.index') }}" class="btn btn-secondary">
                            Cancel
                        </a>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-person-plus me-1"></i>
                            Create Doctor
                        </button>

                    </div>

                </div>

            </div>

        </form>


    </section>

@endsection


@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const profileImage = document.getElementById('profileImage');
            const profilePreview = document.getElementById('profilePreview');

            if (!profileImage || !profilePreview) {
                return;
            }

            profileImage.addEventListener('change', function (event) {

                const file = event.target.files[0];

                if (!file) {
                    return;
                }

                const reader = new FileReader();

                reader.onload = function (e) {
                    profilePreview.src = e.target.result;
                };

                reader.readAsDataURL(file);
            });

        });
    </script>
@endpush