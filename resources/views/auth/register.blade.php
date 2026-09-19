@extends('layouts.guest')

@section('title', 'Create Account')

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
                <h1 class="auth-title">
                    Create an account
                </h1>

                <p class="auth-subtitle">
                    Create your SmartHealthIoT account
                </p>
            </div>

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

            {{-- Register Form --}}
            <form method="POST"
                  action="{{ route('register') }}"
                  class="auth-form">
                @csrf

                {{-- Name --}}
                <div class="form-group">
                    <label for="name" class="form-label">
                        Full name
                    </label>

                    <input
                        type="text"
                        class="form-control @error('name') is-invalid @enderror"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="John Doe"
                        required
                        autofocus
                        autocomplete="name"
                    >

                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

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
                    <label for="password" class="form-label">
                        Password
                    </label>

                    <div class="input-group">
                        <input
                            type="password"
                            class="form-control @error('password') is-invalid @enderror"
                            id="password"
                            name="password"
                            placeholder="Create a password"
                            required
                            autocomplete="new-password"
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

                    <div class="form-text">
                        Use a strong password for your account.
                    </div>

                    @error('password')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">
                        Confirm password
                    </label>

                    <div class="input-group">
                        <input
                            type="password"
                            class="form-control"
                            id="password_confirmation"
                            name="password_confirmation"
                            placeholder="Confirm your password"
                            required
                            autocomplete="new-password"
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
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn btn-primary btn-block">
                    Create account
                </button>

            </form>

            {{-- Login --}}
            <p class="auth-footer-text">
                Already have an account?

                <a href="{{ route('login') }}" class="auth-link">
                    Sign in
                </a>
            </p>

        </div>
 @include('layouts.guestfooter')

    </div>
</div>
 

@endsection
