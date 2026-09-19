<!-- Header -->
<header class="header">

    <!-- Header Left -->
    <div class="header-left">

        <a href="{{ route('dashboard') }}" class="header-logo">
            <img src="{{ asset('assets/img/logo.webp') }}" alt="SmartHealthIOT">
            <span>SmartHealthIOT</span>
        </a>

        <button type="button" class="sidebar-toggle" title="Toggle Sidebar" aria-label="Toggle Sidebar">
            <i class="bi bi-list"></i>
        </button>

    </div>


    <!-- Header Right -->
    <div class="header-right">

        <!-- Desktop Actions -->
        <div class="header-actions-desktop">

            <!-- Fullscreen -->
            <button type="button" class="header-action fullscreen-toggle" onclick="toggleFullscreen()"
                title="Fullscreen" aria-label="Fullscreen">
                <i class="bi bi-fullscreen icon-enter"></i>
                <i class="bi bi-fullscreen-exit icon-exit"></i>
            </button>


            <!-- Notifications -->
            <div class="header-action dropdown notification-dropdown">

                <button type="button" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"
                    aria-label="Notifications">

                    <i class="bi bi-bell"></i>

                    @if(($headerUnreadCount ?? 0) > 0)
                        <span class="badge">
                            {{ $headerUnreadCount > 99 ? '99+' : $headerUnreadCount }}
                        </span>
                    @endif

                </button>


                <div class="dropdown-menu dropdown-menu-end">

                    <!-- Notification Header -->
                    <div class="notification-header">

                        <div>
                            <h6 class="mb-0">
                                Notifications
                            </h6>

                            @if(($headerUnreadCount ?? 0) > 0)
                                <small class="text-muted">
                                    {{ $headerUnreadCount }} unread
                                </small>
                            @endif
                        </div>


                        @if(($headerUnreadCount ?? 0) > 0)

                            <form method="POST" action="{{ route('notifications.readAll') }}">
                                @csrf

                                <button type="submit" class="btn btn-link btn-sm p-0">
                                    Mark all read
                                </button>
                            </form>

                        @endif

                    </div>


                    <!-- Notification List -->

                    <div class="notification-list">

                        @forelse(($headerNotifications ?? collect()) as $notification)

                            @php
                                $data = $notification->data ?? [];

                                $icon = $data['icon'] ?? 'bell';

                                $iconType = $data['icon_type'] ?? 'info';

                                $url = $data['url'] ?? null;

                                $allowedIconTypes = [
                                    'success',
                                    'warning',
                                    'danger',
                                    'info',
                                    'primary',
                                ];

                                $iconClass = in_array($iconType, $allowedIconTypes, true)
                                    ? $iconType
                                    : 'info';
                            @endphp

                            @if($url)
                                        <a href="{{ $url }}" class="notification-item text-decoration-none
                                   {{ is_null($notification->read_at) ? 'unread' : '' }}">
                            @else
                                                <div class="notification-item
                                    {{ is_null($notification->read_at) ? 'unread' : '' }}">
                                @endif

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
                                            {{ $notification->created_at?->diffForHumans() ?? 'Just now' }}
                                        </div>

                                    </div>

                                    @if($url)
                                        </a>
                                    @else
                                </div>
                            @endif

                        @empty

                        <div class="text-center py-4">

                            <i class="bi bi-bell-slash fs-3 text-muted"></i>

                            <div class="mt-2 text-muted">
                                No notifications
                            </div>

                        </div>

                    @endforelse

                </div>


                <!-- Notification Footer -->
                <div class="notification-footer">

                    <a href="{{ route('notifications.index') }}">
                        View all notifications
                    </a>

                </div>

            </div>

        </div>


        <!-- User Dropdown -->
        <div class="header-action dropdown user-dropdown">

            <button type="button" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"
                aria-label="User menu">

                <img src="{{ auth()->user()->profile_photo
    ? asset('storage/' . auth()->user()->profile_photo)
    : asset('assets/img/profile-img.webp') }}" alt="{{ auth()->user()->name ?? 'User' }}"
                    class="avatar">

            </button>


            <ul class="dropdown-menu dropdown-menu-end">

                <!-- User Information -->
                <li class="dropdown-header">

                    <img src="{{ auth()->user()->profile_photo
    ? asset('storage/' . auth()->user()->profile_photo)
    : asset('assets/img/profile-img.webp') }}" alt="{{ auth()->user()->name ?? 'User' }}"
                        class="user-avatar">

                    <div class="user-info">

                        <h6>
                            {{ auth()->user()->name ?? 'User' }}
                        </h6>

                    </div>

                </li>


                <li>
                    <hr class="dropdown-divider">
                </li>


                <!-- Profile -->
                <li>
                    <a class="dropdown-item" href="{{ route('profile.index') }}">
                        <i class="bi bi-person"></i>
                        Profile
                        <span class="shortcut">⇧P</span>
                    </a>
                </li>


                {{-- <!-- Settings -->
                <li>
                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                        <i class="bi bi-gear"></i>
                        Settings
                        <span class="shortcut">⇧S</span>
                    </a>
                </li> --}}


                <!-- Notifications -->
                <li>
                    <a class="dropdown-item" href="{{ route('notifications.index') }}">
                        <i class="bi bi-bell"></i>
                        Notifications
                    </a>
                </li>


                <li>
                    <hr class="dropdown-divider">
                </li>


                <!-- Logout -->
                <li>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button type="submit" class="dropdown-item dropdown-item-danger">
                            <i class="bi bi-box-arrow-right"></i>
                            Sign Out
                        </button>

                    </form>

                </li>

            </ul>

        </div>

    </div>


    <!-- Mobile Actions -->
    <div class="header-actions-mobile">

        <button type="button" class="header-action mobile-menu-toggle" title="More" aria-label="More">
            <i class="bi bi-three-dots-vertical"></i>
        </button>

    </div>

    </div>

</header>


<!-- Mobile Search -->
<div class="mobile-search">
</div>


<!-- Mobile Header Menu -->
<div class="mobile-header-menu">

    <div class="mobile-header-menu-content">

        <!-- Fullscreen -->
        <button type="button" class="mobile-menu-item fullscreen-toggle" onclick="toggleFullscreen()"
            title="Fullscreen">
            <i class="bi bi-fullscreen icon-enter"></i>
            <i class="bi bi-fullscreen-exit icon-exit"></i>

            <span class="mobile-menu-label">
                Fullscreen
            </span>
        </button>


        <!-- Notifications -->
        <a href="{{ route('notifications.index') }}" class="mobile-menu-item">

            <i class="bi bi-bell"></i>

            @if(($headerUnreadCount ?? 0) > 0)
                <span class="badge">
                    {{ $headerUnreadCount > 99 ? '99+' : $headerUnreadCount }}
                </span>
            @endif

            <span class="mobile-menu-label">
                Notifications
            </span>

        </a>


        <!-- Profile -->
        <a href="{{ route('profile.index') }}" class="mobile-menu-item">
            <i class="bi bi-person"></i>

            <span class="mobile-menu-label">
                Profile
            </span>
        </a>


        <!-- Settings -->
        <a href="{{ route('profile.edit') }}" class="mobile-menu-item">
            <i class="bi bi-gear"></i>

            <span class="mobile-menu-label">
                Settings
            </span>
        </a>


        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="mobile-menu-item mobile-menu-item-danger">
                <i class="bi bi-box-arrow-right"></i>

                <span class="mobile-menu-label">
                    Sign Out
                </span>
            </button>

        </form>

    </div>

</div>