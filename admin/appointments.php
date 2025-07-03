<?php
session_start();
require_once 'includes/auth.php';
include 'templates/header.php';

// Check if user is authenticated
if (!isLoggedIn()) {
    header('Location: ../login.php');
    exit();
}

$user_role = getUserRole();
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'] ?? 'User';

// Sample appointments data
$appointments = [
    [
        'id' => 1,
        'date' => date('Y-m-d H:i:s', strtotime('+2 hours')),
        'duration' => 50,
        'type' => 'CBT Session',
        'status' => 'confirmed',
        'patient_name' => $user_role === 'therapist' ? 'Sarah M.' : null,
        'therapist_name' => $user_role === 'patient' ? 'Dr. Sarah Johnson' : null,
        'location' => 'Room 201',
        'notes' => 'Follow-up on anxiety management techniques'
    ],
    [
        'id' => 2,
        'date' => date('Y-m-d H:i:s', strtotime('+2 days')),
        'duration' => 45,
        'type' => 'Progress Review',
        'status' => 'pending',
        'patient_name' => $user_role === 'therapist' ? 'John D.' : null,
        'therapist_name' => $user_role === 'patient' ? 'Dr. Sarah Johnson' : null,
        'location' => 'Room 203',
        'notes' => 'Monthly progress assessment'
    ],
    [
        'id' => 3,
        'date' => date('Y-m-d H:i:s', strtotime('+5 days')),
        'duration' => 60,
        'type' => 'Family Therapy',
        'status' => 'confirmed',
        'patient_name' => $user_role === 'therapist' ? 'Emily R.' : null,
        'therapist_name' => $user_role === 'patient' ? 'Dr. Sarah Johnson' : null,
        'location' => 'Room 205',
        'notes' => 'Family session with spouse'
    ]
];

$stats = [
    'total_appointments' => 24,
    'this_week' => 3,
    'confirmed' => 20,
    'pending' => 4
];
?>

<!-- Appointments Content -->
<div class="container-fluid p-4">
    <!-- Appointments Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">
                <i class="fas fa-calendar-alt me-2"></i>
                <?php echo $user_role === 'therapist' ? 'Appointment Management' : 'My Appointments'; ?>
            </h2>
            <p class="text-muted mb-0">
                <?php echo $user_role === 'therapist' ? 'Schedule and manage patient appointments' : 'View and manage your therapy appointments'; ?>
            </p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-luna-primary" onclick="scheduleAppointment()">
                <i class="fas fa-plus me-2"></i>
                <?php echo $user_role === 'therapist' ? 'Schedule Appointment' : 'Request Appointment'; ?>
            </button>
            <button class="btn btn-luna-outline" onclick="viewCalendar()">
                <i class="fas fa-calendar me-2"></i>Calendar View
            </button>
        </div>
    </div>

    <!-- Appointment Stats -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="stat-label">Total Appointments</p>
                        <h4 class="stat-number"><?php echo $stats['total_appointments']; ?></h4>
                    </div>
                    <div class="stat-icon icon-primary">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="stat-label">This Week</p>
                        <h4 class="stat-number"><?php echo $stats['this_week']; ?></h4>
                    </div>
                    <div class="stat-icon icon-success">
                        <i class="fas fa-calendar-week"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="stat-label">Confirmed</p>
                        <h4 class="stat-number"><?php echo $stats['confirmed']; ?></h4>
                    </div>
                    <div class="stat-icon icon-success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="stat-label">Pending</p>
                        <h4 class="stat-number"><?php echo $stats['pending']; ?></h4>
                    </div>
                    <div class="stat-icon icon-warning">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Appointments List -->
    <div class="stat-card">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="mb-0">
                <i class="fas fa-list text-primary me-2"></i>
                Upcoming Appointments
            </h5>
            <div class="d-flex gap-2">
                <select class="form-select form-select-sm" style="width: auto;">
                    <option>All Appointments</option>
                    <option>This Week</option>
                    <option>Next Week</option>
                    <option>This Month</option>
                </select>
                <button class="btn btn-sm btn-outline-secondary" onclick="refreshAppointments()">
                    <i class="fas fa-sync-alt"></i>
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Date & Time</th>
                    <th><?php echo $user_role === 'therapist' ? 'Patient' : 'Therapist'; ?></th>
                    <th>Type</th>
                    <th>Duration</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($appointments as $appointment): ?>
                    <tr>
                        <td>
                            <div class="fw-semibold"><?php echo date('M j, Y', strtotime($appointment['date'])); ?></div>
                            <div class="small text-muted"><?php echo date('g:i A', strtotime($appointment['date'])); ?></div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="user-avatar me-2">
                                    <?php
                                    $name = $user_role === 'therapist' ? $appointment['patient_name'] : $appointment['therapist_name'];
                                    echo strtoupper(substr($name, 0, 1));
                                    ?>
                                </div>
                                <?php echo $name; ?>
                            </div>
                        </td>
                        <td><?php echo $appointment['type']; ?></td>
                        <td><?php echo $appointment['duration']; ?> min</td>
                        <td><?php echo $appointment['location']; ?></td>
                        <td>
                            <span class="badge bg-<?php echo $appointment['status'] === 'confirmed' ? 'success' : 'warning'; ?>">
                                <?php echo ucfirst($appointment['status']); ?>
                            </span>
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#" onclick="viewAppointment(<?php echo $appointment['id']; ?>)">
                                            <i class="fas fa-eye me-2"></i>View Details</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="editAppointment(<?php echo $appointment['id']; ?>)">
                                            <i class="fas fa-edit me-2"></i>Edit</a></li>
                                    <?php if ($appointment['status'] === 'pending'): ?>
                                        <li><a class="dropdown-item" href="#" onclick="confirmAppointment(<?php echo $appointment['id']; ?>)">
                                                <i class="fas fa-check me-2"></i>Confirm</a></li>
                                    <?php endif; ?>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger" href="#" onclick="cancelAppointment(<?php echo $appointment['id']; ?>)">
                                            <i class="fas fa-times me-2"></i>Cancel</a></li>
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

<script>
    function scheduleAppointment() {
        window.showToast('Opening appointment scheduler...', 'info');
    }

    function viewCalendar() {
        window.showToast('Loading calendar view...', 'info');
    }

    function refreshAppointments() {
        window.showToast('Refreshing appointments...', 'info');
    }

    function viewAppointment(id) {
        window.showToast(`Loading appointment ${id} details...`, 'info');
    }

    function editAppointment(id) {
        window.showToast(`Editing appointment ${id}...`, 'info');
    }

    function confirmAppointment(id) {
        window.showToast(`Confirming appointment ${id}...`, 'info');
    }

    function cancelAppointment(id) {
        if (confirm('Are you sure you want to cancel this appointment?')) {
            window.showToast(`Cancelling appointment ${id}...`, 'info');
        }
    }
</script>

<?php include 'templates/footer.php'; ?>
