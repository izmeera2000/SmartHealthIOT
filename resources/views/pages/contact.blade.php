@extends('layouts.guest')

@section('title', 'Contact Us')

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
                <i class="bi bi-envelope"></i>
            </div>

            <h1 class="auth-title">Contact Us</h1>

            <p class="auth-subtitle">
                Have a question? We'd love to hear from you.
            </p>
        </div>

        <form method="POST"
              action="#"
              class="auth-form">
            @csrf

            <div class="form-group">
                <label for="name" class="form-label">
                    Name
                </label>

                <input
                    type="text"
                    class="form-control"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Your name"
                    required
                >
            </div>

            <div class="form-group">
                <label for="email" class="form-label">
                    Email address
                </label>

                <input
                    type="email"
                    class="form-control"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="name@example.com"
                    required
                >
            </div>

            <div class="form-group">
                <label for="subject" class="form-label">
                    Subject
                </label>

                <input
                    type="text"
                    class="form-control"
                    id="subject"
                    name="subject"
                    value="{{ old('subject') }}"
                    placeholder="How can we help?"
                    required
                >
            </div>

            <div class="form-group">
                <label for="message" class="form-label">
                    Message
                </label>

                <textarea
                    class="form-control"
                    id="message"
                    name="message"
                    rows="5"
                    placeholder="Write your message here..."
                    required
                >{{ old('message') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary btn-block">
                <i class="bi bi-send me-1"></i>
                Send Message
            </button>

        </form>

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
