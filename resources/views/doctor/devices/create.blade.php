@extends('layouts.app')

@section('content')

<section class="section">

    {{-- HEADER --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">

        <div>
            <h5 class="mb-1">
                Register Device
            </h5>

            <small class="text-muted">
                Register a new ESP32 health monitoring device
            </small>
        </div>

        <a href="{{ route('doctor.devices.index') }}"
           class="btn btn-outline-secondary">

            <i class="bi bi-arrow-left"></i>
            Back to Devices

        </a>

    </div>


    {{-- VALIDATION ERRORS --}}
    @if($errors->any())

        <div class="alert alert-danger">

            <div class="fw-semibold mb-2">
                Please correct the following errors:
            </div>

            <ul class="mb-0">

                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif


    {{-- DEVICE FORM --}}
    <div class="card">

        <div class="card-header">

            <h6 class="card-title mb-0">
                Device Information
            </h6>

        </div>


        <div class="card-body">

            <form action="{{ route('doctor.devices.store') }}"
                  method="POST">

                @csrf


                <div class="row g-4">


                    {{-- DEVICE UID --}}
                    <div class="col-md-6">

                        <label for="device_uid"
                               class="form-label">

                            Device UID
                            <span class="text-danger">*</span>

                        </label>

                        <input type="text"
                               id="device_uid"
                               name="device_uid"
                               class="form-control @error('device_uid') is-invalid @enderror"
                               value="{{ old('device_uid') }}"
                               placeholder="e.g. ESP32-001"
                               required>

                        @error('device_uid')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                        <small class="text-muted">
                            Unique identifier assigned to the ESP32.
                        </small>

                    </div>


                    {{-- MAC ADDRESS --}}
                    <div class="col-md-6">

                        <label for="mac_address"
                               class="form-label">

                            MAC Address
                            <span class="text-danger">*</span>

                        </label>

                        <input type="text"
                               id="mac_address"
                               name="mac_address"
                               class="form-control @error('mac_address') is-invalid @enderror"
                               value="{{ old('mac_address') }}"
                               placeholder="e.g. AA:BB:CC:DD:EE:FF"
                               required>

                        @error('mac_address')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                        <small class="text-muted">
                            MAC address of the ESP32 WiFi interface.
                        </small>

                    </div>


                    {{-- DEVICE NAME --}}
                    <div class="col-md-6">

                        <label for="device_name"
                               class="form-label">

                            Device Name

                        </label>

                        <input type="text"
                               id="device_name"
                               name="device_name"
                               class="form-control @error('device_name') is-invalid @enderror"
                               value="{{ old('device_name') }}"
                               placeholder="e.g. Patient Monitor 01">

                        @error('device_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- DEVICE TYPE --}}
                    <div class="col-md-6">

                        <label for="device_type"
                               class="form-label">

                            Device Type

                        </label>

                        <select id="device_type"
                                name="device_type"
                                class="form-select @error('device_type') is-invalid @enderror">

                            <option value="">
                                Select device type
                            </option>

                            <option value="ESP32"
                                @selected(old('device_type') === 'ESP32')>
                                ESP32
                            </option>

                            <option value="ESP32 Health Monitor"
                                @selected(old('device_type') === 'ESP32 Health Monitor')>
                                ESP32 Health Monitor
                            </option>

                            <option value="Other"
                                @selected(old('device_type') === 'Other')>
                                Other
                            </option>

                        </select>

                        @error('device_type')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- FIRMWARE --}}
                    <div class="col-md-6">

                        <label for="firmware_version"
                               class="form-label">

                            Firmware Version

                        </label>

                        <input type="text"
                               id="firmware_version"
                               name="firmware_version"
                               class="form-control @error('firmware_version') is-invalid @enderror"
                               value="{{ old('firmware_version') }}"
                               placeholder="e.g. 1.0.0">

                        @error('firmware_version')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- PATIENT --}}
                    <div class="col-md-6">

                        <label for="patient_id"
                               class="form-label">

                            Assign to Patient

                        </label>

                        <select id="patient_id"
                                name="patient_id"
                                class="form-select @error('patient_id') is-invalid @enderror">

                            <option value="">
                                -- Unassigned --

                            </option>

                            @foreach($patients as $patient)

                                <option value="{{ $patient->id }}"
                                    @selected(old('patient_id') == $patient->id)>

                                    {{ $patient->user->name }}

                                </option>

                            @endforeach

                        </select>

                        @error('patient_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                        <small class="text-muted">
                            You can assign the device to a patient now or later.
                        </small>

                    </div>


                </div>


                {{-- DIVIDER --}}
                <hr class="my-4">


                {{-- SUBMIT --}}
                <div class="d-flex justify-content-end gap-2">

                    <a href="{{ route('doctor.devices.index') }}"
                       class="btn btn-light">

                        Cancel

                    </a>

                    <button type="submit"
                            class="btn btn-primary">

                        <i class="bi bi-cpu"></i>

                        Register Device

                    </button>

                </div>


            </form>

        </div>

    </div>

</section>

@endsection
 