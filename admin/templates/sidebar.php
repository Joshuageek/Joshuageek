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
        <a href="<?= $base_path; ?>notifications.php" class="nav-link <?php echo $current_page === 'notifications.php' ? 'active' : ''; ?>">
            <i class="fas fa-bell"></i>
            Notifications
            <span class="nav-badge">5</span>
        </a>
    </div>

    <?php if ($user_role === 'admin'): ?>
    <!-- Admin Section -->
    <div class="nav-section">
        <div class="nav-section-title">Administration</div>
        <a href="<?= $base_path; ?>sections/users.php" class="nav-link">
            <i class="fas fa-users"></i>
            User Management
        </a>
        <a href="<?= $base_path; ?>sections/therapists.php" class="nav-link">
            <i class="fas fa-user-md"></i>
            Therapists
        </a>
        <a href="<?= $base_path; ?>sections/patients.php" class="nav-link">
            <i class="fas fa-user-friends"></i>
            Patients
        </a>
        <a href="<?= $base_path; ?>sections/reports.php" class="nav-link">
            <i class="fas fa-chart-bar"></i>
            Analytics & Reports
        </a>
        <a href="<?= $base_path; ?>sections/billing.php" class="nav-link">
            <i class="fas fa-credit-card"></i>
            Billing & Payments
        </a>
        <a href="<?= $base_path; ?>sections/settings.php" class="nav-link">
            <i class="fas fa-cog"></i>
            System Settings
        </a>
    </div>
    
    <?php elseif ($user_role === 'therapist'): ?>
    <!-- Therapist Section -->
    <div class="nav-section">
        <div class="nav-section-title">Practice Management</div>
        <a href="<?= $base_path; ?>sections/my-patients.php" class="nav-link">
            <i class="fas fa-user-friends"></i>
            My Patients
        </a>
        <a href="<?= $base_path; ?>sections/appointments.php" class="nav-link">
            <i class="fas fa-calendar-check"></i>
            Appointments
        </a>
        <a href="<?= $base_path; ?>sections/sessions.php" class="nav-link">
            <i class="fas fa-video"></i>
            Session Management
        </a>
        <a href="<?= $base_path; ?>sections/notes.php" class="nav-link">
            <i class="fas fa-sticky-note"></i>
            Session Notes
        </a>
        <a href="<?= $base_path; ?>sections/assessments.php" class="nav-link">
            <i class="fas fa-clipboard-check"></i>
            Assessments
        </a>
        <a href="<?= $base_path; ?>sections/treatment-plans.php" class="nav-link">
            <i class="fas fa-route"></i>
            Treatment Plans
        </a>
    </div>
    
    <div class="nav-section">
        <div class="nav-section-title">Resources</div>
        <a href="<?= $base_path; ?>sections/resources.php" class="nav-link">
            <i class="fas fa-book-open"></i>
            Treatment Resources
        </a>
        <a href="<?= $base_path; ?>sections/continuing-education.php" class="nav-link">
            <i class="fas fa-graduation-cap"></i>
            Continuing Education
        </a>
    </div>
    
    <?php else: // patient ?>
    <!-- Patient Section -->
    <div class="nav-section">
        <div class="nav-section-title">My Wellness Journey</div>
        <a href="<?= $base_path; ?>sections/my-sessions.php" class="nav-link">
            <i class="fas fa-heart"></i>
            My Sessions
        </a>
        <a href="<?= $base_path; ?>sections/progress.php" class="nav-link">
            <i class="fas fa-chart-line"></i>
            Progress Tracking
        </a>
        <a href="<?= $base_path; ?>sections/mood-tracker.php" class="nav-link">
            <i class="fas fa-smile"></i>
            Mood Tracker
        </a>
        <a href="<?= $base_path; ?>sections/goals.php" class="nav-link">
            <i class="fas fa-bullseye"></i>
            My Goals
        </a>
        <a href="<?= $base_path; ?>sections/journal.php" class="nav-link">
            <i class="fas fa-book"></i>
            Personal Journal
        </a>
    </div>
    
    <div class="nav-section">
        <div class="nav-section-title">Wellness Tools</div>
        <a href="<?= $base_path; ?>sections/meditation.php" class="nav-link">
            <i class="fas fa-spa"></i>
            Meditation & Mindfulness
        </a>
        <a href="sections/exercises.php" class="nav-link">
            <i class="fas fa-dumbbell"></i>
            Wellness Exercises
        </a>
        <a href="<?= $base_path; ?>sections/resources.php" class="nav-link">
            <i class="fas fa-book-open"></i>
            Educational Resources
        </a>
        <a href="<?= $base_path; ?>sections/crisis-support.php" class="nav-link">
            <i class="fas fa-phone-alt"></i>
            Crisis Support
        </a>
    </div>
    <?php endif; ?>

    <!-- Account Section -->
    <div class="nav-section">
        <div class="nav-section-title">Account</div>
        <a href="<?= $base_path; ?>profile.php" class="nav-link">
            <i class="fas fa-user"></i>
            My Profile
        </a>
        <!-- <a href="<?= $base_path; ?>settings.php" class="nav-link">
            <i class="fas fa-cog"></i>
            Settings
        </a> -->
        <a href="<?= $base_path; ?>help.php" class="nav-link">
            <i class="fas fa-question-circle"></i>
            Help & Support
        </a>
        <a href="../logout.php" class="nav-link" style="color: #ef4444;">
            <i class="fas fa-sign-out-alt"></i>
            Sign Out
        </a>
    </div>
</div>

<!-- Mobile Overlay -->
<div class="sidebar-overlay d-md-none" id="sidebarOverlay" onclick="toggleSidebar()"></div>
<div class="sidebar-overlay" id="sidebarOverlay"></div>
