
@extends('layouts.guest')

@section('title', '500')

@section('content')

 <div class="error-page">
    <div class="error-container">
      <div class="error-icon danger">
        <i class="bi bi-exclamation-triangle"></i>
      </div>
      <h1 class="error-title">Something went wrong</h1>
      <p class="error-message">
        We're experiencing some technical difficulties. Our team has been notified
        and we're working to fix the issue. Please try again later.
      </p>
      <div class="error-actions">
        <a href="index.html" class="btn btn-primary">
          <i class="bi bi-house"></i> Back to Home
        </a>
        <button class="btn btn-outline-secondary" onclick="location.reload()">
          <i class="bi bi-arrow-clockwise"></i> Try Again
        </button>
      </div>
    </div>
    </div>


 @endsection
