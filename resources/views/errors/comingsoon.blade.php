
@extends('layouts.guest')

@section('title', '500')

@section('content')

<div class="coming-soon-page">
    <div class="coming-soon-logo">
      <img src="assets/img/logo.webp" alt="EasyAdmin">
    </div>
    <h1 class="coming-soon-title">Something awesome is coming!</h1>
    <p class="coming-soon-message">
      We're working hard to bring you something amazing. Sign up to be the
      first to know when we launch.
    </p>

    <!-- Countdown Timer -->
    <div class="countdown">
      <div class="countdown-item">
        <span class="countdown-value" data-countdown="days">00</span>
        <span class="countdown-label">Days</span>
      </div>
      <div class="countdown-item">
        <span class="countdown-value" data-countdown="hours">00</span>
        <span class="countdown-label">Hours</span>
      </div>
      <div class="countdown-item">
        <span class="countdown-value" data-countdown="minutes">00</span>
        <span class="countdown-label">Minutes</span>
      </div>
      <div class="countdown-item">
        <span class="countdown-value" data-countdown="seconds">00</span>
        <span class="countdown-label">Seconds</span>
      </div>
    </div>

    
  </div>


 @endsection


 @push('scripts')
      <script>
    // Simple countdown timer (demo - set to 30 days from now)
    (function() {
      const targetDate = new Date();
      targetDate.setDate(targetDate.getDate() + 30);

      function updateCountdown() {
        const now = new Date();
        const diff = targetDate - now;
        if (diff <= 0) return;
        const days = Math.floor(diff / (1000 * 60 * 60 * 24));
        const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((diff % (1000 * 60)) / 1000);
        document.querySelector('[data-countdown="days"]').textContent = String(days).padStart(2, '0');
        document.querySelector('[data-countdown="hours"]').textContent = String(hours).padStart(2, '0');
        document.querySelector('[data-countdown="minutes"]').textContent = String(minutes).padStart(2, '0');
        document.querySelector('[data-countdown="seconds"]').textContent = String(seconds).padStart(2, '0');
      }
      updateCountdown();
      setInterval(updateCountdown, 1000);
    })();
  </script>
 @endpush
