<?php
session_start();
require_once '../includes/auth.php';

// Check if user is authenticated and is admin
if (!isLoggedIn() || !isAdmin()) {
    header('Location: ../index.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Get activity logs with pagination
$page = $_GET['page'] ?? 1;
$limit = 50;
$offset = ($page - 1) * $limit;

$activity_logs = getActivityLogs($limit, $offset);
$total_logs = getTotalActivityLogs();
$total_pages = ceil($total_logs / $limit);
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
                <h2>System Activity Logs</h2>
                <div>
                    <button class="btn btn-outline-custom" onclick="exportLogs()">
                        <i class="fas fa-download me-2"></i>Export Logs
                    </button>
                    <button class="btn btn-outline-danger" onclick="clearOldLogs()">
                        <i class="fas fa-trash me-2"></i>Clear Old Logs
                    </button>
                </div>
            </div>

            <!-- Activity Statistics -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card stat-card">
                        <div class="stat-icon" style="background: rgba(33, 150, 243, 0.1); color: #2196F3;">
                            <i class="fas fa-list"></i>
                        </div>
                        <div class="stat-number"><?php echo $total_logs; ?></div>
                        <div class="stat-label">Total Activities</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card stat-card">
                        <div class="stat-icon" style="background: rgba(76, 175, 80, 0.1); color: #4CAF50;">
                            <i class="fas fa-sign-in-alt"></i>
                        </div>
                        <div class="stat-number"><?php echo getActivityCountByType('login'); ?></div>
                        <div class="stat-label">Login Activities</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card stat-card">
                        <div class="stat-icon" style="background: rgba(255, 152, 0, 0.1); color: #FF9800;">
                            <i class="fas fa-edit"></i>
                        </div>
                        <div class="stat-number"><?php echo getActivityCountByType('update'); ?></div>
                        <div class="stat-label">Update Activities</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card stat-card">
                        <div class="stat-icon" style="background: rgba(244, 67, 54, 0.1); color: #f44336;">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="stat-number"><?php echo getActivityCountByType('delete'); ?></div>
                        <div class="stat-label">Delete Activities</div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <select class="form-select" id="actionFilter">
                                <option value="">All Actions</option>
                                <option value="login">Login</option>
                                <option value="logout">Logout</option>
                                <option value="create">Create</option>
                                <option value="update">Update</option>
                                <option value="delete">Delete</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="date" class="form-control" id="dateFilter">
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="userFilter" placeholder="Search by user...">
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-outline-secondary w-100" onclick="clearFilters()">Clear Filters</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Activity Logs Table -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-custom" id="logsTable">
                            <thead>
                                <tr>
                                    <th>Timestamp</th>
                                    <th>User</th>
                                    <th>Action</th>
                                    <th>Description</th>
                                    <th>IP Address</th>
                                    <th>Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($activity_logs)): ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">No activity logs found</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($activity_logs as $log): ?>
                                    <tr>
                                        <td>
                                            <div><?php echo date('M j, Y', strtotime($log['created_at'])); ?></div>
                                            <small class="text-muted"><?php echo date('H:i:s', strtotime($log['created_at'])); ?></small>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="user-avatar-small bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px;">
                                                    <?php echo strtoupper(substr($log['full_name'] ?? 'U', 0, 1)); ?>
                                                </div>
                                                <span><?php echo htmlspecialchars($log['full_name'] ?? 'Unknown User'); ?></span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-<?php 
                                                echo match($log['action']) {
                                                    'login' => 'success',
                                                    'logout' => 'secondary',
                                                    'create' => 'info',
                                                    'update' => 'warning',
                                                    'delete' => 'danger',
                                                    default => 'primary'
                                                };
                                            ?>">
                                                <?php echo htmlspecialchars($log['action']); ?>
                                            </span>
                                        </td>
                                        <td><?php echo htmlspecialchars($log['description']); ?></td>
                                        <td>
                                            <small class="text-muted"><?php echo htmlspecialchars($log['ip_address']); ?></small>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-secondary" onclick="viewLogDetails(<?php echo $log['id']; ?>)">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <?php if ($total_pages > 1): ?>
                    <nav aria-label="Activity logs pagination" class="mt-4">
                        <ul class="pagination justify-content-center">
                            <?php if ($page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?php echo $page - 1; ?>">Previous</a>
                                </li>
                            <?php endif; ?>
                            
                            <?php for ($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++): ?>
                                <li class="page-item <?php echo $i === $page ? 'active' : ''; ?>">
                                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>
                            
                            <?php if ($page < $total_pages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        function viewLogDetails(logId) {
            // Implement log details modal
            alert('View log details for ID: ' + logId);
        }

        function exportLogs() {
            window.location.href = 'export-logs.php';
        }

        function clearOldLogs() {
            if (confirm('Are you sure you want to clear logs older than 90 days? This action cannot be undone.')) {
                window.location.href = 'clear-old-logs.php';
            }
        }

        function clearFilters() {
            document.getElementById('actionFilter').value = '';
            document.getElementById('dateFilter').value = '';
            document.getElementById('userFilter').value = '';
            filterLogs();
        }

        function filterLogs() {
            const actionFilter = document.getElementById('actionFilter').value.toLowerCase();
            const dateFilter = document.getElementById('dateFilter').value;
            const userFilter = document.getElementById('userFilter').value.toLowerCase();
            const table = document.getElementById('logsTable');
            const rows = table.getElementsByTagName('tr');

            for (let i = 1; i < rows.length; i++) {
                const row = rows[i];
                const cells = row.getElementsByTagName('td');
                let showRow = true;

                if (actionFilter && !cells[2].textContent.toLowerCase().includes(actionFilter)) {
                    showRow = false;
                }
                if (userFilter && !cells[1].textContent.toLowerCase().includes(userFilter)) {
                    showRow = false;
                }
                if (dateFilter && !cells[0].textContent.includes(dateFilter)) {
                    showRow = false;
                }

                row.style.display = showRow ? '' : 'none';
            }
        }

        document.getElementById('actionFilter').addEventListener('change', filterLogs);
        document.getElementById('dateFilter').addEventListener('change', filterLogs);
        document.getElementById('userFilter').addEventListener('input', filterLogs);
    </script>

    <?php include '../templates/footer.php'; ?>
</body>
</html>
