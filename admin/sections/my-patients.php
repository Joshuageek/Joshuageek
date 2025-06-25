<?php
session_start();
require_once '../includes/auth.php';

// Check if user is authenticated and is therapist
if (!isLoggedIn() || getUserRole() !== 'therapist') {
    header('Location: ../index.php');
    exit();
}

// Sample patients data for the logged-in therapist
$patients = [
    [
        'id' => 1,
        'name' => 'Emily Rodriguez',
        'email' => 'emily.rodriguez@email.com',
        'phone' => '+1 (555) 123-4567',
        'age' => 28,
        'gender' => 'Female',
        'status' => 'active',
        'condition' => 'Anxiety, Depression',
        'last_session' => '2024-06-23 14:00:00',
        'next_session' => '2024-06-27 14:00:00',
        'total_sessions' => 23,
        'progress_score' => 78,
        'joined_date' => '2024-03-10',
        'emergency_contact' => 'Maria Rodriguez - Sister',
        'emergency_phone' => '+1 (555) 987-6543'
    ],
    [
        'id' => 2,
        'name' => 'Michael Chen',
        'email' => 'michael.chen@email.com',
        'phone' => '+1 (555) 234-5678',
        'age' => 35,
        'gender' => 'Male',
        'status' => 'active',
        'condition' => 'PTSD, Sleep Disorders',
        'last_session' => '2024-06-24 10:00:00',
        'next_session' => '2024-06-28 10:00:00',
        'total_sessions' => 31,
        'progress_score' => 65,
        'joined_date' => '2024-02-15',
        'emergency_contact' => 'Lisa Chen - Spouse',
        'emergency_phone' => '+1 (555) 876-5432'
    ],
    [
        'id' => 3,
        'name' => 'Sarah Davis',
        'email' => 'sarah.davis@email.com',
        'phone' => '+1 (555) 345-6789',
        'age' => 42,
        'gender' => 'Female',
        'status' => 'active',
        'condition' => 'Bipolar Disorder',
        'last_session' => '2024-06-22 16:00:00',
        'next_session' => '2024-06-29 16:00:00',
        'total_sessions' => 45,
        'progress_score' => 82,
        'joined_date' => '2023-11-20',
        'emergency_contact' => 'John Davis - Husband',
        'emergency_phone' => '+1 (555) 765-4321'
    ],
    [
        'id' => 4,
        'name' => 'David Thompson',
        'email' => 'david.thompson@email.com',
        'phone' => '+1 (555) 456-7890',
        'age' => 29,
        'gender' => 'Male',
        'status' => 'inactive',
        'condition' => 'Social Anxiety',
        'last_session' => '2024-06-10 11:00:00',
        'next_session' => null,
        'total_sessions' => 12,
        'progress_score' => 45,
        'joined_date' => '2024-04-05',
        'emergency_contact' => 'Nancy Thompson - Mother',
        'emergency_phone' => '+1 (555) 654-3210'
    ]
];

$total_patients = count($patients);
$active_patients = count(array_filter($patients, fn($p) => $p['status'] === 'active'));
$avg_progress = round(array_sum(array_column($patients, 'progress_score')) / $total_patients);
$total_sessions = array_sum(array_column($patients, 'total_sessions'));
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
                    <h1 class="page-title">My Patients</h1>
                    <p class="page-subtitle">Manage your patient caseload and track progress</p>
                </div>
            </div>
            <div class="top-bar-actions">
                <button class="btn btn-luna-primary" data-bs-toggle="modal" data-bs-target="#addPatientModal">
                    <i class="fas fa-user-plus me-2"></i>Add New Patient
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
                                <p class="stat-label">Total Patients</p>
                                <h3 class="stat-number"><?php echo $total_patients; ?></h3>
                                <span class="stat-change positive">
                                    <i class="fas fa-arrow-up"></i> +2 this month
                                </span>
                            </div>
                            <div class="stat-icon icon-primary">
                                <i class="fas fa-user-friends"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card animate-in animate-delay-1">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="stat-label">Active Patients</p>
                                <h3 class="stat-number"><?php echo $active_patients; ?></h3>
                                <span class="stat-change positive">
                                    <i class="fas fa-heart"></i> Currently in care
                                </span>
                            </div>
                            <div class="stat-icon icon-success">
                                <i class="fas fa-heartbeat"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card animate-in animate-delay-2">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="stat-label">Average Progress</p>
                                <h3 class="stat-number"><?php echo $avg_progress; ?>%</h3>
                                <span class="stat-change positive">
                                    <i class="fas fa-chart-line"></i> Excellent outcomes
                                </span>
                            </div>
                            <div class="stat-icon icon-warning">
                                <i class="fas fa-chart-line"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card animate-in animate-delay-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="stat-label">Total Sessions</p>
                                <h3 class="stat-number"><?php echo $total_sessions; ?></h3>
                                <span class="stat-change positive">
                                    <i class="fas fa-calendar-check"></i> This year
                                </span>
                            </div>
                            <div class="stat-icon icon-primary">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Patients Grid -->
            <div class="row">
                <?php foreach ($patients as $patient): ?>
                <div class="col-lg-6 col-xl-4 mb-4">
                    <div class="stat-card patient-card animate-in">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="d-flex align-items-center">
                                <div class="user-avatar me-3" style="width: 50px; height: 50px; font-size: 1.2rem;">
                                    <?php echo strtoupper(substr($patient['name'], 0, 1)); ?>
                                </div>
                                <div>
                                    <h6 class="mb-0"><?php echo htmlspecialchars($patient['name']); ?></h6>
                                    <small class="text-muted"><?php echo $patient['age']; ?> years old • <?php echo $patient['gender']; ?></small>
                                </div>
                            </div>
                            <span class="badge <?php echo $patient['status'] === 'active' ? 'bg-success' : 'bg-secondary'; ?>">
                                <?php echo ucfirst($patient['status']); ?>
                            </span>
                        </div>

                        <div class="mb-3">
                            <div class="small text-muted mb-1">Primary Conditions</div>
                            <div class="fw-semibold"><?php echo htmlspecialchars($patient['condition']); ?></div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-6">
                                <div class="small text-muted">Total Sessions</div>
                                <div class="fw-bold text-primary"><?php echo $patient['total_sessions']; ?></div>
                            </div>
                            <div class="col-6">
                                <div class="small text-muted">Progress Score</div>
                                <div class="fw-bold text-success"><?php echo $patient['progress_score']; ?>%</div>
                            </div>
                        </div>

                        <div class="progress mb-3" style="height: 6px;">
                            <div class="progress-bar bg-success" style="width: <?php echo $patient['progress_score']; ?>%"></div>
                        </div>

                        <div class="mb-3">
                            <div class="small text-muted">Last Session</div>
                            <div class="small"><?php echo date('M j, Y g:i A', strtotime($patient['last_session'])); ?></div>
                        </div>

                        <?php if ($patient['next_session']): ?>
                        <div class="mb-3">
                            <div class="small text-muted">Next Session</div>
                            <div class="small text-primary fw-semibold">
                                <?php echo date('M j, Y g:i A', strtotime($patient['next_session'])); ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-outline-primary flex-fill" onclick="viewPatient(<?php echo $patient['id']; ?>)">
                                <i class="fas fa-eye me-1"></i>View
                            </button>
                            <button class="btn btn-sm btn-outline-success flex-fill" onclick="scheduleSession(<?php echo $patient['id']; ?>)">
                                <i class="fas fa-calendar-plus me-1"></i>Schedule
                            </button>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#" onclick="editPatient(<?php echo $patient['id']; ?>)">
                                        <i class="fas fa-edit me-2"></i>Edit Details
                                    </a></li>
                                    <li><a class="dropdown-item" href="#" onclick="viewNotes(<?php echo $patient['id']; ?>)">
                                        <i class="fas fa-sticky-note me-2"></i>Session Notes
                                    </a></li>
                                    <li><a class="dropdown-item" href="#" onclick="viewProgress(<?php echo $patient['id']; ?>)">
                                        <i class="fas fa-chart-line me-2"></i>Progress Report
                                    </a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="#" onclick="contactPatient(<?php echo $patient['id']; ?>)">
                                        <i class="fas fa-phone me-2"></i>Contact Patient
                                    </a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Add Patient Modal -->
    <div class="modal fade" id="addPatientModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-user-plus me-2"></i>Add New Patient
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addPatientForm">
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
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Age *</label>
                                <input type="number" class="form-control" name="age" min="1" max="120" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Gender *</label>
                                <select class="form-select" name="gender" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Non-binary">Non-binary</option>
                                    <option value="Prefer not to say">Prefer not to say</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" name="phone">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Primary Conditions/Concerns</label>
                            <textarea class="form-control" name="condition" rows="3" placeholder="Brief description of primary mental health concerns..."></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Emergency Contact Name</label>
                                <input type="text" class="form-control" name="emergency_contact">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Emergency Contact Phone</label>
                                <input type="tel" class="form-control" name="emergency_phone">
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="send_welcome" id="sendWelcomePatient" checked>
                                <label class="form-check-label" for="sendWelcomePatient">
                                    Send welcome email with portal access instructions
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-luna-primary" onclick="submitAddPatient()">
                        <i class="fas fa-save me-2"></i>Add Patient
                    </button>
                </div>
            </div>
        </div>
    </div>

    <?php include '../templates/footer.php'; ?>
    
    <script src="../assets/js/simple-luna.js"></script>
    
    <script>
        // Patient management functions
        function viewPatient(patientId) {
            showToast(`Opening patient profile for ID: ${patientId}`, 'info');
            // In real app, redirect to patient detail page
        }

        function editPatient(patientId) {
            showToast(`Opening edit form for patient ID: ${patientId}`, 'info');
            // In real app, open edit modal or redirect to edit page
        }

        function scheduleSession(patientId) {
            showToast(`Opening session scheduler for patient ID: ${patientId}`, 'info');
            // In real app, open scheduling modal
        }

        function viewNotes(patientId) {
            showToast(`Loading session notes for patient ID: ${patientId}`, 'info');
            // In real app, redirect to notes page
        }

        function viewProgress(patientId) {
            showToast(`Loading progress report for patient ID: ${patientId}`, 'info');
            // In real app, redirect to progress page
        }

        function contactPatient(patientId) {
            showToast(`Opening contact options for patient ID: ${patientId}`, 'info');
            // In real app, show contact modal with phone/email options
        }

        function submitAddPatient() {
            const form = document.getElementById('addPatientForm');
            const formData = new FormData(form);
            
            // Basic validation
            if (!formData.get('name') || !formData.get('email') || !formData.get('age') || !formData.get('gender')) {
                showToast('Please fill in all required fields', 'error');
                return;
            }
            
            // In real app, submit to server
            showToast('Patient added successfully!', 'success');
            bootstrap.Modal.getInstance(document.getElementById('addPatientModal')).hide();
            form.reset();
        }
    </script>

    <style>
        .patient-card {
            transition: all 0.3s ease;
        }
        
        .patient-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        }
        
        .progress {
            border-radius: 10px;
            background-color: #e9ecef;
        }
        
        .progress-bar {
            border-radius: 10px;
        }
    </style>
</body>
</html>
