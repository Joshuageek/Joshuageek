<?php
session_start();
require_once 'includes/auth.php';
include 'templates/header.php';

// Check if user is authenticated
if (!isLoggedIn()) {
    header('Location: ../login.php');
    exit();
}

$user_role = getUserRole();
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'] ?? 'User';

// Sample reports data
$patient_reports = [
    [
        'id' => 1,
        'patient_name' => $user_role === 'therapist' ? 'Sarah Mitchell' : 'My Progress Report',
        'report_type' => 'Progress Assessment',
        'date_range' => 'Last 3 Months',
        'generated_date' => date('Y-m-d H:i:s', strtotime('-1 day')),
        'status' => 'completed',
        'sessions_included' => 12,
        'progress_score' => 78,
        'mood_improvement' => 45,
        'goals_achieved' => 8,
        'key_insights' => 'Significant improvement in anxiety management and sleep quality',
        'file_size' => '2.4 MB'
    ],
    [
        'id' => 2,
        'patient_name' => $user_role === 'therapist' ? 'John Davis' : 'My Treatment Summary',
        'report_type' => 'Treatment Summary',
        'date_range' => 'Last 6 Months',
        'generated_date' => date('Y-m-d H:i:s', strtotime('-1 week')),
        'status' => 'completed',
        'sessions_included' => 24,
        'progress_score' => 65,
        'mood_improvement' => 30,
        'goals_achieved' => 12,
        'key_insights' => 'Steady progress in PTSD recovery with improved emotional regulation',
        'file_size' => '3.1 MB'
    ],
    [
        'id' => 3,
        'patient_name' => $user_role === 'therapist' ? 'Emily Rodriguez' : 'My Outcome Report',
        'report_type' => 'Outcome Report',
        'date_range' => 'Last Month',
        'generated_date' => date('Y-m-d H:i:s', strtotime('-3 days')),
        'status' => 'pending',
        'sessions_included' => 4,
        'progress_score' => 45,
        'mood_improvement' => 15,
        'goals_achieved' => 2,
        'key_insights' => 'Requires additional support and modified treatment approach',
        'file_size' => '1.8 MB'
    ]
];

$stats = [
    'total_reports' => count($patient_reports),
    'completed_reports' => count(array_filter($patient_reports, fn($r) => $r['status'] === 'completed')),
    'avg_progress' => round(array_sum(array_column($patient_reports, 'progress_score')) / count($patient_reports)),
    'total_sessions' => array_sum(array_column($patient_reports, 'sessions_included'))
];
?>

<!-- Patient Reports Content -->
<div class="container-fluid p-4">
    <!-- Reports Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">
                <i class="fas fa-chart-bar me-2"></i>
                <?php echo $user_role === 'therapist' ? 'Patient Reports' : 'My Reports'; ?>
            </h2>
            <p class="text-muted mb-0">
                <?php echo $user_role === 'therapist' ? 'Generate and manage patient progress reports' : 'View your therapy progress and outcome reports'; ?>
            </p>
        </div>
        <div class="d-flex gap-2">
            <?php if ($user_role === 'therapist'): ?>
                <button class="btn btn-luna-primary" onclick="generateReport()">
                    <i class="fas fa-plus me-2"></i>Generate Report
                </button>
            <?php endif; ?>
            <button class="btn btn-luna-outline" onclick="exportAllReports()">
                <i class="fas fa-download me-2"></i>Export All
            </button>
        </div>
    </div>

    <!-- Report Stats -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="stat-label">Total Reports</p>
                        <h4 class="stat-number"><?php echo $stats['total_reports']; ?></h4>
                    </div>
                    <div class="stat-icon icon-primary">
                        <i class="fas fa-file-alt"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="stat-label">Completed</p>
                        <h4 class="stat-number"><?php echo $stats['completed_reports']; ?></h4>
                    </div>
                    <div class="stat-icon icon-success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="stat-label">Avg Progress</p>
                        <h4 class="stat-number"><?php echo $stats['avg_progress']; ?>%</h4>
                    </div>
                    <div class="stat-icon icon-info">
                        <i class="fas fa-chart-line"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="stat-label">Total Sessions</p>
                        <h4 class="stat-number"><?php echo $stats['total_sessions']; ?></h4>
                    </div>
                    <div class="stat-icon icon-warning">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reports List -->
    <div class="row">
        <?php foreach ($patient_reports as $report): ?>
            <div class="col-lg-4 mb-4">
                <div class="stat-card h-100">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h6 class="mb-1"><?php echo $report['patient_name']; ?></h6>
                            <div class="small text-muted"><?php echo $report['report_type']; ?></div>
                        </div>
                        <span class="badge bg-<?php echo $report['status'] === 'completed' ? 'success' : 'warning'; ?>">
                        <?php echo ucfirst($report['status']); ?>
                    </span>
                    </div>

                    <!-- Report Metrics -->
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="text-center p-2 bg-light rounded">
                                <div class="h5 fw-bold text-primary mb-0"><?php echo $report['progress_score']; ?>%</div>
                                <div class="small text-muted">Progress Score</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center p-2 bg-light rounded">
                                <div class="h5 fw-bold text-success mb-0"><?php echo $report['sessions_included']; ?></div>
                                <div class="small text-muted">Sessions</div>
                            </div>
                        </div>
                    </div>

                    <!-- Key Metrics -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="small text-muted">Mood Improvement</span>
                            <span class="small fw-semibold text-success">+<?php echo $report['mood_improvement']; ?>%</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-success" style="width: <?php echo $report['mood_improvement']; ?>%"></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="small text-muted mb-1">Goals Achieved</div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-bullseye text-warning me-2"></i>
                            <span class="fw-semibold"><?php echo $report['goals_achieved']; ?> goals completed</span>
                        </div>
                    </div>

                    <!-- Key Insights -->
                    <div class="mb-3">
                        <div class="small text-muted mb-1">Key Insights</div>
                        <p class="small"><?php echo $report['key_insights']; ?></p>
                    </div>

                    <!-- Report Details -->
                    <div class="mb-3">
                        <div class="row small text-muted">
                            <div class="col-6">
                                <div>Date Range:</div>
                                <div class="fw-semibold text-dark"><?php echo $report['date_range']; ?></div>
                            </div>
                            <div class="col-6">
                                <div>File Size:</div>
                                <div class="fw-semibold text-dark"><?php echo $report['file_size']; ?></div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="d-flex justify-content-between align-items-center mt-auto pt-3 border-top">
                        <div class="small text-muted">
                            Generated: <?php echo date('M j, Y', strtotime($report['generated_date'])); ?>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                Actions
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#" onclick="viewReport(<?php echo $report['id']; ?>)">
                                        <i class="fas fa-eye me-2"></i>View Report</a></li>
                                <li><a class="dropdown-item" href="#" onclick="downloadReport(<?php echo $report['id']; ?>)">
                                        <i class="fas fa-download me-2"></i>Download PDF</a></li>
                                <li><a class="dropdown-item" href="#" onclick="shareReport(<?php echo $report['id']; ?>)">
                                        <i class="fas fa-share me-2"></i>Share Report</a></li>
                                <?php if ($user_role === 'therapist'): ?>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="#" onclick="regenerateReport(<?php echo $report['id']; ?>)">
                                            <i class="fas fa-sync-alt me-2"></i>Regenerate</a></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Report Templates (Therapist Only) -->
    <?php if ($user_role === 'therapist'): ?>
        <div class="stat-card">
            <h5 class="mb-4">
                <i class="fas fa-file-alt text-primary me-2"></i>
                Report Templates
            </h5>
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="report-template-card" onclick="generateReportFromTemplate('progress')">
                        <div class="text-center">
                            <i class="fas fa-chart-line fa-2x text-primary mb-3"></i>
                            <h6>Progress Assessment</h6>
                            <p class="small text-muted">Comprehensive progress evaluation</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="report-template-card" onclick="generateReportFromTemplate('treatment')">
                        <div class="text-center">
                            <i class="fas fa-medical-kit fa-2x text-success mb-3"></i>
                            <h6>Treatment Summary</h6>
                            <p class="small text-muted">Complete treatment overview</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="report-template-card" onclick="generateReportFromTemplate('outcome')">
                        <div class="text-center">
                            <i class="fas fa-trophy fa-2x text-warning mb-3"></i>
                            <h6>Outcome Report</h6>
                            <p class="small text-muted">Treatment outcomes and results</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="report-template-card" onclick="generateReportFromTemplate('discharge')">
                        <div class="text-center">
                            <i class="fas fa-graduation-cap fa-2x text-info mb-3"></i>
                            <h6>Discharge Summary</h6>
                            <p class="small text-muted">Treatment completion summary</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
    function generateReport() {
        window.showToast('Opening report generator...', 'info');
    }

    function exportAllReports() {
        window.showToast('Exporting all reports...', 'info');
    }

    function viewReport(id) {
        window.showToast(`Loading report ${id}...`, 'info');
    }

    function downloadReport(id) {
        window.showToast(`Downloading report ${id}...`, 'info');
    }

    function shareReport(id) {
        window.showToast(`Sharing report ${id}...`, 'info');
    }

    function regenerateReport(id) {
        window.showToast(`Regenerating report ${id}...`, 'info');
    }

    function generateReportFromTemplate(template) {
        window.showToast(`Generating ${template} report...`, 'info');
    }
</script>

<style>
    .report-template-card {
        background: var(--luna-light);
        border-radius: 12px;
        padding: 1.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid transparent;
        height: 100%;
    }

    .report-template-card:hover {
        background: white;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        border-color: var(--luna-primary);
        transform: translateY(-2px);
    }
</style>

<?php include 'templates/footer.php'; ?>
