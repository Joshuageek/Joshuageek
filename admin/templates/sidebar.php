<?php
$current_page = basename($_SERVER['PHP_SELF']);
$user_role = getUserRole();
?>

<!-- Sidebar -->
<nav class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <a href="index.php" class="logo">
            <div class="logo-icon">
                <i class="fas fa-shield-alt"></i>
            </div>
            <div>
                <span class="logo-text">Luna</span>
                <span class="admin-badge"><?php echo strtoupper($user_role); ?></span>
            </div>
        </a>
    </div>
    
    <ul class="nav-menu">
        <li class="nav-item">
            <a href="index.php" class="nav-link <?php echo $current_page === 'index.php' ? 'active' : ''; ?>">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>
        
        <?php if ($user_role === 'admin'): ?>
            <!-- User Management Section -->
            <li class="nav-item">
                <a href="sections/all-users.php" class="nav-link">
                    <i class="fas fa-users"></i>
                    <span>All Users</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="sections/therapists.php" class="nav-link">
                    <i class="fas fa-user-md"></i>
                    <span>Therapists</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="sections/patients.php" class="nav-link">
                    <i class="fas fa-user-injured"></i>
                    <span>Patients</span>
                </a>
            </li>
            
            <!-- Booking & Session Management -->
            <li class="nav-item">
                <a href="sections/bookings.php" class="nav-link">
                    <i class="fas fa-calendar"></i>
                    <span>All Bookings</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="sections/sessions.php" class="nav-link">
                    <i class="fas fa-video"></i>
                    <span>Sessions</span>
                </a>
            </li>
            
            <!-- Assessment & Reports -->
            <li class="nav-item">
                <a href="sections/questionnaires.php" class="nav-link">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Questionnaires</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="sections/reports.php" class="nav-link">
                    <i class="fas fa-chart-bar"></i>
                    <span>Reports & Analytics</span>
                </a>
            </li>
            
            <!-- System Management -->
            <li class="nav-item">
                <a href="sections/activity-logs.php" class="nav-link">
                    <i class="fas fa-history"></i>
                    <span>Activity Logs</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="sections/settings.php" class="nav-link">
                    <i class="fas fa-cog"></i>
                    <span>System Settings</span>
                </a>
            </li>
            
        <?php elseif ($user_role === 'therapist'): ?>
            <li class="nav-item">
                <a href="sections/my-patients.php" class="nav-link">
                    <i class="fas fa-users"></i>
                    <span>My Patients</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="sections/appointments.php" class="nav-link">
                    <i class="fas fa-calendar"></i>
                    <span>Appointments</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="sections/sessions.php" class="nav-link">
                    <i class="fas fa-video"></i>
                    <span>My Sessions</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="sections/patient-assessments.php" class="nav-link">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Patient Assessments</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="sections/treatment-plans.php" class="nav-link">
                    <i class="fas fa-file-medical"></i>
                    <span>Treatment Plans</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="sections/notes.php" class="nav-link">
                    <i class="fas fa-sticky-note"></i>
                    <span>Session Notes</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="sections/profile.php" class="nav-link">
                    <i class="fas fa-user"></i>
                    <span>My Profile</span>
                </a>
            </li>
            
        <?php else: // patient ?>
            <li class="nav-item">
                <a href="sections/my-appointments.php" class="nav-link">
                    <i class="fas fa-calendar"></i>
                    <span>My Appointments</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="sections/my-sessions.php" class="nav-link">
                    <i class="fas fa-video"></i>
                    <span>My Sessions</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="sections/my-assessments.php" class="nav-link">
                    <i class="fas fa-clipboard-list"></i>
                    <span>My Assessments</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="sections/my-progress.php" class="nav-link">
                    <i class="fas fa-chart-line"></i>
                    <span>My Progress</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="sections/resources.php" class="nav-link">
                    <i class="fas fa-book"></i>
                    <span>Resources</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="sections/profile.php" class="nav-link">
                    <i class="fas fa-user"></i>
                    <span>My Profile</span>
                </a>
            </li>
        <?php endif; ?>
        
        <li class="nav-item mt-auto">
            <a href="../logout.php" class="nav-link">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </li>
    </ul>
</nav>
