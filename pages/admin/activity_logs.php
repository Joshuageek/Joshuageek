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

// Activity log data with comprehensive tracking
$activity_log = [
    [
        'id' => 1,
        'timestamp' => date('Y-m-d H:i:s', strtotime('-15 minutes')),
        'user_id' => 45,
        'user_name' => 'Dr. Sarah Johnson',
        'user_role' => 'therapist',
        'action' => 'session_created',
        'action_display' => 'Session Created',
        'target_type' => 'session',
        'target_id' => 234,
        'target_name' => 'Therapy Session with John Doe',
        'description' => 'Created new therapy session scheduled for tomorrow at 2:00 PM',
        'ip_address' => '192.168.1.45',
        'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
        'severity' => 'info',
        'category' => 'session_management',
        'metadata' => json_encode(['session_type' => 'individual', 'duration' => 60, 'patient_id' => 123])
    ],
    [
        'id' => 2,
        'timestamp' => date('Y-m-d H:i:s', strtotime('-32 minutes')),
        'user_id' => 12,
        'user_name' => 'Admin User',
        'user_role' => 'admin',
        'action' => 'user_permission_changed',
        'action_display' => 'Permission Modified',
        'target_type' => 'user',
        'target_id' => 45,
        'target_name' => 'Dr. Sarah Johnson',
        'description' => 'Added permission: sessions.export for research purposes',
        'ip_address' => '192.168.1.10',
        'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36',
        'severity' => 'warning',
        'category' => 'user_management',
        'metadata' => json_encode(['permission_added' => 'sessions.export', 'reason' => 'research_access'])
    ],
    [
        'id' => 3,
        'timestamp' => date('Y-m-d H:i:s', strtotime('-1 hour')),
        'user_id' => 78,
        'user_name' => 'John Doe',
        'user_role' => 'patient',
        'action' => 'login_success',
        'action_display' => 'Successful Login',
        'target_type' => 'auth',
        'target_id' => null,
        'target_name' => null,
        'description' => 'User successfully logged into the platform',
        'ip_address' => '192.168.1.78',
        'user_agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 15_0 like Mac OS X) AppleWebKit/605.1.15',
        'severity' => 'info',
        'category' => 'authentication',
        'metadata' => json_encode(['login_method' => 'password', 'device_type' => 'mobile'])
    ],
    [
        'id' => 4,
        'timestamp' => date('Y-m-d H:i:s', strtotime('-1 hour 15 minutes')),
        'user_id' => 99,
        'user_name' => 'Unknown User',
        'user_role' => 'unknown',
        'action' => 'login_failed',
        'action_display' => 'Failed Login Attempt',
        'target_type' => 'auth',
        'target_id' => null,
        'target_name' => 'admin@luna.com',
        'description' => 'Failed login attempt with incorrect password (attempt 3/5)',
        'ip_address' => '203.0.113.45',
        'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
        'severity' => 'error',
        'category' => 'security',
        'metadata' => json_encode(['attempt_number' => 3, 'max_attempts' => 5, 'email' => 'admin@luna.com'])
    ],
    [
        'id' => 5,
        'timestamp' => date('Y-m-d H:i:s', strtotime('-2 hours')),
        'user_id' => 34,
        'user_name' => 'Dr. Michael Wilson',
        'user_role' => 'therapist_supervisor',
        'action' => 'patient_record_accessed',
        'action_display' => 'Patient Record Accessed',
        'target_type' => 'patient',
        'target_id' => 156,
        'target_name' => 'Jane Smith',
        'description' => 'Accessed patient medical history for treatment review',
        'ip_address' => '192.168.1.34',
        'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
        'severity' => 'info',
        'category' => 'patient_management',
        'metadata' => json_encode(['access_type' => 'medical_history', 'purpose' => 'treatment_review'])
    ],
    [
        'id' => 6,
        'timestamp' => date('Y-m-d H:i:s', strtotime('-3 hours')),
        'user_id' => 12,
        'user_name' => 'Admin User',
        'user_role' => 'admin',
        'action' => 'system_backup_completed',
        'action_display' => 'System Backup Completed',
        'target_type' => 'system',
        'target_id' => null,
        'target_name' => 'Daily Backup',
        'description' => 'Automated daily system backup completed successfully',
        'ip_address' => '127.0.0.1',
        'user_agent' => 'System/Automated',
        'severity' => 'success',
        'category' => 'system_maintenance',
        'metadata' => json_encode(['backup_size' => '2.4GB', 'duration' => '45 minutes', 'type' => 'automated'])
    ],
    [
        'id' => 7,
        'timestamp' => date('Y-m-d H:i:s', strtotime('-4 hours')),
        'user_id' => 67,
        'user_name' => 'Finance Manager',
        'user_role' => 'billing_admin',
        'action' => 'payment_processed',
        'action_display' => 'Payment Processed',
        'target_type' => 'payment',
        'target_id' => 789,
        'target_name' => 'Invoice #INV-2024-0234',
        'description' => 'Payment of $120.00 processed successfully for therapy sessions',
        'ip_address' => '192.168.1.67',
        'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
        'severity' => 'success',
        'category' => 'billing',
        'metadata' => json_encode(['amount' => 120.00, 'currency' => 'USD', 'payment_method' => 'credit_card'])
    ],
    [
        'id' => 8,
        'timestamp' => date('Y-m-d H:i:s', strtotime('-5 hours')),
        'user_id' => 45,
        'user_name' => 'Dr. Sarah Johnson',
        'user_role' => 'therapist',
        'action' => 'session_notes_updated',
        'action_display' => 'Session Notes Updated',
        'target_type' => 'session',
        'target_id' => 223,
        'target_name' => 'Session with Alice Brown',
        'description' => 'Updated session notes with treatment progress and next steps',
        'ip_address' => '192.168.1.45',
        'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
        'severity' => 'info',
        'category' => 'session_management',
        'metadata' => json_encode(['session_date' => '2024-01-02', 'notes_length' => 450, 'patient_id' => 189])
    ]
];

// Activity statistics
$activity_stats = [
    'total_activities' => count($activity_log),
    'today_activities' => 15,
    'security_events' => 3,
    'failed_logins' => 2,
    'successful_logins' => 45,
    'system_events' => 8,
    'user_actions' => 32,
    'critical_events' => 1
];

// Activity categories for filtering
$activity_categories = [
    'all' => 'All Activities',
    'authentication' => 'Authentication',
    'user_management' => 'User Management',
    'patient_management' => 'Patient Management',
    'session_management' => 'Session Management',
    'billing' => 'Billing & Payments',
    'system_maintenance' => 'System Maintenance',
    'security' => 'Security Events'
];

// Severity levels
$severity_levels = [
    'all' => 'All Levels',
    'info' => 'Information',
    'success' => 'Success',
    'warning' => 'Warning',
    'error' => 'Error',
    'critical' => 'Critical'
];

// Recent security events
$security_events = array_filter($activity_log, function($log) {
    return $log['category'] === 'security' || $log['severity'] === 'error';
});

// Top active users
$user_activity_count = [];
foreach ($activity_log as $log) {
    $user_key = $log['user_name'];
    if (!isset($user_activity_count[$user_key])) {
        $user_activity_count[$user_key] = 0;
    }
    $user_activity_count[$user_key]++;
}
arsort($user_activity_count);
$top_users = array_slice($user_activity_count, 0, 5, true);
?>

<!-- Activity Log Content -->
<div class="container-fluid p-4">
    <!-- Activity Log Header -->
    <div class="welcome-card animate-in">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h2 class="welcome-title">
                    <i class="fas fa-history me-3"></i>
                    Activity Log & Audit Trail
                </h2>
                <p class="welcome-subtitle">
                    Monitor all platform activities, track user actions, investigate security events, and maintain
                    comprehensive audit trails for compliance. Real-time activity monitoring with detailed logging.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <button class="btn btn-luna-primary" onclick="exportActivityLog()">
                        <i class="fas fa-download me-2"></i>Export Log
                    </button>
                    <button class="btn btn-luna-outline" onclick="clearOldLogs()">
                        <i class="fas fa-trash-alt me-2"></i>Clear Old Logs
                    </button>
                    <button class="btn btn-luna-outline" onclick="configureLogging()">
                        <i class="fas fa-cog me-2"></i>Configure Logging
                    </button>
                    <button class="btn btn-luna-outline" onclick="generateAuditReport()">
                        <i class="fas fa-file-alt me-2"></i>Audit Report
                    </button>
                </div>
            </div>
            <div class="col-lg-4 text-center">
                <div class="row">
                    <div class="col-4">
                        <div class="h2 fw-bold mb-0"><?php echo $activity_stats['today_activities']; ?></div>
                        <div class="small opacity-90">Today's Activities</div>
                    </div>
                    <div class="col-4">
                        <div class="h2 fw-bold mb-0 text-warning"><?php echo $activity_stats['security_events']; ?></div>
                        <div class="small opacity-90">Security Events</div>
                    </div>
                    <div class="col-4">
                        <div class="h2 fw-bold mb-0 text-success"><?php echo $activity_stats['successful_logins']; ?></div>
                        <div class="small opacity-90">Successful Logins</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Activity Overview Stats -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card animate-in">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="stat-label">Total Activities</p>
                        <h3 class="stat-number"><?php echo $activity_stats['total_activities']; ?></h3>
                        <span class="stat-change positive">
                            <i class="fas fa-chart-line"></i> Last 24 hours
                        </span>
                    </div>
                    <div class="stat-icon icon-primary">
                        <i class="fas fa-chart-line"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card animate-in animate-delay-1">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="stat-label">User Actions</p>
                        <h3 class="stat-number"><?php echo $activity_stats['user_actions']; ?></h3>
                        <span class="stat-change positive">
                            <i class="fas fa-users"></i> Active users
                        </span>
                    </div>
                    <div class="stat-icon icon-success">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card animate-in animate-delay-2">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="stat-label">Security Events</p>
                        <h3 class="stat-number"><?php echo $activity_stats['security_events']; ?></h3>
                        <span class="stat-change <?php echo $activity_stats['security_events'] > 0 ? 'warning' : 'positive'; ?>">
                            <i class="fas fa-shield-alt"></i> <?php echo $activity_stats['security_events'] > 0 ? 'Needs attention' : 'All clear'; ?>
                        </span>
                    </div>
                    <div class="stat-icon icon-warning">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card animate-in animate-delay-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="stat-label">System Events</p>
                        <h3 class="stat-number"><?php echo $activity_stats['system_events']; ?></h3>
                        <span class="stat-change positive">
                            <i class="fas fa-server"></i> Automated
                        </span>
                    </div>
                    <div class="stat-icon icon-info">
                        <i class="fas fa-server"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <!-- Activity Log Table -->
        <div class="col-lg-9">
            <div class="stat-card animate-in">
                <!-- Filters -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <label class="form-label">Category</label>
                        <select class="form-select" id="categoryFilter" onchange="filterActivities()">
                            <?php foreach ($activity_categories as $key => $name): ?>
                                <option value="<?php echo $key; ?>"><?php echo $name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Severity</label>
                        <select class="form-select" id="severityFilter" onchange="filterActivities()">
                            <?php foreach ($severity_levels as $key => $name): ?>
                                <option value="<?php echo $key; ?>"><?php echo $name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Date Range</label>
                        <select class="form-select" id="dateFilter" onchange="filterActivities()">
                            <option value="today">Today</option>
                            <option value="week">Last 7 days</option>
                            <option value="month">Last 30 days</option>
                            <option value="all">All time</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Search</label>
                        <input type="text" class="form-control" id="searchFilter" placeholder="Search activities..." onkeyup="filterActivities()">
                    </div>
                </div>

                <!-- Activity Table -->
                <div class="table-responsive">
                    <table class="table table-hover" id="activityTable">
                        <thead>
                        <tr>
                            <th>Timestamp</th>
                            <th>User</th>
                            <th>Action</th>
                            <th>Target</th>
                            <th>IP Address</th>
                            <th>Severity</th>
                            <th>Details</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($activity_log as $log): ?>
                            <tr data-category="<?php echo $log['category']; ?>" data-severity="<?php echo $log['severity']; ?>" data-timestamp="<?php echo $log['timestamp']; ?>">
                                <td>
                                    <div class="small fw-semibold"><?php echo date('M j, Y', strtotime($log['timestamp'])); ?></div>
                                    <div class="small text-muted"><?php echo date('g:i A', strtotime($log['timestamp'])); ?></div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="user-avatar me-2">
                                            <?php echo strtoupper(substr($log['user_name'], 0, 1)); ?>
                                        </div>
                                        <div>
                                            <div class="fw-semibold"><?php echo $log['user_name']; ?></div>
                                            <span class="badge bg-<?php echo $log['user_role'] === 'admin' ? 'danger' : ($log['user_role'] === 'therapist' ? 'primary' : 'success'); ?> badge-sm">
                                                <?php echo ucwords(str_replace('_', ' ', $log['user_role'])); ?>
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="action-badge action-<?php echo $log['action']; ?>">
                                        <i class="fas fa-<?php echo
                                        $log['action'] === 'login_success' ? 'sign-in-alt' :
                                            ($log['action'] === 'login_failed' ? 'times-circle' :
                                                ($log['action'] === 'session_created' ? 'calendar-plus' :
                                                    ($log['action'] === 'payment_processed' ? 'credit-card' :
                                                        ($log['action'] === 'user_permission_changed' ? 'user-cog' : 'cog')))); ?>"></i>
                                        <?php echo $log['action_display']; ?>
                                    </div>
                                </td>
                                <td>
                                    <?php if ($log['target_name']): ?>
                                        <div class="fw-semibold"><?php echo $log['target_name']; ?></div>
                                        <div class="small text-muted"><?php echo ucwords($log['target_type']); ?></div>
                                    <?php else: ?>
                                        <span class="text-muted">—</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <code class="small"><?php echo $log['ip_address']; ?></code>
                                </td>
                                <td>
                                    <span class="badge bg-<?php echo
                                    $log['severity'] === 'success' ? 'success' :
                                        ($log['severity'] === 'error' ? 'danger' :
                                            ($log['severity'] === 'warning' ? 'warning' : 'info')); ?>">
                                        <?php echo ucfirst($log['severity']); ?>
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-secondary" onclick="viewActivityDetails(<?php echo $log['id']; ?>)" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <nav aria-label="Activity log pagination">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1">Previous</a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <!-- Sidebar with Stats and Quick Info -->
        <div class="col-lg-3">
            <!-- Security Alerts -->
            <div class="stat-card animate-in animate-delay-1 mb-4">
                <h5 class="mb-4">
                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                    Security Alerts
                </h5>
                <?php if (empty($security_events)): ?>
                    <div class="text-center text-muted py-3">
                        <i class="fas fa-shield-alt fa-2x mb-2"></i>
                        <div>No security events</div>
                        <div class="small">All systems secure</div>
                    </div>
                <?php else: ?>
                    <?php foreach (array_slice($security_events, 0, 3) as $event): ?>
                        <div class="security-alert">
                            <div class="alert-icon bg-<?php echo $event['severity'] === 'error' ? 'danger' : 'warning'; ?>">
                                <i class="fas fa-<?php echo $event['action'] === 'login_failed' ? 'times-circle' : 'exclamation-triangle'; ?>"></i>
                            </div>
                            <div class="alert-content">
                                <div class="fw-semibold"><?php echo $event['action_display']; ?></div>
                                <div class="small text-muted"><?php echo $event['description']; ?></div>
                                <div class="small text-muted"><?php echo date('M j, g:i A', strtotime($event['timestamp'])); ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                <div class="d-grid mt-3">
                    <button class="btn btn-outline-warning btn-sm" onclick="viewAllSecurityEvents()">
                        <i class="fas fa-shield-alt me-2"></i>View All Security Events
                    </button>
                </div>
            </div>

            <!-- Top Active Users -->
            <div class="stat-card animate-in animate-delay-2">
                <h5 class="mb-4">
                    <i class="fas fa-users text-primary me-2"></i>
                    Most Active Users
                </h5>
                <?php foreach ($top_users as $user => $count): ?>
                    <div class="active-user-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="user-avatar me-2">
                                    <?php echo strtoupper(substr($user, 0, 1)); ?>
                                </div>
                                <div>
                                    <div class="fw-semibold"><?php echo $user; ?></div>
                                </div>
                            </div>
                            <span class="badge bg-primary"><?php echo $count; ?> actions</span>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="d-grid mt-3">
                    <button class="btn btn-outline-primary btn-sm" onclick="viewUserActivityReport()">
                        <i class="fas fa-chart-bar me-2"></i>Full Activity Report
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Activity Details Modal -->
<div class="modal fade" id="activityDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-info-circle me-2"></i>
                    Activity Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="activityDetailsContent">
                    <!-- Content will be loaded dynamically -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-luna-primary" onclick="exportActivityDetails()">
                    <i class="fas fa-download me-2"></i>Export Details
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function exportActivityLog() {
        window.showToast('Exporting activity log...', 'info');
        setTimeout(() => {
            window.showToast('Activity log exported successfully!', 'success');
        }, 2000);
    }

    function clearOldLogs() {
        if (confirm('Are you sure you want to clear old activity logs? This action cannot be undone.')) {
            window.showToast('Clearing old logs...', 'info');
            setTimeout(() => {
                window.showToast('Old logs cleared successfully!', 'success');
            }, 2000);
        }
    }

    function configureLogging() {
        window.showToast('Opening logging configuration...', 'info');
    }

    function generateAuditReport() {
        window.showToast('Generating audit report...', 'info');
        setTimeout(() => {
            window.showToast('Audit report generated successfully!', 'success');
        }, 3000);
    }

    function filterActivities() {
        const category = document.getElementById('categoryFilter').value;
        const severity = document.getElementById('severityFilter').value;
        const dateRange = document.getElementById('dateFilter').value;
        const search = document.getElementById('searchFilter').value.toLowerCase();

        const rows = document.querySelectorAll('#activityTable tbody tr');

        rows.forEach(row => {
            let show = true;

            // Category filter
            if (category !== 'all' && row.dataset.category !== category) {
                show = false;
            }

            // Severity filter
            if (severity !== 'all' && row.dataset.severity !== severity) {
                show = false;
            }

            // Search filter
            if (search && !row.textContent.toLowerCase().includes(search)) {
                show = false;
            }

            row.style.display = show ? '' : 'none';
        });
    }

    function viewActivityDetails(activityId) {
        window.showToast(`Loading details for activity ${activityId}...`, 'info');

        // Sample activity details content
        const detailsContent = `
        <div class="row">
            <div class="col-md-6">
                <h6>Basic Information</h6>
                <table class="table table-sm">
                    <tr><td><strong>Activity ID:</strong></td><td>${activityId}</td></tr>
                    <tr><td><strong>Timestamp:</strong></td><td>Jan 3, 2024 2:15 PM</td></tr>
                    <tr><td><strong>User:</strong></td><td>Dr. Sarah Johnson</td></tr>
                    <tr><td><strong>IP Address:</strong></td><td>192.168.1.45</td></tr>
                    <tr><td><strong>User Agent:</strong></td><td>Mozilla/5.0 (Windows NT 10.0; Win64; x64)</td></tr>
                </table>
            </div>
            <div class="col-md-6">
                <h6>Action Details</h6>
                <table class="table table-sm">
                    <tr><td><strong>Action:</strong></td><td>Session Created</td></tr>
                    <tr><td><strong>Target:</strong></td><td>Therapy Session</td></tr>
                    <tr><td><strong>Category:</strong></td><td>Session Management</td></tr>
                    <tr><td><strong>Severity:</strong></td><td><span class="badge bg-info">Info</span></td></tr>
                </table>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <h6>Description</h6>
                <p>Created new therapy session scheduled for tomorrow at 2:00 PM with patient John Doe. Session type: Individual therapy, Duration: 60 minutes.</p>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <h6>Metadata</h6>
                <pre class="bg-light p-3 rounded"><code>{"session_type": "individual", "duration": 60, "patient_id": 123}</code></pre>
            </div>
        </div>
    `;

        document.getElementById('activityDetailsContent').innerHTML = detailsContent;
        const modal = new bootstrap.Modal(document.getElementById('activityDetailsModal'));
        modal.show();
    }

    function viewAllSecurityEvents() {
        window.showToast('Loading all security events...', 'info');
    }

    function viewUserActivityReport() {
        window.showToast('Generating user activity report...', 'info');
    }

    function exportActivityDetails() {
        window.showToast('Exporting activity details...', 'info');
    }
</script>

<style>
    .action-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.25rem 0.75rem;
        background: var(--luna-light);
        border-radius: 6px;
        font-size: 0.875rem;
        font-weight: 500;
    }

    .user-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: var(--luna-primary);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.875rem;
    }

    .security-alert {
        display: flex;
        align-items: flex-start;
        padding: 1rem;
        background: var(--luna-light);
        border-radius: 8px;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .security-alert:hover {
        background: white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .alert-icon {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        margin-right: 1rem;
        font-size: 0.875rem;
        flex-shrink: 0;
    }

    .alert-content {
        flex-grow: 1;
    }

    .active-user-item {
        padding: 0.75rem;
        background: var(--luna-light);
        border-radius: 8px;
        margin-bottom: 0.75rem;
        transition: all 0.3s ease;
    }

    .active-user-item:hover {
        background: white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .badge-sm {
        font-size: 0.7rem;
        padding: 0.25rem 0.5rem;
    }

    @media (max-width: 768px) {
        .security-alert {
            flex-direction: column;
            text-align: center;
        }

        .alert-icon {
            margin-right: 0;
            margin-bottom: 0.5rem;
        }

        .active-user-item .d-flex {
            flex-direction: column;
            text-align: center;
            gap: 0.5rem;
        }
    }
</style>

<?php include 'templates/footer.php'; ?>
