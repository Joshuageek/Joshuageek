<?php
$current_page = basename($_SERVER['PHP_SELF']);
$user_role = getUserRole();
$user_name = $_SESSION['user_name'] ?? 'User';
$user_email = $_SESSION['user_email'] ?? 'user@example.com';

$base_path = '/luna/admin/';
?>

<!-- Professional Sidebar -->
<div class="sidebar" id="sidebar">
    <!-- Sidebar Header -->
    <div class="sidebar-header">
        <div class="logo-container">
            <div class="logo-icon">
                <i class="fas fa-moon text-white"></i>
            </div>
            <div>
                <h4 class="logo-text">Luna</h4>
                <p class="logo-subtitle">Mental Wellness</p>
            </div>
        </div>
    </div>

    <!-- User Profile -->
    <div class="user-profile">
        <div class="d-flex align-items-center">
            <div class="user-avatar">
                <?php echo strtoupper(substr($user_name, 0, 1)); ?>
            </div>
            <div class="user-info flex-grow-1 ms-3">
                <h6><?php echo htmlspecialchars($user_name); ?></h6>
                <small><?php echo ucfirst($user_role); ?> Account</small>
            </div>
            <div class="status-indicator"></div>
        </div>
    </div>

    <!-- Main Navigation -->
    <div class="nav-section">
        <div class="nav-section-title">Main</div>
        <a href="<?= $base_path; ?>index.php" class="nav-link <?php echo $current_page === 'index.php' ? 'active' : ''; ?>">
            <i class="fas fa-chart-pie"></i>
            Dashboard
        </a>
        <a href="<?= $base_path; ?>calendar.php" class="nav-link <?php echo $current_page === 'calendar.php' ? 'active' : ''; ?>">
            <i class="fas fa-calendar-alt"></i>
            Calendar
        </a>
        <a href="<?= $base_path; ?>messages.php" class="nav-link <?php echo $current_page === 'messages.php' ? 'active' : ''; ?>">
            <i class="fas fa-comments"></i>
            Messages
            <span class="nav-badge">3</span>
        </a>
    </div>

    <?php if ($user_role === 'admin'): ?>
        <!-- Admin Section -->
        <div class="nav-section">
            <div class="nav-section-title">Administration</div>
            <a href="<?= $base_path; ?>users.php" class="nav-link <?php echo $current_page === 'users.php' ? 'active' : ''; ?>">
                <i class="fas fa-users"></i>
                User Management
            </a>
            <a href="<?= $base_path; ?>therapists.php" class="nav-link <?php echo $current_page === 'therapists.php' ? 'active' : ''; ?>">
                <i class="fas fa-user-md"></i>
                Therapists
            </a>
            <a href="<?= $base_path; ?>patients.php" class="nav-link <?php echo $current_page === 'patients.php' ? 'active' : ''; ?>">
                <i class="fas fa-user-friends"></i>
                Patients
            </a>
            <a href="<?= $base_path; ?>reports.php" class="nav-link <?php echo $current_page === 'reports.php' ? 'active' : ''; ?>">
                <i class="fas fa-chart-line"></i>
                Reports and Analytics
            </a>
        </div>

    <?php elseif ($user_role === 'therapist'): ?>
        <!-- Therapist Section - Simplified -->
        <div class="nav-section">
            <div class="nav-section-title">Practice</div>
            <a href="<?= $base_path; ?>my_patients.php" class="nav-link <?php echo $current_page === 'my_patients.php' ? 'active' : ''; ?>"">
                <i class="fas fa-user-friends"></i>
                My Patients
            </a>
            <a href="<?= $base_path; ?>appointments.php" class="nav-link <?php echo $current_page === 'appointments.php' ? 'active' : ''; ?>">
                <i class="fas fa-calendar-check"></i>
                Appointments
            </a>
            <a href="<?= $base_path; ?>sessions.php" class="nav-link <?php echo $current_page === 'sessions.php' ? 'active' : ''; ?>">
                <i class="fas fa-video"></i>
                Sessions
            </a>
            <a href="<?= $base_path; ?>session_notes.php" class="nav-link <?php echo $current_page === 'session_notes.php' ? 'active' : ''; ?>">
                <i class="fas fa-sticky-note"></i>
                Session Notes
            </a>
            <a href="<?= $base_path; ?>patient_reports.php" class="nav-link <?php echo $current_page === 'patient_reports.php' ? 'active' : ''; ?>">
                <i class="fas fa-chart-bar"></i>
                Patient Reports
            </a>
        </div>

    <?php else: // patient ?>
        <!-- Patient Section -->
        <div class="nav-section">
            <div class="nav-section-title">My Therapy</div>
            <a href="<?= $base_path; ?>sessions.php" class="nav-link <?php echo $current_page === 'sessions.php' ? 'active' : ''; ?>">
                <i class="fas fa-heart"></i>
                My Sessions
            </a>
            <a href="<?= $base_path; ?>appointments.php" class="nav-link <?php echo $current_page === 'appointments.php' ? 'active' : ''; ?>">
                <i class="fas fa-calendar-check"></i>
                My Appointments
            </a>
            <a href="<?= $base_path; ?>session_notes.php" class="nav-link <?php echo $current_page === 'session_notes.php' ? 'active' : ''; ?>">
                <i class="fas fa-sticky-note"></i>
                Session Notes
            </a>
            <a href="<?= $base_path; ?>patient_reports.php" class="nav-link <?php echo $current_page === 'patient_reports.php' ? 'active' : ''; ?>">
                <i class="fas fa-chart-bar"></i>
                My Reports
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">Wellness Tracking</div>
            <a href="<?= $base_path; ?>progress.php" class="nav-link <?php echo $current_page === 'progress.php' ? 'active' : ''; ?>">
                <i class="fas fa-chart-line"></i>
                Progress
            </a>
            <a href="<?= $base_path; ?>mood_tracker.php" class="nav-link <?php echo $current_page === 'mood-tracker.php' ? 'active' : ''; ?>">
                <i class="fas fa-smile"></i>
                Mood Tracker
            </a>
            <a href="<?= $base_path; ?>goals.php" class="nav-link <?php echo $current_page === 'goals.php' ? 'active' : ''; ?>">
                <i class="fas fa-bullseye"></i>
                Goals
            </a>
        </div>

        <?php endif; ?>

    <!-- Account Section -->
    <div class="nav-section">
        <div class="nav-section-title">Account</div>
        <a href="<?= $base_path; ?>profile.php" class="nav-link <?php echo $current_page === 'profile.php' ? 'active' : ''; ?>">
            <i class="fas fa-user"></i>
            Profile
        </a>
        <?php if ($user_role === 'admin'): ?>
        <a href="<?= $base_path; ?>permissions.php" class="nav-link <?php echo $current_page === 'permissions.php' ? 'active' : ''; ?>">
            <i class="fas fa-user"></i>
            Permissions
        </a>
        <a href="<?= $base_path; ?>settings.php" class="nav-link <?php echo $current_page === 'settings.php' ? 'active' : ''; ?>">
            <i class="fas fa-user"></i>
            Settings
        </a>
            <a href="<?= $base_path; ?>activity_logs.php" class="nav-link <?php echo $current_page === 'activity_logs.php' ? 'active' : ''; ?>">
                <i class="fas fa-user"></i>
                Activity logs
            </a>
        <?php endif; ?>
        <a href="../logout.php" class="nav-link" style="color: #ef4444;">
            <i class="fas fa-sign-out-alt"></i>
            Sign Out
        </a>
    </div>
</div>

<!-- Mobile Overlay -->
<div class="sidebar-overlay d-md-none" id="sidebarOverlay" onclick="toggleSidebar()"></div>
<div class="sidebar-overlay" id="sidebarOverlay"></div>