@extends('layouts.guest')

@section('title', 'Forgot Password')

@section('content')
 
<div class="auth-layout">
    <div class="auth-container">

        {{-- Logo --}}
        <a href="{{ route('login') }}" class="auth-logo">
            <img src="{{ asset('assets/img/logo.webp') }}" alt="SmartHealthIoT">
            <span>SmartHealthIoT</span>
        </a>

        <div class="auth-card">

            {{-- Header --}}
            <div class="auth-card-header">

                <div class="auth-icon">
                    <i class="bi bi-key"></i>
                </div>

                <h1 class="auth-title">
                    Forgot password?
                </h1>

                <p class="auth-subtitle">
                    No worries, we'll send you reset instructions.
                </p>

            </div>

            {{-- Session Status --}}
            <x-auth-session-status
                class="mb-4"
                :status="session('status')"
            />

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Forgot Password Form --}}
            <form method="POST"
                  action="{{ route('password.email') }}"
                  class="auth-form">
                @csrf

                <div class="form-group">
                    <label for="email" class="form-label">
                        Email address
                    </label>

                    <input
                        type="email"
                        class="form-control @error('email') is-invalid @enderror"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="name@example.com"
                        required
                        autofocus
                        autocomplete="email"
                    >

                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary btn-block">
                    Send reset link
                </button>
            </form>

            {{-- Back to Login --}}
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
