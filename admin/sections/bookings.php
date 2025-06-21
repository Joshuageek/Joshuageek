<?php
session_start();
require_once '../includes/auth.php';

// Check if user is authenticated
if (!isLoggedIn()) {
    header('Location: ../../login.php');
    exit();
}

$user_role = getUserRole();
$user_id = $_SESSION['user_id'];

// Handle booking status updates (admin and therapist only)
if ($_POST && ($user_role === 'admin' || $user_role === 'therapist')) {
    $action = $_POST['action'] ?? '';
    $booking_id = $_POST['booking_id'] ?? '';
    
    if ($action === 'update_status' && $booking_id) {
        $status = $_POST['status'] ?? '';
        
        if (updateBookingStatus($booking_id, $status)) {
            $message = "Booking status updated successfully.";
            logActivity($user_id, 'booking_update', "Updated booking #$booking_id status to $status");
        } else {
            $error = "Failed to update booking status.";
        }
    }
}

// Get bookings based on user role
$bookings = getBookings($user_role, $user_id);
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
                <h2>
                    <?php if ($user_role === 'admin'): ?>
                        All Bookings
                    <?php elseif ($user_role === 'therapist'): ?>
                        Patient Appointments
                    <?php else: ?>
                        My Appointments
                    <?php endif; ?>
                </h2>
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

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-custom">
                            <thead>
                                <tr>
                                    <th>Patient</th>
                                    <th>Contact</th>
                                    <th>Date & Time</th>
                                    <th>People</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <?php if ($user_role !== 'patient'): ?>
                                        <th>Actions</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($bookings)): ?>
                                    <tr>
                                        <td colspan="<?php echo $user_role !== 'patient' ? '7' : '6'; ?>" class="text-center text-muted">
                                            No bookings found
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($bookings as $booking): ?>
                                    <tr>
                                        <td>
                                            <div class="fw-semibold"><?php echo htmlspecialchars($booking['full_name']); ?></div>
                                        </td>
                                        <td>
                                            <div><?php echo htmlspecialchars($booking['email']); ?></div>
                                            <small class="text-muted"><?php echo htmlspecialchars($booking['phone']); ?></small>
                                        </td>
                                        <td>
                                            <div><?php echo date('M j, Y', strtotime($booking['booking_date'])); ?></div>
                                            <small class="text-muted"><?php echo htmlspecialchars($booking['booking_time']); ?></small>
                                        </td>
                                        <td><?php echo htmlspecialchars($booking['number_of_people']); ?></td>
                                        <td>
                                            <span class="status-badge status-<?php echo str_replace("'", "", $booking['status']); ?>">
                                                <?php echo ucfirst(str_replace("'", "", $booking['status'])); ?>
                                            </span>
                                        </td>
                                        <td><?php echo date('M j, Y', strtotime($booking['created_at'])); ?></td>
                                        <?php if ($user_role !== 'patient'): ?>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    Actions
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="#" onclick="updateBookingStatus(<?php echo $booking['id']; ?>, 'accepted')">Accept</a></li>
                                                    <li><a class="dropdown-item" href="#" onclick="updateBookingStatus(<?php echo $booking['id']; ?>, 'rejected')">Reject</a></li>
                                                    <li><a class="dropdown-item" href="#" onclick="updateBookingStatus(<?php echo $booking['id']; ?>, 'completed')">Mark Complete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                        <?php endif; ?>
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
        function updateBookingStatus(bookingId, status) {
            if (confirm('Are you sure you want to update this booking status?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.innerHTML = `
                    <input type="hidden" name="action" value="update_status">
                    <input type="hidden" name="booking_id" value="${bookingId}">
                    <input type="hidden" name="status" value="${status}">
                `;
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>

    <?php include '../templates/footer.php'; ?>
</body>
</html>
