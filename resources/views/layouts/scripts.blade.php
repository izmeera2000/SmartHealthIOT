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
{{-- <script src="{{ asset('vendors/php-email-form/validate.js') }}"></script> --}}


<!-- =========================================
     Template Main JS Files
========================================= -->

<script src="{{ asset('assets/js/theme.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>


<!-- =========================================
     App Sidebar Toggle
========================================= -->

<script src="{{ asset('assets/js/apps-sidebar-toggle.js') }}"></script>


<!-- =========================================
     Pusher Channels
========================================= -->

 
<script src="{{ asset('vendors/pusher/pusher.min.js') }}"></script>
 

<script>
    /*
    |--------------------------------------------------------------------------
    | Pusher Real-Time Notification Toast
    |--------------------------------------------------------------------------
    |
    | This is ONLY for real-time notifications received through
    | Pusher Channels.
    |
    | Normal Laravel success/error messages are handled by the
    | Blade session toast in the layout.
    |
    |--------------------------------------------------------------------------
    */

    function showNotificationToast(
        title,
        message,
        options = {}
    ) {

        const toastElement = document.getElementById(
            'channelNotificationToast'
        );

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


        /*
        |--------------------------------------------------------------------------
        | Check Elements
        |--------------------------------------------------------------------------
        */

        if (
            !toastElement ||
            !titleElement ||
            !messageElement
        ) {

            console.error(
                '❌ Pusher notification toast elements not found.'
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Content
        |--------------------------------------------------------------------------
        */

        titleElement.textContent =
            title || 'Notification';

        messageElement.textContent =
            message || 'You have a new notification.';


        /*
        |--------------------------------------------------------------------------
        | Icon
        |--------------------------------------------------------------------------
        */

        if (iconElement) {

            iconElement.className =
                `bi ${options.icon || 'bi-bell-fill'} me-2`;


            /*
            | Remove previous colors
            */

            iconElement.classList.remove(
                'text-primary',
                'text-success',
                'text-warning',
                'text-danger'
            );


            /*
            | Add current color
            */

            iconElement.classList.add(
                options.color || 'text-primary'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Time
        |--------------------------------------------------------------------------
        */

        if (timeElement) {

            timeElement.textContent =
                options.time || 'just now';
        }


        /*
        |--------------------------------------------------------------------------
        | Action Button
        |--------------------------------------------------------------------------
        */

        if (
            actionsElement &&
            actionButton
        ) {

            if (
                options.actionUrl &&
                options.actionText
            ) {

                actionButton.href =
                    options.actionUrl;

                actionButton.innerHTML =
                    `<i class="bi bi-eye me-1"></i> ${options.actionText}`;

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


        /*
        |--------------------------------------------------------------------------
        | Show Toast
        |--------------------------------------------------------------------------
        */

        const toast =
            bootstrap.Toast.getOrCreateInstance(
                toastElement,
                {
                    delay: 5000
                }
            );

        toast.show();
    }


    /*
    |--------------------------------------------------------------------------
    | PUSHER CHANNELS
    |--------------------------------------------------------------------------
    */

    Pusher.logToConsole = true;


    const pusher = new Pusher(
        '{{ config('broadcasting.connections.pusher.key') }}',
        {
            cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
            forceTLS: true
        }
    );


    /*
    |--------------------------------------------------------------------------
    | Pusher Connection
    |--------------------------------------------------------------------------
    */

    pusher.connection.bind(
        'connected',
        function () {

            console.log(
                '✅ Pusher Channels connected'
            );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Pusher Connection Error
    |--------------------------------------------------------------------------
    */

    pusher.connection.bind(
        'error',
        function (error) {

            console.error(
                '❌ Pusher Channels error:',
                error
            );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Doctor Channel
    |--------------------------------------------------------------------------
    */

    const channelName =
        'doctor.{{ auth()->id() }}';


    console.log(
        '📡 Subscribing to:',
        channelName
    );


    const channel =
        pusher.subscribe(channelName);


    /*
    |--------------------------------------------------------------------------
    | Channel Subscription
    |--------------------------------------------------------------------------
    */

    channel.bind(
        'pusher:subscription_succeeded',
        function () {

            console.log(
                '✅ Successfully subscribed to:',
                channelName
            );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | TEST NOTIFICATION
    |--------------------------------------------------------------------------
    */

    channel.bind(
        'test.notification',
        function (data) {

            console.log(
                '🔔 Test notification received:',
                data
            );


            showNotificationToast(
                data.title,
                data.message,
                {
                    icon: 'bi-bell-fill',
                    color: 'text-primary'
                }
            );

        }
    );
</script>