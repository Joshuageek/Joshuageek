<?php
session_start();
require_once 'includes/auth.php';

// Check if user is authenticated
if (!isLoggedIn()) {
    header('Location: ../login.php');
    exit();
}

$user_role = getUserRole();
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'] ?? 'User';

// Get dashboard data based on role
$stats = getDashboardStats($user_id, $user_role);
$recent_activity = getRecentActivity($user_role, $user_id);
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'templates/header.php'; ?>
<body>
    <?php include 'templates/sidebar.php'; ?>
    
    <!-- Main Content -->
    <div class="main-content">
        <?php include 'templates/toolbar.php'; ?>

        <!-- Dashboard Content -->
        <div class="dashboard-content">
            <!-- Welcome Section -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="mb-1">Welcome back, <?php echo htmlspecialchars($user_name); ?>!</h2>
                            <p class="text-muted">
                                <?php if ($user_role === 'admin'): ?>
                                    You have full administrative access to the Luna platform.
                                <?php elseif ($user_role === 'therapist'): ?>
                                    Manage your patients and appointments from your therapist dashboard.
                                <?php else: ?>
                                    Track your therapy journey and manage your appointments.
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <?php if ($user_role === 'admin'): ?>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="card stat-card animate-in">
                            <div class="stat-icon" style="background: rgba(168, 195, 164, 0.1); color: #A8C3A4;">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="stat-number"><?php echo $stats['total_patients']; ?></div>
                            <div class="stat-label">Total Patients</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="card stat-card animate-in" style="animation-delay: 0.1s;">
                            <div class="stat-icon" style="background: rgba(76, 175, 80, 0.1); color: #4CAF50;">
                                <i class="fas fa-user-md"></i>
                            </div>
                            <div class="stat-number"><?php echo $stats['total_therapists']; ?></div>
                            <div class="stat-label">Total Therapists</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="card stat-card animate-in" style="animation-delay: 0.2s;">
                            <div class="stat-icon" style="background: rgba(33, 150, 243, 0.1); color: #2196F3;">
                                <i class="fas fa-calendar"></i>
                            </div>
                            <div class="stat-number"><?php echo $stats['total_bookings']; ?></div>
                            <div class="stat-label">Total Bookings</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="card stat-card animate-in" style="animation-delay: 0.3s;">
                            <div class="stat-icon" style="background: rgba(255, 152, 0, 0.1); color: #FF9800;">
                                <i class="fas fa-clipboard-list"></i>
                            </div>
                            <div class="stat-number"><?php echo $stats['total_questionnaires']; ?></div>
                            <div class="stat-label">Questionnaires</div>
                        </div>
                    </div>
                <?php elseif ($user_role === 'therapist'): ?>
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="card stat-card animate-in">
                            <div class="stat-icon" style="background: rgba(76, 175, 80, 0.1); color: #4CAF50;">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div class="stat-number"><?php echo $stats['accepted_bookings']; ?></div>
                            <div class="stat-label">Accepted Appointments</div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="card stat-card animate-in" style="animation-delay: 0.1s;">
                            <div class="stat-icon" style="background: rgba(255, 152, 0, 0.1); color: #FF9800;">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="stat-number"><?php echo $stats['pending_bookings']; ?></div>
                            <div class="stat-label">Pending Bookings</div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="card stat-card animate-in" style="animation-delay: 0.2s;">
                            <div class="stat-icon" style="background: rgba(33, 150, 243, 0.1); color: #2196F3;">
                                <i class="fas fa-clipboard-list"></i>
                            </div>
                            <div class="stat-number"><?php echo $stats['patient_questionnaires']; ?></div>
                            <div class="stat-label">Patient Questionnaires</div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="col-lg-6 col-md-6 mb-3">
                        <div class="card stat-card animate-in">
                            <div class="stat-icon" style="background: rgba(168, 195, 164, 0.1); color: #A8C3A4;">
                                <i class="fas fa-calendar"></i>
                            </div>
                            <div class="stat-number"><?php echo $stats['my_bookings']; ?></div>
                            <div class="stat-label">My Appointments</div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 mb-3">
                        <div class="card stat-card animate-in" style="animation-delay: 0.1s;">
                            <div class="stat-icon" style="background: rgba(76, 175, 80, 0.1); color: #4CAF50;">
                                <i class="fas fa-clipboard-list"></i>
                            </div>
                            <div class="stat-number"><?php echo $stats['my_questionnaires']; ?></div>
                            <div class="stat-label">Completed Questionnaires</div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Main Content Row -->
            <div class="row">
                <!-- Recent Activity -->
                <div class="col-lg-8">
                    <div class="card mb-4 animate-in">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="fas fa-activity me-2" style="color: #A8C3A4;"></i>
                                Recent Activity
                            </h5>
                            <div class="table-responsive">
                                <table class="table table-custom">
                                    <thead>
                                        <tr>
                                            <th>User</th>
                                            <th>Action</th>
                                            <th>Description</th>
                                            <th>Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($recent_activity)): ?>
                                            <tr>
                                                <td colspan="4" class="text-center text-muted">No recent activity</td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($recent_activity as $activity): ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="user-avatar-small bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px;">
                                                            <?php echo strtoupper(substr($activity['full_name'] ?? 'U', 0, 1)); ?>
                                                        </div>
                                                        <span><?php echo htmlspecialchars($activity['full_name'] ?? 'Unknown User'); ?></span>
                                                    </div>
                                                </td>
                                                <td><?php echo htmlspecialchars($activity['action']); ?></td>
                                                <td><?php echo htmlspecialchars($activity['description']); ?></td>
                                                <td><?php echo date('M j, H:i', strtotime($activity['created_at'])); ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="col-lg-4">
                    <div class="card mb-4 animate-in">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="fas fa-bolt me-2" style="color: #A8C3A4;"></i>
                                Quick Actions
                            </h5>
                            <div class="d-grid gap-3">
                                <?php if ($user_role === 'admin'): ?>
                                    <a href="sections/user.php" class="btn btn-primary-custom">
                                        <i class="fas fa-users me-2"></i>
                                        Manage Users
                                    </a>
                                    <a href="sections/bookings.php" class="btn btn-outline-custom">
                                        <i class="fas fa-calendar me-2"></i>
                                        View All Bookings
                                        <?php if ($stats['pending_bookings'] > 0): ?>
                                            <span class="badge bg-warning ms-2"><?php echo $stats['pending_bookings']; ?></span>
                                        <?php endif; ?>
                                    </a>
                                    <a href="sections/questionnaires.php" class="btn btn-outline-custom">
                                        <i class="fas fa-clipboard-list me-2"></i>
                                        View Questionnaires
                                    </a>
                                    <a href="sections/therapists.php" class="btn btn-outline-custom">
                                        <i class="fas fa-user-md me-2"></i>
                                        Manage Therapists
                                    </a>
                                <?php elseif ($user_role === 'therapist'): ?>
                                    <a href="sections/bookings.php" class="btn btn-primary-custom">
                                        <i class="fas fa-calendar me-2"></i>
                                        View Appointments
                                        <?php if ($stats['pending_bookings'] > 0): ?>
                                            <span class="badge bg-warning ms-2"><?php echo $stats['pending_bookings']; ?></span>
                                        <?php endif; ?>
                                    </a>
                                    <a href="sections/user.php" class="btn btn-outline-custom">
                                        <i class="fas fa-users me-2"></i>
                                        View Patients
                                    </a>
                                    <a href="sections/questionnaires.php" class="btn btn-outline-custom">
                                        <i class="fas fa-clipboard-list me-2"></i>
                                        Patient Questionnaires
                                    </a>
                                <?php else: ?>
                                    <a href="sections/bookings.php" class="btn btn-primary-custom">
                                        <i class="fas fa-calendar-plus me-2"></i>
                                        My Appointments
                                    </a>
                                    <a href="sections/questionnaires.php" class="btn btn-outline-custom">
                                        <i class="fas fa-clipboard-list me-2"></i>
                                        My Questionnaires
                                    </a>
                                    <a href="sections/profile.php" class="btn btn-outline-custom">
                                        <i class="fas fa-user me-2"></i>
                                        My Profile
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'templates/footer.php'; ?>
</body>
</html>
