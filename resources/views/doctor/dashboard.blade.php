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
                    <div class="widget-stat-label">Total Revenue</div>
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
                    <div class="widget-stat-label">Total Expenses</div>
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
                    <div class="widget-stat-label">Net Profit</div>
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
                    <div class="widget-stat-label">Cash Flow</div>
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

            <!-- Recent Transactions -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Recent Transactions</h5>
                    <div class="card-actions">
                        <a href="dashboard-finance.html#" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Category</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="fw-medium">Jan 24, 2026</div>
                                        <small class="text-muted">10:42 AM</small>
                                    </td>
                                    <td>
                                        <div>Payment from Client ABC</div>
                                        <small class="text-muted">Invoice #INV-2024</small>
                                    </td>
                                    <td><span class="badge badge-soft-success">Income</span></td>
                                    <td><span class="text-success fw-medium">+$12,500.00</span></td>
                                    <td><span class="badge badge-soft-success">Completed</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="fw-medium">Jan 23, 2026</div>
                                        <small class="text-muted">03:15 PM</small>
                                    </td>
                                    <td>
                                        <div>Office Supplies Purchase</div>
                                        <small class="text-muted">Amazon Business</small>
                                    </td>
                                    <td><span class="badge badge-soft-warning">Expense</span></td>
                                    <td><span class="text-danger fw-medium">-$842.50</span></td>
                                    <td><span class="badge badge-soft-success">Completed</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="fw-medium">Jan 23, 2026</div>
                                        <small class="text-muted">11:20 AM</small>
                                    </td>
                                    <td>
                                        <div>Software Subscription</div>
                                        <small class="text-muted">Adobe Creative Cloud</small>
                                    </td>
                                    <td><span class="badge badge-soft-warning">Expense</span></td>
                                    <td><span class="text-danger fw-medium">-$599.99</span></td>
                                    <td><span class="badge badge-soft-success">Completed</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="fw-medium">Jan 22, 2026</div>
                                        <small class="text-muted">02:45 PM</small>
                                    </td>
                                    <td>
                                        <div>Payment from Client XYZ</div>
                                        <small class="text-muted">Invoice #INV-2023</small>
                                    </td>
                                    <td><span class="badge badge-soft-success">Income</span></td>
                                    <td><span class="text-success fw-medium">+$8,750.00</span></td>
                                    <td><span class="badge badge-soft-warning">Pending</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="fw-medium">Jan 22, 2026</div>
                                        <small class="text-muted">09:30 AM</small>
                                    </td>
                                    <td>
                                        <div>Marketing Campaign</div>
                                        <small class="text-muted">Google Ads</small>
                                    </td>
                                    <td><span class="badge badge-soft-warning">Expense</span></td>
                                    <td><span class="text-danger fw-medium">-$2,150.00</span></td>
                                    <td><span class="badge badge-soft-success">Completed</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="fw-medium">Jan 21, 2026</div>
                                        <small class="text-muted">04:20 PM</small>
                                    </td>
                                    <td>
                                        <div>Freelancer Payment</div>
                                        <small class="text-muted">John Smith - Design Work</small>
                                    </td>
                                    <td><span class="badge badge-soft-warning">Expense</span></td>
                                    <td><span class="text-danger fw-medium">-$1,500.00</span></td>
                                    <td><span class="badge badge-soft-success">Completed</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div>
            <!-- Budget Overview -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Budget Overview</h5>
                    <div class="card-actions">
                        <a href="dashboard-finance.html#" class="text-muted">View Details</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="progress-group">
                        <div class="progress-group-item">
                            <div class="progress-group-header">
                                <div>
                                    <span class="progress-group-label">Marketing</span>
                                    <small class="text-muted">$18,240 of $25,000</small>
                                </div>
                                <span class="progress-group-value">73%</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar" style="width: 73%"></div>
                            </div>
                        </div>
                        <div class="progress-group-item">
                            <div class="progress-group-header">
                                <div>
                                    <span class="progress-group-label">Operations</span>
                                    <small class="text-muted">$42,850 of $60,000</small>
                                </div>
                                <span class="progress-group-value">71%</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-success" style="width: 71%"></div>
                            </div>
                        </div>
                        <div class="progress-group-item">
                            <div class="progress-group-header">
                                <div>
                                    <span class="progress-group-label">Payroll</span>
                                    <small class="text-muted">$89,500 of $100,000</small>
                                </div>
                                <span class="progress-group-value">90%</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-warning" style="width: 90%"></div>
                            </div>
                        </div>
                        <div class="progress-group-item">
                            <div class="progress-group-header">
                                <div>
                                    <span class="progress-group-label">Software</span>
                                    <small class="text-muted">$6,420 of $15,000</small>
                                </div>
                                <span class="progress-group-value">43%</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-info" style="width: 43%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Invoices -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Recent Invoices</h5>
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



@push('scripts')

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
@endpush