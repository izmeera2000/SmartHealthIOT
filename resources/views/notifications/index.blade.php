@extends('layouts.app')

 
@section('content')

 
 

<section class="section">
 
<div class="row">

    {{-- =========================================================
         NOTIFICATIONS LIST
    ========================================================== --}}
    <div class="col-lg-8">

        <div class="card">

            <div class="card-header">

                <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center gap-2">

                    <h5 class="card-title mb-0">
                        All Notifications
                    </h5>

                    <div class="d-flex gap-2">

                        {{-- Mark all as read --}}
                        @if($unreadCount > 0)

                            <form method="POST"
                                  action="{{ route('notifications.readAll') }}">

                                @csrf

                                <button type="submit"
                                        class="btn btn-sm btn-outline-primary">

                                    <i class="bi bi-check2-all me-1"></i>

                                    <span class="d-none d-sm-inline">
                                        Mark all as read
                                    </span>

                                    <span class="d-sm-none">
                                        Mark read
                                    </span>

                                </button>

                            </form>

                        @endif


                        {{-- Filter --}}
                        <div class="dropdown">

                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                    type="button"
                                    data-bs-toggle="dropdown">

                                <i class="bi bi-funnel"></i>
                                Filter

                            </button>

                            <ul class="dropdown-menu dropdown-menu-end">

                                <li>
                                    <a class="dropdown-item {{ request('filter') === null ? 'active' : '' }}"
                                       href="{{ route('notifications.index') }}">
                                        All Notifications
                                    </a>
                                </li>

                                <li>
                                    <a class="dropdown-item {{ request('filter') === 'unread' ? 'active' : '' }}"
                                       href="{{ route('notifications.index', ['filter' => 'unread']) }}">
                                        Unread Only
                                    </a>
                                </li>

                            </ul>

                        </div>

                    </div>

                </div>

            </div>


            <div class="card-body p-0">

                <div class="notifications-list">


                    @forelse($notifications as $notification)

                        @php

                            $data = $notification->data;

                            $icon = $data['icon'] ?? 'bell';

                            $iconType = $data['icon_type'] ?? 'info';

                            $iconClasses = [
                                'success' => 'bg-success-light text-success',
                                'warning' => 'bg-warning-light text-warning',
                                'danger'  => 'bg-danger-light text-danger',
                                'info'    => 'bg-info-light text-info',
                                'primary' => 'bg-primary-light text-primary',
                            ];

                            $iconClass =
                                $iconClasses[$iconType]
                                ?? $iconClasses['info'];

                            $isUnread = is_null($notification->read_at);

                        @endphp


                        {{-- Date header --}}
                        @if(
                            $loop->first ||
                            $notification->created_at->toDateString()
                            !== $notifications[$loop->index - 1]->created_at->toDateString()
                        )

                            <div class="notifications-date-header">

                                <span>

                                    @if($notification->created_at->isToday())

                                        Today

                                    @elseif($notification->created_at->isYesterday())

                                        Yesterday

                                    @elseif($notification->created_at->greaterThanOrEqualTo(now()->startOfWeek()))

                                        This Week

                                    @else

                                        {{ $notification->created_at->format('F j, Y') }}

                                    @endif

                                </span>

                            </div>

                        @endif


                        {{-- Notification --}}
                        <div class="notifications-item {{ $isUnread ? 'unread' : '' }}">


                            {{-- Icon --}}
                            <div class="notifications-item-icon {{ $iconClass }}">

                                <i class="bi bi-{{ $icon }}"></i>

                            </div>


                            {{-- Content --}}
                            <div class="notifications-item-content">

                                <div class="notifications-item-title">

                                    {{ $data['title'] ?? 'Notification' }}

                                </div>


                                <div class="notifications-item-text">

                                    {{ $data['message'] ?? '' }}

                                </div>


                                <div class="notifications-item-meta">

                                    <span class="notifications-item-time">

                                        <i class="bi bi-clock"></i>

                                        {{ $notification->created_at->diffForHumans() }}

                                    </span>


                                    @if(!empty($data['type']))

                                        <span class="notifications-item-category">

                                            {{ ucwords(str_replace('_', ' ', $data['type'])) }}

                                        </span>

                                    @endif

                                </div>

                            </div>


                            {{-- Actions --}}
                            <div class="notifications-item-actions">

                                {{-- View --}}
                                @if(!empty($data['url']))

                                    <a href="{{ $data['url'] }}"
                                       class="btn btn-sm btn-link"
                                       title="View">

                                        <i class="bi bi-eye"></i>

                                    </a>

                                @endif


                                {{-- Mark as read --}}
                                @if($isUnread)

                                    <form method="POST"
                                          action="{{ route('notifications.read', $notification->id) }}"
                                          class="d-inline">

                                        @csrf

                                        <button type="submit"
                                                class="btn btn-sm btn-link"
                                                title="Mark as read">

                                            <i class="bi bi-check2"></i>

                                        </button>

                                    </form>

                                @endif

                            </div>

                        </div>

                    @empty

                        <div class="text-center py-5 px-3">

                            <div class="mb-3">

                                <i class="bi bi-bell-slash fs-1 text-muted"></i>

                            </div>

                            <h5>No notifications</h5>

                            <p class="text-muted mb-0">

                                You're all caught up.

                            </p>

                        </div>

                    @endforelse


                </div>


                {{-- Pagination --}}
                @if($notifications->hasPages())

                    <div class="text-center p-4 border-top">

                        {{ $notifications->links() }}

                    </div>

                @endif

            </div>

        </div>

    </div>


    {{-- =========================================================
         RIGHT SIDEBAR
    ========================================================== --}}
    <div class="col-lg-4">


        {{-- Notification Preferences --}}
        <div class="card">

            <div class="card-header">

                <h5 class="card-title mb-0">
                    Notification Preferences
                </h5>

            </div>


            <div class="card-body">


                <div class="notification-setting">

                    <div class="notification-setting-info">

                        <div class="notification-setting-title">
                            Email Notifications
                        </div>

                        <div class="notification-setting-desc">
                            Receive notifications via email
                        </div>

                    </div>

                    <div class="form-check form-switch">

                        <input class="form-check-input"
                               type="checkbox"
                               id="emailNotif">

                    </div>

                </div>


                <div class="notification-setting">

                    <div class="notification-setting-info">

                        <div class="notification-setting-title">
                            Push Notifications
                        </div>

                        <div class="notification-setting-desc">
                            Receive browser push notifications
                        </div>

                    </div>

                    <div class="form-check form-switch">

                        <input class="form-check-input"
                               type="checkbox"
                               id="pushNotif"
                               checked>

                    </div>

                </div>


                <div class="notification-setting">

                    <div class="notification-setting-info">

                        <div class="notification-setting-title">
                            Patient Notifications
                        </div>

                        <div class="notification-setting-desc">
                            Get notified when patients are registered
                        </div>

                    </div>

                    <div class="form-check form-switch">

                        <input class="form-check-input"
                               type="checkbox"
                               id="patientNotif"
                               checked>

                    </div>

                </div>


                <div class="notification-setting">

                    <div class="notification-setting-info">

                        <div class="notification-setting-title">
                            Device Alerts
                        </div>

                        <div class="notification-setting-desc">
                            Get notified about device events
                        </div>

                    </div>

                    <div class="form-check form-switch">

                        <input class="form-check-input"
                               type="checkbox"
                               id="deviceNotif"
                               checked>

                    </div>

                </div>


                <div class="notification-setting">

                    <div class="notification-setting-info">

                        <div class="notification-setting-title">
                            Health Alerts
                        </div>

                        <div class="notification-setting-desc">
                            Get notified about abnormal readings
                        </div>

                    </div>

                    <div class="form-check form-switch">

                        <input class="form-check-input"
                               type="checkbox"
                               id="healthNotif"
                               checked>

                    </div>

                </div>


            </div>

        </div>


        {{-- Summary --}}
        <div class="card">

            <div class="card-header">

                <h5 class="card-title mb-0">
                    Summary
                </h5>

            </div>


            <div class="card-body">

                <div class="row text-center">


                    {{-- Unread --}}
                    <div class="col-6 mb-3">

                        <div class="notification-stat">

                            <div class="notification-stat-value text-primary">
                                {{ $unreadCount }}
                            </div>

                            <div class="notification-stat-label">
                                Unread
                            </div>

                        </div>

                    </div>


                    {{-- This Week --}}
                    <div class="col-6 mb-3">

                        <div class="notification-stat">

                            <div class="notification-stat-value">

                                {{ auth()->user()
                                    ->notifications()
                                    ->where('created_at', '>=', now()->startOfWeek())
                                    ->count()
                                }}

                            </div>

                            <div class="notification-stat-label">
                                This Week
                            </div>

                        </div>

                    </div>


                    {{-- This Month --}}
                    <div class="col-6">

                        <div class="notification-stat">

                            <div class="notification-stat-value">

                                {{ auth()->user()
                                    ->notifications()
                                    ->where('created_at', '>=', now()->startOfMonth())
                                    ->count()
                                }}

                            </div>

                            <div class="notification-stat-label">
                                This Month
                            </div>

                        </div>

                    </div>


                    {{-- Alerts --}}
                    <div class="col-6">

                        <div class="notification-stat">

                            <div class="notification-stat-value text-danger">

                                {{ auth()->user()
                                    ->notifications()
                                    ->whereIn('data->icon_type', ['danger', 'warning'])
                                    ->count()
                                }}

                            </div>

                            <div class="notification-stat-label">
                                Alerts
                            </div>

                        </div>

                    </div>


                </div>

            </div>

        </div>


    </div>

</div>
 
</section>

@endsection
