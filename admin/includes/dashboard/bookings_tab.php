<?php
// Get bookings data from database or API
$bookings = [
    ['id' => 1, 'user_name' => 'John Doe', 'therapist_name' => 'Dr. Smith', 
     'booking_date' => '2023-06-15', 'booking_time' => '10:00 AM', 'status' => 'confirmed'],
    // More booking data...
];

$recentBookings = [
    ['user_name' => 'Jane Smith', 'therapist_name' => 'Dr. Johnson', 
     'created_at' => '2023-06-10 14:30:00'],
    // More recent bookings...
];

$bookingStats = [
    'confirmed' => 15,
    'pending' => 5,
    'cancelled' => 2
];
?>

<div class="table-responsive">
    <table class="table table-striped table-hover" id="bookingsTable">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Therapist</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($bookings)): ?>
                <tr>
                    <td colspan="7" class="text-center">No bookings available.</td>
                </tr>
            <?php else: ?>
                <?php foreach($bookings as $booking): ?>
                <tr>
                    <td><?= $booking['id'] ?></td>
                    <td><?= htmlspecialchars($booking['user_name']) ?></td>
                    <td><?= htmlspecialchars($booking['therapist_name']) ?></td>
                    <td><?= date('M d, Y', strtotime($booking['booking_date'])) ?></td>
                    <td><?= htmlspecialchars($booking['booking_time']) ?></td>
                    <td>
                        <span class="badge bg-<?= 
                            $booking['status'] == 'confirmed' ? 'success' : 
                            ($booking['status'] == 'pending' ? 'warning' : 'danger') 
                        ?>">
                            <?= ucfirst($booking['status']) ?>
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-info view-booking" data-bs-toggle="modal" 
                                data-bs-target="#bookingModal" data-id="<?= $booking['id'] ?>">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-sm btn-primary edit-booking" 
                                data-id="<?= $booking['id'] ?>">
                            <i class="fas fa-edit"></i>
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h6>Booking Statistics</h6>
            </div>
            <div class="card-body">
                <canvas id="bookingStatsChart" height="200"></canvas>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const ctx = document.getElementById('bookingStatsChart').getContext('2d');
                        new Chart(ctx, {
                            type: 'doughnut',
                            data: {
                                labels: ['Confirmed', 'Pending', 'Cancelled'],
                                datasets: [{
                                    data: [<?= $bookingStats['confirmed'] ?>, 
                                           <?= $bookingStats['pending'] ?>, 
                                           <?= $bookingStats['cancelled'] ?>],
                                    backgroundColor: [
                                        'rgba(40, 167, 69, 0.8)',
                                        'rgba(255, 193, 7, 0.8)',
                                        'rgba(220, 53, 69, 0.8)'
                                    ]
                                }]
                            }
                        });
                    });
                </script>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h6>Recent Bookings</h6>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <?php foreach($recentBookings as $recent): ?>
                    <li class="list-group-item">
                        <div class="d-flex justify-content-between">
                            <span><?= htmlspecialchars($recent['user_name']) ?> booked <?= htmlspecialchars($recent['therapist_name']) ?></span>
                            <small class="text-muted"><?= time_elapsed_string($recent['created_at']) ?></small>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>