<?php
// Get users data from database or API
$users = [
    ['id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com', 
     'phone' => '123-456-7890', 'created_at' => '2023-01-15', 'active' => true],
    // More user data...
];

$userStats = [
    'total' => 42,
    'active' => 35,
    'inactive' => 7
];
?>

<div class="row mb-3">
    <div class="col-md-6">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Search users..." id="userSearch">
            <button class="btn btn-outline-secondary" type="button">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>
    <div class="col-md-6 text-end">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addUserModal">
            <i class="fas fa-plus"></i> Add New User
        </button>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover" id="usersTable">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Registered</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($users)): ?>
                <tr>
                    <td colspan="7" class="text-center">No users available.</td>
                </tr>
            <?php else: ?>
                <?php foreach($users as $user): ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td>
                        <img src="assets/img/default-avatar.jpg" class="rounded-circle me-2" width="30" height="30">
                        <?= htmlspecialchars($user['name']) ?>
                    </td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= htmlspecialchars($user['phone']) ?></td>
                    <td><?= date('M d, Y', strtotime($user['created_at'])) ?></td>
                    <td>
                        <span class="badge bg-<?= $user['active'] ? 'success' : 'secondary' ?>">
                            <?= $user['active'] ? 'Active' : 'Inactive' ?>
                        </span>
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-info view-user" data-bs-toggle="modal" 
                                    data-bs-target="#userModal" data-id="<?= $user['id'] ?>">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-primary edit-user" data-id="<?= $user['id'] ?>">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-<?= $user['active'] ? 'warning' : 'success' ?> toggle-user" 
                                    data-id="<?= $user['id'] ?>" data-status="<?= $user['active'] ?>">
                                <i class="fas fa-power-off"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h6>User Statistics</h6>
            </div>
            <div class="card-body">
                <canvas id="userStatsChart" height="100"></canvas>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const ctx = document.getElementById('userStatsChart').getContext('2d');
                        new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: ['Total Users', 'Active', 'Inactive'],
                                datasets: [{
                                    label: 'Users',
                                    data: [<?= $userStats['total'] ?>, 
                                           <?= $userStats['active'] ?>, 
                                           <?= $userStats['inactive'] ?>],
                                    backgroundColor: [
                                        'rgba(13, 110, 253, 0.7)',
                                        'rgba(25, 135, 84, 0.7)',
                                        'rgba(108, 117, 125, 0.7)'
                                    ]
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</div>