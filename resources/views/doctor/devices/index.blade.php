@extends('layouts.app')

@section('content')

    <section class="section">

        {{-- ========================================================== --}}
        {{-- HEADER --}}
        {{-- ========================================================== --}}

        <div class="card">

            <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-3">

                <div>

                    <h5 class="card-title mb-1">
                        Devices
                    </h5>

                    <small class="text-muted">
                        Manage your registered ESP32 devices
                    </small>

                </div>


                <a href="{{ route('doctor.devices.create') }}" class="btn btn-primary">

                    <i class="bi bi-plus-lg me-1"></i>

                    Register Device

                </a>

            </div>


            <div class="card-body">

                {{-- ========================================================== --}}
                {{-- SUCCESS MESSAGE --}}
                {{-- ========================================================== --}}

                @if(session('success'))

                    <div class="alert alert-success alert-dismissible fade show" role="alert">

                        <i class="bi bi-check-circle me-1"></i>

                        {{ session('success') }}

                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

                    </div>

                @endif


                {{-- ========================================================== --}}
                {{-- DATATABLE --}}
                {{-- ========================================================== --}}

                <div class="table-responsive">

                    <table id="devicesTable" class="table table-hover align-middle w-100">

                        <thead>

                            <tr>

                                <th>
                                    Device
                                </th>

                                <th>
                                    Device UID
                                </th>

                                <th>
                                    Patient
                                </th>

                                <th>
                                    Type
                                </th>

                                <th>
                                    Status
                                </th>

                                <th>
                                    Last Seen
                                </th>

                                <th class="text-end">
                                    Actions
                                </th>

                            </tr>

                        </thead>

                        <tbody>
                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </section>

@endsection


@push('scripts')

    <script>

        $(document).ready(function () {

        


            $('#devicesTable').DataTable({

                processing: true,

                serverSide: true,

                responsive: true,

                ajax: {
                    url: "{{ route('doctor.devices.data') }}",
                    type: "GET"
                },

                pageLength: 10,

                lengthMenu: [
                    [10, 25, 50, 100],
                    [10, 25, 50, 100]
                ],

                order: [
                    [0, 'desc']
                ],

                columns: [

                    /*
                    |--------------------------------------------------------------------------
                    | Device
                    |--------------------------------------------------------------------------
                    */

                    {
                        data: 'device_name',
                        name: 'device_name',

                        render: function (data, type, row) {

                            return `
                            <div class="fw-semibold">
                                ${data ?? 'Unnamed Device'}
                            </div>

                            <small class="text-muted">
                                ${row.mac_address ?? '-'}
                            </small>
                        `;
                        }
                    },


                    /*
                    |--------------------------------------------------------------------------
                    | Device UID
                    |--------------------------------------------------------------------------
                    */

                    {
                        data: 'device_uid',
                        name: 'device_uid',

                        render: function (data) {

                            return `
                            <code>
                                ${data ?? '-'}
                            </code>
                        `;
                        }
                    },


                    /*
                    |--------------------------------------------------------------------------
                    | Patient
                    |--------------------------------------------------------------------------
                    */

                    {
                        data: 'patient',
                        name: 'patient',

                        orderable: false,

                        render: function (data) {

                            if (!data) {

                                return `
                                <span class="text-muted">
                                    Unassigned
                                </span>
                            `;
                            }

                            return `
                            <div class="fw-semibold">
                                ${data.name}
                            </div>

                            <small class="text-muted">
                                ${data.patient_id ?? 'Patient'}
                            </small>
                        `;
                        }
                    },


                    /*
                    |--------------------------------------------------------------------------
                    | Type
                    |--------------------------------------------------------------------------
                    */

                    {
                        data: 'device_type',
                        name: 'device_type'
                    },


                    /*
                    |--------------------------------------------------------------------------
                    | Status
                    |--------------------------------------------------------------------------
                    */

                    {
                        data: 'status',
                        name: 'status',

                        render: function (data) {

                            if (data === 'active') {

                                return `
                                <span class="badge bg-success">
                                    Active
                                </span>
                            `;
                            }

                            return `
                            <span class="badge bg-secondary">
                                Inactive
                            </span>
                        `;
                        }
                    },


                    /*
                    |--------------------------------------------------------------------------
                    | Last Seen
                    |--------------------------------------------------------------------------
                    */

                    {
                        data: 'last_seen_at',
                        name: 'last_seen_at',

                        render: function (data, type, row) {

                            if (!data) {

                                return `
                                <span class="text-muted">
                                    Never
                                </span>
                            `;
                            }

                            return `
                            <span title="${row.last_seen_full ?? ''}">
                                ${data}
                            </span>
                        `;
                        }
                    },


                    /*
                    |--------------------------------------------------------------------------
                    | Actions
                    |--------------------------------------------------------------------------
                    */

                    {
                        data: null,

                        orderable: false,

                        searchable: false,

                        className: 'text-end',

                        render: function (data, type, row) {

                            return `

                <div class="dropdown">

                    <button
                        class="btn btn-sm btn-light"
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                    >

                        <i class="bi bi-three-dots-vertical"></i>

                    </button>


                    <ul class="dropdown-menu dropdown-menu-end">

                        {{-- View --}}

                        <li>

                            <a
                                class="dropdown-item"
                                href="${row.show_url}"
                            >

                                <i class="bi bi-eye me-2"></i>

                                View

                            </a>

                        </li>


                        {{-- Edit --}}

                        <li>

                            <a
                                class="dropdown-item"
                                href="${row.edit_url}"
                            >

                                <i class="bi bi-pencil me-2"></i>

                                Edit

                            </a>

                        </li>


                        {{-- Divider --}}

                        <li>

                            <hr class="dropdown-divider">

                        </li>


                        {{-- Delete --}}

                        <li>

                            <button
                                type="button"
                                class="dropdown-item text-danger delete-device"
                                data-id="${row.id}"
                            >

                                <i class="bi bi-trash me-2"></i>

                                Delete

                            </button>

                        </li>

                    </ul>

                </div>

            `;

                        }

                    },




                ],

                language: {

                    processing:
                        '<i class="bi bi-hourglass-split me-1"></i> Loading devices...',

                    emptyTable:
                        'No devices registered',

                    zeroRecords:
                        'No matching devices found'

                }

            });

        });

    </script>

@endpush