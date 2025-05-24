<?php
// Get responses data from database or API
$responses = [
    ['id' => 1, 'user_name' => 'John Doe', 'therapist_name' => 'Dr. Smith', 
     'message' => 'I need help with my back pain...', 'created_at' => '2023-06-10', 'status' => 'pending'],
    // More response data...
];
?>

<div class="row mb-3">
    <div class="col-md-12">
        <div class="btn-group" role="group">
            <input type="radio" class="btn-check" name="responseFilter" id="all" autocomplete="off" checked>
            <label class="btn btn-outline-primary" for="all">All</label>
            
            <input type="radio" class="btn-check" name="responseFilter" id="completed" autocomplete="off">
            <label class="btn btn-outline-success" for="completed">Completed</label>
            
            <input type="radio" class="btn-check" name="responseFilter" id="pending" autocomplete="off">
            <label class="btn btn-outline-warning" for="pending">Pending</label>
            
            <input type="radio" class="btn-check" name="responseFilter" id="cancelled" autocomplete="off">
            <label class="btn btn-outline-danger" for="cancelled">Cancelled</label>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="responsesTable">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Therapist</th>
                                <th>Message</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($responses)): ?>
                                <tr>
                                    <td colspan="7" class="text-center">No responses available.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach($responses as $response): ?>
                                <tr>
                                    <td><?= $response['id'] ?></td>
                                    <td><?= htmlspecialchars($response['user_name']) ?></td>
                                    <td><?= htmlspecialchars($response['therapist_name']) ?></td>
                                    <td>
                                        <div class="response-preview">
                                            <?= htmlspecialchars(substr($response['message'], 0, 50)) ?>
                                            <?= strlen($response['message']) > 50 ? '...' : '' ?>
                                        </div>
                                    </td>
                                    <td><?= date('M d, Y', strtotime($response['created_at'])) ?></td>
                                    <td>
                                        <span class="badge bg-<?= 
                                            $response['status'] == 'completed' ? 'success' : 
                                            ($response['status'] == 'pending' ? 'warning' : 'danger') 
                                        ?>">
                                            <?= ucfirst($response['status']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-info view-response" data-bs-toggle="modal" 
                                                data-bs-target="#responseModal" data-id="<?= $response['id'] ?>">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-primary edit-response" data-id="<?= $response['id'] ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <?php if($response['status'] == 'pending'): ?>
                                        <button class="btn btn-sm btn-success complete-response" data-id="<?= $response['id'] ?>">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter responses by status
    document.querySelectorAll('input[name="responseFilter"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const status = this.id;
            const rows = document.querySelectorAll('#responsesTable tbody tr');
            
            rows.forEach(row => {
                const rowStatus = row.querySelector('.badge').textContent.toLowerCase();
                if (status === 'all' || rowStatus === status) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
});
</script>