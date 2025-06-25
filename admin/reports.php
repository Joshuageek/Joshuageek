<?php
session_start();
require_once '../includes/auth.php';

if (!isLoggedIn() || getUserRole() !== 'admin') {
    header('Location: ../index.php');
    exit();
}

// Sample analytics data
$analytics = [
    'total_revenue' => 125400,
    'monthly_growth' => 12.5,
    'total_sessions' => 1567,
    'session_growth' => 8.3,
    'patient_satisfaction' => 4.8,
    'therapist_utilization' => 87.5,
    'avg_session_duration' => 58,
    'completion_rate' => 94.2
];

$monthly_revenue = [
    ['month' => 'Jan', 'revenue' => 98500],
    ['month' => 'Feb', 'revenue' => 102300],
    ['month' => 'Mar', 'revenue' => 108900],
    ['month' => 'Apr', 'revenue' => 115600],
    ['month' => 'May', 'revenue' => 121200],
    ['month' => 'Jun', 'revenue' => 125400]
];

$session_types = [
    ['type' => 'CBT', 'count' => 456, 'percentage' => 35],
    ['type' => 'PTSD Therapy', 'count' => 298, 'percentage' => 23],
    ['type' => 'Family Therapy', 'count' => 234, 'percentage' => 18],
    ['type' => 'Initial Assessment', 'count' => 189, 'percentage' => 14],
    ['type' => 'Crisis Session', 'count' => 98, 'percentage' => 8],
    ['type' => 'Other', 'count' => 67, 'percentage' => 5]
];

$top_therapists = [
    ['name' => 'Dr. Sarah Johnson', 'sessions' => 156, 'rating' => 4.9, 'patients' => 28],
    ['name' => 'Dr. Michael Wilson', 'sessions' => 203, 'rating' => 4.8, 'patients' => 32],
    ['name' => 'Dr. Lisa Anderson', 'sessions' => 142, 'rating' => 4.7, 'patients' => 24]
];
?>

<!DOCTYPE html>
<html lang="en">
<?php include '../templates/header.php'; ?>
<body>
    <?php include '../templates/sidebar.php'; ?>
    
    <div class="main-content">
        <div class="top-bar">
            <div class="page-info d-flex align-items-center">
                <button class="btn me-3" id="sidebarToggle" style="background: var(--luna-primary); color: white; border-radius: 8px;">
                    <i class="fas fa-bars"></i>
                </button>
                <div>
                    <h1 class="page-title">Analytics & Reports</h1>
                    <p class="page-subtitle">Comprehensive insights and performance metrics</p>
                </div>
            </div>
            <div class="top-bar-actions">
                <button class="btn btn-outline-secondary me-2" onclick="exportReport()">
                    <i class="fas fa-download me-2"></i>Export PDF
                </button>
                <button class="btn btn-luna-primary" data-bs-toggle="modal" data-bs-target="#customReportModal">
                    <i class="fas fa-chart-bar me-2"></i>Custom Report
                </button>
            </div>
        </div>
        
        <div class="container-fluid p-4">
            <!-- Key Metrics -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card animate-in">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="stat-label">Total Revenue</p>
                                <h3 class="stat-number">$<?php echo number_format($analytics['total_revenue']); ?></h3>
                                <span class="stat-change positive">
                                    <i class="fas fa-arrow-up"></i> +<?php echo $analytics['monthly_growth']; ?>% this month
                                </span>
                            </div>
                            <div class="stat-icon icon-success">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card animate-in animate-delay-1">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="stat-label">Total Sessions</p>
                                <h3 class="stat-number"><?php echo number_format($analytics['total_sessions']); ?></h3>
                                <span class="stat-change positive">
                                    <i class="fas fa-arrow-up"></i> +<?php echo $analytics['session_growth']; ?>% growth
                                </span>
                            </div>
                            <div class="stat-icon icon-primary">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card animate-in animate-delay-2">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="stat-label">Patient Satisfaction</p>
                                <h3 class="stat-number"><?php echo $analytics['patient_satisfaction']; ?>/5</h3>
                                <span class="stat-change positive">
                                    <i class="fas fa-star"></i> Excellent rating
                                </span>
                            </div>
                            <div class="stat-icon icon-warning">
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card animate-in animate-delay-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="stat-label">Completion Rate</p>
                                <h3 class="stat-number"><?php echo $analytics['completion_rate']; ?>%</h3>
                                <span class="stat-change positive">
                                    <i class="fas fa-check-circle"></i> High retention
                                </span>
                            </div>
                            <div class="stat-icon icon-success">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Revenue Chart -->
                <div class="col-lg-8 mb-4">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0">
                                <i class="fas fa-chart-line text-success me-2"></i>
                                Revenue Trend
                            </h5>
                            <select class="form-select" style="width: auto;">
                                <option>Last 6 Months</option>
                                <option>Last Year</option>
                                <option>All Time</option>
                            </select>
                        </div>
                        <canvas id="revenueChart" height="300"></canvas>
                    </div>
                </div>

                <!-- Session Types -->
                <div class="col-lg-4 mb-4">
                    <div class="stat-card">
                        <h5 class="mb-4">
                            <i class="fas fa-chart-pie text-primary me-2"></i>
                            Session Types
                        </h5>
                        <div class="session-types-list">
                            <?php foreach ($session_types as $type): ?>
                            <div class="session-type-item mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="fw-semibold"><?php echo $type['type']; ?></span>
                                    <span class="text-muted"><?php echo $type['count']; ?> sessions</span>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-primary" style="width: <?php echo $type['percentage']; ?>%"></div>
                                </div>
                                <small class="text-muted"><?php echo $type['percentage']; ?>% of total</small>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Top Therapists -->
                <div class="col-lg-6 mb-4">
                    <div class="stat-card">
                        <h5 class="mb-4">
                            <i class="fas fa-trophy text-warning me-2"></i>
                            Top Performing Therapists
                        </h5>
                        <div class="therapist-rankings">
                            <?php foreach ($top_therapists as $index => $therapist): ?>
                            <div class="therapist-rank-item">
                                <div class="d-flex align-items-center">
                                    <div class="rank-number">
                                        <?php echo $index + 1; ?>
                                    </div>
                                    <div class="user-avatar me-3">
                                        <?php echo strtoupper(substr($therapist['name'], 0, 1)); ?>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0"><?php echo htmlspecialchars($therapist['name']); ?></h6>
                                        <div class="d-flex gap-3 small text-muted">
                                            <span><?php echo $therapist['sessions']; ?> sessions</span>
                                            <span><?php echo $therapist['patients']; ?> patients</span>
                                            <span class="text-warning">
                                                <i class="fas fa-star"></i> <?php echo $therapist['rating']; ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Quick Reports -->
                <div class="col-lg-6 mb-4">
                    <div class="stat-card">
                        <h5 class="mb-4">
                            <i class="fas fa-file-alt text-info me-2"></i>
                            Quick Reports
                        </h5>
                        <div class="d-grid gap-3">
                            <button class="btn btn-outline-primary text-start" onclick="generateReport('monthly')">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-semibold">Monthly Summary</div>
                                        <small class="text-muted">Revenue, sessions, and patient metrics</small>
                                    </div>
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                            </button>
                            <button class="btn btn-outline-success text-start" onclick="generateReport('therapist')">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-semibold">Therapist Performance</div>
                                        <small class="text-muted">Individual therapist analytics</small>
                                    </div>
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                            </button>
                            <button class="btn btn-outline-warning text-start" onclick="generateReport('patient')">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-semibold">Patient Outcomes</div>
                                        <small class="text-muted">Progress tracking and satisfaction</small>
                                    </div>
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                            </button>
                            <button class="btn btn-outline-info text-start" onclick="generateReport('financial')">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-semibold">Financial Report</div>
                                        <small class="text-muted">Revenue breakdown and billing</small>
                                    </div>
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Analytics Table -->
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0">
                        <i class="fas fa-table text-secondary me-2"></i>
                        Detailed Analytics
                    </h5>
                    <div class="d-flex gap-2">
                        <select class="form-select" style="width: auto;">
                            <option>This Month</option>
                            <option>Last Month</option>
                            <option>Last 3 Months</option>
                            <option>Last 6 Months</option>
                        </select>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Metric</th>
                                <th>Current Period</th>
                                <th>Previous Period</th>
                                <th>Change</th>
                                <th>Trend</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Total Revenue</strong></td>
                                <td>$125,400</td>
                                <td>$111,600</td>
                                <td><span class="text-success">+12.4%</span></td>
                                <td><i class="fas fa-arrow-up text-success"></i></td>
                            </tr>
                            <tr>
                                <td><strong>New Patients</strong></td>
                                <td>47</td>
                                <td>42</td>
                                <td><span class="text-success">+11.9%</span></td>
                                <td><i class="fas fa-arrow-up text-success"></i></td>
                            </tr>
                            <tr>
                                <td><strong>Session Completion Rate</strong></td>
                                <td>94.2%</td>
                                <td>92.8%</td>
                                <td><span class="text-success">+1.5%</span></td>
                                <td><i class="fas fa-arrow-up text-success"></i></td>
                            </tr>
                            <tr>
                                <td><strong>Average Session Duration</strong></td>
                                <td>58 min</td>
                                <td>56 min</td>
                                <td><span class="text-success">+3.6%</span></td>
                                <td><i class="fas fa-arrow-up text-success"></i></td>
                            </tr>
                            <tr>
                                <td><strong>Patient Satisfaction</strong></td>
                                <td>4.8/5</td>
                                <td>4.7/5</td>
                                <td><span class="text-success">+2.1%</span></td>
                                <td><i class="fas fa-arrow-up text-success"></i></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Report Modal -->
    <div class="modal fade" id="customReportModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Generate Custom Report</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="customReportForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Report Type</label>
                                <select class="form-select" name="report_type" required>
                                    <option value="">Select Type</option>
                                    <option value="revenue">Revenue Analysis</option>
                                    <option value="therapist">Therapist Performance</option>
                                    <option value="patient">Patient Outcomes</option>
                                    <option value="session">Session Analytics</option>
                                    <option value="satisfaction">Satisfaction Survey</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Date Range</label>
                                <select class="form-select" name="date_range" required>
                                    <option value="">Select Range</option>
                                    <option value="week">Last Week</option>
                                    <option value="month">Last Month</option>
                                    <option value="quarter">Last Quarter</option>
                                    <option value="year">Last Year</option>
                                    <option value="custom">Custom Range</option>
                                </select>
                            </div>
                        </div>
                        <div class="row" id="customDateRange" style="display: none;">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Start Date</label>
                                <input type="date" class="form-control" name="start_date">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">End Date</label>
                                <input type="date" class="form-control" name="end_date">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Include Metrics</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="includeRevenue" checked>
                                        <label class="form-check-label" for="includeRevenue">Revenue Data</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="includeSessions" checked>
                                        <label class="form-check-label" for="includeSessions">Session Data</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="includePatients" checked>
                                        <label class="form-check-label" for="includePatients">Patient Data</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="includeTherapists">
                                        <label class="form-check-label" for="includeTherapists">Therapist Performance</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="includeSatisfaction">
                                        <label class="form-check-label" for="includeSatisfaction">Satisfaction Scores</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="includeCharts">
                                        <label class="form-check-label" for="includeCharts">Visual Charts</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Export Format</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="format" id="formatPDF" value="pdf" checked>
                                    <label class="form-check-label" for="formatPDF">PDF Report</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="format" id="formatExcel" value="excel">
                                    <label class="form-check-label" for="formatExcel">Excel Spreadsheet</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="format" id="formatCSV" value="csv">
                                    <label class="form-check-label" for="formatCSV">CSV Data</label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-luna-primary" onclick="generateCustomReport()">
                        <i class="fas fa-chart-bar me-2"></i>Generate Report
                    </button>
                </div>
            </div>
        </div>
    </div>

    <?php include '../templates/footer.php'; ?>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../assets/js/simple-luna.js"></script>
    
    <script>
        // Revenue Chart
        const ctx = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode(array_column($monthly_revenue, 'month')); ?>,
                datasets: [{
                    label: 'Revenue ($)',
                    data: <?php echo json_encode(array_column($monthly_revenue, 'revenue')); ?>,
                    borderColor: 'rgb(6, 95, 70)',
                    backgroundColor: 'rgba(6, 95, 70, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });

        function generateReport(type) {
            showToast(`Generating ${type} report...`, 'info');
        }

        function exportReport() {
            showToast('Exporting report as PDF...', 'info');
        }

        function generateCustomReport() {
            showToast('Generating custom report...', 'success');
            bootstrap.Modal.getInstance(document.getElementById('customReportModal')).hide();
        }

        // Show/hide custom date range
        document.querySelector('select[name="date_range"]').addEventListener('change', function() {
            const customRange = document.getElementById('customDateRange');
            if (this.value === 'custom') {
                customRange.style.display = 'block';
            } else {
                customRange.style.display = 'none';
            }
        });
    </script>

    <style>
        .rank-number {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: var(--luna-primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 1rem;
        }

        .therapist-rank-item {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            background: var(--luna-light);
            transition: all 0.3s ease;
        }

        .therapist-rank-item:hover {
            background: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .session-type-item {
            padding: 0.75rem;
            border-radius: 8px;
            background: var(--luna-light);
        }
    </style>
</body>
</html>
