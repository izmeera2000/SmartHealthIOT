@extends('layouts.guest')

@section('title', 'Login')

@section('content')

 
<div class="auth-layout">
    <div class="auth-container">

        {{-- Logo --}}
        <a href="{{ url('/') }}" class="auth-logo">
            <img src="{{ asset('assets/img/logo.webp') }}" alt="SmartHealthIoT">
            <span>SmartHealthIoT</span>
        </a>

        <div class="auth-card">

            {{-- Header --}}
            <div class="auth-card-header">
                <h1 class="auth-title">Welcome back</h1>
                <p class="auth-subtitle">
                    Enter your credentials to access your account
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

            {{-- Login Form --}}
            <form method="POST"
                  action="{{ route('login') }}"
                  class="auth-form">
                @csrf

                {{-- Email --}}
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
                        autocomplete="username"
                    >

                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="form-group">
                    <div class="d-flex justify-content-between align-items-center">
                        <label for="password" class="form-label">
                            Password
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                               class="auth-link small">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    <div class="input-group">
                        <input
                            type="password"
                            class="form-control @error('password') is-invalid @enderror"
                            id="password"
                            name="password"
                            placeholder="Enter your password"
                            required
                            autocomplete="current-password"
                        >

                        <button
                            class="btn btn-outline-secondary"
                            type="button"
                            data-toggle-password
                            aria-label="Show password"
                        >
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>

                    @error('password')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Remember Me --}}
                <div class="form-check">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        id="remember"
                        name="remember"
                        {{ old('remember') ? 'checked' : '' }}
                    >

                    <label class="form-check-label" for="remember">
                        Remember me
                    </label>
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn btn-primary btn-block">
                    Sign in
                </button>

            </form>

            {{-- Register --}}
            @if (Route::has('register'))
                <p class="auth-footer-text">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="auth-link">
                        Create an account
                    </a>
                </p>
            @endif

        </div>
 @include('layouts.guestfooter')


    </div>
</div>
 

@endsection
