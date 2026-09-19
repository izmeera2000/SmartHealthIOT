@extends('layouts.guest')

@section('title', 'About Us')

@section('content')

<div class="auth-layout">
    <div class="auth-container">
 
    <a href="{{ route('login') }}" class="auth-logo">
        <img src="{{ asset('assets/img/logo.webp') }}" alt="SmartHealthIoT">
        <span>SmartHealthIoT</span>
    </a>

    <div class="auth-card">

        <div class="auth-card-header">
            <div class="auth-icon">
                <i class="bi bi-heart-pulse"></i>
            </div>

            <h1 class="auth-title">About SmartHealthIoT</h1>

            <p class="auth-subtitle">
                Smart healthcare monitoring through connected technology.
            </p>
        </div>

        <div class="auth-form">

            <div class="form-group">
                <h5>Our Platform</h5>

                <p class="text-muted">
                    SmartHealthIoT is a healthcare monitoring platform designed
                    to connect IoT devices with healthcare professionals and
                    patients.
                </p>
            </div>

            <div class="form-group">
                <h5>What We Do</h5>

                <p class="text-muted">
                    Our platform allows connected health devices to collect
                    and transmit health information such as heart rate,
                    temperature, battery status, and other supported readings.
                </p>
            </div>

            <div class="form-group">
                <h5>For Healthcare Professionals</h5>

                <p class="text-muted">
                    Doctors can manage patients and connected devices while
                    monitoring available health readings through a centralized
                    dashboard.
                </p>
            </div>

            <div class="form-group">
                <h5>For Patients</h5>

                <p class="text-muted">
                    Patients can access their profile and connected health
                    information through the SmartHealthIoT platform.
                </p>
            </div>

            <div class="alert alert-info">
                <i class="bi bi-info-circle me-2"></i>
                SmartHealthIoT is intended to support healthcare monitoring
                and does not replace professional medical advice,
                diagnosis, or treatment.
            </div>

        </div>

        <p class="auth-footer-text">
            <a href="{{ route('login') }}" class="auth-link">
                <i class="bi bi-arrow-left"></i>
                Back to login
            </a>
        </p>

    </div>

  
 @include('layouts.guestfooter')

</div>
 

</div>

@endsection
