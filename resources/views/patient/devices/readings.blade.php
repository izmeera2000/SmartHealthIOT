 
@extends('layouts.app')

@section('title', $pageTitle)

@section('content')

    <section class="section">

        {{-- Device Information --}}
        <div class="row g-3 mb-4">

            {{-- Device UID --}}
            <div class="col-xl-3 col-md-6">
                <div class="card h-100">
                    <div class="card-body">

                        <div class="d-flex align-items-center">

                            <div class="rounded-circle bg-primary-subtle text-primary
                                        d-flex align-items-center justify-content-center me-3"
                                style="width:45px;height:45px;">
                                <i class="bi bi-cpu"></i>
                            </div>

                            <div>
                                <small class="text-muted">
                                    Device UID
                                </small>

                                <div class="fw-semibold">
                                    {{ $device->device_uid }}
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>


            {{-- Firmware --}}
            <div class="col-xl-3 col-md-6">
                <div class="card h-100">
                    <div class="card-body">

                        <div class="d-flex align-items-center">

                            <div class="rounded-circle bg-info-subtle text-info
                                        d-flex align-items-center justify-content-center me-3"
                                style="width:45px;height:45px;">
                                <i class="bi bi-code-square"></i>
                            </div>

                            <div>
                                <small class="text-muted">
                                    Firmware
                                </small>

                                <div class="fw-semibold">
                                    {{ $device->firmware_version ?: '--' }}
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>


            {{-- Last Seen --}}
            <div class="col-xl-3 col-md-6">
                <div class="card h-100">
                    <div class="card-body">

                        <div class="d-flex align-items-center">

                            <div class="rounded-circle bg-warning-subtle text-warning
                                        d-flex align-items-center justify-content-center me-3"
                                style="width:45px;height:45px;">
                                <i class="bi bi-clock"></i>
                            </div>

                            <div>
                                <small class="text-muted">
                                    Last Seen
                                </small>

                                <div class="fw-semibold">
                                    {{ $device->last_seen_at
        ? $device->last_seen_at->diffForHumans()
        : 'Never'
                                    }}
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>


            {{-- Total Readings --}}
            <div class="col-xl-3 col-md-6">
                <div class="card h-100">
                    <div class="card-body">

                        <div class="d-flex align-items-center">

                            <div class="rounded-circle bg-success-subtle text-success
                                        d-flex align-items-center justify-content-center me-3"
                                style="width:45px;height:45px;">
                                <i class="bi bi-activity"></i>
                            </div>

                            <div>
                                <small class="text-muted">
                                    Readings
                                </small>

                                <div class="fw-semibold" id="readingCount">
                                    {{ $readingCount }}
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

        </div>


        {{-- Readings --}}
        <div class="card">

            <div class="card-header">

                <div class="d-flex flex-wrap justify-content-between
                            align-items-center gap-3">

                    <div>
                        <h5 class="card-title mb-1">
                            Health Readings
                        </h5>

                        <small class="text-muted">
                            Sensor data recorded by this device
                        </small>
                    </div>


                    {{-- Controls --}}
                    <div class="d-flex align-items-center gap-2">

                        {{-- Auto Refresh --}}
                        <div class="form-check form-switch mb-0">

                            <input class="form-check-input" type="checkbox" role="switch" id="autoRefresh" checked>

                            <label class="form-check-label" for="autoRefresh">
                                Auto Refresh
                            </label>

                        </div>


                        {{-- Refresh --}}
                        <button type="button" class="btn btn-outline-primary btn-sm" id="refreshTable">
                            <i class="bi bi-arrow-clockwise me-1"></i>
                            Refresh
                        </button>

                    </div>

                </div>

            </div>


            <div class="card-body">

                <div class="table-responsive">

                    <table id="readingsTable" class="table table-hover align-middle w-100">

                        <thead>

                            <tr>

                                <th>Recorded</th>

                                <th>
                                    <i class="bi bi-heart-pulse text-danger me-1"></i>
                                    Heart Rate
                                </th>

                                <th>
                                    <i class="bi bi-thermometer-half text-warning me-1"></i>
                                    Body Temperature
                                </th>

                                <th>
                                    <i class="bi bi-thermometer text-info me-1"></i>
                                    Ambient Temperature
                                </th>

                                <th>
                                    <i class="bi bi-battery-half text-success me-1"></i>
                                    Battery
                                </th>

                            </tr>

                        </thead>

                        <tbody></tbody>

                    </table>

                </div>

            </div>

        </div>

    </section>

@endsection


@push('styles')

    {{-- DataTables --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.3/css/dataTables.bootstrap5.min.css">

    <style>
        #readingsTable th {
            white-space: nowrap;
        }

        #readingsTable td {
            vertical-align: middle;
        }
    </style>

@endpush


@push('scripts')

    {{-- DataTables --}}
    <script src="https://cdn.datatables.net/2.3.3/js/dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/2.3.3/js/dataTables.bootstrap5.min.js"></script>


    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const table = new DataTable('#readingsTable', {

                processing: true,

                serverSide: true,

                ajax: {
                    url: @json(route('patient.devices.readings.data', $device)),
                    type: 'GET'
                },

                pageLength: 20,

                lengthMenu: [
                    [10, 20, 50, 100],
                    [10, 20, 50, 100]
                ],

                order: [
                    [0, 'desc']
                ],

                columns: [

                    {
                        data: 'recorded_at',
                        name: 'recorded_at'
                    },

                    {
                        data: 'heart_rate',
                        name: 'heart_rate'
                    },

                    {
                        data: 'body_temperature',
                        name: 'body_temperature'
                    },

                    {
                        data: 'ambient_temperature',
                        name: 'ambient_temperature'
                    },

                    {
                        data: 'battery_level',
                        name: 'battery_level'
                    }

                ],

                language: {

                    search: '',

                    searchPlaceholder: 'Search readings...',

                    emptyTable: `
                    <div class="py-4 text-muted">
                        <i class="bi bi-activity fs-2 d-block mb-2"></i>
                        No readings available
                    </div>
                `,

                    processing: `
                    <div class="py-3">
                        <div class="spinner-border spinner-border-sm me-2"></div>
                        Loading readings...
                    </div>
                `

                }

            });


            /*
            |--------------------------------------------------------------------------
            | Manual Refresh
            |--------------------------------------------------------------------------
            */

            document
                .getElementById('refreshTable')
                .addEventListener('click', function () {

                    table.ajax.reload(null, false);

                });


            /*
            |--------------------------------------------------------------------------
            | Auto Refresh
            |--------------------------------------------------------------------------
            */

            let autoRefreshTimer = setInterval(function () {

                if (
                    document.getElementById('autoRefresh').checked
                ) {

                    table.ajax.reload(null, false);

                }

            }, 5000);


        });

    </script>

@endpush