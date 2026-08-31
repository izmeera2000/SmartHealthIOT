<!-- Header -->
<header class="header">
  <!-- Header Left -->
  <div class="header-left">
    <a href="{{ route('dashboard') }}" class="header-logo">
      <img src="{{ asset('assets/img/logo.webp') }}" alt="SmartHealthIOT">
      <span>SmartHealthIOT</span>
    </a>
    <button class="sidebar-toggle" title="Toggle Sidebar">
      <i class="bi bi-list"></i>
    </button>
  </div>

  <!-- Header Search (Desktop) - Expandable -->
  {{-- <div class="header-search">
    <form class="search-form collapsed" action="search-results.html" method="GET">
      <button type="button" class="search-toggle-btn"><i class="bi bi-search"></i></button>
      <input type="search" name="q" placeholder="Search..." autocomplete="off">
    </form>
  </div> --}}

  <!-- Header Right -->
  <div class="header-right">
    <!-- Desktop Actions (hidden on mobile, shown in mobile menu) -->
    <div class="header-actions-desktop">
      <!-- Theme Toggle -->
      {{-- <button class="header-action theme-toggle" title="Toggle Theme">
        <i class="bi bi-moon icon-dark"></i>
        <i class="bi bi-sun icon-light"></i>
      </button> --}}

      <!-- Fullscreen Toggle -->
      <button class="header-action fullscreen-toggle" onclick="toggleFullscreen()" title="Fullscreen">
        <i class="bi bi-fullscreen icon-enter"></i>
        <i class="bi bi-fullscreen-exit icon-exit"></i>
      </button>

      <!-- Notifications -->
      <div class="header-action dropdown notification-dropdown">
        <button class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bi bi-bell"></i>
          <span class="badge">3</span>
        </button>
        <div class="dropdown-menu dropdown-menu-end">
          <div class="notification-header">
            <h6>Notifications</h6>
            <a href="blank.html#" data-notification-action="mark-all-read">Mark all read</a>
          </div>
          <div class="notification-list">
            <div class="notification-item unread">
              <div class="notification-icon success">
                <i class="bi bi-check-circle"></i>
              </div>
              <div class="notification-content">
                <div class="notification-title">Order Completed</div>
                <div class="notification-text">Your order #12345 has been delivered</div>
                <div class="notification-time">5 min ago</div>
              </div>
            </div>
            <div class="notification-item unread">
              <div class="notification-icon warning">
                <i class="bi bi-exclamation-triangle"></i>
              </div>
              <div class="notification-content">
                <div class="notification-title">Low Storage</div>
                <div class="notification-text">Server storage is running low (85% used)</div>
                <div class="notification-time">1 hour ago</div>
              </div>
            </div>
            <div class="notification-item">
              <div class="notification-icon info">
                <i class="bi bi-info-circle"></i>
              </div>
              <div class="notification-content">
                <div class="notification-title">New Feature</div>
                <div class="notification-text">Dark mode is now available</div>
                <div class="notification-time">2 hours ago</div>
              </div>
            </div>
          </div>
          <div class="notification-footer">
            <a href="notifications.html">View all notifications</a>
          </div>
        </div>
      </div>

      <!-- User Dropdown - shadcn style -->
      <div class="header-action dropdown user-dropdown">
        <button class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
          <img src="assets/img/profile-img.webp" alt="User" class="avatar">
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
          <li class="dropdown-header">
            <img src="assets/img/profile-img.webp" alt="User" class="user-avatar">
            <div class="user-info">
              <h6>John Doe</h6>
              {{-- <span><a href="https://bootstrapmade.com/cdn-cgi/l/email-protection" class="__cf_email__"
                  data-cfemail="3b515453557b5e435a564b575e15585456">[email&#160;protected]</a></span> --}}
            </div>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>
          <li>
            <a class="dropdown-item" href="profile.html">
              <i class="bi bi-person"></i> Profile
              <span class="shortcut">⇧P</span>
            </a>
          </li>
          <li>
            <a class="dropdown-item" href="settings.html">
              <i class="bi bi-gear"></i> Settings
              <span class="shortcut">⇧S</span>
            </a>
          </li>
          <li>
            <a class="dropdown-item" href="notifications.html">
              <i class="bi bi-bell"></i> Notifications
            </a>
          </li>
          <li>
            <a class="dropdown-item" href="activity.html">
              <i class="bi bi-activity"></i> Activity
            </a>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>
          <li>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="dropdown-item dropdown-item-danger">
                <i class="bi bi-box-arrow-right"></i> Sign Out
              </button>
            </form>
          </li>

        </ul>
      </div>
    </div>

    <!-- Mobile Actions (visible only on mobile) -->
    <div class="header-actions-mobile">
      <!-- Search Toggle (Mobile) -->
      {{-- <button class="header-action search-toggle" title="Search">
        <i class="bi bi-search"></i>
      </button> --}}

      <!-- Mobile Menu Toggle -->
      <button class="header-action mobile-menu-toggle" title="More">
        <i class="bi bi-three-dots-vertical"></i>
      </button>
    </div>
  </div>
</header>

<!-- Mobile Search -->
<div class="mobile-search">
  <form class="search-form" action="search-results.html" method="GET">
    <input type="search" name="q" placeholder="Search..." autocomplete="off">
    <button type="submit"><i class="bi bi-search"></i></button>
  </form>
</div>

<!-- Mobile Header Menu -->
<div class="mobile-header-menu">
  <div class="mobile-header-menu-content">
    <!-- Theme Toggle -->
    {{-- <button class="mobile-menu-item theme-toggle" title="Toggle Theme">
      <i class="bi bi-moon icon-dark"></i>
      <i class="bi bi-sun icon-light"></i>
      <span class="mobile-menu-label">Theme</span>
    </button> --}}

    <!-- Fullscreen Toggle -->
    <button class="mobile-menu-item fullscreen-toggle" onclick="toggleFullscreen()" title="Fullscreen">
      <i class="bi bi-fullscreen icon-enter"></i>
      <i class="bi bi-fullscreen-exit icon-exit"></i>
      <span class="mobile-menu-label">Fullscreen</span>
    </button>

    <!-- Notifications -->
    <a href="notifications.html" class="mobile-menu-item">
      <i class="bi bi-bell"></i>
      <span class="badge">3</span>
      <span class="mobile-menu-label">Notifications</span>
    </a>

    <!-- Profile -->
    <a href="profile.html" class="mobile-menu-item">
      <i class="bi bi-person"></i>
      <span class="mobile-menu-label">Profile</span>
    </a>

    <!-- Settings -->
    <a href="settings.html" class="mobile-menu-item">
      <i class="bi bi-gear"></i>
      <span class="mobile-menu-label">Settings</span>
    </a>

    <!-- Sign Out -->
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="mobile-menu-item mobile-menu-item-danger">
        <i class="bi bi-box-arrow-right"></i>
        <span class="mobile-menu-label">Sign Out</span>
      </button>
    </form>

  </div>
</div>