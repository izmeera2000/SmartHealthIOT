
@extends('layouts.guest')

@section('title', '404')

@section('content')

  <div class="error-page">
    <div class="error-container">
      <div class="error-code">404</div>
      <h1 class="error-title">Page not found</h1>
      <p class="error-message">
        Sorry, the page you're looking for doesn't exist or has been moved.
        Please check the URL or return to the homepage.
      </p>
      <div class="error-actions">
        <a href="index.html" class="btn btn-primary">
          <i class="bi bi-house"></i> Back to Home
        </a>
        <a href="error-404.html#" class="btn btn-outline-secondary" onclick="history.back(); return false;">
          <i class="bi bi-arrow-left"></i> Go Back
        </a>
      </div>
    </div>


 @endsection
