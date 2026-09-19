@extends('layouts.guest')

@section('title', 'Terms of Service')

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
                <i class="bi bi-file-earmark-text"></i>
            </div>

            <h1 class="auth-title">Terms of Service</h1>

            <p class="auth-subtitle">
                Terms governing the use of SmartHealthIoT.
            </p>
        </div>

        <div class="auth-form">

            <div class="form-group">
                <h5>1. Acceptance of Terms</h5>

                <p class="text-muted">
                    By accessing or using SmartHealthIoT, you agree to comply
                    with these Terms of Service and any applicable policies
                    governing the platform.
                </p>
            </div>

            <div class="form-group">
                <h5>2. Use of the Platform</h5>

                <p class="text-muted">
                    SmartHealthIoT is provided for healthcare monitoring and
                    related administrative purposes. Users must use the
                    platform only for lawful and authorized purposes.
                </p>
            </div>

            <div class="form-group">
                <h5>3. Account Responsibility</h5>

                <p class="text-muted">
                    Users are responsible for maintaining the confidentiality
                    of their account credentials and for activities performed
                    through their account.
                </p>
            </div>

            <div class="form-group">
                <h5>4. Device Responsibility</h5>

                <p class="text-muted">
                    Connected devices should be properly configured and
                    maintained. Users should ensure that devices are used
                    according to their applicable technical instructions.
                </p>
            </div>

            <div class="form-group">
                <h5>5. Health Information</h5>

                <p class="text-muted">
                    Information displayed by SmartHealthIoT is intended to
                    support monitoring. It should not be treated as a
                    substitute for professional medical diagnosis,
                    treatment, or emergency services.
                </p>
            </div>

            <div class="form-group">
                <h5>6. Availability</h5>

                <p class="text-muted">
                    We may modify, suspend, or temporarily interrupt parts
                    of the platform for maintenance, upgrades, security
                    improvements, or other operational reasons.
                </p>
            </div>

            <div class="form-group">
                <h5>7. Prohibited Activities</h5>

                <p class="text-muted">
                    Users must not attempt to gain unauthorized access,
                    interfere with platform operation, misuse another
                    user's account, or intentionally compromise the
                    security of the system.
                </p>
            </div>

            <div class="form-group">
                <h5>8. Changes to These Terms</h5>

                <p class="text-muted">
                    These Terms may be updated when necessary. Continued use
                    of the platform after an update may be subject to the
                    revised Terms.
                </p>
            </div>

            <div class="alert alert-warning">
                <i class="bi bi-exclamation-triangle me-2"></i>
                This is a project-specific Terms of Service template and
                should be reviewed for your actual organization, jurisdiction,
                and production requirements.
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
