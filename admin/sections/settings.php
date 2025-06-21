<?php
session_start();
require_once '../includes/auth.php';

// Check if user is authenticated and is admin
if (!isLoggedIn() || !isAdmin()) {
    header('Location: ../index.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle settings updates
if ($_POST) {
    $action = $_POST['action'] ?? '';
    
    switch ($action) {
        case 'update_general':
            // Handle general settings update
            $message = "General settings updated successfully.";
            logActivity($user_id, 'settings_update', "Updated general system settings");
            break;
        case 'update_email':
            // Handle email settings update
            $message = "Email settings updated successfully.";
            logActivity($user_id, 'settings_update', "Updated email settings");
            break;
        case 'update_security':
            // Handle security settings update
            $message = "Security settings updated successfully.";
            logActivity($user_id, 'settings_update', "Updated security settings");
            break;
    }
}
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
                <h2>System Settings</h2>
                <button class="btn btn-outline-custom" onclick="backupSettings()">
                    <i class="fas fa-download me-2"></i>Backup Settings
                </button>
            </div>

            <?php if (isset($message)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="row">
                <!-- General Settings -->
                <div class="col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="fas fa-cog me-2" style="color: #A8C3A4;"></i>
                                General Settings
                            </h5>
                            <form method="POST">
                                <input type="hidden" name="action" value="update_general">
                                
                                <div class="mb-3">
                                    <label class="form-label">Platform Name</label>
                                    <input type="text" class="form-control" value="Luna Mental Wellness" name="platform_name">
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Support Email</label>
                                    <input type="email" class="form-control" value="support@luna.com" name="support_email">
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Timezone</label>
                                    <select class="form-select" name="timezone">
                                        <option value="UTC">UTC</option>
                                        <option value="America/New_York" selected>Eastern Time</option>
                                        <option value="America/Chicago">Central Time</option>
                                        <option value="America/Denver">Mountain Time</option>
                                        <option value="America/Los_Angeles">Pacific Time</option>
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="maintenanceMode" name="maintenance_mode">
                                        <label class="form-check-label" for="maintenanceMode">
                                            Maintenance Mode
                                        </label>
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn btn-primary-custom">Save General Settings</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Email Settings -->
                <div class="col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="fas fa-envelope me-2" style="color: #4CAF50;"></i>
                                Email Settings
                            </h5>
                            <form method="POST">
                                <input type="hidden" name="action" value="update_email">
                                
                                <div class="mb-3">
                                    <label class="form-label">SMTP Host</label>
                                    <input type="text" class="form-control" value="smtp.gmail.com" name="smtp_host">
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">SMTP Port</label>
                                    <input type="number" class="form-control" value="587" name="smtp_port">
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">SMTP Username</label>
                                    <input type="text" class="form-control" value="noreply@luna.com" name="smtp_username">
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">SMTP Password</label>
                                    <input type="password" class="form-control" placeholder="••••••••" name="smtp_password">
                                </div>
                                
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="emailNotifications" name="email_notifications" checked>
                                        <label class="form-check-label" for="emailNotifications">
                                            Enable Email Notifications
                                        </label>
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn btn-primary-custom">Save Email Settings</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Security Settings -->
                <div class="col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="fas fa-shield-alt me-2" style="color: #f44336;"></i>
                                Security Settings
                            </h5>
                            <form method="POST">
                                <input type="hidden" name="action" value="update_security">
                                
                                <div class="mb-3">
                                    <label class="form-label">Session Timeout (minutes)</label>
                                    <input type="number" class="form-control" value="30" name="session_timeout">
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Max Login Attempts</label>
                                    <input type="number" class="form-control" value="5" name="max_login_attempts">
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Password Min Length</label>
                                    <input type="number" class="form-control" value="8" name="password_min_length">
                                </div>
                                
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="twoFactorAuth" name="two_factor_auth">
                                        <label class="form-check-label" for="twoFactorAuth">
                                            Require Two-Factor Authentication
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="forcePasswordChange" name="force_password_change" checked>
                                        <label class="form-check-label" for="forcePasswordChange">
                                            Force Password Change Every 90 Days
                                        </label>
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn btn-primary-custom">Save Security Settings</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Backup & Maintenance -->
                <div class="col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="fas fa-database me-2" style="color: #FF9800;"></i>
                                Backup & Maintenance
                            </h5>
                            
                            <div class="mb-3">
                                <label class="form-label">Last Backup</label>
                                <p class="text-muted">December 15, 2024 at 3:00 AM</p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Backup Frequency</label>
                                <select class="form-select">
                                    <option value="daily" selected>Daily</option>
                                    <option value="weekly">Weekly</option>
                                    <option value="monthly">Monthly</option>
                                </select>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button class="btn btn-outline-primary" onclick="createBackup()">
                                    <i class="fas fa-save me-2"></i>Create Backup Now
                                </button>
                                <button class="btn btn-outline-warning" onclick="clearCache()">
                                    <i class="fas fa-broom me-2"></i>Clear System Cache
                                </button>
                                <button class="btn btn-outline-info" onclick="optimizeDatabase()">
                                    <i class="fas fa-tools me-2"></i>Optimize Database
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Information -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-info-circle me-2" style="color: #2196F3;"></i>
                        System Information
                    </h5>
                    <div class="row">
                        <div class="col-md-3">
                            <strong>Platform Version:</strong>
                            <p class="text-muted">Luna v2.1.0</p>
                        </div>
                        <div class="col-md-3">
                            <strong>PHP Version:</strong>
                            <p class="text-muted"><?php echo phpversion(); ?></p>
                        </div>
                        <div class="col-md-3">
                            <strong>Database:</strong>
                            <p class="text-muted">MySQL 8.0</p>
                        </div>
                        <div class="col-md-3">
                            <strong>Server:</strong>
                            <p class="text-muted"><?php echo $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown'; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function backupSettings() {
            window.location.href = 'backup-settings.php';
        }

        function createBackup() {
            if (confirm('Create a full system backup? This may take several minutes.')) {
                // Implement backup functionality
                alert('Backup process started. You will be notified when complete.');
            }
        }

        function clearCache() {
            if (confirm('Clear all system cache? This may temporarily slow down the system.')) {
                // Implement cache clearing
                alert('System cache cleared successfully.');
            }
        }

        function optimizeDatabase() {
            if (confirm('Optimize database tables? This may take a few minutes.')) {
                // Implement database optimization
                alert('Database optimization started.');
            }
        }
    </script>

    <?php include '../templates/footer.php'; ?>
</body>
</html>
