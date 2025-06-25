<?php
session_start();
require_once '../includes/auth.php';

if (!isLoggedIn() || getUserRole() !== 'therapist') {
    header('Location: ../index.php');
    exit();
}

$appointments = [
    [
        'id' => 1,
        'patient_name' => 'Emily Rodriguez',
        'patient_id' => 1,
        'date' => '2024-06-27',
        'time' => '14:00:00',
        'duration' => 60,
        'type' => 'Video Call',
        'status' => 'confirmed',
        'notes' => 'Follow-up on anxiety management techniques',
        'session_type' => 'CBT Session'
    ],
    [
        'id' => 2,
        'patient_name' => 'Michael Chen',
        'patient_id' => 2,
        'date' => '2024-06-28',
        'time' => '10:00:00',
        'duration' => 60,
        'type' => 'Video Call',
        'status' => 'confirmed',
        'notes' => 'PTSD therapy session',
        'session_type' => 'Trauma Therapy'
    ],
    [
        'id' => 3,
        'patient_name' => 'Sarah Davis',
        'patient_id' => 3,
        'date' => '2024-06-29',
        'time' => '16:00:00',
        'duration' => 60,
        'type' => 'In-Person',
        'status' => 'pending',
        'notes' => 'Bipolar disorder management',
        'session_type' => 'Follow-up'
    ],
    [
        'id' => 4,
        'patient_name' => 'David Thompson',
        'patient_id' => 4,
        'date' => '2024-06-30',
        'time' => '11:00:00',
        'duration' => 60,
        'type' => 'Video Call',
        'status' => 'requested',
        'notes' => 'Initial consultation for social anxiety',
        'session_type' => 'Initial Assessment'
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<?php include '../templates/header.php'; ?>
<body>
    <?php include '../templates/sidebar.php'; ?>
    
    <div class="main-content">
        <div class="top-bar">
            <div class="page-info d-flex align-items-center">
                <button class="btn me-3" id="sidebarToggle" style="background: var(--luna-primary); color: white; border-radius: 8px;">
                    <i class="fas fa-bars"></i>
                </button>
                <div>
                    <h1 class="page-title">Appointments</h1>
                    <p class="page-subtitle">Manage your therapy sessions and schedule</p>
                </div>
            </div>
            <div class="top-bar-actions">
                <button class="btn btn-luna-primary" data-bs-toggle="modal" data-bs-target="#scheduleModal">
                    <i class="fas fa-calendar-plus me-2"></i>Schedule Appointment
                </button>
            </div>
        </div>
        
        <div class="container-fluid p-4">
            <!-- Quick Stats -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="stat-label">Today's Sessions</p>
                                <h3 class="stat-number">3</h3>
                                <span class="stat-change positive">
                                    <i class="fas fa-calendar-day"></i> Scheduled
                                </span>
                            </div>
                            <div class="stat-icon icon-primary">
                                <i class="fas fa-calendar-day"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="stat-label">This Week</p>
                                <h3 class="stat-number">12</h3>
                                <span class="stat-change positive">
                                    <i class="fas fa-arrow-up"></i> +2 from last week
                                </span>
                            </div>
                            <div class="stat-icon icon-success">
                                <i class="fas fa-calendar-week"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="stat-label">Pending Requests</p>
                                <h3 class="stat-number">2</h3>
                                <span class="stat-change warning">
                                    <i class="fas fa-clock"></i> Needs attention
                                </span>
                            </div>
                            <div class="stat-icon icon-warning">
                                <i class="fas fa-clock"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="stat-label">Completion Rate</p>
                                <h3 class="stat-number">94%</h3>
                                <span class="stat-change positive">
                                    <i class="fas fa-check-circle"></i> Excellent
                                </span>
                            </div>
                            <div class="stat-icon icon-success">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Appointments List -->
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0">
                        <i class="fas fa-calendar-alt text-primary me-2"></i>
                        Upcoming Appointments
                    </h5>
                    <div class="d-flex gap-2">
                        <select class="form-select" style="width: auto;">
                            <option>All Status</option>
                            <option>Confirmed</option>
                            <option>Pending</option>
                            <option>Requested</option>
                        </select>
                        <select class="form-select" style="width: auto;">
                            <option>This Week</option>
                            <option>Next Week</option>
                            <option>This Month</option>
                        </select>
                    </div>
                </div>

                <div class="appointments-list">
                    <?php foreach ($appointments as $appointment): ?>
                    <div class="appointment-item">
                        <div class="appointment-time">
                            <div class="date-display">
                                <div class="day"><?php echo date('j', strtotime($appointment['date'])); ?></div>
                                <div class="month"><?php echo date('M', strtotime($appointment['date'])); ?></div>
                            </div>
                            <div class="time-display">
                                <div class="time"><?php echo date('g:i A', strtotime($appointment['time'])); ?></div>
                                <div class="duration"><?php echo $appointment['duration']; ?> min</div>
                            </div>
                        </div>

                        <div class="appointment-details">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="mb-1"><?php echo htmlspecialchars($appointment['patient_name']); ?></h6>
                                    <div class="text-muted small"><?php echo htmlspecialchars($appointment['session_type']); ?></div>
                                </div>
                                <span class="badge <?php 
                                    echo $appointment['status'] === 'confirmed' ? 'bg-success' : 
                                        ($appointment['status'] === 'pending' ? 'bg-warning' : 'bg-info'); 
                                ?>">
                                    <?php echo ucfirst($appointment['status']); ?>
                                </span>
                            </div>

                            <div class="mb-2">
                                <div class="d-flex align-items-center gap-3">
                                    <span class="badge bg-secondary">
                                        <i class="fas <?php echo $appointment['type'] === 'Video Call' ? 'fa-video' : 'fa-user'; ?> me-1"></i>
                                        <?php echo $appointment['type']; ?>
                                    </span>
                                    <small class="text-muted">
                                        <i class="fas fa-sticky-note me-1"></i>
                                        <?php echo htmlspecialchars($appointment['notes']); ?>
                                    </small>
                                </div>
                            </div>

                            <div class="appointment-actions">
                                <?php if ($appointment['status'] === 'confirmed'): ?>
                                    <button class="btn btn-sm btn-success" onclick="startSession(<?php echo $appointment['id']; ?>)">
                                        <i class="fas fa-play me-1"></i>Start Session
                                    </button>
                                <?php elseif ($appointment['status'] === 'requested'): ?>
                                    <button class="btn btn-sm btn-success" onclick="confirmAppointment(<?php echo $appointment['id']; ?>)">
                                        <i class="fas fa-check me-1"></i>Confirm
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger" onclick="declineAppointment(<?php echo $appointment['id']; ?>)">
                                        <i class="fas fa-times me-1"></i>Decline
                                    </button>
                                <?php endif; ?>
                                
                                <button class="btn btn-sm btn-outline-primary" onclick="viewPatient(<?php echo $appointment['patient_id']; ?>)">
                                    <i class="fas fa-user me-1"></i>Patient
                                </button>
                                <button class="btn btn-sm btn-outline-secondary" onclick="reschedule(<?php echo $appointment['id']; ?>)">
                                    <i class="fas fa-calendar-alt me-1"></i>Reschedule
                                </button>
                                
                                <div class="dropdown d-inline">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-sticky-note me-2"></i>Add Notes</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-phone me-2"></i>Call Patient</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-envelope me-2"></i>Send Message</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-ban me-2"></i>Cancel</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Schedule Modal -->
    <div class="modal fade" id="scheduleModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Schedule New Appointment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="scheduleForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Patient *</label>
                                <select class="form-select" name="patient" required>
                                    <option value="">Select Patient</option>
                                    <option value="1">Emily Rodriguez</option>
                                    <option value="2">Michael Chen</option>
                                    <option value="3">Sarah Davis</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Session Type *</label>
                                <select class="form-select" name="session_type" required>
                                    <option value="">Select Type</option>
                                    <option value="Initial Assessment">Initial Assessment</option>
                                    <option value="CBT Session">CBT Session</option>
                                    <option value="Follow-up">Follow-up</option>
                                    <option value="Crisis Session">Crisis Session</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Date *</label>
                                <input type="date" class="form-control" name="date" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Time *</label>
                                <input type="time" class="form-control" name="time" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Duration (minutes)</label>
                                <select class="form-select" name="duration">
                                    <option value="30">30 minutes</option>
                                    <option value="45">45 minutes</option>
                                    <option value="60" selected>60 minutes</option>
                                    <option value="90">90 minutes</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Meeting Type</label>
                                <select class="form-select" name="type">
                                    <option value="Video Call">Video Call</option>
                                    <option value="In-Person">In-Person</option>
                                    <option value="Phone Call">Phone Call</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Session Notes</label>
                            <textarea class="form-control" name="notes" rows="3" placeholder="Preparation notes or session focus..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-luna-primary" onclick="submitSchedule()">Schedule Appointment</button>
                </div>
            </div>
        </div>
    </div>

    <?php include '../templates/footer.php'; ?>
    <script src="../assets/js/simple-luna.js"></script>
    
    <script>
        function startSession(id) {
            showToast(`Starting session ${id}`, 'success');
        }

        function confirmAppointment(id) {
            showToast(`Appointment ${id} confirmed`, 'success');
        }

        function declineAppointment(id) {
            showToast(`Appointment ${id} declined`, 'warning');
        }

        function viewPatient(id) {
            showToast(`Opening patient profile ${id}`, 'info');
        }

        function reschedule(id) {
            showToast(`Rescheduling appointment ${id}`, 'info');
        }

        function submitSchedule() {
            showToast('Appointment scheduled successfully!', 'success');
            bootstrap.Modal.getInstance(document.getElementById('scheduleModal')).hide();
        }
    </script>

    <style>
        .appointments-list {
            max-height: 600px;
            overflow-y: auto;
        }

        .appointment-item {
            display: flex;
            padding: 1.5rem;
            border: 1px solid #e9ecef;
            border-radius: 12px;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .appointment-item:hover {
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border-color: var(--luna-primary);
        }

        .appointment-time {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-right: 2rem;
            min-width: 100px;
        }

        .date-display {
            text-align: center;
            margin-bottom: 0.5rem;
        }

        .day {
            font-size: 2rem;
            font-weight: bold;
            color: var(--luna-primary);
            line-height: 1;
        }

        .month {
            font-size: 0.9rem;
            color: var(--luna-gray);
            text-transform: uppercase;
        }

        .time-display {
            text-align: center;
        }

        .time {
            font-weight: 600;
            color: var(--luna-dark);
        }

        .duration {
            font-size: 0.8rem;
            color: var(--luna-gray);
        }

        .appointment-details {
            flex: 1;
        }

        .appointment-actions {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            margin-top: 1rem;
        }

        @media (max-width: 768px) {
            .appointment-item {
                flex-direction: column;
            }
            
            .appointment-time {
                flex-direction: row;
                justify-content: space-between;
                margin-right: 0;
                margin-bottom: 1rem;
                min-width: auto;
            }
        }
    </style>
</body>
</html>
