@extends('layouts.app')
@section('content')

    <!-- Page Header -->

    <!-- Stats Row -->
    <div class="dashboard-grid dashboard-grid-4">
        <!-- Total Revenue -->
        <div class="card widget-stat">
            <div class="widget-stat-header">
                <div>
                    <div class="widget-stat-value">$248,762</div>
                    <div class="widget-stat-label">Ambient Temp</div>
                </div>
                <div class="widget-stat-icon primary">
                    <i class="bi bi-currency-dollar"></i>
                </div>
            </div>
            <div class="widget-stat-change positive">
                <i class="bi bi-arrow-up"></i> 15.3% vs last month
            </div>
        </div>

        <!-- Total Expenses -->
        <div class="card widget-stat">
            <div class="widget-stat-header">
                <div>
                    <div class="widget-stat-value">$86,429</div>
                    <div class="widget-stat-label">Body Temp</div>
                </div>
                <div class="widget-stat-icon danger">
                    <i class="bi bi-wallet2"></i>
                </div>
            </div>
            <div class="widget-stat-change positive">
                <i class="bi bi-arrow-up"></i> 8.7% vs last month
            </div>
        </div>

        <!-- Net Profit -->
        <div class="card widget-stat">
            <div class="widget-stat-header">
                <div>
                    <div class="widget-stat-value">$162,333</div>
                    <div class="widget-stat-label">Sp02</div>
                </div>
                <div class="widget-stat-icon success">
                    <i class="bi bi-graph-up-arrow"></i>
                </div>
            </div>
            <div class="widget-stat-change positive">
                <i class="bi bi-arrow-up"></i> 22.5% vs last month
            </div>
        </div>

        <!-- Cash Flow -->
        <div class="card widget-stat">
            <div class="widget-stat-header">
                <div>
                    <div class="widget-stat-value">$52,847</div>
                    <div class="widget-stat-label">BPM</div>
                </div>
                <div class="widget-stat-icon info">
                    <i class="bi bi-arrow-left-right"></i>
                </div>
            </div>
            <div class="widget-stat-change negative">
                <i class="bi bi-arrow-down"></i> 3.2% vs last month
            </div>
        </div>
    </div>

    <!-- Main Content Row -->
    <div class="two-column-layout">
        <!-- Left Column -->
        <div>
            <!-- Revenue vs Expenses Chart -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Revenue vs Expenses</h5>
                    <div class="card-actions">
                        <select class="form-select form-select-sm" style="width: auto;" id="financePeriod">
                            <option value="7">Last 7 days</option>
                            <option value="30" selected>Last 30 days</option>
                            <option value="90">Last 90 days</option>
                            <option value="365">Last year</option>
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container" id="revenueExpensesChart"></div>
                </div>
            </div>

     
        </div>

        <!-- Right Column -->
        <div>
            <!-- Budget Overview -->
            

            <!-- Recent Invoices -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Location History</h5>
                    <div class="card-actions">
                        <a href="dashboard-finance.html#" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="invoice-list">
                        <div class="invoice-item">
                            <div class="invoice-info">
                                <div class="invoice-number">#INV-2024</div>
                                <div class="invoice-client">Client ABC Corp.</div>
                                <div class="invoice-date">Due: Jan 30, 2026</div>
                            </div>
                            <div class="invoice-details">
                                <div class="invoice-amount">$12,500.00</div>
                                <span class="badge badge-soft-success">Paid</span>
                            </div>
                        </div>
                        <div class="invoice-item">
                            <div class="invoice-info">
                                <div class="invoice-number">#INV-2023</div>
                                <div class="invoice-client">Client XYZ Inc.</div>
                                <div class="invoice-date">Due: Jan 28, 2026</div>
                            </div>
                            <div class="invoice-details">
                                <div class="invoice-amount">$8,750.00</div>
                                <span class="badge badge-soft-warning">Pending</span>
                            </div>
                        </div>
                        <div class="invoice-item">
                            <div class="invoice-info">
                                <div class="invoice-number">#INV-2022</div>
                                <div class="invoice-client">Tech Solutions Ltd.</div>
                                <div class="invoice-date">Due: Jan 25, 2026</div>
                            </div>
                            <div class="invoice-details">
                                <div class="invoice-amount">$15,200.00</div>
                                <span class="badge badge-soft-success">Paid</span>
                            </div>
                        </div>
                        <div class="invoice-item">
                            <div class="invoice-info">
                                <div class="invoice-number">#INV-2021</div>
                                <div class="invoice-client">Global Enterprises</div>
                                <div class="invoice-date">Due: Jan 20, 2026</div>
                            </div>
                            <div class="invoice-details">
                                <div class="invoice-amount">$6,890.00</div>
                                <span class="badge badge-soft-danger">Overdue</span>
                            </div>
                        </div>
                        <div class="invoice-item">
                            <div class="invoice-info">
                                <div class="invoice-number">#INV-2020</div>
                                <div class="invoice-client">StartUp Innovations</div>
                                <div class="invoice-date">Due: Jan 15, 2026</div>
                            </div>
                            <div class="invoice-details">
                                <div class="invoice-amount">$9,450.00</div>
                                <span class="badge badge-soft-success">Paid</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection



@section('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const accentColor = getComputedStyle(document.documentElement).getPropertyValue('--accent-color').trim();
            const successColor = getComputedStyle(document.documentElement).getPropertyValue('--success-color').trim();
            const dangerColor = getComputedStyle(document.documentElement).getPropertyValue('--danger-color').trim();
            const borderColor = getComputedStyle(document.documentElement).getPropertyValue('--border-color').trim();
            const mutedColor = getComputedStyle(document.documentElement).getPropertyValue('--muted-color').trim();
            // Revenue vs Expenses Chart
            const revenueExpensesOptions = {
                series: [{
                    name: 'Revenue',
                    data: [28500, 32100, 29800, 35600, 31200, 38900, 34500, 41200, 37800, 44500, 40100, 48200]
                }, {
                    name: 'Expenses',
                    data: [12300, 14200, 13100, 15800, 14200, 16900, 15400, 18200, 16800, 19800, 18200, 21400]
                }],
                chart: {
                    type: 'area',
                    height: 320,
                    fontFamily: 'inherit',
                    toolbar: {
                        show: false
                    },
                    zoom: {
                        enabled: false
                    }
                },
                colors: [successColor, dangerColor],
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 2
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.4,
                        opacityTo: 0.1,
                        stops: [0, 90, 100]
                    }
                },
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    },
                    labels: {
                        style: {
                            colors: mutedColor,
                            fontSize: '12px'
                        }
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: mutedColor,
                            fontSize: '12px'
                        },
                        formatter: function (value) {
                            return '$' + (value / 1000).toFixed(0) + 'k';
                        }
                    }
                },
                grid: {
                    borderColor: borderColor,
                    strokeDashArray: 4,
                    xaxis: {
                        lines: {
                            show: false
                        }
                    }
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'right',
                    fontSize: '13px',
                    markers: {
                        width: 10,
                        height: 10,
                        radius: 4
                    },
                    itemMargin: {
                        horizontal: 12
                    }
                },
                tooltip: {
                    shared: true,
                    intersect: false,
                    y: {
                        formatter: function (value) {
                            return '$' + value.toLocaleString();
                        }
                    }
                }
            };
            const revenueExpensesChart = new ApexCharts(document.querySelector('#revenueExpensesChart'), revenueExpensesOptions);
            revenueExpensesChart.render();
            // Update chart on theme change
            document.addEventListener('themeChanged', function () {
                const newBorderColor = getComputedStyle(document.documentElement).getPropertyValue('--border-color').trim();
                const newMutedColor = getComputedStyle(document.documentElement).getPropertyValue('--muted-color').trim();
                revenueExpensesChart.updateOptions({
                    grid: {
                        borderColor: newBorderColor
                    },
                    xaxis: {
                        labels: {
                            style: {
                                colors: newMutedColor
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: newMutedColor
                            }
                        }
                    }
                });
            });
        });
    </script>
@endsection