{{-- =========================================
     Global Toast Notifications
========================================= --}}

<div
    class="toast-container position-fixed bottom-0 end-0 p-3"
    style="z-index: 9999;"
>
    {{-- Success --}}
    @if (session('success'))
        <div
            class="toast show"
            role="alert"
            aria-live="assertive"
            aria-atomic="true"
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


    {{-- Error --}}
    @if (session('error'))
        <div
            class="toast show"
            role="alert"
            aria-live="assertive"
            aria-atomic="true"
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


    {{-- Warning --}}
    @if (session('warning'))
        <div
            class="toast show"
            role="alert"
            aria-live="assertive"
            aria-atomic="true"
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


    {{-- Info --}}
    @if (session('info'))
        <div
            class="toast show"
            role="alert"
            aria-live="assertive"
            aria-atomic="true"
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


 