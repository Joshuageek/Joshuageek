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

// Enhanced stats with better data
$stats = [
    'total_patients' => 1247,
    'total_therapists' => 89,
    'total_sessions' => 15678,
    'monthly_revenue' => 125400,
    'my_patients' => 32,
    'pending_appointments' => 8,
    'sessions_this_month' => 47,
    'avg_rating' => 4.9,
    'my_sessions' => 23,
    'wellness_score' => 87,
    'completed_assessments' => 12,
    'active_users' => 2156,
    'system_uptime' => 99.8
];

// Enhanced recent activity
$recent_activity = [
    [
        'user_name' => 'Dr. Sarah Johnson',
        'description' => 'Completed therapy session with patient Mike Chen',
        'type' => 'session',
        'created_at' => date('Y-m-d H:i:s', strtotime('-15 minutes'))
    ],
    [
        'user_name' => 'Emily Rodriguez',
        'description' => 'Submitted wellness assessment and mood tracker',
        'type' => 'assessment',
        'created_at' => date('Y-m-d H:i:s', strtotime('-1 hour'))
    ],
    [
        'user_name' => 'Dr. Michael Wilson',
        'description' => 'Updated treatment plan for patient Sarah Davis',
        'type' => 'treatment',
        'created_at' => date('Y-m-d H:i:s', strtotime('-2 hours'))
    ],
    [
        'user_name' => 'Admin User',
        'description' => 'System backup completed successfully',
        'type' => 'system',
        'created_at' => date('Y-m-d H:i:s', strtotime('-3 hours'))
    ],
    [
        'user_name' => 'Jessica Thompson',
        'description' => 'Booked new appointment for next week',
        'type' => 'appointment',
        'created_at' => date('Y-m-d H:i:s', strtotime('-4 hours'))
    ]
];

$upcoming_appointments = [
    [
        'title' => 'Cognitive Behavioral Therapy',
        'participant' => 'Dr. Sarah Johnson',
        'patient' => 'Mike Chen',
        'datetime' => date('Y-m-d H:i:s', strtotime('+2 hours')),
        'type' => 'Video Call',
        'status' => 'confirmed'
    ],
    [
        'title' => 'Initial Consultation',
        'participant' => 'Dr. Michael Wilson',
        'patient' => 'Emma Davis',
        'datetime' => date('Y-m-d H:i:s', strtotime('+1 day')),
        'type' => 'In-Person',
        'status' => 'pending'
    ],
    [
        'title' => 'Follow-up Session',
        'participant' => 'Dr. Lisa Anderson',
        'patient' => 'John Smith',
        'datetime' => date('Y-m-d H:i:s', strtotime('+2 days')),
        'type' => 'Video Call',
        'status' => 'confirmed'
    ]
];
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
        <div class="container-fluid p-4">
            <!-- Welcome Card -->
            <div class="welcome-card animate-in">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <h2 class="welcome-title">Welcome to your professional dashboard</h2>
                        <p class="welcome-subtitle">
                            <?php if ($user_role === 'admin'): ?>
                                Monitor platform performance, manage users, and oversee system operations with comprehensive administrative tools and real-time analytics.
                            <?php elseif ($user_role === 'therapist'): ?>
                                Manage your practice efficiently with advanced patient care tools, session management, and treatment planning features.
                            <?php else: ?>
                                Continue your mental wellness journey with personalized tools, professional support, and comprehensive progress tracking.
                            <?php endif; ?>
                        </p>
                        <div class="d-flex gap-3 flex-wrap">
                            <?php if ($user_role === 'admin'): ?>
                                <a href="sections/users.php" class="btn btn-luna-primary">
                                    <i class="fas fa-users me-2"></i>Manage Users
                                </a>
                                <a href="sections/reports.php" class="btn btn-luna-outline">
                                    <i class="fas fa-chart-bar me-2"></i>View Analytics
                                </a>
                                <a href="sections/settings.php" class="btn btn-luna-outline">
                                    <i class="fas fa-cog me-2"></i>System Settings
                                </a>
                            <?php elseif ($user_role === 'therapist'): ?>
                                <a href="sections/appointments.php" class="btn btn-luna-primary">
                                    <i class="fas fa-calendar-plus me-2"></i>Schedule Session
                                </a>
                                <a href="sections/my-patients.php" class="btn btn-luna-outline">
                                    <i class="fas fa-user-friends me-2"></i>View Patients
                                </a>
                                <a href="sections/notes.php" class="btn btn-luna-outline">
                                    <i class="fas fa-sticky-note me-2"></i>Session Notes
                                </a>
                            <?php else: ?>
                                <a href="sections/book-session.php" class="btn btn-luna-primary">
                                    <i class="fas fa-heart me-2"></i>Book Session
                                </a>
                                <a href="sections/progress.php" class="btn btn-luna-outline">
                                    <i class="fas fa-chart-line me-2"></i>View Progress
                                </a>
                                <a href="sections/wellness.php" class="btn btn-luna-outline">
                                    <i class="fas fa-spa me-2"></i>Wellness Tools
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-lg-4 text-center">
                        <div class="row">
                            <?php if ($user_role === 'admin'): ?>
                                <div class="col-4">
                                    <div class="h2 fw-bold mb-0"><?php echo number_format($stats['total_patients']); ?></div>
                                    <div class="small opacity-90">Total Patients</div>
                                </div>
                                <div class="col-4">
                                    <div class="h2 fw-bold mb-0"><?php echo $stats['total_therapists']; ?></div>
                                    <div class="small opacity-90">Therapists</div>
                                </div>
                                <div class="col-4">
                                    <div class="h2 fw-bold mb-0"><?php echo $stats['system_uptime']; ?>%</div>
                                    <div class="small opacity-90">Uptime</div>
                                </div>
                            <?php elseif ($user_role === 'therapist'): ?>
                                <div class="col-4">
                                    <div class="h2 fw-bold mb-0"><?php echo $stats['my_patients']; ?></div>
                                    <div class="small opacity-90">My Patients</div>
                                </div>
                                <div class="col-4">
                                    <div class="h2 fw-bold mb-0"><?php echo $stats['sessions_this_month']; ?></div>
                                    <div class="small opacity-90">Sessions</div>
                                </div>
                                <div class="col-4">
                                    <div class="h2 fw-bold mb-0"><?php echo $stats['avg_rating']; ?></div>
                                    <div class="small opacity-90">Rating</div>
                                </div>
                            <?php else: ?>
                                <div class="col-4">
                                    <div class="h2 fw-bold mb-0"><?php echo $stats['my_sessions']; ?></div>
                                    <div class="small opacity-90">Sessions</div>
                                </div>
                                <div class="col-4">
                                    <div class="h2 fw-bold mb-0"><?php echo $stats['wellness_score']; ?>%</div>
                                    <div class="small opacity-90">Wellness</div>
                                </div>
                                <div class="col-4">
                                    <div class="h2 fw-bold mb-0"><?php echo $stats['completed_assessments']; ?></div>
                                    <div class="small opacity-90">Assessments</div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <?php if ($user_role === 'admin'): ?>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="stat-card animate-in animate-delay-1">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="stat-label">Total Patients</p>
                                    <h3 class="stat-number"><?php echo number_format($stats['total_patients']); ?></h3>
                                    <span class="stat-change positive">
                                        <i class="fas fa-arrow-up"></i> +12.5% from last month
                                    </span>
                                </div>
                                <div class="stat-icon icon-primary">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="stat-card animate-in animate-delay-2">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="stat-label">Active Therapists</p>
                                    <h3 class="stat-number"><?php echo $stats['total_therapists']; ?></h3>
                                    <span class="stat-change positive">
                                        <i class="fas fa-arrow-up"></i> +8.3% from last month
                                    </span>
                                </div>
                                <div class="stat-icon icon-success">
                                    <i class="fas fa-user-md"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="stat-card animate-in animate-delay-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="stat-label">Total Sessions</p>
                                    <h3 class="stat-number"><?php echo number_format($stats['total_sessions']); ?></h3>
                                    <span class="stat-change positive">
                                        <i class="fas fa-arrow-up"></i> +18.7% from last month
                                    </span>
                                </div>
                                <div class="stat-icon icon-warning">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="stat-card animate-in animate-delay-4">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="stat-label">Monthly Revenue</p>
                                    <h3 class="stat-number">$<?php echo number_format($stats['monthly_revenue']); ?></h3>
                                    <span class="stat-change positive">
                                        <i class="fas fa-arrow-up"></i> +25.4% from last month
                                    </span>
                                </div>
                                <div class="stat-icon icon-success">
                                    <i class="fas fa-dollar-sign"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php elseif ($user_role === 'therapist'): ?>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="stat-card animate-in animate-delay-1">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="stat-label">My Patients</p>
                                    <h3 class="stat-number"><?php echo $stats['my_patients']; ?></h3>
                                    <span class="stat-change positive">
                                        <i class="fas fa-arrow-up"></i> +3 new patients
                                    </span>
                                </div>
                                <div class="stat-icon icon-primary">
                                    <i class="fas fa-user-friends"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="stat-card animate-in animate-delay-2">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="stat-label">Pending Requests</p>
                                    <h3 class="stat-number"><?php echo $stats['pending_appointments']; ?></h3>
                                    <span class="stat-change positive">
                                        <i class="fas fa-clock"></i> Requires attention
                                    </span>
                                </div>
                                <div class="stat-icon icon-warning">
                                    <i class="fas fa-clock"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="stat-card animate-in animate-delay-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="stat-label">Sessions This Month</p>
                                    <h3 class="stat-number"><?php echo $stats['sessions_this_month']; ?></h3>
                                    <span class="stat-change positive">
                                        <i class="fas fa-arrow-up"></i> +7 from last month
                                    </span>
                                </div>
                                <div class="stat-icon icon-success">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="stat-card animate-in animate-delay-4">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="stat-label">Average Rating</p>
                                    <h3 class="stat-number"><?php echo $stats['avg_rating']; ?></h3>
                                    <span class="stat-change positive">
                                        <i class="fas fa-star"></i> Excellent feedback
                                    </span>
                                </div>
                                <div class="stat-icon icon-warning">
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="stat-card animate-in animate-delay-1">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="stat-label">My Sessions</p>
                                    <h3 class="stat-number"><?php echo $stats['my_sessions']; ?></h3>
                                    <span class="stat-change positive">
                                        <i class="fas fa-arrow-up"></i> +2 this month
                                    </span>
                                </div>
                                <div class="stat-icon icon-primary">
                                    <i class="fas fa-heart"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="stat-card animate-in animate-delay-2">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="stat-label">Wellness Score</p>
                                    <h3 class="stat-number"><?php echo $stats['wellness_score']; ?>%</h3>
                                    <span class="stat-change positive">
                                        <i class="fas fa-arrow-up"></i> +15% improvement
                                    </span>
                                </div>
                                <div class="stat-icon icon-success">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="stat-card animate-in animate-delay-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="stat-label">Completed Assessments</p>
                                    <h3 class="stat-number"><?php echo $stats['completed_assessments']; ?></h3>
                                    <span class="stat-change positive">
                                        <i class="fas fa-clipboard-check"></i> Well done!
                                    </span>
                                </div>
                                <div class="stat-icon icon-warning">
                                    <i class="fas fa-clipboard-check"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Main Content Row -->
            <div class="row">
                <!-- Recent Activity -->
                <div class="col-lg-8">
                    <div class="stat-card animate-in">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0">
                                <i class="fas fa-history text-success me-2"></i>
                                Recent Activity
                            </h5>
                            <a href="activity.php" class="btn btn-sm btn-outline-secondary">View All</a>
                        </div>
                        
                        <?php if (empty($recent_activity)): ?>
                            <div class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <h6 class="text-muted">No recent activity</h6>
                                <p class="text-muted">Activity will appear here as you use the system</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($recent_activity as $activity): ?>
                            <div class="activity-item">
                                <div class="activity-avatar">
                                    <?php echo strtoupper(substr($activity['user_name'], 0, 1)); ?>
                                </div>
                                <div class="activity-content flex-grow-1">
                                    <h6><?php echo htmlspecialchars($activity['user_name']); ?></h6>
                                    <p><?php echo htmlspecialchars($activity['description']); ?></p>
                                </div>
                                <div class="activity-time">
                                    <?php echo date('M j, g:i A', strtotime($activity['created_at'])); ?>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Sidebar Content -->
                <div class="col-lg-4">
                    <!-- Quick Actions -->
                    <div class="stat-card mb-4 animate-in animate-delay-1">
                        <h5 class="mb-3">
                            <i class="fas fa-bolt text-warning me-2"></i>
                            Quick Actions
                        </h5>
                        <div class="d-grid gap-2">
                            <?php if ($user_role === 'admin'): ?>
                                <a href="sections/add-user.php" class="btn btn-luna-primary">
                                    <i class="fas fa-user-plus me-2"></i>Add New User
                                </a>
                                <a href="sections/reports.php" class="btn btn-outline-secondary">
                                    <i class="fas fa-chart-bar me-2"></i>Generate Report
                                </a>
                                <a href="sections/settings.php" class="btn btn-outline-secondary">
                                    <i class="fas fa-cog me-2"></i>System Settings
                                </a>
                                <a href="sections/backup.php" class="btn btn-outline-secondary">
                                    <i class="fas fa-database me-2"></i>Backup System
                                </a>
                            <?php elseif ($user_role === 'therapist'): ?>
                                <a href="sections/new-session.php" class="btn btn-luna-primary">
                                    <i class="fas fa-plus me-2"></i>New Session Note
                                </a>
                                <a href="sections/schedule.php" class="btn btn-outline-secondary">
                                    <i class="fas fa-calendar-plus me-2"></i>Schedule Appointment
                                </a>
                                <a href="sections/my-patients.php" class="btn btn-outline-secondary">
                                    <i class="fas fa-user-friends me-2"></i>View Patients
                                </a>
                                <a href="sections/resources.php" class="btn btn-outline-secondary">
                                    <i class="fas fa-book me-2"></i>Resources
                                </a>
                            <?php else: ?>
                                <a href="sections/book-session.php" class="btn btn-luna-primary">
                                    <i class="fas fa-calendar-plus me-2"></i>Book Session
                                </a>
                                <a href="sections/mood-tracker.php" class="btn btn-outline-secondary">
                                    <i class="fas fa-smile me-2"></i>Mood Tracker
                                </a>
                                <a href="sections/wellness.php" class="btn btn-outline-secondary">
                                    <i class="fas fa-spa me-2"></i>Wellness Tools
                                </a>
                                <a href="sections/emergency.php" class="btn btn-outline-danger">
                                    <i class="fas fa-phone-alt me-2"></i>Crisis Support
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Upcoming Appointments -->
                    <div class="stat-card animate-in animate-delay-2">
                        <h5 class="mb-3">
                            <i class="fas fa-calendar-alt text-primary me-2"></i>
                            Upcoming Appointments
                        </h5>
                        
                        <?php if (empty($upcoming_appointments)): ?>
                            <div class="text-center py-4">
                                <i class="fas fa-calendar-times fa-2x text-muted mb-3"></i>
                                <p class="text-muted mb-0">No upcoming appointments</p>
                                <small class="text-muted">Schedule your next session</small>
                            </div>
                        <?php else: ?>
                            <?php foreach ($upcoming_appointments as $appointment): ?>
                            <div class="d-flex align-items-center p-3 bg-light rounded mb-3">
                                <div class="text-center me-3" style="min-width: 60px;">
                                    <div class="fw-bold text-primary"><?php echo date('M j', strtotime($appointment['datetime'])); ?></div>
                                    <div class="small text-muted"><?php echo date('g:i A', strtotime($appointment['datetime'])); ?></div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-semibold"><?php echo htmlspecialchars($appointment['title']); ?></div>
                                    <div class="text-muted small">
                                        <?php if ($user_role === 'therapist'): ?>
                                            Patient: <?php echo htmlspecialchars($appointment['patient']); ?>
                                        <?php else: ?>
                                            <?php echo htmlspecialchars($appointment['participant']); ?>
                                        <?php endif; ?>
                                    </div>
                                    <div class="d-flex gap-2 mt-1">
                                        <span class="badge bg-secondary"><?php echo htmlspecialchars($appointment['type']); ?></span>
                                        <span class="badge <?php echo $appointment['status'] === 'confirmed' ? 'bg-success' : 'bg-warning'; ?>">
                                            <?php echo ucfirst($appointment['status']); ?>
                                        </span>
                                    </div>
                                </div>
                                <button class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-video"></i>
                                </button>
                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Replace the entire <script> section at the bottom with this -->
    <script src="assets/js/simple-luna.js"></script>

    <!-- Add toast styles -->
    <style>
    .simple-toast {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        min-width: 300px;
        padding: 1rem;
        border-radius: 8px;
        color: white;
        transform: translateX(100%);
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .simple-toast.show {
        transform: translateX(0);
    }

    .simple-toast.toast-success { background: var(--luna-success); }
    .simple-toast.toast-error { background: var(--luna-danger); }
    .simple-toast.toast-warning { background: var(--luna-warning); }
    .simple-toast.toast-info { background: var(--luna-primary); }

    .toast-content {
        display: flex;
        align-items: center;
    }

    .toast-close {
        position: absolute;
        top: 5px;
        right: 10px;
        background: none;
        border: none;
        color: white;
        cursor: pointer;
        opacity: 0.7;
    }

    .toast-close:hover {
        opacity: 1;
    }
    </style>
</body>
</html>
