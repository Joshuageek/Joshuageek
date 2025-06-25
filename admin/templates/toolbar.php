<?php
$user_name = $_SESSION['user_name'] ?? 'User';
$user_role = getUserRole();
$current_time = date('l, F j, Y');
$hour = date('H');
$greeting = $hour < 12 ? 'Good morning' : ($hour < 17 ? 'Good afternoon' : 'Good evening');
?>

<!-- Professional Top Bar -->
<div class="top-bar">
    <div class="page-info d-flex align-items-center">
        <!-- Toggle button positioned to the left of greeting -->
        <button class="btn me-3" id="sidebarToggle" style="background: var(--luna-primary); color: white; border-radius: 8px;">
            <i class="fas fa-bars"></i>
        </button>
        <div>
            <h1 class="page-title"><?php echo $greeting; ?>, <?php echo htmlspecialchars($user_name); ?>!</h1>
            <p class="page-subtitle">
                <?php echo $current_time; ?> • 
                <?php if ($user_role === 'admin'): ?>
                    System Administration Dashboard
                <?php elseif ($user_role === 'therapist'): ?>
                    Practice Management Dashboard
                <?php else: ?>
                    Personal Wellness Dashboard
                <?php endif; ?>
            </p>
        </div>
    </div>

    <div class="top-bar-actions">
        <!-- Search -->
        <div class="search-box d-none d-xl-block">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Search patients, sessions, notes..." id="globalSearch">
        </div>
        
        <!-- Quick Actions -->
        <div class="dropdown">
            <button class="notification-btn" data-bs-toggle="dropdown">
                <i class="fas fa-plus"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <?php if ($user_role === 'admin'): ?>
                    <li><a class="dropdown-item" href="sections/add-user.php">
                        <i class="fas fa-user-plus me-2"></i>Add New User
                    </a></li>
                    <li><a class="dropdown-item" href="sections/add-therapist.php">
                        <i class="fas fa-user-md me-2"></i>Add Therapist
                    </a></li>
                    <li><a class="dropdown-item" href="sections/system-backup.php">
                        <i class="fas fa-database me-2"></i>System Backup
                    </a></li>
                <?php elseif ($user_role === 'therapist'): ?>
                    <li><a class="dropdown-item" href="sections/new-session.php">
                        <i class="fas fa-video me-2"></i>Schedule Session
                    </a></li>
                    <li><a class="dropdown-item" href="sections/add-note.php">
                        <i class="fas fa-sticky-note me-2"></i>Add Session Note
                    </a></li>
                    <li><a class="dropdown-item" href="sections/new-assessment.php">
                        <i class="fas fa-clipboard-check me-2"></i>Create Assessment
                    </a></li>
                <?php else: ?>
                    <li><a class="dropdown-item" href="sections/book-session.php">
                        <i class="fas fa-calendar-plus me-2"></i>Book Session
                    </a></li>
                    <li><a class="dropdown-item" href="sections/mood-entry.php">
                        <i class="fas fa-smile me-2"></i>Log Mood
                    </a></li>
                    <li><a class="dropdown-item" href="sections/journal-entry.php">
                        <i class="fas fa-pen me-2"></i>Journal Entry
                    </a></li>
                <?php endif; ?>
            </ul>
        </div>
        
        <!-- Notifications -->
        <div class="dropdown">
            <button class="notification-btn" data-bs-toggle="dropdown">
                <i class="fas fa-bell"></i>
                <span class="notification-badge">5</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" style="width: 350px;">
                <li class="dropdown-header d-flex justify-content-between align-items-center">
                    <span>Notifications</span>
                    <small><a href="#" class="text-decoration-none">Mark all read</a></small>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <div class="bg-success rounded-circle p-2">
                                <i class="fas fa-calendar text-white small"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="fw-semibold">New appointment request</div>
                            <div class="small text-muted">Sarah Johnson wants to schedule a session</div>
                            <div class="small text-muted">2 minutes ago</div>
                        </div>
                    </div>
                </a></li>
                <li><a class="dropdown-item" href="#">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <div class="bg-primary rounded-circle p-2">
                                <i class="fas fa-message text-white small"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="fw-semibold">New message received</div>
                            <div class="small text-muted">Dr. Wilson sent you a message</div>
                            <div class="small text-muted">5 minutes ago</div>
                        </div>
                    </div>
                </a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-center" href="notifications.php">View all notifications</a></li>
            </ul>
        </div>
        
        <!-- User Profile -->
        <div class="dropdown">
            <div class="user-dropdown" data-bs-toggle="dropdown">
                <div class="user-avatar" style="width: 35px; height: 35px; font-size: 0.9rem;">
                    <?php echo strtoupper(substr($user_name, 0, 1)); ?>
                </div>
                <span class="d-none d-lg-inline fw-semibold"><?php echo htmlspecialchars($user_name); ?></span>
                <i class="fas fa-chevron-down small ms-2"></i>
            </div>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="profile.php">
                    <i class="fas fa-user me-2"></i>My Profile
                </a></li>
                <li><a class="dropdown-item" href="settings.php">
                    <i class="fas fa-cog me-2"></i>Account Settings
                </a></li>
                <li><a class="dropdown-item" href="billing.php">
                    <i class="fas fa-credit-card me-2"></i>Billing
                </a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="help.php">
                    <i class="fas fa-question-circle me-2"></i>Help & Support
                </a></li>
                <li><a class="dropdown-item text-danger" href="../logout.php">
                    <i class="fas fa-sign-out-alt me-2"></i>Sign Out
                </a></li>
            </ul>
        </div>
    </div>
</div>
