@extends('layouts.app')

@section('content')

<section class="section">


 

{{-- DEVICE INFO --}}
<div class="card mb-4">

    <div class="card-body">

        <div class="row align-items-center">

            <div class="col-md-4">

                <small class="text-muted d-block">
                    Patient
                </small>

                <strong>
                    @if($device->patient?->user)
                        {{ $device->patient->user->name }}
                    @else
                        Unassigned
                    @endif
                </strong>

            </div>

            <div class="col-md-4">

                <small class="text-muted d-block">
                    Device Status
                </small>

                @if($device->status === 'active')

                    <span class="badge bg-success">
                        Active
                    </span>

                @else

                    <span class="badge bg-secondary">
                        Inactive
                    </span>

                @endif

            </div>

            <div class="col-md-4">

                <small class="text-muted d-block">
                    Last Seen
                </small>

                <strong>
                    {{ $device->last_seen_at?->diffForHumans() ?? 'Never' }}
                </strong>

            </div>

        </div>

    </div>

</div>


{{-- READINGS TABLE --}}
<div class="card">

    <div class="card-header">

        <h6 class="mb-0">
            Reading History
        </h6>

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table id="readingsTable"
                   class="table table-hover align-middle w-100">

                <thead>

                    <tr>
                        <th>Recorded</th>
                        <th>Heart Rate</th>
                        <th>SpO₂</th>
                        <th>Body Temp</th>
                        <th>Ambient Temp</th>
                        <th>Battery</th>
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

    $('#readingsTable').DataTable({

        processing: true,

        serverSide: true,

        ajax: {
            url: "{{ route('doctor.devices.readings', $device) }}",
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

            {
                data: 'recorded_at',
                name: 'recorded_at',
                orderable: true,
                searchable: false
            },

            {
                data: 'heart_rate',
                name: 'heart_rate',
                orderable: true,
                searchable: true
            },

            {
                data: 'spo2',
                name: 'spo2',
                orderable: true,
                searchable: true
            },

            {
                data: 'body_temperature',
                name: 'body_temperature',
                orderable: true,
                searchable: true
            },

            {
                data: 'ambient_temperature',
                name: 'ambient_temperature',
                orderable: true,
                searchable: true
            },

            {
                data: 'battery_level',
                name: 'battery_level',
                orderable: true,
                searchable: true
            }

        ],

        language: {

            search: "",

            searchPlaceholder: "Search readings...",

            lengthMenu: "Show _MENU_ readings",

            info: "Showing _START_ to _END_ of _TOTAL_ readings",

            infoEmpty: "No readings found",

            emptyTable: `
                <div class="py-4 text-center">

                    <i class="bi bi-activity fs-1 text-muted"></i>

                    <h6 class="mt-3">
                        No readings found
                    </h6>

                    <p class="text-muted mb-0">
                        This device has not submitted any sensor readings yet.
                    </p>

                </div>
            `,

            zeroRecords: `
                <div class="py-4 text-center">

                    <i class="bi bi-search fs-1 text-muted"></i>

                    <h6 class="mt-3">
                        No matching readings
                    </h6>

                    <p class="text-muted mb-0">
                        Try changing your search.
                    </p>

                </div>
            `

        }

    });

});

</script>

@endsection
