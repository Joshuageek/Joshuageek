<?php
session_start();
require_once __DIR__ . '/../includes/auth.php';

// Check if user is authenticated and is admin
if (!isLoggedIn() || getUserRole() !== 'admin') {
    header('Location: ../index.php');
    exit();
}

// Sample users data - in real app, this would come from database
$users = [
    [
        'id' => 1,
        'name' => 'Dr. Sarah Johnson',
        'email' => 'sarah.johnson@luna.com',
        'role' => 'therapist',
        'status' => 'active',
        'last_login' => '2024-06-25 10:30:00',
        'patients_count' => 28,
        'sessions_count' => 156,
        'rating' => 4.9,
        'joined_date' => '2023-01-15'
    ],
    [
        'id' => 2,
        'name' => 'Dr. Michael Wilson',
        'email' => 'michael.wilson@luna.com',
        'role' => 'therapist',
        'status' => 'active',
        'last_login' => '2024-06-25 09:15:00',
        'patients_count' => 32,
        'sessions_count' => 203,
        'rating' => 4.8,
        'joined_date' => '2023-02-20'
    ],
    [
        'id' => 3,
        'name' => 'Emily Rodriguez',
        'email' => 'emily.rodriguez@email.com',
        'role' => 'patient',
        'status' => 'active',
        'last_login' => '2024-06-25 11:45:00',
        'sessions_count' => 23,
        'therapist' => 'Dr. Sarah Johnson',
        'joined_date' => '2024-03-10'
    ],
    [
        'id' => 4,
        'name' => 'Admin User',
        'email' => 'admin@luna.com',
        'role' => 'admin',
        'status' => 'active',
        'last_login' => '2024-06-25 12:00:00',
        'joined_date' => '2023-01-01'
    ],
    [
        'id' => 5,
        'name' => 'Jessica Thompson',
        'email' => 'jessica.thompson@email.com',
        'role' => 'patient',
        'status' => 'inactive',
        'last_login' => '2024-06-20 14:30:00',
        'sessions_count' => 8,
        'therapist' => 'Dr. Michael Wilson',
        'joined_date' => '2024-05-15'
    ]
];

$total_users = count($users);
$active_users = count(array_filter($users, fn($u) => $u['status'] === 'active'));
$therapists = count(array_filter($users, fn($u) => $u['role'] === 'therapist'));
$patients = count(array_filter($users, fn($u) => $u['role'] === 'patient'));
?>

<!DOCTYPE html>
<html lang="en">
<?php include '../templates/header.php'; ?>
<body>
    <?php include '../templates/sidebar.php'; ?>
    
    <!-- Main Content -->
    <div class="main-content">
        <!-- Custom toolbar for this page -->
        <div class="top-bar">
            <div class="page-info d-flex align-items-center">
                <button class="btn me-3" id="sidebarToggle" style="background: var(--luna-primary); color: white; border-radius: 8px;">
                    <i class="fas fa-bars"></i>
                </button>
                <div>
                    <h1 class="page-title">User Management</h1>
                    <p class="page-subtitle">Manage system users, roles, and permissions</p>
                </div>
            </div>
            <div class="top-bar-actions">
                <button class="btn btn-luna-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    <i class="fas fa-user-plus me-2"></i>Add New User
                </button>
            </div>
        </div>
        
        <!-- Page Content -->
        <div class="container-fluid p-4">
            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card animate-in">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="stat-label">Total Users</p>
                                <h3 class="stat-number"><?php echo $total_users; ?></h3>
                                <span class="stat-change positive">
                                    <i class="fas fa-arrow-up"></i> +12% this month
                                </span>
                            </div>
                            <div class="stat-icon icon-primary">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card animate-in animate-delay-1">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="stat-label">Active Users</p>
                                <h3 class="stat-number"><?php echo $active_users; ?></h3>
                                <span class="stat-change positive">
                                    <i class="fas fa-check-circle"></i> <?php echo round(($active_users/$total_users)*100); ?>% active
                                </span>
                            </div>
                            <div class="stat-icon icon-success">
                                <i class="fas fa-user-check"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card animate-in animate-delay-2">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="stat-label">Therapists</p>
                                <h3 class="stat-number"><?php echo $therapists; ?></h3>
                                <span class="stat-change positive">
                                    <i class="fas fa-user-md"></i> Professional staff
                                </span>
                            </div>
                            <div class="stat-icon icon-warning">
                                <i class="fas fa-user-md"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card animate-in animate-delay-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="stat-label">Patients</p>
                                <h3 class="stat-number"><?php echo $patients; ?></h3>
                                <span class="stat-change positive">
                                    <i class="fas fa-heart"></i> Receiving care
                                </span>
                            </div>
                            <div class="stat-icon icon-primary">
                                <i class="fas fa-user-friends"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Users Table -->
            <div class="stat-card animate-in">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0">
                        <i class="fas fa-users text-primary me-2"></i>
                        All Users
                    </h5>
                    <div class="d-flex gap-2">
                        <div class="search-box" style="width: 250px;">
                            <i class="fas fa-search"></i>
                            <input type="text" placeholder="Search users..." id="userSearch">
                        </div>
                        <select class="form-select" style="width: auto;" id="roleFilter">
                            <option value="">All Roles</option>
                            <option value="admin">Admin</option>
                            <option value="therapist">Therapist</option>
                            <option value="patient">Patient</option>
                        </select>
                        <select class="form-select" style="width: auto;" id="statusFilter">
                            <option value="">All Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Performance</th>
                                <th>Last Login</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="user-avatar me-3" style="width: 40px; height: 40px; font-size: 1rem;">
                                            <?php echo strtoupper(substr($user['name'], 0, 1)); ?>
                                        </div>
                                        <div>
                                            <h6 class="mb-0"><?php echo htmlspecialchars($user['name']); ?></h6>
                                            <small class="text-muted"><?php echo htmlspecialchars($user['email']); ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge <?php 
                                        echo $user['role'] === 'admin' ? 'bg-danger' : 
                                            ($user['role'] === 'therapist' ? 'bg-success' : 'bg-primary'); 
                                    ?>">
                                        <?php echo ucfirst($user['role']); ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge <?php echo $user['status'] === 'active' ? 'bg-success' : 'bg-secondary'; ?>">
                                        <?php echo ucfirst($user['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($user['role'] === 'therapist'): ?>
                                        <div class="small">
                                            <div><strong><?php echo $user['patients_count']; ?></strong> patients</div>
                                            <div><strong><?php echo $user['sessions_count']; ?></strong> sessions</div>
                                            <div class="text-warning">
                                                <i class="fas fa-star"></i> <?php echo $user['rating']; ?>
                                            </div>
                                        </div>
                                    <?php elseif ($user['role'] === 'patient'): ?>
                                        <div class="small">
                                            <div><strong><?php echo $user['sessions_count']; ?></strong> sessions</div>
                                            <div class="text-muted">with <?php echo $user['therapist']; ?></div>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted">System Admin</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="small">
                                        <?php echo date('M j, Y', strtotime($user['last_login'])); ?>
                                        <div class="text-muted"><?php echo date('g:i A', strtotime($user['last_login'])); ?></div>
                                    </div>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                            Actions
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#" onclick="viewUser(<?php echo $user['id']; ?>)">
                                                <i class="fas fa-eye me-2"></i>View Details
                                            </a></li>
                                            <li><a class="dropdown-item" href="#" onclick="editUser(<?php echo $user['id']; ?>)">
                                                <i class="fas fa-edit me-2"></i>Edit User
                                            </a></li>
                                            <?php if ($user['status'] === 'active'): ?>
                                            <li><a class="dropdown-item text-warning" href="#" onclick="suspendUser(<?php echo $user['id']; ?>)">
                                                <i class="fas fa-pause me-2"></i>Suspend
                                            </a></li>
                                            <?php else: ?>
                                            <li><a class="dropdown-item text-success" href="#" onclick="activateUser(<?php echo $user['id']; ?>)">
                                                <i class="fas fa-play me-2"></i>Activate
                                            </a></li>
                                            <?php endif; ?>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item text-danger" href="#" onclick="deleteUser(<?php echo $user['id']; ?>)">
                                                <i class="fas fa-trash me-2"></i>Delete User
                                            </a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Showing 1 to <?php echo count($users); ?> of <?php echo $total_users; ?> users
                    </div>
                    <nav>
                        <ul class="pagination pagination-sm mb-0">
                            <li class="page-item disabled">
                                <a class="page-link" href="#">Previous</a>
                            </li>
                            <li class="page-item active">
                                <a class="page-link" href="#">1</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">2</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">3</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-user-plus me-2"></i>Add New User
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addUserForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Full Name *</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email Address *</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Role *</label>
                                <select class="form-select" name="role" required>
                                    <option value="">Select Role</option>
                                    <option value="admin">Administrator</option>
                                    <option value="therapist">Therapist</option>
                                    <option value="patient">Patient</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" name="phone">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Temporary Password *</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Confirm Password *</label>
                                <input type="password" class="form-control" name="confirm_password" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="send_welcome" id="sendWelcome" checked>
                                <label class="form-check-label" for="sendWelcome">
                                    Send welcome email with login instructions
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-luna-primary" onclick="submitAddUser()">
                        <i class="fas fa-save me-2"></i>Create User
                    </button>
                </div>
            </div>
        </div>
    </div>

    <?php include '../templates/footer.php'; ?>
    
    <script src="../assets/js/simple-luna.js"></script>
    
    <script>
        // User management functions
        function viewUser(userId) {
            showToast(`Viewing user details for ID: ${userId}`, 'info');
            // In real app, redirect to user detail page
        }

        function editUser(userId) {
            showToast(`Opening edit form for user ID: ${userId}`, 'info');
            // In real app, open edit modal or redirect to edit page
        }

        function suspendUser(userId) {
            if (confirm('Are you sure you want to suspend this user?')) {
                showToast('User suspended successfully', 'warning');
                // In real app, make API call to suspend user
            }
        }

        function activateUser(userId) {
            showToast('User activated successfully', 'success');
            // In real app, make API call to activate user
        }

        function deleteUser(userId) {
            if (confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
                showToast('User deleted successfully', 'success');
                // In real app, make API call to delete user
            }
        }

        function submitAddUser() {
            const form = document.getElementById('addUserForm');
            const formData = new FormData(form);
            
            // Basic validation
            if (!formData.get('name') || !formData.get('email') || !formData.get('role')) {
                showToast('Please fill in all required fields', 'error');
                return;
            }
            
            if (formData.get('password') !== formData.get('confirm_password')) {
                showToast('Passwords do not match', 'error');
                return;
            }
            
            // In real app, submit to server
            showToast('User created successfully!', 'success');
            bootstrap.Modal.getInstance(document.getElementById('addUserModal')).hide();
            form.reset();
        }

        // Search and filter functionality
        document.getElementById('userSearch').addEventListener('input', function() {
            // In real app, implement search functionality
            console.log('Searching for:', this.value);
        });

        document.getElementById('roleFilter').addEventListener('change', function() {
            // In real app, implement role filtering
            console.log('Filtering by role:', this.value);
        });

        document.getElementById('statusFilter').addEventListener('change', function() {
            // In real app, implement status filtering
            console.log('Filtering by status:', this.value);
        });
    </script>
</body>
</html>
