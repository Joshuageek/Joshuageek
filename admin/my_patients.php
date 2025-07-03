<?php
session_start();
require_once 'includes/auth.php';
include 'templates/header.php';

// Check if user is authenticated and is therapist
if (!isLoggedIn()) {
    header('Location: ../login.php');
    exit();
}

$user_role = getUserRole();
if ($user_role !== 'therapist') {
    header('Location: index.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'] ?? 'Therapist';

// Sample patients data
$patients = [
    [
        'id' => 1,
        'name' => 'Sarah Mitchell',
        'email' => 'sarah.m@email.com',
        'phone' => '(555) 123-4567',
        'age' => 28,
        'diagnosis' => 'Anxiety Disorder',
        'status' => 'active',
        'last_session' => date('Y-m-d H:i:s', strtotime('-2 days')),
        'next_session' => date('Y-m-d H:i:s', strtotime('+3 days')),
        'total_sessions' => 12,
        'progress_score' => 78,
        'mood_trend' => 'improving',
        'risk_level' => 'low',
        'joined_date' => date('Y-m-d', strtotime('-3 months'))
    ],
    [
        'id' => 2,
        'name' => 'John Davis',
        'email' => 'john.d@email.com',
        'phone' => '(555) 234-5678',
        'age' => 35,
        'diagnosis' => 'PTSD',
        'status' => 'active',
        'last_session' => date('Y-m-d H:i:s', strtotime('-1 week')),
        'next_session' => date('Y-m-d H:i:s', strtotime('+2 days')),
        'total_sessions' => 8,
        'progress_score' => 65,
        'mood_trend' => 'stable',
        'risk_level' => 'medium',
        'joined_date' => date('Y-m-d', strtotime('-2 months'))
    ],
    [
        'id' => 3,
        'name' => 'Emily Rodriguez',
        'email' => 'emily.r@email.com',
        'phone' => '(555) 345-6789',
        'age' => 42,
        'diagnosis' => 'Depression',
        'status' => 'inactive',
        'last_session' => date('Y-m-d H:i:s', strtotime('-3 weeks')),
        'next_session' => null,
        'total_sessions' => 15,
        'progress_score' => 45,
        'mood_trend' => 'declining',
        'risk_level' => 'high',
        'joined_date' => date('Y-m-d', strtotime('-6 months'))
    ]
];

$stats = [
    'total_patients' => count($patients),
    'active_patients' => count(array_filter($patients, fn($p) => $p['status'] === 'active')),
    'high_risk' => count(array_filter($patients, fn($p) => $p['risk_level'] === 'high')),
    'avg_progress' => round(array_sum(array_column($patients, 'progress_score')) / count($patients))
];
?>

<!-- My Patients Content -->
<div class="container-fluid p-4">
    <!-- Patients Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">
                <i class="fas fa-users me-2"></i>
                My Patients
            </h2>
            <p class="text-muted mb-0">
                Manage your patient caseload and track treatment progress
            </p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-luna-primary" onclick="addNewPatient()">
                <i class="fas fa-user-plus me-2"></i>Add Patient
            </button>
            <button class="btn btn-luna-outline" onclick="exportPatients()">
                <i class="fas fa-download me-2"></i>Export
            </button>
        </div>
    </div>

    <!-- Patient Stats -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="stat-label">Total Patients</p>
                        <h4 class="stat-number"><?php echo $stats['total_patients']; ?></h4>
                    </div>
                    <div class="stat-icon icon-primary">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="stat-label">Active Patients</p>
                        <h4 class="stat-number"><?php echo $stats['active_patients']; ?></h4>
                    </div>
                    <div class="stat-icon icon-success">
                        <i class="fas fa-user-check"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="stat-label">High Risk</p>
                        <h4 class="stat-number"><?php echo $stats['high_risk']; ?></h4>
                    </div>
                    <div class="stat-icon icon-danger">
                        <i class="fas fa-exclamation-triangle"></i>
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
    </div>

    <!-- Patients List -->
    <div class="stat-card">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="mb-0">
                <i class="fas fa-list text-primary me-2"></i>
                Patient List
            </h5>
            <div class="d-flex gap-2">
                <input type="text" class="form-control form-control-sm" placeholder="Search patients..." style="width: 200px;">
                <select class="form-select form-select-sm" style="width: auto;">
                    <option>All Patients</option>
                    <option>Active</option>
                    <option>Inactive</option>
                    <option>High Risk</option>
                </select>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Patient</th>
                    <th>Diagnosis</th>
                    <th>Sessions</th>
                    <th>Progress</th>
                    <th>Last Session</th>
                    <th>Next Session</th>
                    <th>Risk Level</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($patients as $patient): ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="user-avatar me-3">
                                    <?php echo strtoupper(substr($patient['name'], 0, 1)); ?>
                                </div>
                                <div>
                                    <div class="fw-semibold"><?php echo $patient['name']; ?></div>
                                    <div class="small text-muted"><?php echo $patient['email']; ?></div>
                                </div>
                            </div>
                        </td>
                        <td><?php echo $patient['diagnosis']; ?></td>
                        <td><span class="badge bg-primary"><?php echo $patient['total_sessions']; ?></span></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="progress me-2" style="width: 60px; height: 6px;">
                                    <div class="progress-bar bg-<?php echo $patient['progress_score'] >= 70 ? 'success' : ($patient['progress_score'] >= 50 ? 'warning' : 'danger'); ?>"
                                         style="width: <?php echo $patient['progress_score']; ?>%"></div>
                                </div>
                                <span class="small"><?php echo $patient['progress_score']; ?>%</span>
                            </div>
                        </td>
                        <td>
                            <?php if ($patient['last_session']): ?>
                                <div class="small"><?php echo date('M j, Y', strtotime($patient['last_session'])); ?></div>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($patient['next_session']): ?>
                                <div class="small"><?php echo date('M j, Y', strtotime($patient['next_session'])); ?></div>
                            <?php else: ?>
                                <span class="text-muted">Not scheduled</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="badge bg-<?php echo $patient['risk_level'] === 'high' ? 'danger' : ($patient['risk_level'] === 'medium' ? 'warning' : 'success'); ?>">
                                <?php echo ucfirst($patient['risk_level']); ?>
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-<?php echo $patient['status'] === 'active' ? 'success' : 'secondary'; ?>">
                                <?php echo ucfirst($patient['status']); ?>
                            </span>
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#" onclick="viewPatient(<?php echo $patient['id']; ?>)">
                                            <i class="fas fa-eye me-2"></i>View Profile</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="scheduleSession(<?php echo $patient['id']; ?>)">
                                            <i class="fas fa-calendar-plus me-2"></i>Schedule Session</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="viewNotes(<?php echo $patient['id']; ?>)">
                                            <i class="fas fa-sticky-note me-2"></i>View Notes</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="generateReport(<?php echo $patient['id']; ?>)">
                                            <i class="fas fa-chart-bar me-2"></i>Generate Report</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="#" onclick="editPatient(<?php echo $patient['id']; ?>)">
                                            <i class="fas fa-edit me-2"></i>Edit Patient</a></li>
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

<script>
    function addNewPatient() {
        window.showToast('Opening new patient form...', 'info');
    }

    function exportPatients() {
        window.showToast('Exporting patient list...', 'info');
    }

    function viewPatient(id) {
        window.showToast(`Loading patient ${id} profile...`, 'info');
    }

    function scheduleSession(id) {
        window.showToast(`Scheduling session for patient ${id}...`, 'info');
    }

    function viewNotes(id) {
        window.showToast(`Loading notes for patient ${id}...`, 'info');
    }

    function generateReport(id) {
        window.showToast(`Generating report for patient ${id}...`, 'info');
    }

    function editPatient(id) {
        window.showToast(`Editing patient ${id}...`, 'info');
    }
</script>

<?php include 'templates/footer.php'; ?>
