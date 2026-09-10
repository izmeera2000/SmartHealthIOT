 

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

          @if($headerUnreadCount > 0)
            <span class="badge">
              {{ $headerUnreadCount > 99 ? '99+' : $headerUnreadCount }}
            </span>
          @endif

        </button>


        <div class="dropdown-menu dropdown-menu-end">

          <div class="notification-header">

            <div>
              <h6 class="mb-0">
                Notifications
              </h6>

              @if($headerUnreadCount > 0)
                <small class="text-muted">
                  {{ $headerUnreadCount }} unread
                </small>
              @endif
            </div>


            @if($headerUnreadCount > 0)

              <form method="POST" action="{{ route('notifications.readAll') }}">

                @csrf

                <button type="submit" class="btn btn-link btn-sm p-0">

                  Mark all read

                </button>

              </form>

            @endif

          </div>


          <div class="notification-list">

            @forelse($headerNotifications as $notification)

              @php
                $data = $notification->data;

                $icon = $data['icon'] ?? 'bell';

                $iconType = $data['icon_type'] ?? 'info';

                $iconClasses = [
                  'success' => 'success',
                  'warning' => 'warning',
                  'danger' => 'danger',
                  'info' => 'info',
                  'primary' => 'primary',
                ];

                $iconClass = $iconClasses[$iconType] ?? 'info';
              @endphp


              <div class="notification-item
                      {{ is_null($notification->read_at) ? 'unread' : '' }}">

                <div class="notification-icon {{ $iconClass }}">

                  <i class="bi bi-{{ $icon }}"></i>

                </div>


                <div class="notification-content">

                  <div class="notification-title">

                    {{ $data['title'] ?? 'Notification' }}

                  </div>


                  <div class="notification-text">

                    {{ $data['message'] ?? '' }}

                  </div>


                  <div class="notification-time">

                    {{ $notification->created_at->diffForHumans() }}

                  </div>

                </div>

              </div>

            @empty

              <div class="text-center py-4">

                <i class="bi bi-bell-slash fs-3 text-muted"></i>

                <div class="mt-2 text-muted">
                  No notifications
                </div>

              </div>

            @endforelse

          </div>


          <div class="notification-footer">

            <a href="{{ route('notifications.index') }}">
              View all notifications
            </a>

          </div>

        </div>

      </div>

      <!-- User Dropdown - shadcn style -->
      <div class="header-action dropdown user-dropdown">
        <button class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
          {{-- <img src="{{ asset('assets/img/profile-img.webp') }}" alt="User" class="avatar"> --}}

          <img src="{{ auth()->user()->profile_photo
  ? asset('storage/' . auth()->user()->profile_photo)
  : asset('assets/img/profile-img.webp') }}" alt="{{ auth()->user()->name ?? 'User' }}" class="avatar">
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
          <li class="dropdown-header">
            {{-- <img src="{{ asset('assets/img/profile-img.webp') }}" alt="User" class="user-avatar"> --}}
            <img src="{{ auth()->user()->profile_photo
  ? asset('storage/' . auth()->user()->profile_photo)
  : asset('assets/img/profile-img.webp') }}" alt="{{ auth()->user()->name ?? 'User' }}" class="user-avatar">
            <div class="user-info">
              <h6>{{ auth()->user()->name ?? 'User' }}</h6>
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
  {{-- <form class="search-form" action="search-results.html" method="GET">
    <input type="search" name="q" placeholder="Search..." autocomplete="off">
    <button type="submit"><i class="bi bi-search"></i></button>
  </form> --}}
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
   <a href="{{ route('notifications.index') }}"
   class="mobile-menu-item">

    <i class="bi bi-bell"></i>

    @if($headerUnreadCount > 0)
        <span class="badge">
            {{ $headerUnreadCount > 99 ? '99+' : $headerUnreadCount }}
        </span>
    @endif

    <span class="mobile-menu-label">
        Notifications
    </span>

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