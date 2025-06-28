<?php
session_start();
require_once __DIR__ . '/../includes/auth.php';

if (!isLoggedIn() || getUserRole() !== 'admin') {
    header('Location: ../index.php');
    exit();
}

// Sample system settings
$system_settings = [
    'site_name' => 'Luna Mental Wellness',
    'site_description' => 'Professional therapy platform for mental health care',
    'admin_email' => 'admin@luna.com',
    'timezone' => 'America/New_York',
    'date_format' => 'M j, Y',
    'time_format' => '12',
    'session_timeout' => '30',
    'max_file_size' => '10',
    'backup_frequency' => 'daily',
    'maintenance_mode' => false
];

$notification_settings = [
    'email_notifications' => true,
    'sms_notifications' => false,
    'push_notifications' => true,
    'appointment_reminders' => true,
    'payment_notifications' => true,
    'system_alerts' => true
];

$security_settings = [
    'two_factor_auth' => true,
    'password_expiry' => '90',
    'login_attempts' => '5',
    'session_security' => 'high',
    'ip_whitelist' => false,
    'audit_logging' => true
];

$integration_settings = [
    'stripe_enabled' => true,
    'paypal_enabled' => false,
    'zoom_integration' => true,
    'google_calendar' => true,
    'email_service' => 'sendgrid',
    'sms_service' => 'twilio'
];
?>

<!DOCTYPE html>
<html lang="en">
<?php include '../templates/header.php'; ?>
<body>
    <?php include '../templates/sidebar.php'; ?>
    
    <div class="main-content">
        <div class="top-bar">
            <div class="page-info d-flex align-items-center">
                <button class="btn me-3" id="sidebarToggle" style="background: var(--luna-primary); color: white; border-radius: 8px;">
                    <i class="fas fa-bars"></i>
                </button>
                <div>
                    <h1 class="page-title">System Settings</h1>
                    <p class="page-subtitle">Configure platform settings and preferences</p>
                </div>
            </div>
            <div class="top-bar-actions">
                <button class="btn btn-outline-secondary me-2" onclick="resetSettings()">
                    <i class="fas fa-undo me-2"></i>Reset to Default
                </button>
                <button class="btn btn-luna-primary" onclick="saveAllSettings()">
                    <i class="fas fa-save me-2"></i>Save All Changes
                </button>
            </div>
        </div>
        
        <div class="container-fluid p-4">
            <div class="row">
                <!-- Settings Navigation -->
                <div class="col-lg-3 mb-4">
                    <div class="stat-card">
                        <h6 class="mb-3">Settings Categories</h6>
                        <div class="nav flex-column nav-pills" id="settings-nav">
                            <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#general-settings">
                                <i class="fas fa-cog me-2"></i>General
                            </button>
                            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#notification-settings">
                                <i class="fas fa-bell me-2"></i>Notifications
                            </button>
                            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#security-settings">
                                <i class="fas fa-shield-alt me-2"></i>Security
                            </button>
                            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#integration-settings">
                                <i class="fas fa-plug me-2"></i>Integrations
                            </button>
                            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#backup-settings">
                                <i class="fas fa-database me-2"></i>Backup & Recovery
                            </button>
                            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#email-settings">
                                <i class="fas fa-envelope me-2"></i>Email Configuration
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Settings Content -->
                <div class="col-lg-9">
                    <div class="tab-content">
                        <!-- General Settings -->
                        <div class="tab-pane fade show active" id="general-settings">
                            <div class="stat-card">
                                <h5 class="mb-4">
                                    <i class="fas fa-cog text-primary me-2"></i>
                                    General Settings
                                </h5>
                                <form id="generalSettingsForm">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Site Name</label>
                                            <input type="text" class="form-control" name="site_name" value="<?php echo $system_settings['site_name']; ?>">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Admin Email</label>
                                            <input type="email" class="form-control" name="admin_email" value="<?php echo $system_settings['admin_email']; ?>">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Site Description</label>
                                        <textarea class="form-control" name="site_description" rows="3"><?php echo $system_settings['site_description']; ?></textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Timezone</label>
                                            <select class="form-select" name="timezone">
                                                <option value="America/New_York" <?php echo $system_settings['timezone'] === 'America/New_York' ? 'selected' : ''; ?>>Eastern Time</option>
                                                <option value="America/Chicago">Central Time</option>
                                                <option value="America/Denver">Mountain Time</option>
                                                <option value="America/Los_Angeles">Pacific Time</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Date Format</label>
                                            <select class="form-select" name="date_format">
                                                <option value="M j, Y" <?php echo $system_settings['date_format'] === 'M j, Y' ? 'selected' : ''; ?>>Jun 25, 2024</option>
                                                <option value="Y-m-d">2024-06-25</option>
                                                <option value="d/m/Y">25/06/2024</option>
                                                <option value="m/d/Y">06/25/2024</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Time Format</label>
                                            <select class="form-select" name="time_format">
                                                <option value="12" <?php echo $system_settings['time_format'] === '12' ? 'selected' : ''; ?>>12 Hour (2:30 PM)</option>
                                                <option value="24">24 Hour (14:30)</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Session Timeout (minutes)</label>
                                            <input type="number" class="form-control" name="session_timeout" value="<?php echo $system_settings['session_timeout']; ?>">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Max File Upload Size (MB)</label>
                                            <input type="number" class="form-control" name="max_file_size" value="<?php echo $system_settings['max_file_size']; ?>">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Backup Frequency</label>
                                            <select class="form-select" name="backup_frequency">
                                                <option value="daily" <?php echo $system_settings['backup_frequency'] === 'daily' ? 'selected' : ''; ?>>Daily</option>
                                                <option value="weekly">Weekly</option>
                                                <option value="monthly">Monthly</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="maintenance_mode" <?php echo $system_settings['maintenance_mode'] ? 'checked' : ''; ?>>
                                            <label class="form-check-label">
                                                Maintenance Mode
                                                <small class="text-muted d-block">Temporarily disable access for maintenance</small>
                                            </label>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Notification Settings -->
                        <div class="tab-pane fade" id="notification-settings">
                            <div class="stat-card">
                                <h5 class="mb-4">
                                    <i class="fas fa-bell text-warning me-2"></i>
                                    Notification Settings
                                </h5>
                                <form id="notificationSettingsForm">
                                    <div class="mb-4">
                                        <h6>Global Notification Preferences</h6>
                                        <div class="form-check form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" name="email_notifications" <?php echo $notification_settings['email_notifications'] ? 'checked' : ''; ?>>
                                            <label class="form-check-label">
                                                Email Notifications
                                                <small class="text-muted d-block">Send notifications via email</small>
                                            </label>
                                        </div>
                                        <div class="form-check form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" name="sms_notifications" <?php echo $notification_settings['sms_notifications'] ? 'checked' : ''; ?>>
                                            <label class="form-check-label">
                                                SMS Notifications
                                                <small class="text-muted d-block">Send notifications via SMS</small>
                                            </label>
                                        </div>
                                        <div class="form-check form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" name="push_notifications" <?php echo $notification_settings['push_notifications'] ? 'checked' : ''; ?>>
                                            <label class="form-check-label">
                                                Push Notifications
                                                <small class="text-muted d-block">Browser push notifications</small>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <h6>Specific Notification Types</h6>
                                        <div class="form-check form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" name="appointment_reminders" <?php echo $notification_settings['appointment_reminders'] ? 'checked' : ''; ?>>
                                            <label class="form-check-label">
                                                Appointment Reminders
                                                <small class="text-muted d-block">Automatic reminders for upcoming appointments</small>
                                            </label>
                                        </div>
                                        <div class="form-check form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" name="payment_notifications" <?php echo $notification_settings['payment_notifications'] ? 'checked' : ''; ?>>
                                            <label class="form-check-label">
                                                Payment Notifications
                                                <small class="text-muted d-block">Payment confirmations and reminders</small>
                                            </label>
                                        </div>
                                        <div class="form-check form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" name="system_alerts" <?php echo $notification_settings['system_alerts'] ? 'checked' : ''; ?>>
                                            <label class="form-check-label">
                                                System Alerts
                                                <small class="text-muted d-block">Critical system notifications</small>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Reminder Time (hours before)</label>
                                            <select class="form-select" name="reminder_time">
                                                <option value="1">1 Hour</option>
                                                <option value="2">2 Hours</option>
                                                <option value="24" selected>24 Hours</option>
                                                <option value="48">48 Hours</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Quiet Hours</label>
                                            <div class="d-flex gap-2">
                                                <input type="time" class="form-control" name="quiet_start" value="22:00">
                                                <span class="align-self-center">to</span>
                                                <input type="time" class="form-control" name="quiet_end" value="08:00">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Security Settings -->
                        <div class="tab-pane fade" id="security-settings">
                            <div class="stat-card">
                                <h5 class="mb-4">
                                    <i class="fas fa-shield-alt text-danger me-2"></i>
                                    Security Settings
                                </h5>
                                <form id="securitySettingsForm">
                                    <div class="mb-4">
                                        <h6>Authentication</h6>
                                        <div class="form-check form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" name="two_factor_auth" <?php echo $security_settings['two_factor_auth'] ? 'checked' : ''; ?>>
                                            <label class="form-check-label">
                                                Two-Factor Authentication
                                                <small class="text-muted d-block">Require 2FA for all admin accounts</small>
                                            </label>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Password Expiry (days)</label>
                                                <input type="number" class="form-control" name="password_expiry" value="<?php echo $security_settings['password_expiry']; ?>">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Max Login Attempts</label>
                                                <input type="number" class="form-control" name="login_attempts" value="<?php echo $security_settings['login_attempts']; ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <h6>Session Security</h6>
                                        <div class="mb-3">
                                            <label class="form-label">Session Security Level</label>
                                            <select class="form-select" name="session_security">
                                                <option value="low">Low - Basic security</option>
                                                <option value="medium">Medium - Standard security</option>
                                                <option value="high" <?php echo $security_settings['session_security'] === 'high' ? 'selected' : ''; ?>>High - Enhanced security</option>
                                            </select>
                                        </div>
                                        <div class="form-check form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" name="ip_whitelist" <?php echo $security_settings['ip_whitelist'] ? 'checked' : ''; ?>>
                                            <label class="form-check-label">
                                                IP Whitelist
                                                <small class="text-muted d-block">Restrict access to specific IP addresses</small>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <h6>Audit & Logging</h6>
                                        <div class="form-check form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" name="audit_logging" <?php echo $security_settings['audit_logging'] ? 'checked' : ''; ?>>
                                            <label class="form-check-label">
                                                Audit Logging
                                                <small class="text-muted d-block">Log all user actions and system events</small>
                                            </label>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Log Retention (days)</label>
                                            <input type="number" class="form-control" name="log_retention" value="365">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Integration Settings -->
                        <div class="tab-pane fade" id="integration-settings">
                            <div class="stat-card">
                                <h5 class="mb-4">
                                    <i class="fas fa-plug text-info me-2"></i>
                                    Third-Party Integrations
                                </h5>
                                <form id="integrationSettingsForm">
                                    <div class="mb-4">
                                        <h6>Payment Gateways</h6>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="integration-card">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="d-flex align-items-center">
                                                            <i class="fab fa-stripe fa-2x text-primary me-3"></i>
                                                            <div>
                                                                <h6 class="mb-0">Stripe</h6>
                                                                <small class="text-muted">Payment processing</small>
                                                            </div>
                                                        </div>
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" name="stripe_enabled" <?php echo $integration_settings['stripe_enabled'] ? 'checked' : ''; ?>>
                                                        </div>
                                                    </div>
                                                    <div class="mt-3">
                                                        <input type="text" class="form-control" placeholder="Stripe API Key" name="stripe_key">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="integration-card">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="d-flex align-items-center">
                                                            <i class="fab fa-paypal fa-2x text-primary me-3"></i>
                                                            <div>
                                                                <h6 class="mb-0">PayPal</h6>
                                                                <small class="text-muted">Payment processing</small>
                                                            </div>
                                                        </div>
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" name="paypal_enabled" <?php echo $integration_settings['paypal_enabled'] ? 'checked' : ''; ?>>
                                                        </div>
                                                    </div>
                                                    <div class="mt-3">
                                                        <input type="text" class="form-control" placeholder="PayPal Client ID" name="paypal_client_id">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <h6>Video Conferencing</h6>
                                        <div class="integration-card">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-video fa-2x text-primary me-3"></i>
                                                    <div>
                                                        <h6 class="mb-0">Zoom Integration</h6>
                                                        <small class="text-muted">Video therapy sessions</small>
                                                    </div>
                                                </div>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="zoom_integration" <?php echo $integration_settings['zoom_integration'] ? 'checked' : ''; ?>>
                                                </div>
                                            </div>
                                            <div class="mt-3 row">
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control" placeholder="Zoom API Key" name="zoom_api_key">
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control" placeholder="Zoom API Secret" name="zoom_api_secret">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <h6>Calendar Integration</h6>
                                        <div class="integration-card">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <i class="fab fa-google fa-2x text-danger me-3"></i>
                                                    <div>
                                                        <h6 class="mb-0">Google Calendar</h6>
                                                        <small class="text-muted">Sync appointments</small>
                                                    </div>
                                                </div>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="google_calendar" <?php echo $integration_settings['google_calendar'] ? 'checked' : ''; ?>>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Backup Settings -->
                        <div class="tab-pane fade" id="backup-settings">
                            <div class="stat-card">
                                <h5 class="mb-4">
                                    <i class="fas fa-database text-success me-2"></i>
                                    Backup & Recovery
                                </h5>
                                <div class="mb-4">
                                    <h6>Automatic Backups</h6>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Backup Frequency</label>
                                            <select class="form-select" name="backup_frequency">
                                                <option value="daily" selected>Daily</option>
                                                <option value="weekly">Weekly</option>
                                                <option value="monthly">Monthly</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Backup Time</label>
                                            <input type="time" class="form-control" name="backup_time" value="02:00">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Retention Period (days)</label>
                                        <input type="number" class="form-control" name="backup_retention" value="30">
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <h6>Manual Backup</h6>
                                    <p class="text-muted">Create an immediate backup of all system data</p>
                                    <button class="btn btn-outline-primary" onclick="createBackup()">
                                        <i class="fas fa-download me-2"></i>Create Backup Now
                                    </button>
                                </div>

                                <div class="mb-4">
                                    <h6>Recent Backups</h6>
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Type</th>
                                                    <th>Size</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Jun 25, 2024 02:00</td>
                                                    <td>Automatic</td>
                                                    <td>245 MB</td>
                                                    <td><span class="badge bg-success">Success</span></td>
                                                    <td>
                                                        <button class="btn btn-sm btn-outline-primary">Download</button>
                                                        <button class="btn btn-sm btn-outline-success">Restore</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Jun 24, 2024 02:00</td>
                                                    <td>Automatic</td>
                                                    <td>243 MB</td>
                                                    <td><span class="badge bg-success">Success</span></td>
                                                    <td>
                                                        <button class="btn btn-sm btn-outline-primary">Download</button>
                                                        <button class="btn btn-sm btn-outline-success">Restore</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Email Settings -->
                        <div class="tab-pane fade" id="email-settings">
                            <div class="stat-card">
                                <h5 class="mb-4">
                                    <i class="fas fa-envelope text-primary me-2"></i>
                                    Email Configuration
                                </h5>
                                <form id="emailSettingsForm">
                                    <div class="mb-4">
                                        <h6>SMTP Configuration</h6>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">SMTP Host</label>
                                                <input type="text" class="form-control" name="smtp_host" value="smtp.sendgrid.net">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">SMTP Port</label>
                                                <input type="number" class="form-control" name="smtp_port" value="587">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">SMTP Username</label>
                                                <input type="text" class="form-control" name="smtp_username">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">SMTP Password</label>
                                                <input type="password" class="form-control" name="smtp_password">
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Encryption</label>
                                            <select class="form-select" name="smtp_encryption">
                                                <option value="tls" selected>TLS</option>
                                                <option value="ssl">SSL</option>
                                                <option value="none">None</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <h6>Email Templates</h6>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">From Name</label>
                                                <input type="text" class="form-control" name="from_name" value="Luna Mental Wellness">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">From Email</label>
                                                <input type="email" class="form-control" name="from_email" value="noreply@luna.com">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <h6>Test Email</h6>
                                        <p class="text-muted">Send a test email to verify your configuration</p>
                                        <div class="d-flex gap-2">
                                            <input type="email" class="form-control" placeholder="Test email address" id="testEmail">
                                            <button type="button" class="btn btn-outline-primary" onclick="sendTestEmail()">
                                                <i class="fas fa-paper-plane me-2"></i>Send Test
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include '../templates/footer.php'; ?>
    <script src="../assets/js/simple-luna.js"></script>
    
    <script>
        function saveAllSettings() {
            showToast('All settings saved successfully!', 'success');
        }

        function resetSettings() {
            if (confirm('Are you sure you want to reset all settings to default values?')) {
                showToast('Settings reset to default values', 'info');
            }
        }

        function createBackup() {
            showToast('Creating backup... This may take a few minutes.', 'info');
            // Simulate backup progress
            setTimeout(() => {
                showToast('Backup created successfully!', 'success');
            }, 3000);
        }

        function sendTestEmail() {
            const email = document.getElementById('testEmail').value;
            if (!email) {
                showToast('Please enter a test email address', 'warning');
                return;
            }
            showToast(`Test email sent to ${email}`, 'success');
        }

        // Auto-save functionality
        document.addEventListener('change', function(e) {
            if (e.target.type === 'checkbox' || e.target.type === 'select-one') {
                console.log('Setting changed:', e.target.name, e.target.value || e.target.checked);
            }
        });
    </script>

    <style>
        .nav-pills .nav-link {
            color: var(--luna-gray);
            border-radius: 8px;
            margin-bottom: 0.5rem;
            padding: 0.75rem 1rem;
            text-align: left;
        }

        .nav-pills .nav-link.active {
            background-color: var(--luna-primary);
            color: white;
        }

        .nav-pills .nav-link:hover:not(.active) {
            background-color: var(--luna-light);
        }

        .integration-card {
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
            background: #f8f9fa;
        }

        .form-check-input:checked {
            background-color: var(--luna-primary);
            border-color: var(--luna-primary);
        }

        .tab-content {
            min-height: 600px;
        }
    </style>
</body>
</html>
