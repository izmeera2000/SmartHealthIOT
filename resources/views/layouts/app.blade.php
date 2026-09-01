<!DOCTYPE html>
<html lang="en" data-theme="dark" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="robots" content="noindex, nofollow">
    <meta name="description" content="EasyAdmin - Bootstrap Admin Template">
    <meta name="keywords" content="admin, dashboard, bootstrap">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('vendors/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/phosphor-icons/phosphor-icons.css') }}" rel="stylesheet">
    {{--
    <link href="{{ asset('vendors/lucide-icons/lucide.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('vendors/simple-datatables/style.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/choices.js/choices.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/datatables/datatables.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">


</head>

<body>

    @include('layouts.header')

    @include('layouts.sidebar')


    <!-- Main Content -->
    <main class="main">

        <div class="main-content">

            <div class="pagetitle">
                <h1>{{ $pageTitle ?? 'Dashboard' }}</h1>

                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">Home</a>
                        </li>

                        @if(isset($breadcrumbs))
                            @foreach($breadcrumbs as $breadcrumb)
                                @if(!$loop->last)
                                    <li class="breadcrumb-item">
                                        <a href="{{ $breadcrumb['url'] }}">
                                            {{ $breadcrumb['title'] }}
                                        </a>
                                    </li>
                                @else
                                    <li class="breadcrumb-item active">
                                        {{ $breadcrumb['title'] }}
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    </ol>
                </nav>
            </div>

            @yield('content')

        </div>



        @include('layouts.footer')



    </main>

    <!-- Back to Top -->
    <a href="#" class="back-to-top">
        <i class="bi bi-arrow-up"></i>
    </a>

 
    

<!-- =========================================
     Pusher Channel Toast Notification
========================================= -->

<div
    class="toast-container position-fixed top-0 end-0 p-3"
    style="z-index: 9999;"
>
    <div
        id="channelNotificationToast"
        class="toast"
        role="alert"
        aria-live="assertive"
        aria-atomic="true"
    >

        <div class="toast-header">

            <i class="bi bi-bell-fill text-primary me-2"></i>

            <strong
                class="me-auto"
                id="channelToastTitle"
            >
                Smart Health IoT
            </strong>

            <small>Just now</small>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="toast"
                aria-label="Close"
            ></button>

        </div>

        <div
            class="toast-body"
            id="channelToastMessage"
        >
            You have a new notification.
        </div>

    </div>
</div>




    @include('layouts.scripts')



    @stack('scripts')

</body>

</html>