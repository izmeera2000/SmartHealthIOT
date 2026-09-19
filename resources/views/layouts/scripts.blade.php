<!-- =========================================
     Vendor JS Files
========================================= -->

<script src="{{ asset('vendors/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendors/jquery/jquery-3.7.1.js') }}"></script>

<script src="{{ asset('vendors/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset('vendors/chart.js/chart.umd.js') }}"></script>
<script src="{{ asset('vendors/echarts/echarts.min.js') }}"></script>
<script src="{{ asset('vendors/simple-datatables/simple-datatables.js') }}"></script>
<script src="{{ asset('vendors/quill/quill.js') }}"></script>
<script src="{{ asset('vendors/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('vendors/choices.js/choices.min.js') }}"></script>
<script src="{{ asset('vendors/flatpickr/flatpickr.min.js') }}"></script>
{{--
<script src="{{ asset('vendors/php-email-form/validate.js') }}"></script> --}}


<!-- =========================================
     Template Main JS Files
========================================= -->

<script src="{{ asset('assets/js/theme.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>


<!-- =========================================
     App Sidebar Toggle
========================================= -->

<script src="{{ asset('assets/js/apps-sidebar-toggle.js') }}"></script>

{{-- ========================================================= Pusher Channels Available for all authenticated users
========================================================= --}}
{{-- =========================================================
Pusher Channels Available for all authenticated users
========================================================= --}}

@auth
    <script src="{{ asset('vendors/pusher/pusher.min.js') }}" defer></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            /* ---------------------------------------------------------
             | Notification Toast
             |---------------------------------------------------------- */
            function showNotificationToast(data = {}) {
                const toastElement = document.getElementById(
                    'channelNotificationToast'
                );

                if (!toastElement) {
                    return;
                }

                /* ---------------------------------------------------------
                 | Elements
                 |---------------------------------------------------------- */
                const titleElement = document.getElementById(
                    'channelToastTitle'
                );

                const messageElement = document.getElementById(
                    'channelToastMessage'
                );

                const iconElement = document.getElementById(
                    'channelToastIcon'
                );

                const timeElement = document.getElementById(
                    'channelToastTime'
                );

                const actionsElement = document.getElementById(
                    'channelToastActions'
                );

                const actionButton = document.getElementById(
                    'channelToastActionButton'
                );

                /* ---------------------------------------------------------
                 | Notification Data
                 |---------------------------------------------------------- */
                const title = data.title || 'Notification';
                const message = data.message || 'You have a new notification.';
                const icon = data.icon || 'bell-fill';
                const iconType = data.icon_type || 'primary';
                const url = data.url || null;

                /* ---------------------------------------------------------
                 | Content
                 |---------------------------------------------------------- */
                if (titleElement) {
                    titleElement.textContent = title;
                }

                if (messageElement) {
                    messageElement.textContent = message;
                }

                /* ---------------------------------------------------------
                 | Icon
                 |---------------------------------------------------------- */
                if (iconElement) {
                    iconElement.className = `bi bi-${icon} me-2`;

                    iconElement.classList.remove(
                        'text-primary',
                        'text-success',
                        'text-warning',
                        'text-danger',
                        'text-info',
                        'text-secondary'
                    );

                    iconElement.classList.add(`text-${iconType}`);
                }

                /* ---------------------------------------------------------
                 | Time
                 |---------------------------------------------------------- */
                if (timeElement) {
                    timeElement.textContent = 'just now';
                }

                /* ---------------------------------------------------------
                 | Action Button
                 |---------------------------------------------------------- */
                if (actionsElement && actionButton) {
                    if (url) {
                        actionButton.href = url;
                        actionButton.innerHTML =
                            '<i class="bi bi-eye me-1"></i> View';

                        actionsElement.style.setProperty(
                            'display',
                            'flex',
                            'important'
                        );
                    } else {
                        actionsElement.style.setProperty(
                            'display',
                            'none',
                            'important'
                        );
                    }
                }

                /* ---------------------------------------------------------
                 | Show Toast
                 |---------------------------------------------------------- */
                bootstrap.Toast.getOrCreateInstance(toastElement, {
                    delay: 5000
                }).show();
            }

            /* ---------------------------------------------------------
             | Pusher Configuration
             |---------------------------------------------------------- */
            const pusher = new Pusher(
                @json(config('broadcasting.connections.pusher.key')),
                {
                    cluster: @json(
                        config('broadcasting.connections.pusher.options.cluster')
                    ),
                    forceTLS: true
                }
            );

            /* ---------------------------------------------------------
             | Connection
             |---------------------------------------------------------- */
            pusher.connection.bind('connected', function () {
                console.log('Pusher connected');
            });

            pusher.connection.bind('error', function (error) {
                console.error('Pusher connection error:', error);
            });

            /* ---------------------------------------------------------
             | User Channel
             |---------------------------------------------------------
             |
             | Each authenticated user gets their own private notification
             | channel based on their user ID.
             |
             --------------------------------------------------------- */
            const channelName = @json('user.' . auth()->id());
            const channel = pusher.subscribe(channelName);

            /* ---------------------------------------------------------
             | Subscription
             |---------------------------------------------------------- */
            channel.bind(
                'pusher:subscription_succeeded',
                function () {
                    console.log('Subscribed to:', channelName);
                }
            );

            /* ---------------------------------------------------------
             | Test Notification
             |---------------------------------------------------------- */
            channel.bind('test.notification', function (data) {
                console.log(
                    'Test notification received:',
                    data
                );

                showNotificationToast(data);
            });

            /* ---------------------------------------------------------
             | Patient Registered
             |---------------------------------------------------------- */
            channel.bind('patient.registered', function (data) {
                console.log(
                    'Patient registered notification:',
                    data
                );

                showNotificationToast(data);
            });

        });
    </script>
@endauth