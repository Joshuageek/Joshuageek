<?php
session_start();
require_once '../includes/auth.php';

// Check if user is authenticated and is admin
if (!isLoggedIn() || !isAdmin()) {
    header('Location: ../index.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle user actions
if ($_POST) {
    $action = $_POST['action'] ?? '';
    $target_user_id = $_POST['user_id'] ?? '';
    
    switch ($action) {
        case 'delete':
            if (deleteUser($target_user_id)) {
                $message = "User deleted successfully.";
                logActivity($user_id, 'user_delete', "Deleted user ID: $target_user_id");
            } else {
                $error = "Failed to delete user.";
            }
            break;
        case 'change_role':
            $new_role = $_POST['new_role'] ?? '';
            if (changeUserRole($target_user_id, $new_role)) {
                $message = "User role updated successfully.";
                logActivity($user_id, 'role_change', "Changed user ID $target_user_id role to $new_role");
            } else {
                $error = "Failed to update user role.";
            }
            break;
    }
}

// Get all users with statistics
$users = getAllUsersWithStats();
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
                <h2>All Users Management</h2>
                <div>
                    <button class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#addUserModal">
                        <i class="fas fa-plus me-2"></i>Add New User
                    </button>
                    <button class="btn btn-outline-custom" onclick="exportUsers()">
                        <i class="fas fa-download me-2"></i>Export
                    </button>
                </div>
            </div>

            <?php if (isset($message)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo $error; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- User Statistics Cards -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card stat-card">
                        <div class="stat-icon" style="background: rgba(168, 195, 164, 0.1); color: #A8C3A4;">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-number"><?php echo count($users); ?></div>
                        <div class="stat-label">Total Users</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card stat-card">
                        <div class="stat-icon" style="background: rgba(76, 175, 80, 0.1); color: #4CAF50;">
                            <i class="fas fa-user-md"></i>
                        </div>
                        <div class="stat-number"><?php echo count(array_filter($users, fn($u) => $u['role'] === 'therapist')); ?></div>
                        <div class="stat-label">Therapists</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card stat-card">
                        <div class="stat-icon" style="background: rgba(33, 150, 243, 0.1); color: #2196F3;">
                            <i class="fas fa-user-injured"></i>
                        </div>
                        <div class="stat-number"><?php echo count(array_filter($users, fn($u) => $u['role'] === 'patient')); ?></div>
                        <div class="stat-label">Patients</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card stat-card">
                        <div class="stat-icon" style="background: rgba(255, 152, 0, 0.1); color: #FF9800;">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <div class="stat-number"><?php echo count(array_filter($users, fn($u) => $u['role'] === 'admin')); ?></div>
                        <div class="stat-label">Administrators</div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <select class="form-select" id="roleFilter">
                                <option value="">All Roles</option>
                                <option value="admin">Admin</option>
                                <option value="therapist">Therapist</option>
                                <option value="patient">Patient</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="searchUsers" placeholder="Search users...">
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="statusFilter">
                                <option value="">All Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-outline-secondary" onclick="clearFilters()">Clear Filters</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Users Table -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-custom" id="usersTable">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Age</th>
                                    <th>Location</th>
                                    <th>Last Login</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="user-avatar-small bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                <?php echo strtoupper(substr($user['full_name'] ?? 'U', 0, 1)); ?>
                                            </div>
                                            <div>
                                                <div class="fw-semibold"><?php echo htmlspecialchars($user['full_name'] ?? 'No Name'); ?></div>
                                                <?php if ($user['google_id']): ?>
                                                    <small class="text-muted">Google Account</small>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?php echo htmlspecialchars($user['email'] ?? 'No Email'); ?></td>
                                    <td>
                                        <span class="badge bg-<?php echo $user['role'] === 'admin' ? 'danger' : ($user['role'] === 'therapist' ? 'info' : 'secondary'); ?>">
                                            <?php echo ucfirst($user['role'] ?? 'Unknown'); ?>
                                        </span>
                                    </td>
                                    <td><?php echo htmlspecialchars($user['age'] ?? 'Not specified'); ?></td>
                                    <td><?php echo htmlspecialchars($user['location'] ?? 'Not specified'); ?></td>
                                    <td><?php echo $user['last_login'] ? date('M j, Y H:i', strtotime($user['last_login'])) : 'Never'; ?></td>
                                    <td>
                                        <span class="status-badge status-active">Active</span>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                Actions
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#" onclick="viewUser(<?php echo $user['id']; ?>)">View Details</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="editUser(<?php echo $user['id']; ?>)">Edit User</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="changeRole(<?php echo $user['id']; ?>, '<?php echo $user['role']; ?>')">Change Role</a></li>
                                                <?php if ($user['id'] !== $user_id): ?>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item text-danger" href="#" onclick="deleteUser(<?php echo $user['id']; ?>)">Delete User</a></li>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function deleteUser(userId) {
            if (confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.innerHTML = `
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="user_id" value="${userId}">
                `;
                document.body.appendChild(form);
                form.submit();
            }
        }

        function changeRole(userId, currentRole) {
            const roles = ['admin', 'therapist', 'patient'];
            const newRole = prompt(`Change role from ${currentRole} to:`, currentRole);
            
            if (newRole && roles.includes(newRole) && newRole !== currentRole) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.innerHTML = `
                    <input type="hidden" name="action" value="change_role">
                    <input type="hidden" name="user_id" value="${userId}">
                    <input type="hidden" name="new_role" value="${newRole}">
                `;
                document.body.appendChild(form);
                form.submit();
            }
        }

        function viewUser(userId) {
            window.location.href = `user-details.php?id=${userId}`;
        }

        function editUser(userId) {
            window.location.href = `edit-user.php?id=${userId}`;
        }

        function exportUsers() {
            window.location.href = 'export-users.php';
        }

        function clearFilters() {
            document.getElementById('roleFilter').value = '';
            document.getElementById('searchUsers').value = '';
            document.getElementById('statusFilter').value = '';
            filterTable();
        }

        // Simple table filtering
        function filterTable() {
            const roleFilter = document.getElementById('roleFilter').value.toLowerCase();
            const searchFilter = document.getElementById('searchUsers').value.toLowerCase();
            const statusFilter = document.getElementById('statusFilter').value.toLowerCase();
            const table = document.getElementById('usersTable');
            const rows = table.getElementsByTagName('tr');

            for (let i = 1; i < rows.length; i++) {
                const row = rows[i];
                const cells = row.getElementsByTagName('td');
                let showRow = true;

                if (roleFilter && !cells[2].textContent.toLowerCase().includes(roleFilter)) {
                    showRow = false;
                }
                if (searchFilter && !row.textContent.toLowerCase().includes(searchFilter)) {
                    showRow = false;
                }

                row.style.display = showRow ? '' : 'none';
            }
        }

        document.getElementById('roleFilter').addEventListener('change', filterTable);
        document.getElementById('searchUsers').addEventListener('input', filterTable);
        document.getElementById('statusFilter').addEventListener('change', filterTable);
    </script>

    <?php include '../templates/footer.php'; ?>
</body>
</html>
