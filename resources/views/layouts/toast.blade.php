 
{{-- =========================================
     Global Toast Notifications
========================================= --}}

<div
    class="toast-container position-fixed bottom-0 end-0 p-3 d-flex flex-column gap-3"
    style="z-index: 9999;"
>


    {{-- =========================================
         Dynamic Pusher Notification Toast
    ========================================= --}}

    <div
        id="channelNotificationToast"
        class="toast"
        role="alert"
        aria-live="assertive"
        aria-atomic="true"
        data-bs-delay="5000"
        data-bs-autohide="true"
    >

        <div class="toast-header">

            <i
                id="channelToastIcon"
                class="bi bi-bell-fill text-primary me-2"
            ></i>

            <strong
                id="channelToastTitle"
                class="me-auto"
            >
                Notification
            </strong>

            <small
                id="channelToastTime"
                class="text-muted"
            >
                just now
            </small>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="toast"
                aria-label="Close"
            ></button>

        </div>


        <div class="toast-body">

            <div id="channelToastMessage">
                You have a new notification.
            </div>


            {{-- Action --}}
            <div
                id="channelToastActions"
                class="mt-3"
                style="display: none;"
            >

                <a
                    id="channelToastActionButton"
                    href="#"
                    class="btn btn-sm btn-primary"
                >
                    <i class="bi bi-eye me-1"></i>
                    View
                </a>

            </div>

        </div>

    </div>


    {{-- =========================================
         Laravel Success
    ========================================= --}}

    @if (session('success'))

        <div
            class="toast"
            role="alert"
            aria-live="assertive"
            aria-atomic="true"
            data-bs-delay="5000"
            data-bs-autohide="true"
        >

            <div class="toast-header">

                <i class="bi bi-check-circle-fill text-success me-2"></i>

                <strong class="me-auto">
                    Success
                </strong>

                <small class="text-muted">
                    just now
                </small>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="toast"
                    aria-label="Close"
                ></button>

            </div>

            <div class="toast-body">
                {{ session('success') }}
            </div>

        </div>

    @endif


    {{-- =========================================
         Laravel Error
    ========================================= --}}

    @if (session('error'))

        <div
            class="toast"
            role="alert"
            aria-live="assertive"
            aria-atomic="true"
            data-bs-delay="5000"
            data-bs-autohide="true"
        >

            <div class="toast-header">

                <i class="bi bi-x-circle-fill text-danger me-2"></i>

                <strong class="me-auto">
                    Error
                </strong>

                <small class="text-muted">
                    just now
                </small>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="toast"
                    aria-label="Close"
                ></button>

            </div>

            <div class="toast-body">
                {{ session('error') }}
            </div>

        </div>

    @endif


    {{-- =========================================
         Laravel Warning
    ========================================= --}}

    @if (session('warning'))

        <div
            class="toast"
            role="alert"
            aria-live="assertive"
            aria-atomic="true"
            data-bs-delay="5000"
            data-bs-autohide="true"
        >

            <div class="toast-header">

                <i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>

                <strong class="me-auto">
                    Warning
                </strong>

                <small class="text-muted">
                    just now
                </small>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="toast"
                    aria-label="Close"
                ></button>

            </div>

            <div class="toast-body">
                {{ session('warning') }}
            </div>

        </div>

    @endif


    {{-- =========================================
         Laravel Info
    ========================================= --}}

    @if (session('info'))

        <div
            class="toast"
            role="alert"
            aria-live="assertive"
            aria-atomic="true"
            data-bs-delay="5000"
            data-bs-autohide="true"
        >

            <div class="toast-header">

                <i class="bi bi-info-circle-fill text-primary me-2"></i>

                <strong class="me-auto">
                    Information
                </strong>

                <small class="text-muted">
                    just now
                </small>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="toast"
                    aria-label="Close"
                ></button>

            </div>

            <div class="toast-body">
                {{ session('info') }}
            </div>

        </div>

    @endif

</div>


{{-- =========================================
     Initialize Laravel Session Toasts
========================================= --}}

<script>
    document.addEventListener('DOMContentLoaded', function () {

        document
            .querySelectorAll('.toast:not(#channelNotificationToast)')
            .forEach(function (toastElement) {

                bootstrap.Toast
                    .getOrCreateInstance(toastElement, {
                        autohide: true,
                        delay: 5000
                    })
                    .show();

            });

    });
</script>
 