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


        <form method="POST" action="{{ route('doctor.doctors.update', $doctor) }}" enctype="multipart/form-data">

            @csrf
            @method('PUT')


            <div class="row">

                {{-- ===================================================== --}}
                {{-- LEFT --}}
                {{-- ===================================================== --}}

                <div class="col-xl-4">

                    {{-- Doctor Information --}}
                    <div class="card">

                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                Personal Information
                            </h5>
                        </div>

                        <div class="card-body text-center">

                            <div class="mb-4">

                                <label class="form-label">
                                    Profile Photo
                                </label>


                                {{-- Profile Preview --}}
                                <div class="mb-3">


                                    <img src="{{ $doctor->user->profile_photo
        ? asset('storage/' . $doctor->user->profile_photo)
        : asset('assets/img/profile-img.webp') }}" alt="{{ $doctor->user->name }}" id="profileImagePreview"
                                        class="rounded-circle" width="120" height="120" style="object-fit: cover;">

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

                    </div>




                    {{-- Account --}}

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

                                <input type="email" name="email" class="form-control"
                                    value="{{ old('email', $doctor->user->email) }}" required>

                            </div>


                            <div class="mb-3">

                                <label class="form-label">
                                    New Password
                                </label>

                                <input type="password" name="password" class="form-control">

                                <small class="text-muted">
                                    Leave blank to keep the current password.
                                </small>

                            </div>


                            <div>

                                <label class="form-label">
                                    Confirm New Password
                                </label>

                                <input type="password" name="password_confirmation" class="form-control">

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

                            <p class="text-muted small">
                                Deleting this doctor will also remove
                                the associated user account.
                            </p>

                            <button type="button" class="btn btn-outline-danger w-100" data-bs-toggle="modal"
                                data-bs-target="#deleteDoctorModal">
                                <i class="bi bi-trash me-1"></i>
                                Delete Doctor
                            </button>

                        </div>

                    </div>

                </div>


                {{-- ===================================================== --}}
                {{-- RIGHT --}}
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

                            @php
                                $nameParts = explode(
                                    ' ',
                                    $doctor->user->name,
                                    2
                                );
                            @endphp

                            <div class="row">

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        First Name
                                        <span class="text-danger">*</span>
                                    </label>

                                    <input type="text" name="first_name" class="form-control" value="{{ old(
        'first_name',
        $nameParts[0] ?? ''
    ) }}" required>

                                </div>


                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        Last Name
                                        <span class="text-danger">*</span>
                                    </label>

                                    <input type="text" name="last_name" class="form-control" value="{{ old(
        'last_name',
        $nameParts[1] ?? ''
    ) }}" required>

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

                                <input type="text" name="doctor_id" class="form-control"
                                    value="{{ old('doctor_id', $doctor->doctor_id) }}" required>

                            </div>


                            <div class="mb-3">

                                <label class="form-label">
                                    Specialization
                                    <span class="text-danger">*</span>
                                </label>

                                <input type="text" name="specialization" class="form-control"
                                    value="{{ old('specialization', $doctor->specialization) }}" required>

                            </div>


                            <div>

                                <label class="form-label">
                                    Phone Number
                                </label>

                                <input type="tel" name="phone" class="form-control"
                                    value="{{ old('phone', $doctor->phone) }}">

                            </div>

                        </div>

                    </div>


                 


                    {{-- Actions --}}

                    <div class="d-flex justify-content-end gap-2">

                        <a href="{{ route('doctor.doctors.show', $doctor) }}" class="btn btn-secondary">
                            Cancel
                        </a>

                        <button type="submit" class="btn btn-primary">
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

    <div class="modal fade" id="deleteDoctorModal" tabindex="-1">


        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header border-0">

                    <h5 class="modal-title text-danger">

                        <i class="bi bi-exclamation-triangle me-2"></i>

                        Delete Doctor

                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                </div>


                <div class="modal-body">

                    <p>

                        Are you sure you want to delete

                        <strong>
                            {{ $doctor->user->name }}
                        </strong>?

                    </p>

                    <p class="text-muted mb-0">

                        This will permanently remove the doctor
                        and their user account.

                    </p>

                </div>


                <div class="modal-footer border-0">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <form method="POST" action="{{ route('doctor.doctors.destroy', $doctor) }}">

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger">
                            Delete Doctor
                        </button>

                    </form>

                </div>

            </div>

        </div>


    </div>

@endsection


@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const profileImageInput = document.getElementById('profileImage');
            const profileImagePreview = document.getElementById('profileImagePreview');

            if (!profileImageInput || !profileImagePreview) {
                return;
            }

            profileImageInput.addEventListener('change', function (event) {

                const file = event.target.files[0];

                if (!file) {
                    return;
                }

                // Make sure the selected file is an image
                if (!file.type.startsWith('image/')) {
                    return;
                }

                // Create preview
                const reader = new FileReader();

                reader.onload = function (e) {
                    profileImagePreview.src = e.target.result;
                };

                reader.readAsDataURL(file);
            });

        });
    </script>
@endpush