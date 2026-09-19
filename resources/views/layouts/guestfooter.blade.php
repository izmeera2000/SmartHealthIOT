{{-- Footer --}}
<footer class="footer-centered">

    <div class="footer-copyright">
        &copy; {{ date('Y') }}
        <a href="{{ route('login') }}">SmartHealthIoT</a>.
        All Rights Reserved.
    </div>

    <div class="footer-links">
      <a href="{{ route('about') }}">About</a>
<a href="{{ route('privacy') }}">Privacy Policy</a>
<a href="{{ route('terms') }}">Terms of Service</a>
<a href="{{ route('contact') }}">Contact</a>
    </div>

</footer>