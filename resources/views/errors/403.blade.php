
@extends('layouts.guest')

@section('title', '403')

@section('content')

  <div class="error-page">
    <div class="error-container">
      <div class="error-icon warning">
        <i class="bi bi-shield-x"></i>
      </div>
      <h1 class="error-title">Access denied</h1>
      <p class="error-message">
        You don't have permission to access this page. If you believe this is
        a mistake, please contact your administrator or try logging in with
        different credentials.
      </p>
      <div class="error-actions">
        <a href="index.html" class="btn btn-primary">
          <i class="bi bi-house"></i> Back to Home
        </a>
        <a href="auth-login.html" class="btn btn-outline-secondary">
          <i class="bi bi-box-arrow-in-right"></i> Sign In
        </a>
      </div>
    </div>


 @endsection
