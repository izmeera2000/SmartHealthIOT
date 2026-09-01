@extends('layouts.app')

@section('content')

    <section class="section">


        <div class="card">

            <div class="card-body p-0">

                <div class="contacts-container">

                    {{-- SIDEBAR --}}
                    <div class="contacts-sidebar">

                        <div class="contacts-sidebar-header">

                            <a href="{{ route('doctor.doctors.create') }}" class="btn btn-primary w-100">
                                <i class="bi bi-plus-lg me-2"></i>
                                Add Doctor
                            </a>

                        </div>


                        <div class="contacts-nav">

                            <a href="#" class="contacts-nav-item active">
                                <i class="bi bi-people"></i>

                                <span>
                                    All Doctors
                                </span>

                                <span class="badge" id="doctor-total">
                                    0
                                </span>
                            </a>


                            <a href="#" class="contacts-nav-item">
                                <i class="bi bi-star"></i>

                                <span>
                                    Favorites
                                </span>

                                <span class="badge">
                                    0
                                </span>
                            </a>


                            <a href="#" class="contacts-nav-item">
                                <i class="bi bi-clock-history"></i>

                                <span>
                                    Recently Added
                                </span>

                                <span class="badge">
                                    0
                                </span>
                            </a>

                        </div>


                        {{-- SPECIALIZATIONS --}}
                        <div class="contacts-groups">

                            <div class="contacts-groups-header">

                                <span>
                                    Specializations
                                </span>

                            </div>


                            <div class="contacts-groups-list">

                                <a href="#" class="contacts-group-item active">

                                    <span class="contacts-group-dot" style="background: var(--accent-color);"></span>

                                    <span>
                                        All
                                    </span>

                                </a>


                                <a href="#" class="contacts-group-item">

                                    <span class="contacts-group-dot" style="background: var(--success-color);"></span>

                                    <span>
                                        General Medicine
                                    </span>

                                </a>


                                <a href="#" class="contacts-group-item">

                                    <span class="contacts-group-dot" style="background: var(--warning-color);"></span>

                                    <span>
                                        Cardiology
                                    </span>

                                </a>


                                <a href="#" class="contacts-group-item">

                                    <span class="contacts-group-dot" style="background: var(--info-color);"></span>

                                    <span>
                                        Neurology
                                    </span>

                                </a>

                            </div>

                        </div>


                        {{-- TAGS --}}
                        <div class="contacts-tags">

                            <div class="contacts-tags-header">
                                Doctor Information
                            </div>

                            <div class="contacts-tags-list">

                                <span class="contacts-tag">
                                    Doctor
                                </span>

                                <span class="contacts-tag">
                                    Medical Staff
                                </span>

                                <span class="contacts-tag">
                                    Specialist
                                </span>

                            </div>

                        </div>

                    </div>


                    {{-- MAIN --}}
                    <div class="contacts-main">


                        {{-- HEADER --}}
                        <div class="contacts-header">


                            {{-- MOBILE SIDEBAR --}}
                            <button class="contacts-sidebar-toggle" id="contactsSidebarToggle"
                                aria-label="Open contacts list">
                                <i class="bi bi-person-lines-fill"></i>
                            </button>


                            {{-- SEARCH --}}
                            <div class="contacts-search">

                                <i class="bi bi-search"></i>

                                <input type="text" class="form-control" placeholder="Search doctors..." id="doctor-search">

                            </div>


                            {{-- VIEW TOGGLE --}}
                            <div class="contacts-view-toggle">

                                <button class="contacts-view-btn active" data-view="grid" title="Grid View">
                                    <i class="bi bi-grid-3x3-gap"></i>
                                </button>


                                <button class="contacts-view-btn" data-view="list" title="List View">
                                    <i class="bi bi-list-ul"></i>
                                </button>

                            </div>


                            {{-- FILTER --}}
                            <div class="dropdown">

                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                                    <i class="bi bi-funnel me-1"></i>
                                    Filter
                                </button>


                                <ul class="dropdown-menu dropdown-menu-end">

                                    <li>
                                        <a class="dropdown-item" href="#">
                                            All Doctors
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" href="#">
                                            With Email
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" href="#">
                                            With Phone
                                        </a>
                                    </li>

                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>

                                    <li>
                                        <a class="dropdown-item" href="#">
                                            Recently Added
                                        </a>
                                    </li>

                                </ul>

                            </div>

                        </div>


                        {{-- GRID VIEW --}}
                        <div class="contacts-grid" id="doctors-list">

                            {{-- DataTables renders doctors here --}}

                        </div>


                        {{-- LIST VIEW --}}
                        <div class="contacts-list" id="doctors-table-list" style="display: none;">

                            <table class="table contacts-table">

                                <thead>

                                    <tr>
                                        {{--
                                        <th>
                                            <input type="checkbox" class="form-check-input" id="selectAllDoctors">
                                        </th> --}}

                                        <th>
                                            Doctor
                                        </th>

                                        <th>
                                            Email
                                        </th>

                                        <th>
                                            Phone
                                        </th>

                                        <th>
                                            Specialization
                                        </th>

                                        <th>
                                            Doctor ID
                                        </th>

                                        <th>
                                            Actions
                                        </th>

                                    </tr>

                                </thead>


                                <tbody id="doctors-table-body">
                                </tbody>

                            </table>

                        </div>


                        {{-- PAGINATION --}}
                        <div class="contacts-pagination">

                            <div class="contacts-pagination-info" id="doctor-pagination-info">
                            </div>


                            <nav>

                                <div id="doctor-pagination"></div>

                            </nav>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

    {{-- HIDDEN DATATABLE --}}

    <div id="doctors-datatable-wrapper" style="display: none !important;">
        <table id="doctors-datatable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Doctor ID</th>
                    <th>Specialization</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Created</th>
                    <th>View</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

@endsection

@push('scripts')

    <script>

        $(document).ready(function () {


            /*
            |--------------------------------------------------------------------------
            | View
            |--------------------------------------------------------------------------
            */

            let currentView = 'grid';


            /*
            |--------------------------------------------------------------------------
            | DataTable
            |--------------------------------------------------------------------------
            */

            const table = $('#doctors-datatable').DataTable({

                processing: true,

                serverSide: true,

                searching: true,

                paging: true,

                pageLength: 8,

                lengthChange: false,

                info: true,

                ordering: true,

                ajax: {

                    url: "{{ route('doctor.doctors.data') }}",

                    type: "GET"

                },


                language: {

                    processing:
                        'Loading doctors...',

                    zeroRecords:
                        'No doctors found.',

                    emptyTable:
                        'No doctors available.'

                },


                columns: [

                    {
                        data: 'name',
                        name: 'user.name'
                    },

                    {
                        data: 'doctor_id',
                        name: 'doctor_id'
                    },

                    {
                        data: 'specialization',
                        name: 'specialization'
                    },

                    {
                        data: 'phone',
                        name: 'phone'
                    },

                    {
                        data: 'email',
                        name: 'user.email'
                    },

                    {
                        data: 'created_at',
                        name: 'created_at'
                    },

                    {
                        data: 'show_url',
                        searchable: false,
                        orderable: false
                    },

                    {
                        data: 'edit_url',
                        searchable: false,
                        orderable: false
                    }

                ],


                drawCallback: function () {

                    const api = this.api();


                    renderDoctorContacts(api);

                    renderDoctorPagination(api);

                }

            });


            /*
            |--------------------------------------------------------------------------
            | Search
            |--------------------------------------------------------------------------
            */

            $('#doctor-search').on(
                'keyup',
                function () {

                    table
                        .search(this.value)
                        .draw();

                }
            );


            /*
            |--------------------------------------------------------------------------
            | View Toggle
            |--------------------------------------------------------------------------
            */

            $('.contacts-view-btn').on(
                'click',
                function () {

                    $('.contacts-view-btn')
                        .removeClass('active');

                    $(this)
                        .addClass('active');


                    currentView =
                        $(this).data('view');


                    if (currentView === 'grid') {

                        $('#doctors-list')
                            .show();

                        $('#doctors-table-list')
                            .hide();

                    } else {

                        $('#doctors-list')
                            .hide();

                        $('#doctors-table-list')
                            .show();

                    }


                    renderDoctorContacts(
                        table
                    );

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Render Doctors
            |--------------------------------------------------------------------------
            */

            function renderDoctorContacts(api) {

                const rows =
                    api.rows({
                        page: 'current'
                    }).data();


                if (currentView === 'list') {

                    renderDoctorTable(rows);

                    return;

                }


                const container =
                    $('#doctors-list');


                container.empty();


                if (rows.length === 0) {
                    container.html(`
            <div class="doctors-empty-state">

                <div
                    class="rounded-circle
                           bg-primary-light
                           d-inline-flex
                           align-items-center
                           justify-content-center
                           mb-3"
                    style="width:70px; height:70px;"
                >
                    <i class="bi bi-person-badge text-primary fs-2"></i>
                </div>

                <h6 class="mb-1">
                    No doctors found
                </h6>

                <div class="text-muted small">
                    Try changing your search.
                </div>

            </div>
        `);

                    return;
                }




                rows.each(function (doctor) {


                    const name =
                        escapeHtml(
                            doctor.name ||
                            'Unknown Doctor'
                        );


                    const email =
                        escapeHtml(
                            doctor.email ||
                            ''
                        );


                    const doctorId =
                        escapeHtml(
                            doctor.doctor_id ||
                            '—'
                        );


                    const specialization =
                        escapeHtml(
                            doctor.specialization ||
                            'General Medicine'
                        );


                    const phone =
                        escapeHtml(
                            doctor.phone ||
                            'No phone number'
                        );


                    const createdAt =
                        escapeHtml(
                            doctor.created_at ||
                            '—'
                        );


                    container.append(`

                                <div
                                    class="contact-card"
                                    data-contact-id="${doctor.id}"
                                >


                                    {{-- ACTIONS --}}
                                    <div class="contact-card-actions">

                                        <button
                                            class="contact-favorite"
                                            title="Add to favorites"
                                        >

                                            <i class="bi bi-star"></i>

                                        </button>


                                        <div class="dropdown">

                                            <button
                                                class="contact-menu"
                                                data-bs-toggle="dropdown"
                                            >

                                                <i
                                                    class="bi bi-three-dots-vertical"
                                                ></i>

                                            </button>


                                            <ul
                                                class="dropdown-menu
                                                       dropdown-menu-end"
                                            >

                                                <li>

                                                    <a
                                                        class="dropdown-item"
                                                        href="${doctor.show_url}"
                                                    >

                                                        <i
                                                            class="bi bi-eye me-2"
                                                        ></i>

                                                        View

                                                    </a>

                                                </li>


                                                <li>

                                                    <a
                                                        class="dropdown-item"
                                                        href="${doctor.edit_url}"
                                                    >

                                                        <i
                                                            class="bi bi-pencil me-2"
                                                        ></i>

                                                        Edit

                                                    </a>

                                                </li>


                                                <li>

                                                    <a
                                                        class="dropdown-item"
                                                        href="mailto:${email}"
                                                    >

                                                        <i
                                                            class="bi bi-envelope me-2"
                                                        ></i>

                                                        Send Email

                                                    </a>

                                                </li>


                                                <li>

                                                    <a
                                                        class="dropdown-item"
                                                        href="tel:${phone}"
                                                    >

                                                        <i
                                                            class="bi bi-telephone me-2"
                                                        ></i>

                                                        Call

                                                    </a>

                                                </li>


                                                <li>

                                                    <hr
                                                        class="dropdown-divider"
                                                    >

                                                </li>


                                                <li>

                                                    <button
                                                        type="button"
                                                        class="dropdown-item
                                                               text-danger
                                                               delete-doctor"
                                                        data-id="${doctor.id}"
                                                        data-name="${name}"
                                                    >

                                                        <i
                                                            class="bi bi-trash me-2"
                                                        ></i>

                                                        Delete

                                                    </button>

                                                </li>

                                            </ul>

                                        </div>

                                    </div>


                                    {{-- BODY --}}
                                    <div class="contact-card-body">


                                        <div class="contact-card-avatar">

                                            <div
                                                class="rounded-circle
                                                       bg-primary-light
                                                       text-primary
                                                       d-flex
                                                       align-items-center
                                                       justify-content-center"
                                                style="
                                                    width:70px;
                                                    height:70px;
                                                    font-size:25px;
                                                "
                                            >

                                                <i class="bi bi-person-badge"></i>

                                            </div>

                                        </div>


                                        <h5 class="contact-card-name">

                                            ${name}

                                        </h5>


                                        <p class="contact-card-role">

                                            ${specialization}

                                        </p>


                                        <p class="contact-card-company">

                                            Doctor ID: ${doctorId}

                                        </p>


                                        <div class="contact-card-tags">

                                            <span class="contact-tag">
                                                Doctor
                                            </span>

                                            <span class="contact-tag">
                                                Medical Staff
                                            </span>

                                        </div>

                                    </div>


                                    {{-- CONTACT INFO --}}
                                    <div class="contact-card-info">

                                        <a
                                            href="mailto:${email}"
                                            class="contact-info-item"
                                            title="${email}"
                                        >

                                            <i class="bi bi-envelope"></i>

                                        </a>


                                        <a
                                            href="tel:${phone}"
                                            class="contact-info-item"
                                            title="${phone}"
                                        >

                                            <i class="bi bi-telephone"></i>

                                        </a>


                                        <a
                                            href="${doctor.show_url}"
                                            class="contact-info-item"
                                            title="View doctor"
                                        >

                                            <i class="bi bi-person-vcard"></i>

                                        </a>

                                    </div>

                                </div>

                            `);




                });

            }


            /*
            |--------------------------------------------------------------------------
            | List View
            |--------------------------------------------------------------------------
            */

            function renderDoctorTable(rows) {

                const tbody =
                    $('#doctors-table-body');


                tbody.empty();


                rows.each(function (doctor) {

                    const name =
                        escapeHtml(
                            doctor.name ||
                            'Unknown Doctor'
                        );


                    const email =
                        escapeHtml(
                            doctor.email ||
                            '—'
                        );


                    const phone =
                        escapeHtml(
                            doctor.phone ||
                            '—'
                        );


                    const specialization =
                        escapeHtml(
                            doctor.specialization ||
                            'General Medicine'
                        );


                    const doctorId =
                        escapeHtml(
                            doctor.doctor_id ||
                            '—'
                        );


                    tbody.append(`

                                <tr>




                                    <td>

                                        <div class="contact-list-user">

                                            <div
                                                class="rounded-circle
                                                       bg-primary-light
                                                       text-primary
                                                       d-flex
                                                       align-items-center
                                                       justify-content-center"
                                                style="
                                                    width:45px;
                                                    height:45px;
                                                "
                                            >

                                                <i class="bi bi-person-badge"></i>

                                            </div>


                                            <div>

                                                <div class="contact-list-name">

                                                    <a
                                                        href="${doctor.show_url}"
                                                    >
                                                        ${name}
                                                    </a>

                                                </div>


                                                <div class="contact-list-role">

                                                    ${specialization}

                                                </div>

                                            </div>

                                        </div>

                                    </td>


                                    <td>

                                        <a
                                            href="mailto:${email}"
                                        >
                                            ${email}
                                        </a>

                                    </td>


                                    <td>

                                        <a
                                            href="tel:${phone}"
                                        >
                                            ${phone}
                                        </a>

                                    </td>


                                    <td>

                                        <span class="contact-tag">

                                            ${specialization}

                                        </span>

                                    </td>


                                    <td>

                                        ${doctorId}

                                    </td>


                                    <td>

                                        <div class="dropdown">

                                            <button
                                                class="btn btn-sm btn-light"
                                                data-bs-toggle="dropdown"
                                            >

                                                <i
                                                    class="bi bi-three-dots-vertical"
                                                ></i>

                                            </button>


                                            <ul
                                                class="dropdown-menu
                                                       dropdown-menu-end"
                                            >

                                                <li>

                                                    <a
                                                        class="dropdown-item"
                                                        href="${doctor.show_url}"
                                                    >

                                                        <i
                                                            class="bi bi-eye me-2"
                                                        ></i>

                                                        View

                                                    </a>

                                                </li>


                                                <li>

                                                    <a
                                                        class="dropdown-item"
                                                        href="${doctor.edit_url}"
                                                    >

                                                        <i
                                                            class="bi bi-pencil me-2"
                                                        ></i>

                                                        Edit

                                                    </a>

                                                </li>


                                                <li>

                                                    <button
                                                        type="button"
                                                        class="dropdown-item
                                                               text-danger
                                                               delete-doctor"
                                                        data-id="${doctor.id}"
                                                        data-name="${name}"
                                                    >

                                                        <i
                                                            class="bi bi-trash me-2"
                                                        ></i>

                                                        Delete

                                                    </button>

                                                </li>

                                            </ul>

                                        </div>

                                    </td>

                                </tr>

                            `);

                });

            }


            /*
            |--------------------------------------------------------------------------
            | Pagination
            |--------------------------------------------------------------------------
            */

            function renderDoctorPagination(api) {

                const info =
                    api.page.info();


                $('#doctor-pagination-info').html(`

                            Showing
                            <strong>${info.start + 1}</strong>
                            to
                            <strong>${info.end}</strong>
                            of
                            <strong>${info.recordsDisplay}</strong>
                            doctors

                        `);


                const pagination =
                    $('#doctor-pagination');


                pagination.empty();


                const current =
                    info.page + 1;


                const total =
                    info.pages;


                if (total <= 1) {

                    return;

                }


                let html = `

                            <ul class="pagination pagination-sm mb-0">

                                <li class="page-item ${current === 1
                        ? 'disabled'
                        : ''
                    }">

                                    <a
                                        href="#"
                                        class="page-link"
                                        data-page="${current - 1}"
                                    >

                                        <i class="bi bi-chevron-left"></i>

                                    </a>

                                </li>

                        `;


                for (
                    let page = 1;
                    page <= total;
                    page++
                ) {

                    html += `

                                <li class="page-item ${page === current
                            ? 'active'
                            : ''
                        }">

                                    <a
                                        href="#"
                                        class="page-link"
                                        data-page="${page}"
                                    >

                                        ${page}

                                    </a>

                                </li>

                            `;

                }


                html += `

                                <li class="page-item ${current === total
                        ? 'disabled'
                        : ''
                    }">

                                    <a
                                        href="#"
                                        class="page-link"
                                        data-page="${current + 1}"
                                    >

                                        <i class="bi bi-chevron-right"></i>

                                    </a>

                                </li>

                            </ul>

                        `;


                pagination.html(html);

            }


            /*
            |--------------------------------------------------------------------------
            | Pagination Click
            |--------------------------------------------------------------------------
            */

            $('#doctor-pagination').on(
                'click',
                '[data-page]',
                function (event) {

                    event.preventDefault();


                    const page =
                        Number(
                            $(this).data('page')
                        );


                    if (page < 1) {

                        return;

                    }


                    table
                        .page(page - 1)
                        .draw('page');

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Favorite
            |--------------------------------------------------------------------------
            */

            $('#doctors-list').on(
                'click',
                '.contact-favorite',
                function (event) {

                    event.stopPropagation();


                    $(this)
                        .toggleClass('active');


                    const icon =
                        $(this).find('i');


                    if (
                        $(this).hasClass('active')
                    ) {

                        icon.attr(
                            'class',
                            'bi bi-star-fill'
                        );

                        $(this).attr(
                            'title',
                            'Remove from favorites'
                        );

                    } else {

                        icon.attr(
                            'class',
                            'bi bi-star'
                        );

                        $(this).attr(
                            'title',
                            'Add to favorites'
                        );

                    }

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Delete
            |--------------------------------------------------------------------------
            */

            $('#doctors-list, #doctors-table-body').on(
                'click',
                '.delete-doctor',
                function () {

                    const id =
                        $(this).data('id');


                    const name =
                        $(this).data('name');


                    if (
                        !confirm(
                            `Are you sure you want to delete ${name}?`
                        )
                    ) {

                        return;

                    }


                    $.ajax({

                        url:
                            `/doctor/doctors/${id}`,

                        type:
                            'DELETE',

                        data: {

                            _token:
                                "{{ csrf_token() }}"

                        },


                        success: function () {

                            table
                                .ajax
                                .reload(
                                    null,
                                    false
                                );

                        },


                        error: function (xhr) {

                            console.error(xhr);

                            alert(
                                'Failed to delete doctor.'
                            );

                        }

                    });

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Select All
            |--------------------------------------------------------------------------
            */

            $('#selectAllDoctors').on(
                'change',
                function () {

                    $('.doctor-checkbox')
                        .prop(
                            'checked',
                            this.checked
                        );

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Mobile Sidebar
            |--------------------------------------------------------------------------
            */

            $('#contactsSidebarToggle').on(
                'click',
                function () {

                    $('.contacts-sidebar')
                        .toggleClass('show');

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Sidebar Navigation
            |--------------------------------------------------------------------------
            */

            $('.contacts-nav-item').on(
                'click',
                function (event) {

                    event.preventDefault();

                    $('.contacts-nav-item')
                        .removeClass('active');

                    $(this)
                        .addClass('active');

                }
            );


            $('.contacts-group-item').on(
                'click',
                function (event) {

                    event.preventDefault();

                    $('.contacts-group-item')
                        .removeClass('active');

                    $(this)
                        .addClass('active');

                    $('.contacts-nav-item')
                        .removeClass('active');

                }
            );


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

@endpush