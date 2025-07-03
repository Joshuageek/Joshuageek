<?php
session_start();
require_once 'includes/auth.php';
include 'templates/header.php';

// Check if user is authenticated and is admin
if (!isLoggedIn()) {
    header('Location: ../login.php');
    exit();
}

$user_role = getUserRole();
if ($user_role !== 'admin') {
    header('Location: index.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'] ?? 'Admin';

// Enhanced analytics data with more comprehensive metrics
$analytics = [
    'total_revenue' => 125400,
    'monthly_growth' => 12.5,
    'total_sessions' => 1567,
    'session_growth' => 8.3,
    'patient_satisfaction' => 4.8,
    'therapist_utilization' => 87.5,
    'avg_session_duration' => 58,
    'completion_rate' => 94.2,
    'new_patients_month' => 47,
    'returning_patients' => 89.3,
    'cancellation_rate' => 5.8,
    'no_show_rate' => 3.2,
    'revenue_per_session' => 120,
    'patient_retention' => 91.7,
    'therapist_satisfaction' => 4.6,
    'platform_uptime' => 99.8
];

// Enhanced monthly revenue with more data points
$monthly_revenue = [
    ['month' => 'Jul 2023', 'revenue' => 89500, 'sessions' => 745, 'patients' => 156],
    ['month' => 'Aug 2023', 'revenue' => 94200, 'sessions' => 785, 'patients' => 162],
    ['month' => 'Sep 2023', 'revenue' => 98500, 'sessions' => 821, 'patients' => 168],
    ['month' => 'Oct 2023', 'revenue' => 102300, 'sessions' => 852, 'patients' => 174],
    ['month' => 'Nov 2023', 'revenue' => 108900, 'sessions' => 907, 'patients' => 181],
    ['month' => 'Dec 2023', 'revenue' => 115600, 'sessions' => 963, 'patients' => 189],
    ['month' => 'Jan 2024', 'revenue' => 121200, 'sessions' => 1010, 'patients' => 195],
    ['month' => 'Feb 2024', 'revenue' => 125400, 'sessions' => 1045, 'patients' => 203],
    ['month' => 'Mar 2024', 'revenue' => 132800, 'sessions' => 1106, 'patients' => 212],
    ['month' => 'Apr 2024', 'revenue' => 138900, 'sessions' => 1157, 'patients' => 218],
    ['month' => 'May 2024', 'revenue' => 145200, 'sessions' => 1210, 'patients' => 225],
    ['month' => 'Jun 2024', 'revenue' => 152600, 'sessions' => 1271, 'patients' => 234]
];

// Enhanced session types with more detailed breakdown
$session_types = [
    ['type' => 'Cognitive Behavioral Therapy (CBT)', 'count' => 456, 'percentage' => 29.1, 'revenue' => 54720, 'avg_duration' => 52],
    ['type' => 'PTSD & Trauma Therapy', 'count' => 298, 'percentage' => 19.0, 'revenue' => 41720, 'avg_duration' => 65],
    ['type' => 'Family & Couples Therapy', 'count' => 234, 'percentage' => 14.9, 'revenue' => 35100, 'avg_duration' => 75],
    ['type' => 'Initial Assessment', 'count' => 189, 'percentage' => 12.1, 'revenue' => 18900, 'avg_duration' => 45],
    ['type' => 'Group Therapy Sessions', 'count' => 156, 'percentage' => 10.0, 'revenue' => 12480, 'avg_duration' => 90],
    ['type' => 'Crisis Intervention', 'count' => 98, 'percentage' => 6.3, 'revenue' => 14700, 'avg_duration' => 40],
    ['type' => 'Medication Management', 'count' => 89, 'percentage' => 5.7, 'revenue' => 8900, 'avg_duration' => 30],
    ['type' => 'Other Specialized Therapy', 'count' => 47, 'percentage' => 3.0, 'revenue' => 7050, 'avg_duration' => 55]
];

// Enhanced top therapists with more metrics
$top_therapists = [
    [
        'name' => 'Dr. Sarah Johnson',
        'sessions' => 156,
        'rating' => 4.9,
        'patients' => 28,
        'revenue' => 18720,
        'specialization' => 'CBT & Anxiety',
        'completion_rate' => 96.8,
        'patient_satisfaction' => 4.9,
        'years_experience' => 12
    ],
    [
        'name' => 'Dr. Michael Wilson',
        'sessions' => 203,
        'rating' => 4.8,
        'patients' => 32,
        'revenue' => 24360,
        'specialization' => 'PTSD & Trauma',
        'completion_rate' => 94.1,
        'patient_satisfaction' => 4.8,
        'years_experience' => 15
    ],
    [
        'name' => 'Dr. Lisa Anderson',
        'sessions' => 142,
        'rating' => 4.7,
        'patients' => 24,
        'revenue' => 17040,
        'specialization' => 'Family Therapy',
        'completion_rate' => 92.3,
        'patient_satisfaction' => 4.7,
        'years_experience' => 8
    ],
    [
        'name' => 'Dr. James Rodriguez',
        'sessions' => 134,
        'rating' => 4.6,
        'patients' => 26,
        'revenue' => 16080,
        'specialization' => 'Depression & Mood',
        'completion_rate' => 91.8,
        'patient_satisfaction' => 4.6,
        'years_experience' => 10
    ],
    [
        'name' => 'Dr. Emily Chen',
        'sessions' => 128,
        'rating' => 4.8,
        'patients' => 22,
        'revenue' => 15360,
        'specialization' => 'Adolescent Therapy',
        'completion_rate' => 95.3,
        'patient_satisfaction' => 4.8,
        'years_experience' => 7
    ]
];

// Report templates
$report_templates = [
    [
        'id' => 'executive_summary',
        'name' => 'Executive Summary',
        'description' => 'High-level overview for leadership',
        'icon' => 'fa-chart-line',
        'color' => 'primary',
        'estimated_time' => '2-3 minutes'
    ],
    [
        'id' => 'financial_detailed',
        'name' => 'Detailed Financial Report',
        'description' => 'Comprehensive revenue and billing analysis',
        'icon' => 'fa-dollar-sign',
        'color' => 'success',
        'estimated_time' => '5-7 minutes'
    ],
    [
        'id' => 'therapist_performance',
        'name' => 'Therapist Performance Analysis',
        'description' => 'Individual and comparative therapist metrics',
        'icon' => 'fa-user-md',
        'color' => 'info',
        'estimated_time' => '4-6 minutes'
    ],
    [
        'id' => 'patient_outcomes',
        'name' => 'Patient Outcomes & Satisfaction',
        'description' => 'Treatment effectiveness and patient feedback',
        'icon' => 'fa-heart',
        'color' => 'warning',
        'estimated_time' => '3-5 minutes'
    ],
    [
        'id' => 'operational_metrics',
        'name' => 'Operational Metrics',
        'description' => 'Platform usage, efficiency, and system performance',
        'icon' => 'fa-cogs',
        'color' => 'secondary',
        'estimated_time' => '4-5 minutes'
    ],
    [
        'id' => 'compliance_audit',
        'name' => 'Compliance & Audit Report',
        'description' => 'HIPAA compliance and security metrics',
        'icon' => 'fa-shield-alt',
        'color' => 'danger',
        'estimated_time' => '6-8 minutes'
    ]
];

// Recent reports history
$recent_reports = [
    [
        'name' => 'Monthly Executive Summary - June 2024',
        'type' => 'Executive Summary',
        'generated_by' => 'Admin User',
        'generated_at' => date('Y-m-d H:i:s', strtotime('-2 hours')),
        'format' => 'PDF',
        'size' => '2.4 MB',
        'status' => 'completed'
    ],
    [
        'name' => 'Therapist Performance Q2 2024',
        'type' => 'Therapist Performance',
        'generated_by' => 'Admin User',
        'generated_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
        'format' => 'Excel',
        'size' => '1.8 MB',
        'status' => 'completed'
    ],
    [
        'name' => 'Financial Analysis May 2024',
        'type' => 'Financial Report',
        'generated_by' => 'Finance Manager',
        'generated_at' => date('Y-m-d H:i:s', strtotime('-3 days')),
        'format' => 'PDF',
        'size' => '3.1 MB',
        'status' => 'completed'
    ],
    [
        'name' => 'Patient Satisfaction Survey Results',
        'type' => 'Patient Outcomes',
        'generated_by' => 'Quality Manager',
        'generated_at' => date('Y-m-d H:i:s', strtotime('-5 days')),
        'format' => 'CSV',
        'size' => '856 KB',
        'status' => 'completed'
    ]
];

// Scheduled reports
$scheduled_reports = [
    [
        'name' => 'Weekly Executive Dashboard',
        'frequency' => 'Weekly',
        'next_run' => date('Y-m-d H:i:s', strtotime('+2 days')),
        'recipients' => 'CEO, COO, CFO',
        'format' => 'PDF',
        'status' => 'active'
    ],
    [
        'name' => 'Monthly Financial Summary',
        'frequency' => 'Monthly',
        'next_run' => date('Y-m-d H:i:s', strtotime('+15 days')),
        'recipients' => 'Finance Team',
        'format' => 'Excel',
        'status' => 'active'
    ],
    [
        'name' => 'Quarterly Compliance Report',
        'frequency' => 'Quarterly',
        'next_run' => date('Y-m-d H:i:s', strtotime('+45 days')),
        'recipients' => 'Compliance Officer',
        'format' => 'PDF',
        'status' => 'active'
    ]
];
?>

<!-- Reports Dashboard Content -->
<div class="container-fluid p-4">
    <!-- Reports Dashboard Header -->
    <div class="welcome-card animate-in">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h2 class="welcome-title">
                    <i class="fas fa-chart-bar me-3"></i>
                    Advanced Reports & Analytics
                </h2>
                <p class="welcome-subtitle">
                    Generate comprehensive reports, track key performance indicators, and gain actionable insights
                    into your mental wellness platform's performance. Access real-time analytics, scheduled reports,
                    and custom data visualizations with professional-grade reporting tools.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <button class="btn btn-luna-primary" onclick="generateQuickReport()">
                        <i class="fas fa-bolt me-2"></i>Quick Report
                    </button>
                    <button class="btn btn-luna-outline" data-bs-toggle="modal" data-bs-target="#reportHistoryModal">
                        <i class="fas fa-history me-2"></i>Report History
                    </button>
                    <button class="btn btn-luna-outline" onclick="viewScheduledReports()">
                        <i class="fas fa-calendar-alt me-2"></i>Scheduled Reports
                    </button>
                    <button class="btn btn-luna-outline" data-bs-toggle="modal" data-bs-target="#reportBuilderModal">
                        <i class="fas fa-plus me-2"></i>Create Custom Report
                    </button>
                </div>
            </div>
            <div class="col-lg-4 text-center">
                <div class="row">
                    <div class="col-4">
                        <div class="h2 fw-bold mb-0"><?php echo count($recent_reports); ?></div>
                        <div class="small opacity-90">Recent Reports</div>
                    </div>
                    <div class="col-4">
                        <div class="h2 fw-bold mb-0"><?php echo count($scheduled_reports); ?></div>
                        <div class="small opacity-90">Scheduled</div>
                    </div>
                    <div class="col-4">
                        <div class="h2 fw-bold mb-0"><?php echo count($report_templates); ?></div>
                        <div class="small opacity-90">Templates</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Export Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="stat-card animate-in animate-delay-1">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">
                        <i class="fas fa-download text-primary me-2"></i>
                        Quick Export Options
                    </h5>
                    <div class="d-flex gap-2">
                        <span class="badge bg-success">Real-time Data</span>
                        <span class="badge bg-info">Auto-refresh</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-3">
                        <button class="btn btn-outline-danger w-100 text-start" onclick="quickExport('pdf')">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-file-pdf fa-2x me-3 text-danger"></i>
                                <div>
                                    <div class="fw-semibold">Export as PDF</div>
                                    <small class="text-muted">Professional formatted reports</small>
                                </div>
                            </div>
                        </button>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <button class="btn btn-outline-success w-100 text-start" onclick="quickExport('excel')">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-file-excel fa-2x me-3 text-success"></i>
                                <div>
                                    <div class="fw-semibold">Export as Excel</div>
                                    <small class="text-muted">Spreadsheet with formulas</small>
                                </div>
                            </div>
                        </button>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <button class="btn btn-outline-info w-100 text-start" onclick="quickExport('csv')">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-file-csv fa-2x me-3 text-info"></i>
                                <div>
                                    <div class="fw-semibold">Export as CSV</div>
                                    <small class="text-muted">Raw data for analysis</small>
                                </div>
                            </div>
                        </button>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <button class="btn btn-outline-warning w-100 text-start" onclick="scheduleReport()">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-clock fa-2x me-3 text-warning"></i>
                                <div>
                                    <div class="fw-semibold">Schedule Report</div>
                                    <small class="text-muted">Automated delivery</small>
                                </div>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Key Performance Indicators -->
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

    <!-- Report Templates Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="stat-card animate-in">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0">
                        <i class="fas fa-file-alt text-primary me-2"></i>
                        Professional Report Templates
                    </h5>
                    <button class="btn btn-sm btn-outline-secondary" onclick="manageTemplates()">
                        <i class="fas fa-cog me-1"></i>Manage Templates
                    </button>
                </div>
                <div class="row">
                    <?php foreach ($report_templates as $template): ?>
                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="report-template-card" onclick="selectTemplate('<?php echo $template['id']; ?>')">
                                <div class="d-flex align-items-start">
                                    <div class="template-icon bg-<?php echo $template['color']; ?>">
                                        <i class="fas <?php echo $template['icon']; ?>"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1"><?php echo $template['name']; ?></h6>
                                        <p class="text-muted small mb-2"><?php echo $template['description']; ?></p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge bg-light text-dark">
                                                <i class="fas fa-clock me-1"></i><?php echo $template['estimated_time']; ?>
                                            </span>
                                            <button class="btn btn-sm btn-outline-<?php echo $template['color']; ?>">
                                                Generate
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Analytics Row -->
    <div class="row mb-4">
        <!-- Enhanced Revenue Chart -->
        <div class="col-lg-8 mb-4">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-line text-success me-2"></i>
                        Revenue & Growth Trends
                    </h5>
                    <div class="d-flex gap-2">
                        <select class="form-select form-select-sm" style="width: auto;" onchange="updateRevenueChart(this.value)">
                            <option value="12">Last 12 Months</option>
                            <option value="6">Last 6 Months</option>
                            <option value="3">Last 3 Months</option>
                        </select>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-cog"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#" onclick="exportChart('revenue')"><i class="fas fa-download me-2"></i>Export Chart</a></li>
                                <li><a class="dropdown-item" href="#" onclick="fullscreenChart('revenue')"><i class="fas fa-expand me-2"></i>Fullscreen</a></li>
                                <li><a class="dropdown-item" href="#" onclick="shareChart('revenue')"><i class="fas fa-share me-2"></i>Share</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="chart-container" style="height: 350px;">
                    <canvas id="revenueChart"></canvas>
                </div>
                <div class="row mt-3">
                    <div class="col-3 text-center">
                        <div class="small text-muted">Total Revenue</div>
                        <div class="h5 fw-bold text-success">$<?php echo number_format(array_sum(array_column($monthly_revenue, 'revenue'))); ?></div>
                    </div>
                    <div class="col-3 text-center">
                        <div class="small text-muted">Avg Monthly</div>
                        <div class="h5 fw-bold text-primary">$<?php echo number_format(array_sum(array_column($monthly_revenue, 'revenue')) / count($monthly_revenue)); ?></div>
                    </div>
                    <div class="col-3 text-center">
                        <div class="small text-muted">Growth Rate</div>
                        <div class="h5 fw-bold text-warning">+<?php echo $analytics['monthly_growth']; ?>%</div>
                    </div>
                    <div class="col-3 text-center">
                        <div class="small text-muted">Revenue/Session</div>
                        <div class="h5 fw-bold text-info">$<?php echo $analytics['revenue_per_session']; ?></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Session Types -->
        <div class="col-lg-4 mb-4">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-pie text-primary me-2"></i>
                        Session Distribution
                    </h5>
                    <button class="btn btn-sm btn-outline-secondary" onclick="viewDetailedBreakdown()">
                        <i class="fas fa-expand-alt"></i>
                    </button>
                </div>
                <div class="chart-container mb-3" style="height: 200px;">
                    <canvas id="sessionTypesChart"></canvas>
                </div>
                <div class="session-types-list" style="max-height: 200px; overflow-y: auto;">
                    <?php foreach (array_slice($session_types, 0, 5) as $type): ?>
                        <div class="session-type-item mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="fw-semibold small"><?php echo $type['type']; ?></span>
                                <span class="text-muted small"><?php echo $type['count']; ?> sessions</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <div class="progress flex-grow-1 me-2" style="height: 6px;">
                                    <div class="progress-bar bg-primary" style="width: <?php echo $type['percentage']; ?>%"></div>
                                </div>
                                <span class="small text-muted"><?php echo $type['percentage']; ?>%</span>
                            </div>
                            <div class="d-flex justify-content-between small text-muted">
                                <span>Revenue: $<?php echo number_format($type['revenue']); ?></span>
                                <span>Avg: <?php echo $type['avg_duration']; ?>min</span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Analytics Tables Row -->
    <div class="row mb-4">
        <!-- Top Therapists Enhanced -->
        <div class="col-lg-8 mb-4">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0">
                        <i class="fas fa-trophy text-warning me-2"></i>
                        Therapist Performance Analytics
                    </h5>
                    <div class="d-flex gap-2">
                        <select class="form-select form-select-sm" style="width: auto;">
                            <option>This Month</option>
                            <option>Last 3 Months</option>
                            <option>Last 6 Months</option>
                            <option>This Year</option>
                        </select>
                        <button class="btn btn-sm btn-outline-secondary" onclick="exportTherapistData()">
                            <i class="fas fa-download"></i>
                        </button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Rank</th>
                            <th>Therapist</th>
                            <th>Sessions</th>
                            <th>Patients</th>
                            <th>Revenue</th>
                            <th>Rating</th>
                            <th>Completion</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($top_therapists as $index => $therapist): ?>
                            <tr>
                                <td>
                                    <div class="bg-luna-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                         style="width: 30px; height: 30px; font-weight: 600;">
                                        <?php echo $index + 1; ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="user-avatar me-3">
                                            <?php echo strtoupper(substr($therapist['name'], 0, 1)); ?>
                                        </div>
                                        <div>
                                            <div class="fw-semibold"><?php echo htmlspecialchars($therapist['name']); ?></div>
                                            <div class="small text-muted"><?php echo $therapist['specialization']; ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-primary"><?php echo $therapist['sessions']; ?></span></td>
                                <td><?php echo $therapist['patients']; ?></td>
                                <td class="fw-bold text-success">$<?php echo number_format($therapist['revenue']); ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-star text-warning me-1"></i>
                                        <?php echo $therapist['rating']; ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="progress" style="height: 6px; width: 60px;">
                                        <div class="progress-bar bg-success" style="width: <?php echo $therapist['completion_rate']; ?>%"></div>
                                    </div>
                                    <small class="text-muted"><?php echo $therapist['completion_rate']; ?>%</small>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#" onclick="viewTherapistDetails('<?php echo $therapist['name']; ?>')">
                                                    <i class="fas fa-eye me-2"></i>View Details</a></li>
                                            <li><a class="dropdown-item" href="#" onclick="generateTherapistReport('<?php echo $therapist['name']; ?>')">
                                                    <i class="fas fa-chart-bar me-2"></i>Generate Report</a></li>
                                            <li><a class="dropdown-item" href="#" onclick="contactTherapist('<?php echo $therapist['name']; ?>')">
                                                    <i class="fas fa-envelope me-2"></i>Contact</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Quick Actions & Recent Reports -->
        <div class="col-lg-4 mb-4">
            <!-- Quick Report Actions -->
            <div class="stat-card mb-4">
                <h5 class="mb-4">
                    <i class="fas fa-bolt text-warning me-2"></i>
                    Quick Report Actions
                </h5>
                <div class="d-grid gap-2">
                    <button class="btn btn-outline-primary text-start" onclick="generateQuickReport('daily')">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-semibold">Daily Summary</div>
                                <small class="text-muted">Today's key metrics and activities</small>
                            </div>
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </button>
                    <button class="btn btn-outline-success text-start" onclick="generateQuickReport('weekly')">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-semibold">Weekly Dashboard</div>
                                <small class="text-muted">7-day performance overview</small>
                            </div>
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </button>
                    <button class="btn btn-outline-warning text-start" onclick="generateQuickReport('monthly')">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-semibold">Monthly Analysis</div>
                                <small class="text-muted">Comprehensive monthly report</small>
                            </div>
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </button>
                    <button class="btn btn-outline-info text-start" onclick="generateQuickReport('custom')">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-semibold">Custom Report</div>
                                <small class="text-muted">Build your own report</small>
                            </div>
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </button>
                </div>
            </div>

            <!-- Recent Reports -->
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0">
                        <i class="fas fa-history text-secondary me-2"></i>
                        Recent Reports
                    </h6>
                    <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#reportHistoryModal">
                        View All
                    </button>
                </div>
                <?php foreach (array_slice($recent_reports, 0, 4) as $report): ?>
                    <div class="activity-item">
                        <div class="activity-avatar bg-primary">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div class="activity-content flex-grow-1">
                            <h6><?php echo $report['name']; ?></h6>
                            <p><?php echo $report['type']; ?> • <?php echo $report['size']; ?></p>
                        </div>
                        <div class="activity-time">
                            <?php echo date('M j, g:i A', strtotime($report['generated_at'])); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Detailed Analytics Table -->
    <div class="stat-card animate-in">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="mb-0">
                <i class="fas fa-table text-secondary me-2"></i>
                Comprehensive Analytics Overview
            </h5>
            <div class="d-flex gap-2">
                <select class="form-select form-select-sm" style="width: auto;" onchange="updateAnalyticsTable(this.value)">
                    <option value="month">This Month</option>
                    <option value="quarter">This Quarter</option>
                    <option value="year">This Year</option>
                    <option value="custom">Custom Range</option>
                </select>
                <button class="btn btn-sm btn-outline-secondary" onclick="exportAnalyticsTable()">
                    <i class="fas fa-download me-1"></i>Export
                </button>
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
                    <th>Target</th>
                    <th>Performance</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><strong>Total Revenue</strong></td>
                    <td>$<?php echo number_format($analytics['total_revenue']); ?></td>
                    <td>$111,600</td>
                    <td><span class="text-success">+<?php echo $analytics['monthly_growth']; ?>%</span></td>
                    <td><i class="fas fa-arrow-up text-success"></i></td>
                    <td>$120,000</td>
                    <td>
                        <div class="progress" style="height: 6px; width: 80px;">
                            <div class="progress-bar bg-success" style="width: 104%"></div>
                        </div>
                        <small class="text-success">104%</small>
                    </td>
                </tr>
                <tr>
                    <td><strong>New Patients</strong></td>
                    <td><?php echo $analytics['new_patients_month']; ?></td>
                    <td>42</td>
                    <td><span class="text-success">+11.9%</span></td>
                    <td><i class="fas fa-arrow-up text-success"></i></td>
                    <td>50</td>
                    <td>
                        <div class="progress" style="height: 6px; width: 80px;">
                            <div class="progress-bar bg-warning" style="width: 94%"></div>
                        </div>
                        <small class="text-warning">94%</small>
                    </td>
                </tr>
                <tr>
                    <td><strong>Session Completion Rate</strong></td>
                    <td><?php echo $analytics['completion_rate']; ?>%</td>
                    <td>92.8%</td>
                    <td><span class="text-success">+1.5%</span></td>
                    <td><i class="fas fa-arrow-up text-success"></i></td>
                    <td>95%</td>
                    <td>
                        <div class="progress" style="height: 6px; width: 80px;">
                            <div class="progress-bar bg-success" style="width: 99%"></div>
                        </div>
                        <small class="text-success">99%</small>
                    </td>
                </tr>
                <tr>
                    <td><strong>Patient Retention</strong></td>
                    <td><?php echo $analytics['patient_retention']; ?>%</td>
                    <td>89.2%</td>
                    <td><span class="text-success">+2.8%</span></td>
                    <td><i class="fas fa-arrow-up text-success"></i></td>
                    <td>90%</td>
                    <td>
                        <div class="progress" style="height: 6px; width: 80px;">
                            <div class="progress-bar bg-success" style="width: 102%"></div>
                        </div>
                        <small class="text-success">102%</small>
                    </td>
                </tr>
                <tr>
                    <td><strong>Average Session Duration</strong></td>
                    <td><?php echo $analytics['avg_session_duration']; ?> min</td>
                    <td>56 min</td>
                    <td><span class="text-success">+3.6%</span></td>
                    <td><i class="fas fa-arrow-up text-success"></i></td>
                    <td>60 min</td>
                    <td>
                        <div class="progress" style="height: 6px; width: 80px;">
                            <div class="progress-bar bg-warning" style="width: 97%"></div>
                        </div>
                        <small class="text-warning">97%</small>
                    </td>
                </tr>
                <tr>
                    <td><strong>Patient Satisfaction</strong></td>
                    <td><?php echo $analytics['patient_satisfaction']; ?>/5</td>
                    <td>4.7/5</td>
                    <td><span class="text-success">+2.1%</span></td>
                    <td><i class="fas fa-arrow-up text-success"></i></td>
                    <td>4.5/5</td>
                    <td>
                        <div class="progress" style="height: 6px; width: 80px;">
                            <div class="progress-bar bg-success" style="width: 107%"></div>
                        </div>
                        <small class="text-success">107%</small>
                    </td>
                </tr>
                <tr>
                    <td><strong>Therapist Utilization</strong></td>
                    <td><?php echo $analytics['therapist_utilization']; ?>%</td>
                    <td>84.2%</td>
                    <td><span class="text-success">+3.9%</span></td>
                    <td><i class="fas fa-arrow-up text-success"></i></td>
                    <td>85%</td>
                    <td>
                        <div class="progress" style="height: 6px; width: 80px;">
                            <div class="progress-bar bg-success" style="width: 103%"></div>
                        </div>
                        <small class="text-success">103%</small>
                    </td>
                </tr>
                <tr>
                    <td><strong>Platform Uptime</strong></td>
                    <td><?php echo $analytics['platform_uptime']; ?>%</td>
                    <td>99.6%</td>
                    <td><span class="text-success">+0.2%</span></td>
                    <td><i class="fas fa-arrow-up text-success"></i></td>
                    <td>99.5%</td>
                    <td>
                        <div class="progress" style="height: 6px; width: 80px;">
                            <div class="progress-bar bg-success" style="width: 100%"></div>
                        </div>
                        <small class="text-success">100%</small>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Enhanced Report Builder Modal -->
<div class="modal fade" id="reportBuilderModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-chart-bar me-2"></i>
                    Advanced Report Builder
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <h6 class="mb-3">Report Configuration</h6>
                        <form id="reportBuilderForm">
                            <div class="mb-3">
                                <label class="form-label">Report Template</label>
                                <select class="form-select" name="template" required onchange="updateReportPreview()">
                                    <option value="">Select Template</option>
                                    <?php foreach ($report_templates as $template): ?>
                                        <option value="<?php echo $template['id']; ?>"><?php echo $template['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Date Range</label>
                                <select class="form-select" name="date_range" required onchange="toggleCustomDates()">
                                    <option value="">Select Range</option>
                                    <option value="today">Today</option>
                                    <option value="week">Last 7 Days</option>
                                    <option value="month">Last 30 Days</option>
                                    <option value="quarter">Last Quarter</option>
                                    <option value="year">Last Year</option>
                                    <option value="custom">Custom Range</option>
                                </select>
                            </div>
                            <div class="row" id="customDateRange" style="display: none;">
                                <div class="col-6 mb-3">
                                    <label class="form-label">Start Date</label>
                                    <input type="date" class="form-control" name="start_date">
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label">End Date</label>
                                    <input type="date" class="form-control" name="end_date">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Data Sources</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="includeRevenue" checked>
                                    <label class="form-check-label" for="includeRevenue">Revenue & Financial Data</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="includeSessions" checked>
                                    <label class="form-check-label" for="includeSessions">Session Analytics</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="includePatients" checked>
                                    <label class="form-check-label" for="includePatients">Patient Metrics</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="includeTherapists">
                                    <label class="form-check-label" for="includeTherapists">Therapist Performance</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="includeOperational">
                                    <label class="form-check-label" for="includeOperational">Operational Data</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Export Format</label>
                                <div class="d-flex gap-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="format" id="formatPDF" value="pdf" checked>
                                        <label class="form-check-label" for="formatPDF">PDF</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="format" id="formatExcel" value="excel">
                                        <label class="form-check-label" for="formatExcel">Excel</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="format" id="formatCSV" value="csv">
                                        <label class="form-check-label" for="formatCSV">CSV</label>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-8">
                        <h6 class="mb-3">Report Preview</h6>
                        <div id="reportPreview" class="border rounded p-3" style="height: 500px; overflow-y: auto; background: #f8f9fa;">
                            <div class="text-center text-muted py-5">
                                <i class="fas fa-file-alt fa-3x mb-3"></i>
                                <p>Select a template to preview your report</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-outline-secondary" onclick="saveReportTemplate()">
                    <i class="fas fa-save me-2"></i>Save Template
                </button>
                <button type="button" class="btn btn-luna-primary" onclick="generateAdvancedReport()">
                    <i class="fas fa-chart-bar me-2"></i>Generate Report
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Report History Modal -->
<div class="modal fade" id="reportHistoryModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-history me-2"></i>
                    Report History
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex gap-2">
                        <input type="text" class="form-control" placeholder="Search reports..." style="width: 250px;">
                        <select class="form-select" style="width: auto;">
                            <option>All Types</option>
                            <option>Executive Summary</option>
                            <option>Financial Report</option>
                            <option>Therapist Performance</option>
                            <option>Patient Outcomes</option>
                        </select>
                    </div>
                    <button class="btn btn-outline-danger btn-sm" onclick="clearReportHistory()">
                        <i class="fas fa-trash me-1"></i>Clear History
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Report Name</th>
                            <th>Type</th>
                            <th>Generated By</th>
                            <th>Date</th>
                            <th>Size</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($recent_reports as $report): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-file-alt text-primary me-2"></i>
                                        <?php echo $report['name']; ?>
                                    </div>
                                </td>
                                <td><span class="badge bg-secondary"><?php echo $report['type']; ?></span></td>
                                <td><?php echo $report['generated_by']; ?></td>
                                <td><?php echo date('M j, Y g:i A', strtotime($report['generated_at'])); ?></td>
                                <td><?php echo $report['size']; ?></td>
                                <td><span class="badge bg-success">Completed</span></td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-outline-primary" onclick="downloadReport('<?php echo $report['name']; ?>')">
                                            <i class="fas fa-download"></i>
                                        </button>
                                        <button class="btn btn-outline-secondary" onclick="shareReport('<?php echo $report['name']; ?>')">
                                            <i class="fas fa-share"></i>
                                        </button>
                                        <button class="btn btn-outline-danger" onclick="deleteReport('<?php echo $report['name']; ?>')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Enhanced Chart Initialization
    document.addEventListener('DOMContentLoaded', function() {
        initializeCharts();
        initializeReportBuilder();
    });

    function initializeCharts() {
        // Enhanced Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        window.revenueChart = new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode(array_column($monthly_revenue, 'month')); ?>,
                datasets: [
                    {
                        label: 'Revenue ($)',
                        data: <?php echo json_encode(array_column($monthly_revenue, 'revenue')); ?>,
                        borderColor: 'var(--luna-primary)',
                        backgroundColor: 'rgba(6, 95, 70, 0.1)',
                        tension: 0.4,
                        fill: true,
                        borderWidth: 3
                    },
                    {
                        label: 'Sessions',
                        data: <?php echo json_encode(array_column($monthly_revenue, 'sessions')); ?>,
                        borderColor: 'var(--luna-secondary)',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        tension: 0.4,
                        fill: false,
                        borderWidth: 2,
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                if (context.datasetIndex === 0) {
                                    return 'Revenue: $' + context.parsed.y.toLocaleString();
                                } else {
                                    return 'Sessions: ' + context.parsed.y.toLocaleString();
                                }
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + value.toLocaleString();
                            }
                        }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        beginAtZero: true,
                        grid: {
                            drawOnChartArea: false,
                        },
                    }
                }
            }
        });

        // Enhanced Session Types Chart
        const sessionTypesCtx = document.getElementById('sessionTypesChart').getContext('2d');
        window.sessionTypesChart = new Chart(sessionTypesCtx, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode(array_slice(array_column($session_types, 'type'), 0, 5)); ?>,
                datasets: [{
                    data: <?php echo json_encode(array_slice(array_column($session_types, 'percentage'), 0, 5)); ?>,
                    backgroundColor: [
                        'var(--luna-primary)',
                        'var(--luna-secondary)',
                        'var(--luna-warning)',
                        'var(--luna-accent)',
                        'var(--luna-gray)'
                    ],
                    borderWidth: 0,
                    cutout: '60%'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': ' + context.parsed + '%';
                            }
                        }
                    }
                }
            }
        });
    }

    // Enhanced Report Functions
    function generateQuickReport(type = 'monthly') {
        window.showToast(`Generating ${type} report...`, 'info');

        // Simulate report generation
        setTimeout(() => {
            window.showToast(`${type.charAt(0).toUpperCase() + type.slice(1)} report generated successfully!`, 'success');
        }, 2000);
    }

    function selectTemplate(templateId) {
        // Update form with template selection
        document.querySelector('select[name="template"]').value = templateId;
        updateReportPreview();

        // Show modal if not already open
        const modal = new bootstrap.Modal(document.getElementById('reportBuilderModal'));
        modal.show();
    }

    function updateReportPreview() {
        const template = document.querySelector('select[name="template"]').value;
        const previewDiv = document.getElementById('reportPreview');

        if (!template) {
            previewDiv.innerHTML = `
            <div class="text-center text-muted py-5">
                <i class="fas fa-file-alt fa-3x mb-3"></i>
                <p>Select a template to preview your report</p>
            </div>
        `;
            return;
        }

        // Generate preview based on template
        const previews = {
            'executive_summary': `
            <div class="report-preview">
                <h4 class="mb-3">Executive Summary Preview</h4>
                <div class="row mb-3">
                    <div class="col-3"><strong>Total Revenue:</strong></div>
                    <div class="col-3">$125,400</div>
                    <div class="col-3"><strong>Growth:</strong></div>
                    <div class="col-3">+12.5%</div>
                </div>
                <div class="mb-3">
                    <h6>Key Highlights:</h6>
                    <ul>
                        <li>Revenue exceeded target by 4.5%</li>
                        <li>Patient satisfaction at 4.8/5</li>
                        <li>94.2% session completion rate</li>
                    </ul>
                </div>
                <div class="bg-light p-3 rounded">
                    <small class="text-muted">This preview shows a sample of the executive summary format.</small>
                </div>
            </div>
        `,
            'financial_detailed': `
            <div class="report-preview">
                <h4 class="mb-3">Financial Report Preview</h4>
                <table class="table table-sm">
                    <tr><td>Total Revenue</td><td>$125,400</td></tr>
                    <tr><td>Operating Expenses</td><td>$89,200</td></tr>
                    <tr><td>Net Profit</td><td>$36,200</td></tr>
                    <tr><td>Profit Margin</td><td>28.9%</td></tr>
                </table>
                <div class="bg-light p-3 rounded">
                    <small class="text-muted">Detailed financial breakdown with charts and comparisons.</small>
                </div>
            </div>
        `,
            'therapist_performance': `
            <div class="report-preview">
                <h4 class="mb-3">Therapist Performance Preview
            <div class="report-preview">
                <h4 class="mb-3">Therapist Performance Preview</h4>
                <div class="mb-3">
                    <strong>Top Performer:</strong> Dr. Sarah Johnson<br>
                    <strong>Sessions:</strong> 156 | <strong>Rating:</strong> 4.9/5
                </div>
                <div class="progress mb-2">
                    <div class="progress-bar" style="width: 96%">Completion Rate: 96%</div>
                </div>
                <div class="bg-light p-3 rounded">
                    <small class="text-muted">Individual and comparative performance metrics.</small>
                </div>
            </div>
        `
        };

        previewDiv.innerHTML = previews[template] || `
        <div class="text-center text-muted py-5">
            <i class="fas fa-file-alt fa-3x mb-3"></i>
            <p>Preview for ${template} template</p>
        </div>
    `;
    }

    function toggleCustomDates() {
        const dateRange = document.querySelector('select[name="date_range"]').value;
        const customRange = document.getElementById('customDateRange');

        if (dateRange === 'custom') {
            customRange.style.display = 'block';
        } else {
            customRange.style.display = 'none';
        }
    }

    function generateAdvancedReport() {
        const formData = new FormData(document.getElementById('reportBuilderForm'));
        const template = formData.get('template');
        const format = formData.get('format');

        if (!template) {
            window.showToast('Please select a report template', 'error');
            return;
        }

        window.showToast(`Generating ${template} report in ${format.toUpperCase()} format...`, 'info');

        // Simulate advanced report generation
        setTimeout(() => {
            window.showToast('Advanced report generated successfully!', 'success');
            bootstrap.Modal.getInstance(document.getElementById('reportBuilderModal')).hide();
        }, 3000);
    }

    function saveReportTemplate() {
        window.showToast('Report template saved successfully!', 'success');
    }

    function initializeReportBuilder() {
        // Set default dates
        const today = new Date();
        const lastMonth = new Date(today.getFullYear(), today.getMonth() - 1, today.getDate());

        document.querySelector('input[name="start_date"]').value = lastMonth.toISOString().split('T')[0];
        document.querySelector('input[name="end_date"]').value = today.toISOString().split('T')[0];
    }

    // Chart Management Functions
    function updateRevenueChart(months) {
        const data = <?php echo json_encode($monthly_revenue); ?>;
        const filteredData = data.slice(-months);

        window.revenueChart.data.labels = filteredData.map(item => item.month);
        window.revenueChart.data.datasets[0].data = filteredData.map(item => item.revenue);
        window.revenueChart.data.datasets[1].data = filteredData.map(item => item.sessions);
        window.revenueChart.update();
    }

    function exportChart(chartType) {
        window.showToast(`Exporting ${chartType} chart...`, 'info');
        setTimeout(() => {
            window.showToast('Chart exported successfully!', 'success');
        }, 1500);
    }

    function fullscreenChart(chartType) {
        window.showToast(`Opening ${chartType} chart in fullscreen...`, 'info');
    }

    function shareChart(chartType) {
        window.showToast(`Sharing ${chartType} chart...`, 'info');
    }

    // Export Functions
    function quickExport(format) {
        window.showToast(`Exporting current view as ${format.toUpperCase()}...`, 'info');
        setTimeout(() => {
            window.showToast(`Report exported as ${format.toUpperCase()} successfully!`, 'success');
        }, 2000);
    }

    function exportTherapistData() {
        window.showToast('Exporting therapist performance data...', 'info');
        setTimeout(() => {
            window.showToast('Therapist data exported successfully!', 'success');
        }, 1500);
    }

    function exportAnalyticsTable() {
        window.showToast('Exporting analytics table...', 'info');
        setTimeout(() => {
            window.showToast('Analytics table exported successfully!', 'success');
        }, 1500);
    }

    // Table Management Functions
    function updateAnalyticsTable(period) {
        window.showToast(`Updating analytics for ${period}...`, 'info');
        // Simulate data update
        setTimeout(() => {
            window.showToast('Analytics table updated successfully!', 'success');
        }, 1000);
    }

    // Therapist Functions
    function viewTherapistDetails(name) {
        window.showToast(`Loading details for ${name}...`, 'info');
    }

    function generateTherapistReport(name) {
        window.showToast(`Generating report for ${name}...`, 'info');
        setTimeout(() => {
            window.showToast(`Report for ${name} generated successfully!`, 'success');
        }, 2000);
    }

    function contactTherapist(name) {
        window.showToast(`Opening contact form for ${name}...`, 'info');
    }

    // Report History Functions
    function downloadReport(reportName) {
        window.showToast(`Downloading ${reportName}...`, 'info');
        setTimeout(() => {
            window.showToast('Report downloaded successfully!', 'success');
        }, 1500);
    }

    function shareReport(reportName) {
        window.showToast(`Sharing ${reportName}...`, 'info');
    }

    function deleteReport(reportName) {
        if (confirm(`Are you sure you want to delete "${reportName}"?`)) {
            window.showToast(`Deleting ${reportName}...`, 'info');
            setTimeout(() => {
                window.showToast('Report deleted successfully!', 'success');
            }, 1000);
        }
    }

    function clearReportHistory() {
        if (confirm('Are you sure you want to clear all report history?')) {
            window.showToast('Clearing report history...', 'info');
            setTimeout(() => {
                window.showToast('Report history cleared successfully!', 'success');
            }, 1500);
        }
    }

    // Additional Functions
    function scheduleReport() {
        window.showToast('Opening report scheduler...', 'info');
    }

    function manageTemplates() {
        window.showToast('Opening template manager...', 'info');
    }

    function viewDetailedBreakdown() {
        window.showToast('Loading detailed session breakdown...', 'info');
    }

    function viewScheduledReports() {
        window.showToast('Loading scheduled reports...', 'info');
    }
</script>

<style>
    /* Enhanced Styles */
    .report-template-card {
        background: var(--luna-light);
        border-radius: 12px;
        padding: 1.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .report-template-card:hover {
        background: white;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        border-color: var(--luna-primary);
        transform: translateY(-2px);
    }

    .template-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
    }

    .chart-container {
        position: relative;
    }

    .report-preview {
        background: white;
        border-radius: 8px;
        padding: 1.5rem;
    }

    .session-type-item {
        padding: 1rem;
        border-radius: 8px;
        background: var(--luna-light);
        transition: all 0.3s ease;
    }

    .session-type-item:hover {
        background: white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .template-icon {
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }

        .report-template-card {
            padding: 1rem;
        }

        .chart-container {
            height: 250px !important;
        }
    }

    /* Animation for loading states */
    .loading-spinner {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 3px solid rgba(255,255,255,.3);
        border-radius: 50%;
        border-top-color: #fff;
        animation: spin 1s ease-in-out infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }
</style>

<?php include 'templates/footer.php'; ?>
