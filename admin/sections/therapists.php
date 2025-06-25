<?php
session_start();
require_once '../includes/auth.php';

if (!isLoggedIn() || getUserRole() !== 'admin') {
    header('Location: ../index.php');
    exit();
}

$therapists = [
    [
        'id' => 1,
        'name' => 'Dr. Sarah Johnson',
        'email' => 'sarah.johnson@luna.com',
        'phone' => '+1 (555) 123-4567',
        'specialization' => 'Cognitive Behavioral Therapy, Anxiety Disorders',
        'license' => 'LPC-12345',
        'experience' => '8 years',
        'patients_count' => 28,
        'sessions_count' => 156,
        'rating' => 4.9,
        'status' => 'active',
        'joined_date' => '2023-01-15',
        'education' => 'PhD Psychology - Stanford University',
        'certifications' => 'CBT Certified, EMDR Level 2'
    ],
    [
        'id' => 2,
        'name' => 'Dr. Michael Wilson',
        'email' => 'michael.wilson@luna.com',
        'phone' => '+1 (555) 234-5678',
        'specialization' => 'PTSD, Trauma Therapy, Veterans Care',
        'license' => 'LPC-23456',
        'experience' => '12 years',
        'patients_count' => 32,
        'sessions_count' => 203,
        'rating' => 4.8,
        'status' => 'active',
        'joined_date' => '2023-02-20',
        'education' => 'PsyD Clinical Psychology - UCLA',
        'certifications' => 'PTSD Specialist, Trauma-Informed Care'
    ],
    [
        'id' => 3,
        'name' => 'Dr. Lisa Anderson',
        'email' => 'lisa.anderson@luna.com',
        'phone' => '+1 (555) 345-6789',
        'specialization' => 'Family Therapy, Couples Counseling',
        'license' => 'LMFT-34567',
        'experience' => '10 years',
        'patients_count' => 24,
        'sessions_count' => 142,
        'rating' => 4.7,
        'status' => 'active',
        'joined_date' => '2023-03-10',
        'education' => 'MA Marriage & Family Therapy - USC',
        'certifications' => 'Gottman Method, EFT Certified'
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
                    <h1 class="page-title">Therapist Management</h1>
                    <p class="page-subtitle">Manage professional staff and credentials</p>
                </div>
            </div>
            <div class="top-bar-actions">
                <button class="btn btn-luna-primary" data-bs-toggle="modal" data-bs-target="#addTherapistModal">
                    <i class="fas fa-user-md me-2"></i>Add Therapist
                </button>
            </div>
        </div>
        
        <div class="container-fluid p-4">
            <!-- Statistics -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="stat-label">Total Therapists</p>
                                <h3 class="stat-number"><?php echo count($therapists); ?></h3>
                                <span class="stat-change positive">
                                    <i class="fas fa-arrow-up"></i> +2 this month
                                </span>
                            </div>
                            <div class="stat-icon icon-success">
                                <i class="fas fa-user-md"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="stat-label">Active Therapists</p>
                                <h3 class="stat-number"><?php echo count(array_filter($therapists, fn($t) => $t['status'] === 'active')); ?></h3>
                                <span class="stat-change positive">
                                    <i class="fas fa-check-circle"></i> All active
                                </span>
                            </div>
                            <div class="stat-icon icon-primary">
                                <i class="fas fa-heartbeat"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="stat-label">Total Patients</p>
                                <h3 class="stat-number"><?php echo array_sum(array_column($therapists, 'patients_count')); ?></h3>
                                <span class="stat-change positive">
                                    <i class="fas fa-users"></i> Under care
                                </span>
                            </div>
                            <div class="stat-icon icon-warning">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="stat-label">Avg Rating</p>
                                <h3 class="stat-number"><?php echo round(array_sum(array_column($therapists, 'rating')) / count($therapists), 1); ?></h3>
                                <span class="stat-change positive">
                                    <i class="fas fa-star"></i> Excellent
                                </span>
                            </div>
                            <div class="stat-icon icon-warning">
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Therapists Grid -->
            <div class="row">
                <?php foreach ($therapists as $therapist): ?>
                <div class="col-lg-6 col-xl-4 mb-4">
                    <div class="stat-card therapist-card">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="d-flex align-items-center">
                                <div class="user-avatar me-3" style="width: 60px; height: 60px; font-size: 1.5rem;">
                                    <?php echo strtoupper(substr($therapist['name'], 0, 1)); ?>
                                </div>
                                <div>
                                    <h6 class="mb-0"><?php echo htmlspecialchars($therapist['name']); ?></h6>
                                    <small class="text-muted"><?php echo $therapist['license']; ?></small>
                                    <div class="text-warning small">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <i class="fas fa-star<?php echo $i <= $therapist['rating'] ? '' : '-o'; ?>"></i>
                                        <?php endfor; ?>
                                        <span class="ms-1"><?php echo $therapist['rating']; ?></span>
                                    </div>
                                </div>
                            </div>
                            <span class="badge bg-success">Active</span>
                        </div>

                        <div class="mb-3">
                            <div class="small text-muted mb-1">Specialization</div>
                            <div class="fw-semibold"><?php echo htmlspecialchars($therapist['specialization']); ?></div>
                        </div>

                        <div class="mb-3">
                            <div class="small text-muted mb-1">Education</div>
                            <div class="small"><?php echo htmlspecialchars($therapist['education']); ?></div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-4">
                                <div class="small text-muted">Patients</div>
                                <div class="fw-bold text-primary"><?php echo $therapist['patients_count']; ?></div>
                            </div>
                            <div class="col-4">
                                <div class="small text-muted">Sessions</div>
                                <div class="fw-bold text-success"><?php echo $therapist['sessions_count']; ?></div>
                            </div>
                            <div class="col-4">
                                <div class="small text-muted">Experience</div>
                                <div class="fw-bold text-warning"><?php echo $therapist['experience']; ?></div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="small text-muted mb-1">Certifications</div>
                            <div class="small"><?php echo htmlspecialchars($therapist['certifications']); ?></div>
                        </div>

                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-outline-primary flex-fill" onclick="viewTherapist(<?php echo $therapist['id']; ?>)">
                                <i class="fas fa-eye me-1"></i>View
                            </button>
                            <button class="btn btn-sm btn-outline-success flex-fill" onclick="editTherapist(<?php echo $therapist['id']; ?>)">
                                <i class="fas fa-edit me-1"></i>Edit
                            </button>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-users me-2"></i>View Patients</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-calendar me-2"></i>Schedule</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-chart-bar me-2"></i>Performance</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-warning" href="#"><i class="fas fa-pause me-2"></i>Suspend</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Add Therapist Modal -->
    <div class="modal fade" id="addTherapistModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Therapist</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addTherapistForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Full Name *</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email *</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone</label>
                                <input type="tel" class="form-control" name="phone">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">License Number *</label>
                                <input type="text" class="form-control" name="license" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Specialization *</label>
                            <textarea class="form-control" name="specialization" rows="2" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Education</label>
                                <input type="text" class="form-control" name="education">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Years of Experience</label>
                                <input type="number" class="form-control" name="experience" min="0">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Certifications</label>
                            <textarea class="form-control" name="certifications" rows="2"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-luna-primary" onclick="submitTherapist()">Add Therapist</button>
                </div>
            </div>
        </div>
    </div>

    <?php include '../templates/footer.php'; ?>
    <script src="../assets/js/simple-luna.js"></script>
    
    <script>
        function viewTherapist(id) {
            showToast(`Viewing therapist profile ${id}`, 'info');
        }

        function editTherapist(id) {
            showToast(`Editing therapist ${id}`, 'info');
        }

        function submitTherapist() {
            showToast('Therapist added successfully!', 'success');
            bootstrap.Modal.getInstance(document.getElementById('addTherapistModal')).hide();
        }
    </script>

    <style>
        .therapist-card {
            transition: all 0.3s ease;
        }
        
        .therapist-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        }
    </style>
</body>
</html>
