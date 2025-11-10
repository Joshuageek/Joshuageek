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

// All available permissions in the system
$all_permissions = [
    'user_management' => [
        'name' => 'User Management',
        'description' => 'Manage platform users and accounts',
        'permissions' => [
            'users.view' => 'View user profiles and information',
            'users.create' => 'Create new user accounts',
            'users.edit' => 'Edit existing user accounts',
            'users.delete' => 'Delete user accounts',
            'users.suspend' => 'Suspend/activate user accounts',
            'users.impersonate' => 'Login as another user',
            'users.export' => 'Export user data',
            'users.bulk_actions' => 'Perform bulk operations on users'
        ]
    ],
    'patient_management' => [
        'name' => 'Patient Management',
        'description' => 'Manage patient records and data',
        'permissions' => [
            'patients.view' => 'View patient profiles and records',
            'patients.create' => 'Create new patient records',
            'patients.edit' => 'Edit patient information',
            'patients.delete' => 'Delete patient records',
            'patients.assign_therapist' => 'Assign patients to therapists',
            'patients.view_medical_history' => 'Access medical history',
            'patients.view_progress' => 'View patient progress reports',
            'patients.export_data' => 'Export patient data'
        ]
    ],
    'therapist_management' => [
        'name' => 'Therapist Management',
        'description' => 'Manage therapist accounts and credentials',
        'permissions' => [
            'therapists.view' => 'View therapist profiles',
            'therapists.create' => 'Create therapist accounts',
            'therapists.edit' => 'Edit therapist information',
            'therapists.verify_credentials' => 'Verify professional credentials',
            'therapists.manage_specializations' => 'Manage specialization areas',
            'therapists.view_performance' => 'View therapist performance metrics',
            'therapists.assign_patients' => 'Assign patients to therapists'
        ]
    ],
    'session_management' => [
        'name' => 'Session Management',
        'description' => 'Manage therapy sessions and appointments',
        'permissions' => [
            'sessions.view_all' => 'View all therapy sessions',
            'sessions.create' => 'Create new sessions',
            'sessions.edit' => 'Edit session details',
            'sessions.cancel' => 'Cancel sessions',
            'sessions.reschedule' => 'Reschedule appointments',
            'sessions.view_notes' => 'Access session notes',
            'sessions.edit_notes' => 'Edit session notes',
            'sessions.export' => 'Export session data'
        ]
    ],
    'analytics_reporting' => [
        'name' => 'Analytics & Reporting',
        'description' => 'Access analytics and generate reports',
        'permissions' => [
            'analytics.view_dashboard' => 'View analytics dashboard',
            'analytics.view_patient_metrics' => 'View patient analytics',
            'analytics.view_therapist_metrics' => 'View therapist analytics',
            'analytics.view_financial' => 'View financial analytics',
            'analytics.export_reports' => 'Export analytics reports',
            'analytics.create_custom_reports' => 'Create custom reports',
            'analytics.schedule_reports' => 'Schedule automated reports'
        ]
    ],
    'system_administration' => [
        'name' => 'System Administration',
        'description' => 'System configuration and maintenance',
        'permissions' => [
            'system.view_settings' => 'View system settings',
            'system.edit_settings' => 'Modify system settings',
            'system.view_logs' => 'Access system logs',
            'system.manage_backups' => 'Manage system backups',
            'system.maintenance_mode' => 'Enable/disable maintenance mode',
            'system.manage_integrations' => 'Configure third-party integrations',
            'system.security_settings' => 'Manage security configurations'
        ]
    ]
];

// Predefined role templates
$role_templates = [
    'super_admin' => [
        'name' => 'Super Administrator',
        'description' => 'Full system access with all permissions',
        'permissions' => ['users.view', 'users.create', 'users.edit', 'users.delete', 'system.edit_settings']
    ],
    'admin' => [
        'name' => 'Administrator',
        'description' => 'Standard admin with most permissions',
        'permissions' => ['users.view', 'users.create', 'users.edit', 'patients.view', 'therapists.view']
    ],
    'therapist' => [
        'name' => 'Licensed Therapist',
        'description' => 'Standard therapist permissions',
        'permissions' => ['patients.view', 'sessions.create', 'sessions.edit']
    ]
];

// Current user permissions (sample data)
$user_permissions = [
    [
        'id' => 1,
        'user_name' => 'Dr. Sarah Johnson',
        'user_email' => 'sarah.johnson@luna.com',
        'role' => 'therapist',
        'custom_permissions' => ['patients.view_medical_history', 'sessions.export'],
        'permission_groups' => ['therapist'],
        'last_updated' => date('Y-m-d H:i:s', strtotime('-2 days')),
        'updated_by' => 'Admin User'
    ],
    [
        'id' => 2,
        'user_name' => 'Dr. Michael Wilson',
        'user_email' => 'michael.wilson@luna.com',
        'role' => 'admin',
        'custom_permissions' => ['users.view', 'therapists.manage_specializations'],
        'permission_groups' => ['admin'],
        'last_updated' => date('Y-m-d H:i:s', strtotime('-1 week')),
        'updated_by' => 'Admin User'
    ]
];

// Permission audit log
$permission_audit = [
    [
        'timestamp' => date('Y-m-d H:i:s', strtotime('-2 hours')),
        'action' => 'Permission Added',
        'user_affected' => 'Dr. Sarah Johnson',
        'permission' => 'sessions.export',
        'changed_by' => 'Admin User',
        'reason' => 'Requested for research purposes'
    ],
    [
        'timestamp' => date('Y-m-d H:i:s', strtotime('-1 day')),
        'action' => 'Role Changed',
        'user_affected' => 'Dr. Michael Wilson',
        'permission' => 'therapist → admin',
        'changed_by' => 'Admin User',
        'reason' => 'Promotion to admin role'
    ]
];

// Permission statistics
$permission_stats = [
    'total_permissions' => 50,
    'active_users_with_permissions' => count($user_permissions),
    'custom_permissions_granted' => 4,
    'role_templates' => count($role_templates)
];
?>

<!-- Permissions Management Content -->
<div class="container-fluid p-4">
    <!-- Permissions Header -->
    <div class="welcome-card animate-in">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h2 class="welcome-title">
                    <i class="fas fa-key me-3"></i>
                    Permissions & Access Control
                </h2>
                <p class="welcome-subtitle">
                    Manage granular permissions, create custom roles, assign specific access rights, and maintain
                    security compliance. Control exactly what each user can access and modify within the platform.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <button class="btn btn-luna-primary" onclick="createPermissionGroup()">
                        <i class="fas fa-plus me-2"></i>Create Permission Group
                    </button>
                    <button class="btn btn-luna-outline" onclick="bulkPermissionUpdate()">
                        <i class="fas fa-users-cog me-2"></i>Bulk Update
                    </button>
                    <button class="btn btn-luna-outline" onclick="exportPermissions()">
                        <i class="fas fa-download me-2"></i>Export Permissions
                    </button>
                </div>
            </div>
            <div class="col-lg-4 text-center">
                <div class="row">
                    <div class="col-4">
                        <div class="h2 fw-bold mb-0"><?php echo $permission_stats['total_permissions']; ?></div>
                        <div class="small opacity-90">Total Permissions</div>
                    </div>
                    <div class="col-4">
                        <div class="h2 fw-bold mb-0"><?php echo $permission_stats['active_users_with_permissions']; ?></div>
                        <div class="small opacity-90">Active Users</div>
                    </div>
                    <div class="col-4">
                        <div class="h2 fw-bold mb-0"><?php echo $permission_stats['role_templates']; ?></div>
                        <div class="small opacity-90">Role Templates</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Permission Overview Stats -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card animate-in">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="stat-label">System Permissions</p>
                        <h3 class="stat-number"><?php echo $permission_stats['total_permissions']; ?></h3>
                        <span class="stat-change positive">
                            <i class="fas fa-shield-alt"></i> Available
                        </span>
                    </div>
                    <div class="stat-icon icon-primary">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card animate-in animate-delay-1">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="stat-label">Custom Permissions</p>
                        <h3 class="stat-number"><?php echo $permission_stats['custom_permissions_granted']; ?></h3>
                        <span class="stat-change neutral">
                            <i class="fas fa-user-cog"></i> Granted
                        </span>
                    </div>
                    <div class="stat-icon icon-info">
                        <i class="fas fa-user-cog"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card animate-in animate-delay-2">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="stat-label">Role Templates</p>
                        <h3 class="stat-number"><?php echo $permission_stats['role_templates']; ?></h3>
                        <span class="stat-change positive">
                            <i class="fas fa-users"></i> Predefined
                        </span>
                    </div>
                    <div class="stat-icon icon-success">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card animate-in animate-delay-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="stat-label">Recent Changes</p>
                        <h3 class="stat-number"><?php echo count($permission_audit); ?></h3>
                        <span class="stat-change warning">
                            <i class="fas fa-clock"></i> Last 7 days
                        </span>
                    </div>
                    <div class="stat-icon icon-warning">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- User Permissions Table -->
    <div class="row">
        <div class="col-lg-8">
            <div class="stat-card animate-in">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0">
                        <i class="fas fa-users-cog text-success me-2"></i>
                        User Permission Assignments
                    </h5>
                    <div class="d-flex gap-2">
                        <input type="text" class="form-control form-control-sm" placeholder="Search users..." style="width: 200px;">
                        <select class="form-select form-select-sm" style="width: auto;">
                            <option value="all">All Roles</option>
                            <option value="admin">Administrators</option>
                            <option value="therapist">Therapists</option>
                            <option value="patient">Patients</option>
                        </select>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>User</th>
                            <th>Role</th>
                            <th>Permission Groups</th>
                            <th>Custom Permissions</th>
                            <th>Last Updated</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($user_permissions as $user): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="user-avatar me-3">
                                            <?php echo strtoupper(substr($user['user_name'], 0, 1)); ?>
                                        </div>
                                        <div>
                                            <div class="fw-semibold"><?php echo $user['user_name']; ?></div>
                                            <div class="small text-muted"><?php echo $user['user_email']; ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-<?php echo $user['role'] === 'admin' ? 'danger' : 'primary'; ?>">
                                        <?php echo ucwords(str_replace('_', ' ', $user['role'])); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php foreach ($user['permission_groups'] as $group): ?>
                                        <span class="badge bg-light text-dark me-1"><?php echo ucwords(str_replace('_', ' ', $group)); ?></span>
                                    <?php endforeach; ?>
                                </td>
                                <td>
                                    <?php if (empty($user['custom_permissions'])): ?>
                                        <span class="text-muted">None</span>
                                    <?php else: ?>
                                        <span class="badge bg-info"><?php echo count($user['custom_permissions']); ?> custom</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="small"><?php echo date('M j, Y', strtotime($user['last_updated'])); ?></div>
                                    <div class="small text-muted">by <?php echo $user['updated_by']; ?></div>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary" onclick="editUserPermissions(<?php echo $user['id']; ?>)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Role Templates -->
        <div class="col-lg-4">
            <div class="stat-card animate-in animate-delay-1">
                <h5 class="mb-4">
                    <i class="fas fa-user-tag text-warning me-2"></i>
                    Role Templates
                </h5>
                <?php foreach ($role_templates as $template_key => $template): ?>
                    <div class="role-template-card">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <div class="fw-bold"><?php echo $template['name']; ?></div>
                                <div class="small text-muted"><?php echo $template['description']; ?></div>
                            </div>
                        </div>
                        <div class="template-stats">
                            <span class="badge bg-primary"><?php echo count($template['permissions']); ?> permissions</span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<script>
    function createPermissionGroup() {
        window.showToast('Opening permission group creator...', 'info');
    }

    function bulkPermissionUpdate() {
        window.showToast('Opening bulk permission update...', 'info');
    }

    function exportPermissions() {
        window.showToast('Exporting permission data...', 'info');
    }

    function editUserPermissions(userId) {
        window.showToast(`Loading permissions for user ${userId}...`, 'info');
    }
</script>

<style>
    .role-template-card {
        padding: 1rem;
        background: var(--luna-light);
        border-radius: 8px;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .role-template-card:hover {
        background: white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: var(--luna-primary);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
    }
</style>

<?php include 'templates/footer.php'; ?>
