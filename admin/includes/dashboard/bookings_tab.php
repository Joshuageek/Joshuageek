<div class="dashboard-card">
    <div class="card-header bg-info text-white rounded-top">
        <h2 class="fw-bold">Bookings Management</h2>
        <div class="card-actions">
            <div class="dropdown">
                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-filter"></i> Filter
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Week</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                </ul>
            </div>
            <button class="btn btn-sm btn-primary">
                <i class="fas fa-plus"></i> New Booking
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Phone</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                   <tbody>
                        <?php if (!empty($recentBookings)): ?>
                            <?php $i = 1; ?>
                            <?php foreach ($recentBookings as $booking): ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= htmlspecialchars($booking['user_name']) ?></td>
                                    <td><?= htmlspecialchars($booking['phone']) ?></td>
                                    <td><?= date('M j, Y', strtotime($booking['booking_date'])) ?></td>
                                    <td><?= date('g:i A', strtotime($booking['booking_time'])) ?></td>
                                    <td>
                                        <?php
                                            $status = ucfirst($booking['status']);
                                            $badgeClass = match ($status) {
                                                'Confirmed' => 'bg-success',
                                                'Pending' => 'bg-warning',
                                                'Cancelled' => 'bg-danger',
                                                default => 'bg-secondary',
                                            };
                                        ?>
                                        <span class="badge <?= $badgeClass ?>"><?= $status ?></span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary" title="Message">
                                            <i class="fas fa-comment"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">
                                    <div  class="alert alert-warning" role="alert">No recent bookings found.</div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>

                    <!-- More booking rows -->
                </tbody>
            </table>
        </div>
    </div>
</div>