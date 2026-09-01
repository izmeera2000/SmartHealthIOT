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
<script src="{{ asset('vendors/php-email-form/validate.js') }}"></script>
<script src="{{ asset('vendors/datatables/datatables.js') }}"></script>


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

<script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>


<script>
    /*
    |--------------------------------------------------------------------------
    | Push Notification Toast
    |--------------------------------------------------------------------------
    */

    function showPushToast(title, message) {

        const toastElement = document.getElementById(
            'pushNotificationToast'
        );

        const titleElement = document.getElementById(
            'pushToastTitle'
        );

        const messageElement = document.getElementById(
            'pushToastMessage'
        );

        if (!toastElement || !titleElement || !messageElement) {

            console.error(
                '❌ Push notification toast elements not found.'
            );

            return;
        }

        titleElement.textContent = title;
        messageElement.textContent = message;

        const toast = bootstrap.Toast.getOrCreateInstance(
            toastElement,
            {
                delay: 5000
            }
        );

        toast.show();
    }


    /*
    |--------------------------------------------------------------------------
    | Pusher Channels
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

    pusher.connection.bind('connected', function () {

        console.log(
            '✅ Pusher Channels connected'
        );

    });


    /*
    |--------------------------------------------------------------------------
    | Pusher Connection Error
    |--------------------------------------------------------------------------
    */

    pusher.connection.bind('error', function (error) {

        console.error(
            '❌ Pusher Channels error:',
            error
        );

    });


    /*
    |--------------------------------------------------------------------------
    | Doctor Channel
    |--------------------------------------------------------------------------
    */

    const channelName = 'doctor.{{ auth()->id() }}';

    console.log(
        '📡 Subscribing to:',
        channelName
    );

    const channel = pusher.subscribe(channelName);


    /*
    |--------------------------------------------------------------------------
    | Channel Subscription Success
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
    | Test Notification
    |--------------------------------------------------------------------------
    */

    channel.bind(
        'test.notification',
        function (data) {

            console.log(
                '🔔 Test notification received:',
                data
            );

            showPushToast(
                data.title,
                data.message
            );

        }
    );
</script>