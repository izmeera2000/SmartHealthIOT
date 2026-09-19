@extends('layouts.app')

@section('content')
    <section class="section">

        @if($device)

            {{-- ========================================= --}}
            {{-- DEVICE CONNECTED: SHOW HEALTH DASHBOARD --}}
            {{-- ========================================= --}}



            {{-- Device Status --}}
            <div class="card mb-4">
                <div class="card-body d-flex justify-content-between align-items-center">

                    <div>
                        <h5 class="mb-1">
                            {{ $device->device_name ?? 'Health Monitoring Device' }}
                        </h5>

                        <small class="text-muted">
                            Device UID: {{ $device->device_uid }}
                        </small>
                    </div>

                    <div>
                        @if($device->status === 'active')
                            <span class="badge badge-soft-success">
                                <i class="bi bi-circle-fill me-1"></i>
                                Connected
                            </span>
                        @else
                            <span class="badge badge-soft-danger">
                                <i class="bi bi-circle-fill me-1"></i>
                                Offline
                            </span>
                        @endif
                    </div>

                </div>
            </div>


            {{-- Health Stats --}}
            <div class="dashboard-grid dashboard-grid-4">

                {{-- Ambient Temperature --}}
                <div class="card widget-stat">
                    <div class="widget-stat-header">
                        <div>
                            <div class="widget-stat-value">
                                {{ $device->latestSensorReading?->ambient_temperature ?? '--' }} °C
                            </div>

                            <div class="widget-stat-label">
                                Ambient Temperature
                            </div>
                        </div>

                        <div class="widget-stat-icon primary">
                            <i class="bi bi-thermometer-half"></i>
                        </div>
                    </div>
                </div>


                {{-- Body Temperature --}}
                <div class="card widget-stat">
                    <div class="widget-stat-header">
                        <div>
                            <div class="widget-stat-value">
                                {{ $device->latestSensorReading?->body_temperature ?? '--' }} °C
                            </div>

                            <div class="widget-stat-label">
                                Body Temperature
                            </div>
                        </div>

                        <div class="widget-stat-icon danger">
                            <i class="bi bi-thermometer"></i>
                        </div>
                    </div>
                </div>


                {{-- SpO2 --}}
                <div class="card widget-stat">
                    <div class="widget-stat-header">
                        <div>
                            <div class="widget-stat-value">
                                {{ $device->latestSensorReading?->spo2 ?? '--' }} %
                            </div>

                            <div class="widget-stat-label">
                                SpO₂
                            </div>
                        </div>

                        <div class="widget-stat-icon success">
                            <i class="bi bi-lungs"></i>
                        </div>
                    </div>
                </div>


                {{-- Heart Rate --}}
                <div class="card widget-stat">
                    <div class="widget-stat-header">
                        <div>
                            <div class="widget-stat-value">
                                {{ $device->latestSensorReading?->heart_rate ?? '--' }}
                                <small>BPM</small>
                            </div>

                            <div class="widget-stat-label">
                                Heart Rate
                            </div>
                        </div>

                        <div class="widget-stat-icon info">
                            <i class="bi bi-heart-pulse"></i>
                        </div>
                    </div>
                </div>

            </div>


            {{-- Charts --}}
            <div class="two-column-layout">

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">
                            Health Readings
                        </h5>

                        <div class="card-actions">
                            <select class="form-select form-select-sm" id="readingPeriod">
                                <option value="7">Last 7 days</option>
                                <option value="30" selected>Last 30 days</option>
                                <option value="90">Last 90 days</option>
                            </select>
                        </div>
                    </div>

                    <div class="card-body">
                        <div id="healthReadingsChart" style="min-height: 350px;"></div>
                    </div>
                </div>


                <div>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">
                                Device Information
                            </h5>
                        </div>

                        <div class="card-body">

                            <div class="mb-3">
                                <small class="text-muted">
                                    Device Name
                                </small>

                                <div class="fw-semibold">
                                    {{ $device->device_name ?? 'Health Device' }}
                                </div>
                            </div>

                            <div class="mb-3">
                                <small class="text-muted">
                                    Device UID
                                </small>

                                <div class="fw-semibold">
                                    {{ $device->device_uid }}
                                </div>
                            </div>

                            <div class="mb-3">
                                <small class="text-muted">
                                    Firmware
                                </small>

                                <div class="fw-semibold">
                                    {{ $device->firmware_version ?? 'Unknown' }}
                                </div>
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


        @else

            {{-- ========================================= --}}
            {{-- NO DEVICE: GETTING STARTED / TODO LIST --}}
            {{-- ========================================= --}}



            <div class="row g-4">
                <div class="col-12">

                    <div class="card">

                        <div class="card-header">
                            <h5 class="card-title">
                                Register Your Health Device
                            </h5>

                            <p class="card-subtitle">
                                Follow the steps below to connect your SmartHealthIoT device.
                            </p>
                        </div>


                        <div class="card-body">

                            {{-- Wizard Steps --}}
                            <div class="wizard-steps mb-4">

                                <div class="wizard-step active" data-step="1">
                                    <div class="wizard-step-icon">
                                        <span class="wizard-step-number">1</span>
                                        <i class="bi bi-check-lg wizard-step-check"></i>
                                    </div>

                                    <div class="wizard-step-label">
                                        Device
                                    </div>
                                </div>


                                <div class="wizard-step" data-step="2">
                                    <div class="wizard-step-icon">
                                        <span class="wizard-step-number">2</span>
                                        <i class="bi bi-check-lg wizard-step-check"></i>
                                    </div>

                                    <div class="wizard-step-label">
                                        Pair
                                    </div>
                                </div>


                                <div class="wizard-step" data-step="3">
                                    <div class="wizard-step-icon">
                                        <span class="wizard-step-number">3</span>
                                        <i class="bi bi-check-lg wizard-step-check"></i>
                                    </div>

                                    <div class="wizard-step-label">
                                        Connect
                                    </div>
                                </div>


                                <div class="wizard-step" data-step="4">
                                    <div class="wizard-step-icon">
                                        <span class="wizard-step-number">4</span>
                                        <i class="bi bi-check-lg wizard-step-check"></i>
                                    </div>

                                    <div class="wizard-step-label">
                                        Finish
                                    </div>
                                </div>

                            </div>


                            {{-- Wizard Form --}}
                            <form id="deviceRegistrationWizard" method="POST" action=" ">

                                @csrf


                                {{-- ========================= --}}
                                {{-- STEP 1 --}}
                                {{-- ========================= --}}

                                <div class="wizard-content active" data-step="1">

                                    <h5 class="mb-4">
                                        Device Information
                                    </h5>

                                    <div class="row g-3">

                                        <div class="col-md-6">

                                            <label for="device_name" class="form-label">
                                                Device Name
                                                <span class="text-danger">*</span>
                                            </label>

                                            <input type="text" class="form-control" id="device_name" name="device_name"
                                                placeholder="e.g. My Health Monitor" value="{{ old('device_name') }}" required>

                                        </div>


                                        <div class="col-md-6">

                                            <label for="device_uid" class="form-label">
                                                Device UID
                                                <span class="text-danger">*</span>
                                            </label>

                                            <input type="text" class="form-control" id="device_uid" name="device_uid"
                                                placeholder="Enter the UID shown on your device" value="{{ old('device_uid') }}"
                                                required>

                                            <div class="form-text">
                                                You can find the Device UID on your
                                                ESP32 display.
                                            </div>

                                        </div>

                                    </div>

                                </div>


                                {{-- ========================= --}}
                                {{-- STEP 2 --}}
                                {{-- ========================= --}}

                                <div class="wizard-content" data-step="2">

                                    <h5 class="mb-4">
                                        Pair Your Device
                                    </h5>


                                    <div class="text-center py-3">

                                        <div class="mb-4">

                                            <div class="rounded-circle
                                                                           bg-primary-light
                                                                           text-primary
                                                                           d-flex
                                                                           align-items-center
                                                                           justify-content-center
                                                                           mx-auto" style="width: 80px; height: 80px;">
                                                <i class="bi bi-phone" style="font-size: 36px;"></i>
                                            </div>

                                        </div>


                                        <h5>
                                            Enter Your Pairing Code
                                        </h5>

                                        <p class="text-muted">
                                            Enter the pairing code displayed on your
                                            ESP32 device.
                                        </p>


                                        <div class="row justify-content-center">

                                            <div class="col-md-5">

                                                <label for="pairing_code" class="form-label">
                                                    Pairing Code
                                                    <span class="text-danger">*</span>
                                                </label>

                                                <input type="text" class="form-control text-center" id="pairing_code"
                                                    name="pairing_code" placeholder="123456" maxlength="6" required>

                                            </div>

                                        </div>

                                    </div>

                                </div>


                                {{-- ========================= --}}
                                {{-- STEP 3 --}}
                                {{-- ========================= --}}

                                <div class="wizard-content" data-step="3">

                                    <h5 class="mb-4">
                                        Connect Your Device
                                    </h5>


                                    <div class="row justify-content-center">

                                        <div class="col-lg-8">

                                            <div class="alert alert-info">

                                                <i class="bi bi-info-circle me-2"></i>

                                                Make sure your ESP32 is powered on
                                                and connected to Wi-Fi.

                                            </div>


                                            <div class="d-flex align-items-start mb-4">

                                                <div class="me-3">

                                                    <span class="badge bg-primary rounded-circle">
                                                        1
                                                    </span>

                                                </div>

                                                <div>

                                                    <strong>
                                                        Turn on your device
                                                    </strong>

                                                    <div class="text-muted small">
                                                        Power on the SmartHealthIoT
                                                        health monitoring device.
                                                    </div>

                                                </div>

                                            </div>


                                            <div class="d-flex align-items-start mb-4">

                                                <div class="me-3">

                                                    <span class="badge bg-primary rounded-circle">
                                                        2
                                                    </span>

                                                </div>

                                                <div>

                                                    <strong>
                                                        Connect to Wi-Fi
                                                    </strong>

                                                    <div class="text-muted small">
                                                        Configure your device with your
                                                        Wi-Fi network.
                                                    </div>

                                                </div>

                                            </div>


                                            <div class="d-flex align-items-start">

                                                <div class="me-3">

                                                    <span class="badge bg-success rounded-circle">
                                                        <i class="bi bi-check"></i>
                                                    </span>

                                                </div>

                                                <div>

                                                    <strong>
                                                        Wait for connection
                                                    </strong>

                                                    <div class="text-muted small">
                                                        Your device will automatically
                                                        connect to SmartHealthIoT.
                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>


                                {{-- ========================= --}}
                                {{-- STEP 4 --}}
                                {{-- ========================= --}}

                                <div class="wizard-content" data-step="4">

                                    <div class="text-center py-4">

                                        <div class="mb-4">

                                            <div class="wizard-finish-icon">
                                                <i class="bi bi-check-circle"></i>
                                            </div>

                                        </div>


                                        <h4 class="mb-2">
                                            Ready to Register!
                                        </h4>

                                        <p class="text-muted mb-4">
                                            Review your device information before
                                            completing registration.
                                        </p>


                                        <div class="card bg-light mx-auto" style="max-width: 500px;">

                                            <div class="card-body text-start">

                                                <div class="mb-3">

                                                    <small class="text-muted">
                                                        Device Name
                                                    </small>

                                                    <div id="reviewDeviceName" class="fw-semibold">
                                                        -
                                                    </div>

                                                </div>


                                                <div class="mb-3">

                                                    <small class="text-muted">
                                                        Device UID
                                                    </small>

                                                    <div id="reviewDeviceUid" class="fw-semibold">
                                                        -
                                                    </div>

                                                </div>


                                                <div>

                                                    <small class="text-muted">
                                                        Pairing Code
                                                    </small>

                                                    <div id="reviewPairingCode" class="fw-semibold">
                                                        -
                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>


                                {{-- Wizard Actions --}}
                                <div class="wizard-actions">

                                    <button type="button" class="btn btn-outline-secondary wizard-prev" disabled>
                                        <i class="bi bi-arrow-left me-1"></i>
                                        Previous
                                    </button>


                                    <button type="button" class="btn btn-primary wizard-next">
                                        Next
                                        <i class="bi bi-arrow-right ms-1"></i>
                                    </button>


                                    <button type="submit" class="btn btn-success wizard-submit" style="display: none;">
                                        <i class="bi bi-check-lg me-1"></i>
                                        Register Device
                                    </button>

                                </div>

                            </form>

                        </div>

                    </div>

                </div>
            </div>

        @endif
    </section>
@endsection


@push('scripts')

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            let currentStep = 1;

            const totalSteps = 4;

            const wizard = document.getElementById(
                'deviceRegistrationWizard'
            );

            const nextButton = document.querySelector(
                '.wizard-next'
            );

            const prevButton = document.querySelector(
                '.wizard-prev'
            );

            const submitButton = document.querySelector(
                '.wizard-submit'
            );


            function showStep(step) {

                currentStep = step;


                // Content
                document
                    .querySelectorAll('.wizard-content')
                    .forEach(function (content) {

                        content.classList.remove('active');

                        if (
                            parseInt(
                                content.dataset.step
                            ) === step
                        ) {
                            content.classList.add('active');
                        }

                    });


                // Progress
                document
                    .querySelectorAll('.wizard-step')
                    .forEach(function (wizardStep) {

                        const stepNumber =
                            parseInt(
                                wizardStep.dataset.step
                            );

                        wizardStep.classList.remove(
                            'active',
                            'completed'
                        );


                        if (stepNumber === step) {

                            wizardStep.classList.add(
                                'active'
                            );

                        } else if (stepNumber < step) {

                            wizardStep.classList.add(
                                'completed'
                            );

                        }

                    });


                // Previous
                prevButton.disabled = step === 1;


                // Next / Submit
                if (step === totalSteps) {

                    nextButton.style.display = 'none';

                    submitButton.style.display = 'inline-block';

                    updateReview();

                } else {

                    nextButton.style.display = 'inline-block';

                    submitButton.style.display = 'none';

                }

            }


            function validateStep(step) {

                const content = document.querySelector(
                    `.wizard-content[data-step="${step}"]`
                );

                const inputs = content.querySelectorAll(
                    'input[required], select[required], textarea[required]'
                );


                let valid = true;


                inputs.forEach(function (input) {

                    if (!input.checkValidity()) {

                        input.reportValidity();

                        valid = false;

                    }

                });


                return valid;

            }


            nextButton.addEventListener(
                'click',
                function () {

                    if (!validateStep(currentStep)) {
                        return;
                    }

                    if (currentStep < totalSteps) {

                        showStep(
                            currentStep + 1
                        );

                    }

                }
            );


            prevButton.addEventListener(
                'click',
                function () {

                    if (currentStep > 1) {

                        showStep(
                            currentStep - 1
                        );

                    }

                }
            );


            function updateReview() {

                document.getElementById(
                    'reviewDeviceName'
                ).textContent =
                    document.getElementById(
                        'device_name'
                    ).value || '-';


                document.getElementById(
                    'reviewDeviceUid'
                ).textContent =
                    document.getElementById(
                        'device_uid'
                    ).value || '-';


                document.getElementById(
                    'reviewPairingCode'
                ).textContent =
                    document.getElementById(
                        'pairing_code'
                    ).value || '-';

            }


            showStep(1);

        });

    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // Make sure ApexCharts is available
            if (typeof ApexCharts === 'undefined') {
                console.error('ApexCharts is not loaded.');
                return;
            }

            const chartElement = document.querySelector('#healthReadingsChart');
            const periodSelector = document.querySelector('#readingPeriod');

            if (!chartElement) {
                console.error('Health readings chart element not found.');
                return;
            }

            // Sensor readings supplied by DashboardController
            const readings = @json($sensorReadings ?? []);

            console.log('Sensor readings:', readings);

            /*
            |--------------------------------------------------------------------------
            | Prepare readings
            |--------------------------------------------------------------------------
            */

            function getChartData(days) {

                const cutoff = new Date();

                cutoff.setDate(
                    cutoff.getDate() - Number(days)
                );

                return readings.filter(function (reading) {

                    if (!reading.recorded_at) {
                        return false;
                    }

                    const recordedAt = new Date(
                        reading.recorded_at
                    );

                    return !isNaN(recordedAt.getTime())
                        && recordedAt >= cutoff;
                });
            }


            /*
            |--------------------------------------------------------------------------
            | Build ApexCharts series
            |--------------------------------------------------------------------------
            */

            function buildSeries(days) {

                const data = getChartData(days);

                return [

                    // Heart Rate
                    {
                        name: 'Heart Rate',
                        data: data
                            .filter(function (item) {
                                return item.heart_rate !== null
                                    && item.heart_rate !== undefined;
                            })
                            .map(function (item) {
                                return {
                                    x: new Date(
                                        item.recorded_at
                                    ).getTime(),

                                    y: Number(
                                        item.heart_rate
                                    )
                                };
                            })
                    },

                    // SpO2
                    {
                        name: 'SpO₂',
                        data: data
                            .filter(function (item) {
                                return item.spo2 !== null
                                    && item.spo2 !== undefined;
                            })
                            .map(function (item) {
                                return {
                                    x: new Date(
                                        item.recorded_at
                                    ).getTime(),

                                    y: Number(
                                        item.spo2
                                    )
                                };
                            })
                    },

                    // Body Temperature
                    {
                        name: 'Body Temperature',
                        data: data
                            .filter(function (item) {
                                return item.body_temperature !== null
                                    && item.body_temperature !== undefined;
                            })
                            .map(function (item) {
                                return {
                                    x: new Date(
                                        item.recorded_at
                                    ).getTime(),

                                    y: Number(
                                        item.body_temperature
                                    )
                                };
                            })
                    },

                    // Ambient Temperature
                    {
                        name: 'Ambient Temperature',
                        data: data
                            .filter(function (item) {
                                return item.ambient_temperature !== null
                                    && item.ambient_temperature !== undefined;
                            })
                            .map(function (item) {
                                return {
                                    x: new Date(
                                        item.recorded_at
                                    ).getTime(),

                                    y: Number(
                                        item.ambient_temperature
                                    )
                                };
                            })
                    }
                ];
            }


            /*
            |--------------------------------------------------------------------------
            | Chart options
            |--------------------------------------------------------------------------
            */

            const options = {

                chart: {
                    type: 'line',
                    height: 350,

                    toolbar: {
                        show: true
                    },

                    zoom: {
                        enabled: true
                    },

                    animations: {
                        enabled: true
                    }
                },


                series: buildSeries(30),


                stroke: {
                    curve: 'smooth',
                    width: 2
                },


                markers: {
                    size: 3,

                    hover: {
                        size: 5
                    }
                },


                xaxis: {

                    type: 'datetime',

                    labels: {
                        datetimeUTC: false
                    },

                    title: {
                        text: 'Time'
                    }
                },


                yaxis: [

                    // Heart Rate
                    {
                        seriesName: 'Heart Rate',

                        title: {
                            text: 'Heart Rate (BPM)'
                        },

                        labels: {
                            formatter: function (value) {
                                return Math.round(value);
                            }
                        }
                    },

                    // SpO2
                    {
                        seriesName: 'SpO₂',

                        opposite: true,

                        title: {
                            text: 'SpO₂ (%)'
                        },

                        min: 80,
                        max: 100,

                        labels: {
                            formatter: function (value) {
                                return Math.round(value) + '%';
                            }
                        }
                    },

                    // Body Temperature
                    {
                        seriesName: 'Body Temperature',

                        title: {
                            text: 'Body Temp (°C)'
                        },

                        labels: {
                            formatter: function (value) {
                                return Number(value).toFixed(1) + '°';
                            }
                        }
                    },

                    // Ambient Temperature
                    {
                        seriesName: 'Ambient Temperature',

                        opposite: true,

                        title: {
                            text: 'Ambient Temp (°C)'
                        },

                        labels: {
                            formatter: function (value) {
                                return Number(value).toFixed(1) + '°';
                            }
                        }
                    }
                ],


                tooltip: {

                    shared: false,

                    x: {
                        formatter: function (value) {

                            return new Date(value)
                                .toLocaleString([], {
                                    month: 'short',
                                    day: 'numeric',
                                    hour: '2-digit',
                                    minute: '2-digit'
                                });
                        }
                    },

                    y: {
                        formatter: function (
                            value,
                            {
                                seriesIndex
                            }
                        ) {

                            if (seriesIndex === 0) {
                                return Math.round(value) + ' BPM';
                            }

                            if (seriesIndex === 1) {
                                return Number(value).toFixed(0) + '%';
                            }

                            if (seriesIndex === 2) {
                                return Number(value).toFixed(1) + ' °C';
                            }

                            if (seriesIndex === 3) {
                                return Number(value).toFixed(1) + ' °C';
                            }

                            return value;
                        }
                    }
                },


                legend: {

                    position: 'top',

                    horizontalAlign: 'left',

                    itemMargin: {
                        horizontal: 10
                    }
                },


                grid: {
                    borderColor: '#e7e7e7',

                    strokeDashArray: 4
                },


                dataLabels: {
                    enabled: false
                },


                noData: {
                    text: 'No sensor readings available',

                    align: 'center',

                    verticalAlign: 'middle',

                    style: {
                        fontSize: '14px'
                    }
                }
            };


            /*
            |--------------------------------------------------------------------------
            | Create chart
            |--------------------------------------------------------------------------
            */

            const healthChart = new ApexCharts(
                chartElement,
                options
            );

            healthChart.render().then(function () {

                // Hide all health readings except Heart Rate by default
                healthChart.hideSeries('SpO₂');
                healthChart.hideSeries('Body Temperature');
                healthChart.hideSeries('Ambient Temperature');

            });

            /*
            |--------------------------------------------------------------------------
            | Change period
            |--------------------------------------------------------------------------
            */

            if (periodSelector) {

                periodSelector.addEventListener(
                    'change',
                    function () {

                        const days = Number(
                            this.value
                        );

                        console.log(
                            'Changing chart period:',
                            days,
                            'days'
                        );

                        healthChart.updateSeries(
                            buildSeries(days)
                        );
                    }
                );
            }

        });
    </script>

@endpush