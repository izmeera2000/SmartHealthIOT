@php
  $user = auth()->user();

  $isAdmin = $user?->hasRole('admin');
  $isDoctor = $user?->hasRole('doctor');
  $isPatient = $user?->hasRole('patient');

  /*
  |--------------------------------------------------------------------------
  | Active Route Helper
  |--------------------------------------------------------------------------
  */
  $isActive = fn($routes) =>
    request()->routeIs($routes);
@endphp


<!-- =========================================================
     Sidebar
========================================================= -->

<aside class="sidebar">


  <!-- =====================================================
         Sidebar Header
    ====================================================== -->

  <div class="sidebar-header">

    <a href="{{ route('dashboard') }}" class="sidebar-logo">

      <img src="{{ asset('assets/img/logo.webp') }}" alt="SmartHealthIOT">

      <span class="sidebar-logo-text">

        <span class="sidebar-logo-name">
          SmartHealthIOT
        </span>

        <span class="sidebar-logo-tagline">

          @if($isAdmin)
            Admin Panel
          @elseif($isDoctor)
            Doctor Portal
          @elseif($isPatient)
            Patient Portal
          @else
            Health IoT
          @endif

        </span>

      </span>

    </a>


    <button class="sidebar-close" type="button" title="Close Sidebar">

      <i class="bi bi-x-lg"></i>

    </button>

  </div>



  <!-- =====================================================
         Sidebar Navigation
    ====================================================== -->

  <nav class="sidebar-nav">

    <ul class="nav-menu">


      <!-- =================================================
                 MAIN
            ================================================== -->

      <li class="nav-heading">

        <span>MAIN</span>

      </li>


      <!-- Home -->

      <li class="nav-item">

        <a class="nav-link {{ $isActive('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"
          data-tooltip="Home">

          <i class="ph-duotone ph-squares-four"></i>

          <span>Home</span>

        </a>

      </li>



      <!-- =================================================
                 DOCTOR NAVIGATION
            ================================================== -->

      @if($isDoctor)


        <li class="nav-heading">

          <span>CLINICAL</span>

        </li>


        <!-- Patients -->

        <li class="nav-item has-submenu">

          <a class="nav-link
                                  {{ $isActive('doctor.patients.*') ? 'active' : '' }}" href="#"
            aria-expanded="{{ $isActive('doctor.patients.*') ? 'true' : 'false' }}" data-tooltip="Patients">

            <i class="ph-duotone ph-users"></i>

            <span>Patients</span>

            <i class="ph-duotone ph-caret-down nav-arrow"></i>

          </a>


          <ul class="nav-submenu
                                  {{ $isActive('doctor.patients.*') ? 'show' : '' }}">

            <li>

              <a class="nav-link
                                          {{ $isActive('doctor.patients.index') ? 'active' : '' }}"
                href="{{ route('doctor.patients.index') }}">


                <span>All Patients</span>

              </a>

            </li>


            <li>

              <a class="nav-link
                                          {{ $isActive('doctor.patients.create') ? 'active' : '' }}"
                href="{{ route('doctor.patients.create') }}">


                <span>Add Patient</span>

              </a>

            </li>

          </ul>

        </li>



        <!-- Devices -->

        <li class="nav-item has-submenu">

          <a class="nav-link
                                  {{ $isActive('doctor.devices.*') ? 'active' : '' }}" href="#"
            aria-expanded="{{ $isActive('doctor.devices.*') ? 'true' : 'false' }}" data-tooltip="Devices">

            <i class="ph-duotone ph-first-aid-kit"></i>

            <span>Devices</span>

            <i class="ph-duotone ph-caret-down nav-arrow"></i>

          </a>


          <ul class="nav-submenu
                                  {{ $isActive('doctor.devices.*') ? 'show' : '' }}">
            @if(Route::has('doctor.devices.index'))

            <li>

              <a class="nav-link
                                          {{ $isActive('doctor.devices.index') ? 'active' : '' }}"
                href="{{ route('doctor.devices.index') }}">


                <span>All Devices</span>

              </a>

            </li>
            @endif


            @if(Route::has('doctor.devices.create'))

              <li>

                <a class="nav-link
                                                    {{ $isActive('doctor.devices.create') ? 'active' : '' }}"
                  href="{{ route('doctor.devices.create') }}">


                  <span>Add Device</span>

                </a>

              </li>

            @endif

          </ul>

        </li>


      @endif



      <!-- =================================================
                 ADMIN NAVIGATION
            ================================================== -->

      @if($isAdmin || $isDoctor)


        <li class="nav-heading">

          <span>MANAGEMENT</span>

        </li>


        <!-- Doctors -->

        <li class="nav-item has-submenu">

          <a class="nav-link
                                  {{ $isActive('doctor.doctors.*') ? 'active' : '' }}" href="#"
            aria-expanded="{{ $isActive('doctor.doctors.*') ? 'true' : 'false' }}" data-tooltip="Doctors">

            <i class="ph-duotone ph-stethoscope"></i>

            <span>Doctors</span>

            <i class="ph-duotone ph-caret-down nav-arrow"></i>

          </a>


          <ul class="nav-submenu
                                  {{ $isActive('doctor.doctors.*') ? 'show' : '' }}">

            <li>

              <a class="nav-link
                                          {{ $isActive('doctor.doctors.index') ? 'active' : '' }}"
                href="{{ route('doctor.doctors.index') }}">


                <span>Directory</span>

              </a>

            </li>


            @if(Route::has('doctor.doctors.create'))

              <li>

                <a class="nav-link
                                                    {{ $isActive('doctor.doctors.create') ? 'active' : '' }}"
                  href="{{ route('doctor.doctors.create') }}">


                  <span>Add Doctor</span>

                </a>

              </li>

            @endif

          </ul>

        </li>








        <!-- Roles & Permissions -->

        @if(Route::has('admin.roles.index'))

          <li class="nav-item">

            <a class="nav-link
                                            {{ $isActive('admin.roles.*') ? 'active' : '' }}"
              href="{{ route('admin.roles.index') }}" data-tooltip="Roles">

              <i class="ph-duotone ph-shield-check"></i>

              <span>Roles & Permissions</span>

            </a>

          </li>

        @endif


      @endif



      <!-- =================================================
                 PATIENT NAVIGATION
            ================================================== -->

      @if($isPatient)


        <li class="nav-heading">

          <span>MY HEALTH</span>

        </li>


        <!-- My Health -->

        @if(Route::has('patient.health'))

          <li class="nav-item">

            <a class="nav-link
                                            {{ $isActive('patient.health') ? 'active' : '' }}"
              href="{{ route('patient.health') }}" data-tooltip="My Health">

              <i class="ph-duotone ph-heartbeat"></i>

              <span>My Health</span>

            </a>

          </li>

        @endif



        <!-- My Devices -->

        @if(Route::has('patient.devices'))

          <li class="nav-item">

            <a class="nav-link
                                            {{ $isActive('patient.devices.*') ? 'active' : '' }}"
              href="{{ route('patient.devices') }}" data-tooltip="My Devices">

              <i class="ph-duotone ph-first-aid-kit"></i>

              <span>My Devices</span>

            </a>

          </li>

        @endif



        <!-- My Readings -->

        @if(Route::has('patient.readings.index'))

          <li class="nav-item">

            <a class="nav-link
                                            {{ $isActive('patient.readings.*') ? 'active' : '' }}"
              href="{{ route('patient.readings.index') }}" data-tooltip="Health Readings">

              <i class="ph-duotone ph-chart-line-up"></i>

              <span>Health Readings</span>

            </a>

          </li>

        @endif


      @endif



      <!-- =================================================
                 ACCOUNT
            ================================================== -->

      <li class="nav-heading">

        <span>ACCOUNT</span>

      </li>


      <!-- Profile -->

      @if(Route::has('profile.index'))

        <li class="nav-item">

          <a class="nav-link
                                  {{ $isActive('profile.*') ? 'active' : '' }}" href="{{ route('profile.index') }}"
            data-tooltip="Profile">

            <i class="ph-duotone ph-user"></i>

            <span>Profile</span>

          </a>

        </li>

      @endif



      <!-- Notifications -->

      @if(Route::has('notifications.index'))

        <li class="nav-item">

          <a class="nav-link
                                  {{ $isActive('notifications.*') ? 'active' : '' }}"
            href="{{ route('notifications.index') }}" data-tooltip="Notifications">

            <i class="ph-duotone ph-bell"></i>

            <span>Notifications</span>

            @if(($headerUnreadCount ?? 0) > 0)

                  <span class="sidebar-notification-badge">

                    {{ $headerUnreadCount > 99
              ? '99+'
              : $headerUnreadCount }}

                  </span>

            @endif

          </a>

        </li>

      @endif



      <!-- Settings -->

      @if(Route::has('settings.index'))

        <li class="nav-item">

          <a class="nav-link
                                  {{ $isActive('settings.*') ? 'active' : '' }}" href="{{ route('settings.index') }}"
            data-tooltip="Settings">

            <i class="ph-duotone ph-gear"></i>

            <span>Settings</span>

          </a>

        </li>

      @endif



    </ul>

  </nav>

</aside>


<!-- =========================================================
     Sidebar Overlay
========================================================= -->

<div class="sidebar-overlay"></div>