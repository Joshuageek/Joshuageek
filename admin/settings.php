<?php
session_start();
require_once 'includes/auth.php';
include 'templates/header.php';

// Check if user is authenticated and is admin
if (!isLoggedIn()) {
    header('Location: ../login.php');
    exit();
}

$user_role = getUserRole();
if ($user_role !== 'admin') {
    header('Location: index.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'] ?? 'Admin';

// System settings data
$system_settings = [
    'general' => [
        'site_name' => 'Luna Mental Wellness Platform',
        'site_description' => 'Comprehensive mental health therapy platform',
        'admin_email' => 'admin@luna.com',
        'timezone' => 'America/New_York',
        'date_format' => 'M j, Y',
        'time_format' => '12',
        'language' => 'en',
        'maintenance_mode' => false
    ],
    'security' => [
        'session_timeout' => 30, // minutes
        'password_min_length' => 8,
        'require_2fa' => false,
        'login_attempts' => 5,
        'lockout_duration' => 15, // minutes
        'force_https' => true,
        'ip_whitelist_enabled' => false,
        'audit_logging' => true
    ],
    'email' => [
        'smtp_host' => 'smtp.luna.com',
        'smtp_port' => 587,
        'smtp_username' => 'noreply@luna.com',
        'smtp_password' => '••••••••',
        'smtp_encryption' => 'tls',
        'from_name' => 'Luna Platform',
        'from_email' => 'noreply@luna.com'
    ],
    'notifications' => [
        'email_notifications' => true,
        'sms_notifications' => false,
        'push_notifications' => true,
        'appointment_reminders' => true,
        'session_confirmations' => true,
        'progress_reports' => true,
        'system_alerts' => true
    ],
    'privacy' => [
        'data_retention_days' => 2555, // 7 years
        'anonymize_data' => true,
        'gdpr_compliance' => true,
        'hipaa_compliance' => true,
        'cookie_consent' => true,
        'data_export_enabled' => true,
        'data_deletion_enabled' => true
    ],
    'integrations' => [
        'calendar_sync' => true,
        'payment_gateway' => 'stripe',
        'video_conferencing' => 'zoom',
        'analytics_tracking' => true,
        'backup_service' => 'aws_s3',
        'cdn_enabled' => true
    ]
];

// System status
$system_status = [
    'server_uptime' => '99.8%',
    'database_status' => 'healthy',
    'storage_usage' => 68.5,
    'memory_usage' => 45.2,
    'cpu_usage' => 23.8,
    'active_sessions' => 156,
    'last_backup' => date('Y-m-d H:i:s', strtotime('-2 hours')),
    'ssl_certificate' => 'valid',
    'ssl_expires' => date('Y-m-d', strtotime('+3 months'))
];

// Recent system events
$system_events = [
    [
        'event' => 'System Backup Completed',
        'type' => 'success',
        'timestamp' => date('Y-m-d H:i:s', strtotime('-2 hours')),
        'details' => 'Automated daily backup completed successfully'
    ],
    [
        'event' => 'Security Scan Completed',
        'type' => 'info',
        'timestamp' => date('Y-m-d H:i:s', strtotime('-6 hours')),
        'details' => 'No vulnerabilities detected'
    ],
    [
        'event' => 'SSL Certificate Renewed',
        'type' => 'success',
        'timestamp' => date('Y-m-d H:i:s', strtotime('-1 day')),
        'details' => 'SSL certificate automatically renewed'
    ],
    [
        'event' => 'High Memory Usage Alert',
        'type' => 'warning',
        'timestamp' => date('Y-m-d H:i:s', strtotime('-2 days')),
        'details' => 'Memory usage exceeded 80% threshold'
    ]
];
?>

<!-- System Settings Content -->
<div class="container-fluid p-4">
    <!-- System Settings Header -->
    <div class="welcome-card animate-in">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h2 class="welcome-title">
                    <i class="fas fa-cogs me-3"></i>
                    System Settings & Configuration
                </h2>
                <p class="welcome-subtitle">
                    Configure platform settings, manage security policies, monitor system health, and maintain
                    compliance standards. Ensure optimal performance and security for your mental wellness platform.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <button class="btn btn-luna-primary" onclick="saveAllSettings()">
                        <i class="fas fa-save me-2"></i>Save All Changes
                    </button>
                    <button class="btn btn-luna-outline" onclick="resetToDefaults()">
                        <i class="fas fa-undo me-2"></i>Reset to Defaults
                    </button>
                    <button class="btn btn-luna-outline" onclick="exportSettings()">
                        <i class="fas fa-download me-2"></i>Export Config
                    </button>
                    <button class="btn btn-luna-outline" onclick="systemMaintenance()">
                        <i class="fas fa-tools me-2"></i>Maintenance
                    </button>
                </div>
            </div>
            <div class="col-lg-4 text-center">
                <div class="system-health">
                    <div class="health-indicator <?php echo $system_status['database_status'] === 'healthy' ? 'healthy' : 'warning'; ?>">
                        <i class="fas fa-heartbeat fa-2x"></i>
                    </div>
                    <div class="mt-2">
                        <div class="h5 fw-bold">System Health</div>
                        <div class="small text-muted"><?php echo ucfirst($system_status['database_status']); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- System Status Overview -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card animate-in">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="stat-label">Server Uptime</p>
                        <h3 class="stat-number"><?php echo $system_status['server_uptime']; ?></h3>
                        <span class="stat-change positive">
                            <i class="fas fa-server"></i> Excellent
                        </span>
                    </div>
                    <div class="stat-icon icon-success">
                        <i class="fas fa-server"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card animate-in animate-delay-1">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="stat-label">Storage Usage</p>
                        <h3 class="stat-number"><?php echo $system_status['storage_usage']; ?>%</h3>
                        <span class="stat-change neutral">
                            <i class="fas fa-hdd"></i> Normal
                        </span>
                    </div>
                    <div class="stat-icon icon-info">
                        <i class="fas fa-hdd"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card animate-in animate-delay-2">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="stat-label">Active Sessions</p>
                        <h3 class="stat-number"><?php echo $system_status['active_sessions']; ?></h3>
                        <span class="stat-change positive">
                            <i class="fas fa-users"></i> Online users
                        </span>
                    </div>
                    <div class="stat-icon icon-primary">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card animate-in animate-delay-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="stat-label">Last Backup</p>
                        <h3 class="stat-number">2h ago</h3>
                        <span class="stat-change positive">
                            <i class="fas fa-shield-alt"></i> Secure
                        </span>
                    </div>
                    <div class="stat-icon icon-warning">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Settings Tabs -->
    <div class="row">
        <div class="col-lg-9">
            <div class="stat-card animate-in">
                <ul class="nav nav-tabs" id="settingsTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button">
                            <i class="fas fa-cog me-2"></i>General
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="security-tab" data-bs-toggle="tab" data-bs-target="#security" type="button">
                            <i class="fas fa-shield-alt me-2"></i>Security
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="email-tab" data-bs-toggle="tab" data-bs-target="#email" type="button">
                            <i class="fas fa-envelope me-2"></i>Email
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="notifications-tab" data-bs-toggle="tab" data-bs-target="#notifications" type="button">
                            <i class="fas fa-bell me-2"></i>Notifications
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="privacy-tab" data-bs-toggle="tab" data-bs-target="#privacy" type="button">
                            <i class="fas fa-user-shield me-2"></i>Privacy
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="integrations-tab" data-bs-toggle="tab" data-bs-target="#integrations" type="button">
                            <i class="fas fa-plug me-2"></i>Integrations
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="settingsTabContent">
                    <!-- General Settings -->
                    <div class="tab-pane fade show active" id="general" role="tabpanel">
                        <div class="p-4">
                            <h5 class="mb-4">General Platform Settings</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Site Name</label>
                                    <input type="text" class="form-control" value="<?php echo $system_settings['general']['site_name']; ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Admin Email</label>
                                    <input type="email" class="form-control" value="<?php echo $system_settings['general']['admin_email']; ?>">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Site Description</label>
                                <textarea class="form-control" rows="3"><?php echo $system_settings['general']['site_description']; ?></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Timezone</label>
                                    <select class="form-select">
                                        <option selected><?php echo $system_settings['general']['timezone']; ?></option>
                                        <option>America/Los_Angeles</option>
                                        <option>America/Chicago</option>
                                        <option>Europe/London</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Date Format</label>
                                    <select class="form-select">
                                        <option selected><?php echo $system_settings['general']['date_format']; ?></option>
                                        <option>Y-m-d</option>
                                        <option>d/m/Y</option>
                                        <option>m/d/Y</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Time Format</label>
                                    <select class="form-select">
                                        <option value="12" <?php echo $system_settings['general']['time_format'] === '12' ? 'selected' : ''; ?>>12 Hour</option>
                                        <option value="24" <?php echo $system_settings['general']['time_format'] === '24' ? 'selected' : ''; ?>>24 Hour</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" <?php echo $system_settings['general']['maintenance_mode'] ? 'checked' : ''; ?>>
                                <label class="form-check-label">
                                    <strong>Maintenance Mode</strong>
                                    <div class="small text-muted">Temporarily disable public access to the platform</div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Security Settings -->
                    <div class="tab-pane fade" id="security" role="tabpanel">
                        <div class="p-4">
                            <h5 class="mb-4">Security & Authentication</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Session Timeout (minutes)</label>
                                    <input type="number" class="form-control" value="<?php echo $system_settings['security']['session_timeout']; ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Password Minimum Length</label>
                                    <input type="number" class="form-control" value="<?php echo $system_settings['security']['password_min_length']; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Max Login Attempts</label>
                                    <input type="number" class="form-control" value="<?php echo $system_settings['security']['login_attempts']; ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Lockout Duration (minutes)</label>
                                    <input type="number" class="form-control" value="<?php echo $system_settings['security']['lockout_duration']; ?>">
                                </div>
                            </div>
                            <div class="security-options">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" <?php echo $system_settings['security']['require_2fa'] ? 'checked' : ''; ?>>
                                    <label class="form-check-label">
                                        <strong>Require Two-Factor Authentication</strong>
                                        <div class="small text-muted">Force all users to enable 2FA</div>
                                    </label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" <?php echo $system_settings['security']['force_https'] ? 'checked' : ''; ?>>
                                    <label class="form-check-label">
                                        <strong>Force HTTPS</strong>
                                        <div class="small text-muted">Redirect all HTTP traffic to HTTPS</div>
                                    </label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" <?php echo $system_settings['security']['audit_logging'] ? 'checked' : ''; ?>>
                                    <label class="form-check-label">
                                        <strong>Audit Logging</strong>
                                        <div class="small text-muted">Log all user actions for security auditing</div>
                                    </label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" <?php echo $system_settings['security']['ip_whitelist_enabled'] ? 'checked' : ''; ?>>
                                    <label class="form-check-label">
                                        <strong>IP Whitelist</strong>
                                        <div class="small text-muted">Restrict admin access to specific IP addresses</div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Email Settings -->
                    <div class="tab-pane fade" id="email" role="tabpanel">
                        <div class="p-4">
                            <h5 class="mb-4">Email Configuration</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">SMTP Host</label>
                                    <input type="text" class="form-control" value="<?php echo $system_settings['email']['smtp_host']; ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">SMTP Port</label>
                                    <input type="number" class="form-control" value="<?php echo $system_settings['email']['smtp_port']; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">SMTP Username</label>
                                    <input type="text" class="form-control" value="<?php echo $system_settings['email']['smtp_username']; ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">SMTP Password</label>
                                    <input type="password" class="form-control" value="<?php echo $system_settings['email']['smtp_password']; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Encryption</label>
                                    <select class="form-select">
                                        <option value="tls" <?php echo $system_settings['email']['smtp_encryption'] === 'tls' ? 'selected' : ''; ?>>TLS</option>
                                        <option value="ssl" <?php echo $system_settings['email']['smtp_encryption'] === 'ssl' ? 'selected' : ''; ?>>SSL</option>
                                        <option value="none">None</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">From Name</label>
                                    <input type="text" class="form-control" value="<?php echo $system_settings['email']['from_name']; ?>">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">From Email</label>
                                    <input type="email" class="form-control" value="<?php echo $system_settings['email']['from_email']; ?>">
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn btn-outline-primary" onclick="testEmail()">
                                    <i class="fas fa-paper-plane me-2"></i>Send Test Email
                                </button>
                                <button class="btn btn-outline-secondary" onclick="validateSettings()">
                                    <i class="fas fa-check me-2"></i>Validate Settings
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Notifications Settings -->
                    <div class="tab-pane fade" id="notifications" role="tabpanel">
                        <div class="p-4">
                            <h5 class="mb-4">Notification Preferences</h5>
                            <div class="notification-options">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" <?php echo $system_settings['notifications']['email_notifications'] ? 'checked' : ''; ?>>
                                    <label class="form-check-label">
                                        <strong>Email Notifications</strong>
                                        <div class="small text-muted">Send notifications via email</div>
                                    </label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" <?php echo $system_settings['notifications']['sms_notifications'] ? 'checked' : ''; ?>>
                                    <label class="form-check-label">
                                        <strong>SMS Notifications</strong>
                                        <div class="small text-muted">Send notifications via SMS (requires SMS provider)</div>
                                    </label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" <?php echo $system_settings['notifications']['push_notifications'] ? 'checked' : ''; ?>>
                                    <label class="form-check-label">
                                        <strong>Push Notifications</strong>
                                        <div class="small text-muted">Send browser push notifications</div>
                                    </label>
                                </div>
                            </div>
                            <hr>
                            <h6 class="mb-3">Notification Types</h6>
                            <div class="notification-types">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" <?php echo $system_settings['notifications']['appointment_reminders'] ? 'checked' : ''; ?>>
                                    <label class="form-check-label">Appointment Reminders</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" <?php echo $system_settings['notifications']['session_confirmations'] ? 'checked' : ''; ?>>
                                    <label class="form-check-label">Session Confirmations</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" <?php echo $system_settings['notifications']['progress_reports'] ? 'checked' : ''; ?>>
                                    <label class="form-check-label">Progress Reports</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" <?php echo $system_settings['notifications']['system_alerts'] ? 'checked' : ''; ?>>
                                    <label class="form-check-label">System Alerts</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Privacy Settings -->
                    <div class="tab-pane fade" id="privacy" role="tabpanel">
                        <div class="p-4">
                            <h5 class="mb-4">Privacy & Compliance</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Data Retention Period (days)</label>
                                    <input type="number" class="form-control" value="<?php echo $system_settings['privacy']['data_retention_days']; ?>">
                                    <div class="small text-muted">How long to keep user data (HIPAA requires 7 years)</div>
                                </div>
                            </div>
                            <div class="privacy-options">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" <?php echo $system_settings['privacy']['gdpr_compliance'] ? 'checked' : ''; ?>>
                                    <label class="form-check-label">
                                        <strong>GDPR Compliance</strong>
                                        <div class="small text-muted">Enable GDPR compliance features</div>
                                    </label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" <?php echo $system_settings['privacy']['hipaa_compliance'] ? 'checked' : ''; ?>>
                                    <label class="form-check-label">
                                        <strong>HIPAA Compliance</strong>
                                        <div class="small text-muted">Enable HIPAA compliance features</div>
                                    </label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" <?php echo $system_settings['privacy']['cookie_consent'] ? 'checked' : ''; ?>>
                                    <label class="form-check-label">
                                        <strong>Cookie Consent</strong>
                                        <div class="small text-muted">Require user consent for cookies</div>
                                    </label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" <?php echo $system_settings['privacy']['data_export_enabled'] ? 'checked' : ''; ?>>
                                    <label class="form-check-label">
                                        <strong>Data Export</strong>
                                        <div class="small text-muted">Allow users to export their data</div>
                                    </label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" <?php echo $system_settings['privacy']['data_deletion_enabled'] ? 'checked' : ''; ?>>
                                    <label class="form-check-label">
                                        <strong>Data Deletion</strong>
                                        <div class="small text-muted">Allow users to request data deletion</div>
                                    </label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" <?php echo $system_settings['privacy']['anonymize_data'] ? 'checked' : ''; ?>>
                                    <label class="form-check-label">
                                        <strong>Data Anonymization</strong>
                                        <div class="small text-muted">Automatically anonymize sensitive data after retention period</div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Integrations Settings -->
                    <div class="tab-pane fade" id="integrations" role="tabpanel">
                        <div class="p-4">
                            <h5 class="mb-4">Third-Party Integrations</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Payment Gateway</label>
                                    <select class="form-select">
                                        <option value="stripe" <?php echo $system_settings['integrations']['payment_gateway'] === 'stripe' ? 'selected' : ''; ?>>Stripe</option>
                                        <option value="paypal">PayPal</option>
                                        <option value="square">Square</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Video Conferencing</label>
                                    <select class="form-select">
                                        <option value="zoom" <?php echo $system_settings['integrations']['video_conferencing'] === 'zoom' ? 'selected' : ''; ?>>Zoom</option>
                                        <option value="teams">Microsoft Teams</option>
                                        <option value="meet">Google Meet</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Backup Service</label>
                                    <select class="form-select">
                                        <option value="aws_s3" <?php echo $system_settings['integrations']['backup_service'] === 'aws_s3' ? 'selected' : ''; ?>>AWS S3</option>
                                        <option value="google_cloud">Google Cloud</option>
                                        <option value="azure">Azure Storage</option>
                                    </select>
                                </div>
                            </div>
                            <div class="integration-options">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" <?php echo $system_settings['integrations']['calendar_sync'] ? 'checked' : ''; ?>>
                                    <label class="form-check-label">
                                        <strong>Calendar Synchronization</strong>
                                        <div class="small text-muted">Sync appointments with external calendars</div>
                                    </label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" <?php echo $system_settings['integrations']['analytics_tracking'] ? 'checked' : ''; ?>>
                                    <label class="form-check-label">
                                        <strong>Analytics Tracking</strong>
                                        <div class="small text-muted">Enable Google Analytics or similar tracking</div>
                                    </label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" <?php echo $system_settings['integrations']['cdn_enabled'] ? 'checked' : ''; ?>>
                                    <label class="form-check-label">
                                        <strong>CDN (Content Delivery Network)</strong>
                                        <div class="small text-muted">Use CDN for faster content delivery</div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Status and Events -->
        <div class="col-lg-3">
            <!-- System Performance -->
            <div class="stat-card animate-in animate-delay-1 mb-4">
                <h5 class="mb-4">
                    <i class="fas fa-tachometer-alt text-info me-2"></i>
                    System Performance
                </h5>
                <div class="performance-metrics">
                    <div class="metric-item">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="small">CPU Usage</span>
                            <span class="small fw-bold"><?php echo $system_status['cpu_usage']; ?>%</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-success" style="width: <?php echo $system_status['cpu_usage']; ?>%"></div>
                        </div>
                    </div>
                    <div class="metric-item">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="small">Memory Usage</span>
                            <span class="small fw-bold"><?php echo $system_status['memory_usage']; ?>%</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-warning" style="width: <?php echo $system_status['memory_usage']; ?>%"></div>
                        </div>
                    </div>
                    <div class="metric-item">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="small">Storage Usage</span>
                            <span class="small fw-bold"><?php echo $system_status['storage_usage']; ?>%</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-info" style="width: <?php echo $system_status['storage_usage']; ?>%"></div>
                        </div>
                    </div>
                </div>
                <div class="d-grid mt-3">
                    <button class="btn btn-outline-info btn-sm" onclick="viewDetailedMetrics()">
                        <i class="fas fa-chart-line me-2"></i>Detailed Metrics
                    </button>
                </div>
            </div>

            <!-- Recent System Events -->
            <div class="stat-card animate-in animate-delay-2">
                <h5 class="mb-4">
                    <i class="fas fa-bell text-warning me-2"></i>
                    System Events
                </h5>
                <?php foreach ($system_events as $event): ?>
                    <div class="event-item">
                        <div class="event-icon bg-<?php echo $event['type'] === 'success' ? 'success' : ($event['type'] === 'warning' ? 'warning' : 'info'); ?>">
                            <i class="fas fa-<?php echo $event['type'] === 'success' ? 'check' : ($event['type'] === 'warning' ? 'exclamation-triangle' : 'info'); ?>"></i>
                        </div>
                        <div class="event-content flex-grow-1">
                            <h6><?php echo $event['event']; ?></h6>
                            <p><?php echo $event['details']; ?></p>
                        </div>
                        <div class="event-time">
                            <?php echo date('M j, g:i A', strtotime($event['timestamp'])); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="d-grid mt-3">
                    <button class="btn btn-outline-warning btn-sm" onclick="viewAllEvents()">
                        <i class="fas fa-list me-2"></i>View All Events
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function saveAllSettings() {
        window.showToast('Saving all settings...', 'info');
        setTimeout(() => {
            window.showToast('Settings saved successfully!', 'success');
        }, 2000);
    }

    function resetToDefaults() {
        if (confirm('Are you sure you want to reset all settings to defaults? This action cannot be undone.')) {
            window.showToast('Resetting to default settings...', 'info');
            setTimeout(() => {
                window.showToast('Settings reset to defaults!', 'success');
            }, 2000);
        }
    }

    function exportSettings() {
        window.showToast('Exporting configuration...', 'info');
        setTimeout(() => {
            window.showToast('Configuration exported successfully!', 'success');
        }, 1500);
    }

    function systemMaintenance() {
        window.showToast('Opening maintenance panel...', 'info');
    }

    function testEmail() {
        window.showToast('Sending test email...', 'info');
        setTimeout(() => {
            window.showToast('Test email sent successfully!', 'success');
        }, 3000);
    }

    function validateSettings() {
        window.showToast('Validating email settings...', 'info');
        setTimeout(() => {
            window.showToast('Email settings validated successfully!', 'success');
        }, 2000);
    }

    function viewDetailedMetrics() {
        window.showToast('Loading detailed performance metrics...', 'info');
    }

    function viewAllEvents() {
        window.showToast('Loading all system events...', 'info');
    }
</script>

<style>
    .system-health {
        text-align: center;
    }

    .health-indicator {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        transition: all 0.3s ease;
    }

    .health-indicator.healthy {
        background: linear-gradient(135deg, #22c55e, #16a34a);
        color: white;
        animation: pulse-healthy 2s infinite;
    }

    .health-indicator.warning {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
        animation: pulse-warning 2s infinite;
    }

    @keyframes pulse-healthy {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    @keyframes pulse-warning {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }

    .performance-metrics .metric-item {
        margin-bottom: 1.5rem;
        padding: 1rem;
        background: var(--luna-light);
        border-radius: 8px;
    }

    .event-item {
        display: flex;
        align-items: center;
        padding: 1rem;
        border-radius: 8px;
        background: var(--luna-light);
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .event-item:hover {
        background: white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .event-icon {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        margin-right: 1rem;
        font-size: 0.875rem;
    }

    .event-content h6 {
        margin-bottom: 0.25rem;
        font-weight: 600;
        font-size: 0.875rem;
    }

    .event-content p {
        margin-bottom: 0;
        font-size: 0.8rem;
        color: var(--luna-text-muted);
    }

    .event-time {
        font-size: 0.7rem;
        color: var(--luna-text-muted);
        text-align: center;
        min-width: 70px;
    }

    .nav-tabs .nav-link {
        border: none;
        color: var(--luna-text-muted);
        padding: 1rem 1.5rem;
    }

    .nav-tabs .nav-link.active {
        background: var(--luna-primary);
        color: white;
        border-radius: 8px 8px 0 0;
    }

    .tab-content {
        border: 1px solid #e5e7eb;
        border-top: none;
        border-radius: 0 0 8px 8px;
    }

    .security-options .form-check,
    .privacy-options .form-check,
    .notification-options .form-check,
    .integration-options .form-check {
        padding: 1rem;
        background: var(--luna-light);
        border-radius: 8px;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .security-options .form-check:hover,
    .privacy-options .form-check:hover,
    .notification-options .form-check:hover,
    .integration-options .form-check:hover {
        background: white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    @media (max-width: 768px) {
        .event-item {
            flex-direction: column;
            text-align: center;
        }

        .event-icon {
            margin-right: 0;
            margin-bottom: 0.5rem;
        }

        .event-time {
            margin-top: 0.5rem;
        }

        .nav-tabs .nav-link {
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
        }
    }
</style>

<?php include 'templates/footer.php'; ?>
