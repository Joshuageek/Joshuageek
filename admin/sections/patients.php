<?php
session_start();
require_once '../includes/auth.php';

if (!isLoggedIn() || getUserRole() !== 'admin') {
    header('Location: ../index.php');
    exit();
}

$patients = [
    [
        'id' => 1,
        'name' => 'Emily Rodriguez',
        'email' => 'emily.rodriguez@email.com',
        'phone' => '+1 (555) 123-4567',
        'age' => 28,
        'gender' => 'Female',
        'therapist' => 'Dr. Sarah Johnson',
        'therapist_id' => 1,
        'condition' => 'Anxiety, Depression',
        'status' => 'active',
        'last_session' => '2024-06-23 14:00:00',
        'total_sessions' => 23,
        'progress_score' => 78,
        'joined_date' => '2024-03-10',
        'insurance' => 'Blue Cross Blue Shield',
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
        'therapist' => 'Dr. Michael Wilson',
        'therapist_id' => 2,
        'condition' => 'PTSD, Sleep Disorders',
        'status' => 'active',
        'last_session' => '2024-06-24 10:00:00',
        'total_sessions' => 31,
        'progress_score' => 65,
        'joined_date' => '2024-02-15',
        'insurance' => 'Aetna',
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
        'therapist' => 'Dr. Lisa Anderson',
        'therapist_id' => 3,
        'condition' => 'Bipolar Disorder',
        'status' => 'active',
        'last_session' => '2024-06-22 16:00:00',
        'total_sessions' => 45,
        'progress_score' => 82,
        'joined_date' => '2023-11-20',
        'insurance' => 'United Healthcare',
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
        'therapist' => 'Dr. Sarah Johnson',
        'therapist_id' => 1,
        'condition' => 'Social Anxiety',
        'status' => 'inactive',
        'last_session' => '2024-06-10 11:00:00',
        'total_sessions' => 12,
        'progress_score' => 45,
        'joined_date' => '2024-04-05',
        'insurance' => 'Cigna',
        'emergency_contact' => 'Nancy Thompson - Mother',
        'emergency_phone' => '+1 (555) 654-3210'
    ],
    [
        'id' => 5,
        'name' => 'Jessica Martinez',
        'email' => 'jessica.martinez@email.com',
        'phone' => '+1 (555) 567-8901',
        'age' => 24,
        'gender' => 'Female',
        'therapist' => 'Dr. Michael Wilson',
        'therapist_id' => 2,
        'condition' => 'Eating Disorder, Body Dysmorphia',
        'status' => 'active',
        'last_session' => '2024-06-25 15:00:00',
        'total_sessions' => 18,
        'progress_score' => 72,
        'joined_date' => '2024-01-20',
        'insurance' => 'Kaiser Permanente',
        'emergency_contact' => 'Carlos Martinez - Father',
        'emergency_phone' => '+1 (555) 543-2109'
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
    
    <div class="main-content">
        <div class="top-bar">
            <div class="page-info d-flex align-items-center">
                <button class="btn me-3" id="sidebarToggle" style="background: var(--luna-primary); color: white; border-radius: 8px;">
                    <i class="fas fa-bars"></i>
                </button>
                <div>
                    <h1 class="page-title">Patient Management</h1>
                    <p class="page-subtitle">Comprehensive patient records and care coordination</p>
                </div>
            </div>
            <div class="top-bar-actions">
                <button class="btn btn-outline-secondary me-2" onclick="exportPatients()">
                    <i class="fas fa-download me-2"></i>Export
                </button>
                <button class="btn btn-luna-primary" data-bs-toggle="modal" data-bs-target="#addPatientModal">
                    <i class="fas fa-user-plus me-2"></i>Add Patient
                </button>
            </div>
        </div>
        
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
                                    <i class="fas fa-arrow-up"></i> +8% this month
                                </span>
                            </div>
                            <div class="stat-icon icon-primary">
                                <i class="fas fa-users"></i>
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
                                    <i class="fas fa-heartbeat"></i> Currently in care
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

            <!-- Patients Table -->
            <div class="stat-card animate-in">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0">
                        <i class="fas fa-user-friends text-primary me-2"></i>
                        All Patients
                    </h5>
                    <div class="d-flex gap-2">
                        <div class="search-box" style="width: 250px;">
                            <i class="fas fa-search"></i>
                            <input type="text" placeholder="Search patients..." id="patientSearch">
                        </div>
                        <select class="form-select" style="width: auto;" id="therapistFilter">
                            <option value="">All Therapists</option>
                            <option value="1">Dr. Sarah Johnson</option>
                            <option value="2">Dr. Michael Wilson</option>
                            <option value="3">Dr. Lisa Anderson</option>
                        </select>
                        <select class="form-select" style="width: auto;" id="statusFilter">
                            <option value="">All Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Patient</th>
                                <th>Therapist</th>
                                <th>Condition</th>
                                <th>Progress</th>
                                <th>Sessions</th>
                                <th>Last Session</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($patients as $patient): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="user-avatar me-3" style="width: 40px; height: 40px; font-size: 1rem;">
                                            <?php echo strtoupper(substr($patient['name'], 0, 1)); ?>
                                        </div>
                                        <div>
                                            <h6 class="mb-0"><?php echo htmlspecialchars($patient['name']); ?></h6>
                                            <small class="text-muted"><?php echo $patient['age']; ?> years • <?php echo $patient['gender']; ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <div class="fw-semibold"><?php echo htmlspecialchars($patient['therapist']); ?></div>
                                        <small class="text-muted">Primary Therapist</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="small"><?php echo htmlspecialchars($patient['condition']); ?></div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress me-2" style="width: 60px; height: 6px;">
                                            <div class="progress-bar bg-success" style="width: <?php echo $patient['progress_score']; ?>%"></div>
                                        </div>
                                        <span class="small fw-bold"><?php echo $patient['progress_score']; ?>%</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-bold text-primary"><?php echo $patient['total_sessions']; ?></span>
                                </td>
                                <td>
                                    <div class="small">
                                        <?php echo date('M j, Y', strtotime($patient['last_session'])); ?>
                                        <div class="text-muted"><?php echo date('g:i A', strtotime($patient['last_session'])); ?></div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge <?php echo $patient['status'] === 'active' ? 'bg-success' : 'bg-secondary'; ?>">
                                        <?php echo ucfirst($patient['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                            Actions
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#" onclick="viewPatient(<?php echo $patient['id']; ?>)">
                                                <i class="fas fa-eye me-2"></i>View Profile
                                            </a></li>
                                            <li><a class="dropdown-item" href="#" onclick="editPatient(<?php echo $patient['id']; ?>)">
                                                <i class="fas fa-edit me-2"></i>Edit Details
                                            </a></li>
                                            <li><a class="dropdown-item" href="#" onclick="viewSessions(<?php echo $patient['id']; ?>)">
                                                <i class="fas fa-calendar me-2"></i>View Sessions
                                            </a></li>
                                            <li><a class="dropdown-item" href="#" onclick="viewProgress(<?php echo $patient['id']; ?>)">
                                                <i class="fas fa-chart-line me-2"></i>Progress Report
                                            </a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item" href="#" onclick="assignTherapist(<?php echo $patient['id']; ?>)">
                                                <i class="fas fa-user-md me-2"></i>Assign Therapist
                                            </a></li>
                                            <li><a class="dropdown-item" href="#" onclick="contactPatient(<?php echo $patient['id']; ?>)">
                                                <i class="fas fa-phone me-2"></i>Contact Patient
                                            </a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Showing 1 to <?php echo count($patients); ?> of <?php echo $total_patients; ?> patients
                    </div>
                    <nav>
                        <ul class="pagination pagination-sm mb-0">
                            <li class="page-item disabled">
                                <a class="page-link" href="#">Previous</a>
                            </li>
                            <li class="page-item active">
                                <a class="page-link" href="#">1</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">2</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">3</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
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
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Assign Therapist</label>
                                <select class="form-select" name="therapist">
                                    <option value="">Select Therapist</option>
                                    <option value="1">Dr. Sarah Johnson</option>
                                    <option value="2">Dr. Michael Wilson</option>
                                    <option value="3">Dr. Lisa Anderson</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Insurance Provider</label>
                                <input type="text" class="form-control" name="insurance">
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
        function viewPatient(id) {
            showToast(`Opening patient profile ${id}`, 'info');
        }

        function editPatient(id) {
            showToast(`Editing patient ${id}`, 'info');
        }

        function viewSessions(id) {
            showToast(`Loading sessions for patient ${id}`, 'info');
        }

        function viewProgress(id) {
            showToast(`Loading progress report for patient ${id}`, 'info');
        }

        function assignTherapist(id) {
            showToast(`Assigning therapist to patient ${id}`, 'info');
        }

        function contactPatient(id) {
            showToast(`Opening contact options for patient ${id}`, 'info');
        }

        function exportPatients() {
            showToast('Exporting patient data...', 'info');
        }

        function submitAddPatient() {
            showToast('Patient added successfully!', 'success');
            bootstrap.Modal.getInstance(document.getElementById('addPatientModal')).hide();
        }

        // Search and filter functionality
        document.getElementById('patientSearch').addEventListener('input', function() {
            console.log('Searching for:', this.value);
        });

        document.getElementById('therapistFilter').addEventListener('change', function() {
            console.log('Filtering by therapist:', this.value);
        });

        document.getElementById('statusFilter').addEventListener('change', function() {
            console.log('Filtering by status:', this.value);
        });
    </script>
</body>
</html>
