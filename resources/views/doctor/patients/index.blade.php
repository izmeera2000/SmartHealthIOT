@extends('layouts.app')

@section('content')

    <section class="section">

        <div class="card">

            {{-- HEADER --}}
            <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-3">

                <div class="d-flex align-items-center gap-3">

                    <h5 class="card-title mb-0">
                        All Patients
                    </h5>

                    <span class="badge bg-primary-light text-primary" id="patient-count">
                        0 patients
                    </span>

                </div>


                <div>

                    <a href="{{ route('doctor.patients.create') }}" class="btn btn-primary">

                        <i class="bi bi-plus-lg me-1"></i>

                        Add Patient

                    </a>

                </div>

            </div>


            {{-- TABLE --}}
            <div class="card-body">

                <div class="table-responsive">

                    <table id="patients-table" class="table table-hover align-middle" style="width:100%;">

                        <thead>

                            <tr>

                                {{-- <th style="width:40px;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="selectAll">
                                    </div>
                                </th> --}}

                                <th>Patient</th>

                                <th>Patient ID</th>

                                <th>Age</th>

                                <th>Gender</th>

                                <th>Phone</th>

                                <th>Blood Type</th>

                                <th>Joined</th>

                                <th style="width:100px;">
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


@section('scripts')

    <script>

        $(document).ready(function () {

            /*
            |--------------------------------------------------------------------------
            | DataTable
            |--------------------------------------------------------------------------
            */

            const table = $('#patients-table').DataTable({

                processing: true,

                serverSide: true,

                responsive: true,

                pageLength: 5,

                lengthMenu: [
                    [5,10, 25, 50, 100],
                    [5,10, 25, 50, 100]
                ],

                ajax: {
                    url: "{{ route('doctor.patients.data') }}",
                    type: "GET"
                },

                order: [
                    [7, 'desc']
                ],

                columns: [

                    /*
                    |--------------------------------------------------------------------------
                    | Checkbox
                    |--------------------------------------------------------------------------
                    */

                    // {
                    //     data: 'id',

                    //     name: 'id',

                    //     orderable: false,

                    //     searchable: false,

                    //     render: function (data) {

                    //         return `
                    //                 <div class="form-check">

                    //                     <input
                    //                         class="form-check-input patient-checkbox"
                    //                         type="checkbox"
                    //                         value="${data}"
                    //                         style="
                    //                             border: 2px solid #6c757d;
                    //                         "
                    //                     >

                    //                 </div>
                    //             `;

                    //     }

                    // },


                    /*
                    |--------------------------------------------------------------------------
                    | Patient
                    |--------------------------------------------------------------------------
                    */

                    {
                        data: 'name',

                        name: 'name',

                        render: function (data, type, row) {

                            const name =
                                data || 'Unknown Patient';

                            const email =
                                row.email || '';

                            return `

                                    <div class="d-flex align-items-center gap-3">

                                        <div
                                            class="rounded-circle bg-primary-light
                                                   d-flex align-items-center
                                                   justify-content-center"
                                            style="
                                                width:40px;
                                                height:40px;
                                            "
                                        >

                                            <i class="bi bi-person text-primary"></i>

                                        </div>


                                        <div>

                                            <div class="fw-semibold text-primary">

                                                ${escapeHtml(name)}

                                            </div>


                                            <div class="text-muted small">

                                                ${escapeHtml(email)}

                                            </div>

                                        </div>

                                    </div>

                                `;

                        }

                    },


                    /*
                    |--------------------------------------------------------------------------
                    | Patient ID
                    |--------------------------------------------------------------------------
                    */

                    {
                        data: 'patient_id',
                        name: 'patient_id',

                        render: function (data) {

                            return `
                        <span class="text-primary">
                            ${escapeHtml(data || '—')}
                        </span>
                    `;

                        }
                    },

                    /*
                    |--------------------------------------------------------------------------
                    | Age
                    |--------------------------------------------------------------------------
                    */
                    {
                        data: 'age',

                        name: 'date_of_birth',

                        render: function (data) {

                            return data !== null
                                ? `<span class="text-primary fw-semibold">${data} years</span>`
                                : '—';

                        }

                    },


                    /*
                    |--------------------------------------------------------------------------
                    | Gender
                    |--------------------------------------------------------------------------
                    */

                    {
                        data: 'gender',

                        name: 'gender',

                        render: function (data) {

                            if (!data) {
                                return '—';
                            }

                            const gender =
                                data.charAt(0).toUpperCase() +
                                data.slice(1);

                            return `
                <span class="text-primary fw-semibold">
                    ${escapeHtml(gender)}
                </span>
            `;

                        }

                    },


                    /*
                    |--------------------------------------------------------------------------
                    | Phone
                    |--------------------------------------------------------------------------
                    */

                    {
                        data: 'phone',

                        name: 'phone',

                        render: function (data) {

                            return `
                <span class="text-primary">
                    ${escapeHtml(data || '—')}
                </span>
            `;

                        }

                    },


                    /*
                    |--------------------------------------------------------------------------
                    | Blood Type
                    |--------------------------------------------------------------------------
                    */

                    {
                        data: 'blood_type',

                        name: 'blood_type',

                        render: function (data) {

                            if (!data) {
                                return '—';
                            }

                            return `

                                    <span class="badge bg-danger-subtle text-danger">

                                        ${escapeHtml(data)}

                                    </span>

                                `;

                        }

                    },


                    /*
                    |--------------------------------------------------------------------------
                    | Created
                    |--------------------------------------------------------------------------
                    */

                    {
                        data: 'created_at',

                        name: 'created_at',

                        render: function (data) {

                            return `
                <span class="text-primary">
                    ${escapeHtml(data || '—')}
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

                        render: function (data, type, row) {

                            return `

                                    <div class="dropdown">

                                        <button
                                            class="btn btn-sm btn-link"
                                            type="button"
                                            data-bs-toggle="dropdown"
                                        >

                                            <i class="bi bi-three-dots-vertical"></i>

                                        </button>


                                        <ul class="dropdown-menu dropdown-menu-end">

                                            <li>

                                                <a
                                                    class="dropdown-item"
                                                    href="${row.show_url}"
                                                >

                                                    <i class="bi bi-eye me-2"></i>

                                                    View

                                                </a>

                                            </li>


                                            <li>

                                                <a
                                                    class="dropdown-item"
                                                    href="${row.edit_url}"
                                                >

                                                    <i class="bi bi-pencil me-2"></i>

                                                    Edit

                                                </a>

                                            </li>


                                            <li>

                                                <hr class="dropdown-divider">

                                            </li>


                                            <li>

                                                <button
                                                    type="button"
                                                    class="dropdown-item text-danger delete-patient"
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

                    }

                ],


                /*
                |--------------------------------------------------------------------------
                | Language
                |--------------------------------------------------------------------------
                */

                language: {

                    processing: `
                            <div class="spinner-border"
                                 role="status">
                            </div>
                        `,

                    emptyTable:
                        "No patients found.",

                    zeroRecords:
                        "No matching patients found."

                },


                /*
                |--------------------------------------------------------------------------
                | Update Patient Count
                |--------------------------------------------------------------------------
                */

                drawCallback: function (settings) {

                    const total =
                        settings.json?.recordsFiltered ?? 0;

                    $('#patient-count').text(
                        total + ' patients'
                    );

                }

            });


            /*
            |--------------------------------------------------------------------------
            | Select All
            |--------------------------------------------------------------------------
            */

            $('#selectAll').on('change', function () {

                $('.patient-checkbox').prop(
                    'checked',
                    this.checked
                );

            });


            /*
            |--------------------------------------------------------------------------
            | Reset Select All After Page Change
            |--------------------------------------------------------------------------
            */

            table.on('draw', function () {

                $('#selectAll').prop(
                    'checked',
                    false
                );

            });


            /*
            |--------------------------------------------------------------------------
            | Escape HTML
            |--------------------------------------------------------------------------
            */

            function escapeHtml(value) {

                const div =
                    document.createElement('div');

                div.textContent =
                    value ?? '';

                return div.innerHTML;

            }

        });

    </script>

@endsection