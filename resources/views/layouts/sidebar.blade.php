<!-- Sidebar -->
<aside class="sidebar">
  <!-- Sidebar Header -->
  <div class="sidebar-header">
    <a href="index.html" class="sidebar-logo">
      <img src="assets/img/logo.webp" alt="SmartHealthIOT">
      <span class="sidebar-logo-text">
        <span class="sidebar-logo-name">SmartHealthIOT</span>
        <span class="sidebar-logo-tagline">Admin Panel</span>
      </span>
    </a>
    <button class="sidebar-close">
      <i class="bi bi-x-lg"></i>
    </button>
  </div>

  <!-- Sidebar Navigation -->
  <nav class="sidebar-nav">
    <ul class="nav-menu">


      <li class="nav-item">
        <a class="nav-link " href="{{ route('dashboard') }}" data-tooltip="Home">
          <i class="ph-duotone ph-squares-four"></i>
          <span>Home</span>
        </a>
      </li>

      <!-- Users -->
      <li class="nav-item has-submenu ">
        <a class="nav-link" href="dashboard-finance.html#" aria-expanded="false" data-tooltip="Patients">
          <i class="ph-duotone ph-users"></i>
          <span>Patients</span>
          <i class="ph-duotone ph-caret-down nav-arrow"></i>
        </a>
        <ul class="nav-submenu ">
          <li><a class="nav-link " href="{{ route('doctor.patients.index') }}">List</a></li>
          {{-- <li><a class="nav-link " href="users-view.html">Patients View</a></li> --}}
          {{-- <li><a class="nav-link " href="users-edit.html">Patients Edit</a></li> --}}
          {{-- <li><a class="nav-link " href="profile.html">Profile</a></li> --}}
          <!-- 3rd Level - Settings submenu -->
          {{-- <li class="has-submenu ">
            <a class="nav-link" href="dashboard-finance.html#" aria-expanded="false">
              Settings
              <i class="ph-duotone ph-caret-down nav-arrow"></i>
            </a>
            <ul class="nav-submenu ">
              <li><a class="nav-link " href="settings.html">Account</a></li>
              <li><a class="nav-link " href="notifications.html">Notifications</a></li>
              <li><a class="nav-link " href="activity.html">Activity</a></li>
            </ul>
          </li> --}}
          {{-- <li><a class="nav-link " href="roles.html">Roles & Permissions</a></li> --}}
        </ul>
      </li>


      <li class="nav-item has-submenu ">
        <a class="nav-link" href="dashboard-finance.html#" aria-expanded="false" data-tooltip="Devices">
          <i class="ph-duotone ph-first-aid-kit"></i>
          <span>Devices</span>
          <i class="ph-duotone ph-caret-down nav-arrow"></i>
        </a>
        <ul class="nav-submenu ">
          <li><a class="nav-link " href="{{ route('doctor.devices.index') }}">List</a></li>
          {{-- <li><a class="nav-link " href="users-view.html">Patients View</a></li> --}}
          {{-- <li><a class="nav-link " href="users-edit.html">Patients Edit</a></li> --}}
          {{-- <li><a class="nav-link " href="profile.html">Profile</a></li> --}}
          <!-- 3rd Level - Settings submenu -->
          {{-- <li class="has-submenu ">
            <a class="nav-link" href="dashboard-finance.html#" aria-expanded="false">
              Settings
              <i class="ph-duotone ph-caret-down nav-arrow"></i>
            </a>
            <ul class="nav-submenu ">
              <li><a class="nav-link " href="settings.html">Account</a></li>
              <li><a class="nav-link " href="notifications.html">Notifications</a></li>
              <li><a class="nav-link " href="activity.html">Activity</a></li>
            </ul>
          </li> --}}
          {{-- <li><a class="nav-link " href="roles.html">Roles & Permissions</a></li> --}}
        </ul>
      </li>


      <li class="nav-item has-submenu ">
        <a class="nav-link" href="dashboard-finance.html#" aria-expanded="false" data-tooltip="Doctors">
          <i class="ph-duotone ph-users"></i>
          <span>Doctors</span>
          <i class="ph-duotone ph-caret-down nav-arrow"></i>
        </a>
        <ul class="nav-submenu ">
          <li><a class="nav-link " href="{{ route('doctor.doctors.index') }}">List</a></li>
          {{-- <li><a class="nav-link " href="users-view.html">Patients View</a></li> --}}
          {{-- <li><a class="nav-link " href="users-edit.html">Patients Edit</a></li> --}}
          {{-- <li><a class="nav-link " href="profile.html">Profile</a></li> --}}
          <!-- 3rd Level - Settings submenu -->
          {{-- <li class="has-submenu ">
            <a class="nav-link" href="dashboard-finance.html#" aria-expanded="false">
              Settings
              <i class="ph-duotone ph-caret-down nav-arrow"></i>
            </a>
            <ul class="nav-submenu ">
              <li><a class="nav-link " href="settings.html">Account</a></li>
              <li><a class="nav-link " href="notifications.html">Notifications</a></li>
              <li><a class="nav-link " href="activity.html">Activity</a></li>
            </ul>
          </li> --}}
          {{-- <li><a class="nav-link " href="roles.html">Roles & Permissions</a></li> --}}
        </ul>
      </li>


         <li class="nav-item">
        <a class="nav-link " href="index.html" data-tooltip="Home">
          <i class="ph-duotone ph-user"></i>
          <span>Profile</span>
        </a>
      </li>







{{-- 
      <li class="nav-item">
        <a class="nav-link " href="index.html" data-tooltip="Dashboard">
          <i class="ph-duotone ph-squares-four"></i>
          <span>Dashboard</span>
        </a>
      </li> --}}

      <!-- Dashboards Submenu -->
      {{-- <li class="nav-item has-submenu open">
        <a class="nav-link" href="dashboard-finance.html#" aria-expanded="true" data-tooltip="Dashboards">
          <i class="ph-duotone ph-speedometer"></i>
          <span>Dashboards</span>
          <i class="ph-duotone ph-caret-down nav-arrow"></i>
        </a>
        <ul class="nav-submenu show">
          <li><a class="nav-link " href="dashboard-sales.html">Sales</a></li>
          <li><a class="nav-link " href="dashboard-analytics.html">Analytics</a></li>
          <li><a class="nav-link " href="dashboard-crm.html">CRM</a></li>
          <li><a class="nav-link " href="dashboard-marketing.html">Marketing</a></li>
          <li><a class="nav-link " href="dashboard-projects.html">Projects</a></li>
          <li><a class="nav-link active" href="dashboard-finance.html">Finance</a></li>
        </ul>
      </li> --}}

      <!-- Users -->
      {{-- <li class="nav-item has-submenu ">
        <a class="nav-link" href="dashboard-finance.html#" aria-expanded="false" data-tooltip="Users">
          <i class="ph-duotone ph-users"></i>
          <span>Users</span>
          <i class="ph-duotone ph-caret-down nav-arrow"></i>
        </a>
        <ul class="nav-submenu ">
          <li><a class="nav-link " href="users.html">Users List</a></li>
          <li><a class="nav-link " href="users-view.html">User View</a></li>
          <li><a class="nav-link " href="users-edit.html">User Edit</a></li>
          <li><a class="nav-link " href="profile.html">Profile</a></li>
          <!-- 3rd Level - Settings submenu -->
          <li class="has-submenu ">
            <a class="nav-link" href="dashboard-finance.html#" aria-expanded="false">
              Settings
              <i class="ph-duotone ph-caret-down nav-arrow"></i>
            </a>
            <ul class="nav-submenu ">
              <li><a class="nav-link " href="settings.html">Account</a></li>
              <li><a class="nav-link " href="notifications.html">Notifications</a></li>
              <li><a class="nav-link " href="activity.html">Activity</a></li>
            </ul>
          </li>
          <li><a class="nav-link " href="roles.html">Roles & Permissions</a></li>
        </ul>
      </li> --}}

      <!-- Authentication -->
      {{-- <li class="nav-item has-submenu ">
        <a class="nav-link" href="dashboard-finance.html#" aria-expanded="false" data-tooltip="Authentication">
          <i class="ph-duotone ph-shield-check"></i>
          <span>Authentication</span>
          <i class="ph-duotone ph-caret-down nav-arrow"></i>
        </a>
        <ul class="nav-submenu ">
          <li><a class="nav-link " href="auth-login.html">Login</a></li>
          <li><a class="nav-link " href="auth-register.html">Register</a></li>
          <li><a class="nav-link " href="auth-forgot-password.html">Forgot Password</a></li>
          <li><a class="nav-link " href="auth-reset-password.html">Reset Password</a></li>
          <li><a class="nav-link " href="auth-verify-email.html">Email Verification</a></li>
          <li><a class="nav-link " href="auth-two-factor.html">Two Factor Auth</a></li>
          <li><a class="nav-link " href="auth-lock-screen.html">Lock Screen</a></li>
        </ul>
      </li> --}}

      <!-- Apps Section -->
      {{-- <li class="nav-heading"><span>Apps</span></li>

      <li class="nav-item">
        <a class="nav-link " href="apps-calendar.html" data-tooltip="Calendar">
          <i class="ph-duotone ph-calendar"></i>
          <span>Calendar</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link " href="apps-kanban.html" data-tooltip="Kanban Board">
          <i class="ph-duotone ph-kanban"></i>
          <span>Kanban Board</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link " href="apps-chat.html" data-tooltip="Chat">
          <i class="ph-duotone ph-chats"></i>
          <span>Chat</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link " href="apps-contacts.html" data-tooltip="Contacts">
          <i class="ph-duotone ph-address-book"></i>
          <span>Contacts</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link " href="apps-file-manager.html" data-tooltip="File Manager">
          <i class="ph-duotone ph-folder-open"></i>
          <span>File Manager</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link " href="apps-email.html" data-tooltip="Email">
          <i class="ph-duotone ph-envelope"></i>
          <span>Email</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link " href="apps-todo.html" data-tooltip="Todo List">
          <i class="ph-duotone ph-check-square"></i>
          <span>Todo List</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link " href="apps-support.html" data-tooltip="Support Center">
          <i class="ph-duotone ph-headset"></i>
          <span>Support Center</span>
        </a>
      </li> --}}

      <!-- UI Elements Section -->
      {{-- <li class="nav-heading"><span>UI Elements</span></li> --}}

      {{-- <li class="nav-item has-submenu ">
        <a class="nav-link" href="dashboard-finance.html#" aria-expanded="false" data-tooltip="Components">
          <i class="ph-duotone ph-puzzle-piece"></i>
          <span>Components</span>
          <i class="ph-duotone ph-caret-down nav-arrow"></i>
        </a>
        <ul class="nav-submenu ">
          <li><a class="nav-link " href="components-alerts.html">Alerts</a></li>
          <li><a class="nav-link " href="components-accordion.html">Accordion</a></li>
          <li><a class="nav-link " href="components-badges.html">Badges</a></li>
          <li><a class="nav-link " href="components-breadcrumbs.html">Breadcrumbs</a></li>
          <li><a class="nav-link " href="components-buttons.html">Buttons</a></li>
          <li><a class="nav-link " href="components-cards.html">Cards</a></li>
          <li><a class="nav-link " href="components-carousel.html">Carousel</a></li>
          <li><a class="nav-link " href="components-dropdowns.html">Dropdowns</a></li>
          <li><a class="nav-link " href="components-list-group.html">List Group</a></li>
          <li><a class="nav-link " href="components-modal.html">Modal</a></li>
          <li><a class="nav-link " href="components-nav-tabs.html">Navs & Tabs</a></li>
          <li><a class="nav-link " href="components-offcanvas.html">Offcanvas</a></li>
          <li><a class="nav-link " href="components-pagination.html">Pagination</a></li>
          <li><a class="nav-link " href="components-popovers.html">Popovers</a></li>
          <li><a class="nav-link " href="components-progress.html">Progress</a></li>
          <li><a class="nav-link " href="components-spinners.html">Spinners</a></li>
          <li><a class="nav-link " href="components-toasts.html">Toasts</a></li>
          <li><a class="nav-link " href="components-tooltips.html">Tooltips</a></li>
        </ul>
      </li> --}}

      <!-- Widgets -->
      {{-- <li class="nav-item has-submenu ">
        <a class="nav-link" href="dashboard-finance.html#" aria-expanded="false" data-tooltip="Widgets">
          <i class="ph-duotone ph-layout"></i>
          <span>Widgets</span>
          <i class="ph-duotone ph-caret-down nav-arrow"></i>
        </a>
        <ul class="nav-submenu ">
          <li><a class="nav-link " href="widgets-cards.html">Cards</a></li>
          <li><a class="nav-link " href="widgets-banners.html">Banners</a></li>
          <li><a class="nav-link " href="widgets-charts.html">Charts</a></li>
          <li><a class="nav-link " href="widgets-apps.html">Apps</a></li>
          <li><a class="nav-link " href="widgets-data.html">Data</a></li>
        </ul>
      </li> --}}

      <!-- Forms Section -->
      {{-- <li class="nav-item has-submenu ">
        <a class="nav-link" href="dashboard-finance.html#" aria-expanded="false" data-tooltip="Forms">
          <i class="ph-duotone ph-textbox"></i>
          <span>Forms</span>
          <i class="ph-duotone ph-caret-down nav-arrow"></i>
        </a>
        <ul class="nav-submenu ">
          <li><a class="nav-link " href="forms-elements.html">Form Elements</a></li>
          <li><a class="nav-link " href="forms-layouts.html">Form Layouts</a></li>
          <li><a class="nav-link " href="forms-validation.html">Validation</a></li>
          <li><a class="nav-link " href="forms-wizard.html">Wizard</a></li>
          <li><a class="nav-link " href="forms-editors.html">Rich Editors</a></li>
          <li><a class="nav-link " href="forms-pickers.html">Date/Time Pickers</a></li>
          <li><a class="nav-link " href="forms-select.html">Advanced Select</a></li>
          <li><a class="nav-link " href="forms-upload.html">File Upload</a></li>
        </ul>
      </li> --}}

      <!-- Tables Section -->
      {{-- <li class="nav-item has-submenu ">
        <a class="nav-link" href="dashboard-finance.html#" aria-expanded="false" data-tooltip="Tables">
          <i class="ph-duotone ph-table"></i>
          <span>Tables</span>
          <i class="ph-duotone ph-caret-down nav-arrow"></i>
        </a>
        <ul class="nav-submenu ">
          <li><a class="nav-link " href="tables-basic.html">Basic Tables</a></li>
          <li><a class="nav-link " href="tables-datatables.html">DataTables</a></li>
          <li><a class="nav-link " href="tables-responsive.html">Responsive Tables</a></li>
        </ul>
      </li> --}}

      <!-- Charts Section -->
      {{-- <li class="nav-item has-submenu ">
        <a class="nav-link" href="dashboard-finance.html#" aria-expanded="false" data-tooltip="Charts">
          <i class="ph-duotone ph-chart-bar"></i>
          <span>Charts</span>
          <i class="ph-duotone ph-caret-down nav-arrow"></i>
        </a>
        <ul class="nav-submenu ">
          <li><a class="nav-link " href="charts-apexcharts.html">ApexCharts</a></li>
          <li><a class="nav-link " href="charts-chartjs.html">Chart.js</a></li>
          <li><a class="nav-link " href="charts-echarts.html">ECharts</a></li>
        </ul>
      </li> --}}

      <!-- Icons Section -->
      {{-- <li class="nav-item has-submenu ">
        <a class="nav-link" href="dashboard-finance.html#" aria-expanded="false" data-tooltip="Icons">
          <i class="ph-duotone ph-diamond"></i>
          <span>Icons</span>
          <i class="ph-duotone ph-caret-down nav-arrow"></i>
        </a>
        <ul class="nav-submenu ">
          <li><a class="nav-link " href="icons-bootstrap.html">Bootstrap Icons</a></li>
          <li><a class="nav-link " href="icons-remixicon.html">Remix Icons</a></li>
          <li><a class="nav-link " href="icons-fontawesome.html">Font Awesome</a></li>
          <li><a class="nav-link " href="icons-phosphor.html">Phosphor Icons</a></li>
          <li><a class="nav-link " href="icons-lucide.html">Lucide Icons</a></li>
        </ul>
      </li> --}}

      <!-- Pages Section -->
      {{-- <li class="nav-heading"><span>Pages</span></li>

      <li class="nav-item">
        <a class="nav-link " href="contact.html" data-tooltip="Contact">
          <i class="ph-duotone ph-envelope"></i>
          <span>Contact</span>
        </a>
      </li> --}}

      <!-- Invoices -->
      {{-- <li class="nav-item has-submenu ">
        <a class="nav-link" href="dashboard-finance.html#" aria-expanded="false" data-tooltip="Invoices">
          <i class="ph-duotone ph-receipt"></i>
          <span>Invoices</span>
          <i class="ph-duotone ph-caret-down nav-arrow"></i>
        </a>
        <ul class="nav-submenu ">
          <li><a class="nav-link " href="invoice-list.html">Invoice List</a></li>
          <li><a class="nav-link " href="invoice.html">Invoice View</a></li>
        </ul>
      </li>

      <li class="nav-item">
        <a class="nav-link " href="pricing.html" data-tooltip="Pricing">
          <i class="ph-duotone ph-tag"></i>
          <span>Pricing</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link " href="faq.html" data-tooltip="FAQ">
          <i class="ph-duotone ph-question"></i>
          <span>FAQ</span>
        </a>
      </li> --}}

      <!-- Error Pages -->
      {{-- <li class="nav-item has-submenu ">
        <a class="nav-link" href="dashboard-finance.html#" aria-expanded="false" data-tooltip="Error Pages">
          <i class="ph-duotone ph-warning"></i>
          <span>Error Pages</span>
          <i class="ph-duotone ph-caret-down nav-arrow"></i>
        </a>
        <ul class="nav-submenu ">
          <li><a class="nav-link " href="error-404.html">404 Not Found</a></li>
          <li><a class="nav-link " href="error-403.html">403 Forbidden</a></li>
          <li><a class="nav-link " href="error-500.html">500 Server Error</a></li>
          <li><a class="nav-link " href="error-maintenance.html">Maintenance</a></li>
          <li><a class="nav-link " href="error-coming-soon.html">Coming Soon</a></li>
        </ul>
      </li>

      <li class="nav-item">
        <a class="nav-link " href="timeline.html" data-tooltip="Timeline">
          <i class="ph-duotone ph-clock-counter-clockwise"></i>
          <span>Timeline</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link " href="search-results.html" data-tooltip="Search Results">
          <i class="ph-duotone ph-magnifying-glass"></i>
          <span>Search Results</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link " href="blank.html" data-tooltip="Blank Page">
          <i class="ph-duotone ph-file"></i>
          <span>Blank Page</span>
        </a>
      </li> --}}

    </ul>
  </nav>

</aside>

<!-- Sidebar Overlay (Mobile) -->
<div class="sidebar-overlay"></div>