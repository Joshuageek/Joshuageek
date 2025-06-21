<?php
session_start();
require_once '../includes/auth.php';

// Check if user is authenticated and has appropriate permissions
if (!isLoggedIn() || (!isAdmin() && !isTherapist())) {
    header('Location: ../index.php');
    exit();
}

$user_role = getUserRole();
$user_id = $_SESSION['user_id'];

// Handle therapist actions (admin only)
if ($_POST && isAdmin()) {
    $action = $_POST['action'] ?? '';
    $therapist_id = $_POST['therapist_id'] ?? '';
    
    switch ($action) {
        case 'approve':
            if (approveTherapist($therapist_id)) {
                $message = "Therapist approved successfully.";
                logActivity($user_id, 'therapist_approve', "Approved therapist ID: $therapist_id");
            } else {
                $error = "Failed to approve therapist.";
            }
            break;
        case 'reject':
            if (rejectTherapist($therapist_id)) {
                $message = "Therapist application rejected.";
                logActivity($user_id, 'therapist_reject', "Rejected therapist ID: $therapist_id");
            } else {
                $error = "Failed to reject therapist.";
            }
            break;
    }
}

// Get therapists based on role
$therapists = getTherapistsData($user_role, $user_id);
?>

<!DOCTYPE html>
<html lang="en">
<?php include '../templates/header.php'; ?>
<body>
    <?php include '../templates/sidebar.php'; ?>
    
    <div class="main-content">
        <?php include '../templates/toolbar.php'; ?>

        <div class="dashboard-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>
                    <?php echo isAdmin() ? 'Therapist Management' : 'Therapist Directory'; ?>
                </h2>
                <?php if (isAdmin()): ?>
                    <button class="btn btn-outline-custom" onclick="exportTherapists()">
                        <i class="fas fa-download me-2"></i>Export Report
                    </button>
                <?php endif; ?>
            </div>

            <?php if (isset($message)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo $error; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Therapist Statistics -->
            <?php if (isAdmin()): ?>
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card stat-card">
                        <div class="stat-icon" style="background: rgba(76, 175, 80, 0.1); color: #4CAF50;">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <div class="stat-number"><?php echo count(array_filter($therapists, fn($t) => $t['status'] === 'approved')); ?></div>
                        <div class="stat-label">Active Therapists</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card stat-card">
                        <div class="stat-icon" style="background: rgba(255, 152, 0, 0.1); color: #FF9800;">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-number"><?php echo count(array_filter($therapists, fn($t) => $t['status'] === 'pending')); ?></div>
                        <div class="stat-label">Pending Applications</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card stat-card">
                        <div class="stat-icon" style="background: rgba(33, 150, 243, 0.1); color: #2196F3;">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="stat-number">156</div>
                        <div class="stat-label">Total Sessions</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card stat-card">
                        <div class="stat-icon" style="background: rgba(168, 195, 164, 0.1); color: #A8C3A4;">
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="stat-number">4.8</div>
                        <div class="stat-label">Average Rating</div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Therapists Grid -->
            <div class="row">
                <?php if (empty($therapists)): ?>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body text-center">
                                <i class="fas fa-user-md fa-3x text-muted mb-3"></i>
                                <h5>No therapists found</h5>
                                <p class="text-muted">No therapist records are available at this time.</p>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <?php foreach ($therapists as $therapist): ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="user-avatar-small bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                        <?php echo strtoupper(substr($therapist['full_name'] ?? 'T', 0, 1)); ?>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1"><?php echo htmlspecialchars($therapist['full_name'] ?? 'No Name'); ?></h6>
                                        <small class="text-muted"><?php echo htmlspecialchars($therapist['email']); ?></small>
                                    </div>
                                    <span class="badge bg-<?php echo $therapist['status'] === 'approved' ? 'success' : ($therapist['status'] === 'pending' ? 'warning' : 'danger'); ?>">
                                        <?php echo ucfirst($therapist['status'] ?? 'Unknown'); ?>
                                    </span>
                                </div>
                                
                                <div class="therapist-details">
                                    <div class="row">
                                        <div class="col-6">
                                            <small class="text-muted">Specialization</small>
                                            <p class="mb-2"><?php echo htmlspecialchars($therapist['specialization'] ?? 'Not specified'); ?></p>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">Experience</small>
                                            <p class="mb-2"><?php echo htmlspecialchars($therapist['experience_years'] ?? 'Not specified'); ?> years</p>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">License</small>
                                            <p class="mb-2"><?php echo htmlspecialchars($therapist['license_number'] ?? 'Not provided'); ?></p>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">Patients</small>
                                            <p class="mb-2"><?php echo $therapist['patient_count'] ?? 0; ?></p>
                                        </div>
                                    </div>
                                    
                                    <?php if (!empty($therapist['bio'])): ?>
                                    <div class="mt-2">
                                        <small class="text-muted">Bio</small>
                                        <p class="small"><?php echo htmlspecialchars(substr($therapist['bio'], 0, 100)) . (strlen($therapist['bio']) > 100 ? '...' : ''); ?></p>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="mt-3">
                                    <?php if (isAdmin()): ?>
                                        <?php if ($therapist['status'] === 'pending'): ?>
                                            <button class="btn btn-sm btn-success-custom me-2" onclick="approveTherapist(<?php echo $therapist['id']; ?>)">
                                                Approve
                                            </button>
                                            <button class="btn btn-sm btn-danger-custom" onclick="rejectTherapist(<?php echo $therapist['id']; ?>)">
                                                Reject
                                            </button>
                                        <?php else: ?>
                                            <button class="btn btn-sm btn-outline-primary" onclick="viewTherapistDetails(<?php echo $therapist['id']; ?>)">
                                                View Details
                                            </button>
                                            <button class="btn btn-sm btn-outline-secondary ms-2" onclick="contactTherapist('<?php echo $therapist['email']; ?>')">
                                                Contact
                                            </button>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <button class="btn btn-sm btn-outline-primary" onclick="viewTherapistProfile(<?php echo $therapist['id']; ?>)">
                                            View Profile
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        function approveTherapist(therapistId) {
            if (confirm('Are you sure you want to approve this therapist?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.innerHTML = `
                    <input type="hidden" name="action" value="approve">
                    <input type="hidden" name="therapist_id" value="${therapistId}">
                `;
                document.body.appendChild(form);
                form.submit();
            }
        }

        function rejectTherapist(therapistId) {
            if (confirm('Are you sure you want to reject this therapist application?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.innerHTML = `
                    <input type="hidden" name="action" value="reject">
                    <input type="hidden" name="therapist_id" value="${therapistId}">
                `;
                document.body.appendChild(form);
                form.submit();
            }
        }

        function viewTherapistDetails(therapistId) {
            window.location.href = `therapist-details.php?id=${therapistId}`;
        }

        function viewTherapistProfile(therapistId) {
            window.location.href = `therapist-profile.php?id=${therapistId}`;
        }

        function contactTherapist(email) {
            window.location.href = 'mailto:' + email;
        }

        function exportTherapists() {
            window.location.href = 'export-therapists.php';
        }
    </script>

    <?php include '../templates/footer.php'; ?>
</body>
</html>
