<?php
session_start();
require_once '../includes/auth.php';

// Check if user is authenticated and has appropriate permissions
if (!isLoggedIn() || (!isAdmin() && !isTherapist())) {
    header('Location: ../index.php');
    exit();
}

$user_role = getUserRole();
$user_id = $_SESSION['user_id'];

// Get patients based on role
$patients = getPatientsData($user_role, $user_id);
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
                    <?php echo isAdmin() ? 'Patient Management' : 'My Patients'; ?>
                </h2>
                <div>
                    <button class="btn btn-outline-custom" onclick="exportPatients()">
                        <i class="fas fa-download me-2"></i>Export Report
                    </button>
                </div>
            </div>

            <!-- Patient Statistics -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card stat-card">
                        <div class="stat-icon" style="background: rgba(33, 150, 243, 0.1); color: #2196F3;">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-number"><?php echo count($patients); ?></div>
                        <div class="stat-label">Total Patients</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card stat-card">
                        <div class="stat-icon" style="background: rgba(76, 175, 80, 0.1); color: #4CAF50;">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <div class="stat-number"><?php echo count(array_filter($patients, fn($p) => !empty($p['last_session']))); ?></div>
                        <div class="stat-label">Active Patients</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card stat-card">
                        <div class="stat-icon" style="background: rgba(255, 152, 0, 0.1); color: #FF9800;">
                            <i class="fas fa-calendar-plus"></i>
                        </div>
                        <div class="stat-number"><?php echo count(array_filter($patients, fn($p) => empty($p['last_session']))); ?></div>
                        <div class="stat-label">New Patients</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card stat-card">
                        <div class="stat-icon" style="background: rgba(168, 195, 164, 0.1); color: #A8C3A4;">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="stat-number">87%</div>
                        <div class="stat-label">Improvement Rate</div>
                    </div>
                </div>
            </div>

            <!-- Search and Filter -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="searchPatients" placeholder="Search patients...">
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="ageFilter">
                                <option value="">All Ages</option>
                                <option value="18-25">18-25</option>
                                <option value="26-35">26-35</option>
                                <option value="36-45">36-45</option>
                                <option value="46+">46+</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="statusFilter">
                                <option value="">All Status</option>
                                <option value="active">Active</option>
                                <option value="new">New</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-outline-secondary w-100" onclick="clearFilters()">Clear</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Patients Grid -->
            <div class="row" id="patientsGrid">
                <?php if (empty($patients)): ?>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body text-center">
                                <i class="fas fa-user-injured fa-3x text-muted mb-3"></i>
                                <h5>No patients found</h5>
                                <p class="text-muted">No patient records are available at this time.</p>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <?php foreach ($patients as $patient): ?>
                    <div class="col-lg-4 col-md-6 mb-4 patient-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="user-avatar-small bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                        <?php echo strtoupper(substr($patient['full_name'] ?? 'P', 0, 1)); ?>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1"><?php echo htmlspecialchars($patient['full_name'] ?? 'No Name'); ?></h6>
                                        <small class="text-muted"><?php echo htmlspecialchars($patient['email']); ?></small>
                                    </div>
                                    <span class="badge bg-<?php echo !empty($patient['last_session']) ? 'success' : 'warning'; ?>">
                                        <?php echo !empty($patient['last_session']) ? 'Active' : 'New'; ?>
                                    </span>
                                </div>
                                
                                <div class="patient-details">
                                    <div class="row">
                                        <div class="col-6">
                                            <small class="text-muted">Age</small>
                                            <p class="mb-2"><?php echo htmlspecialchars($patient['age'] ?? 'Not specified'); ?></p>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">Location</small>
                                            <p class="mb-2"><?php echo htmlspecialchars($patient['location'] ?? 'Not specified'); ?></p>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">Sessions</small>
                                            <p class="mb-2"><?php echo $patient['session_count'] ?? 0; ?></p>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">Last Session</small>
                                            <p class="mb-2"><?php echo $patient['last_session'] ? date('M j', strtotime($patient['last_session'])) : 'None'; ?></p>
                                        </div>
                                    </div>
                                    
                                    <?php if (!empty($patient['primary_concern'])): ?>
                                    <div class="mt-2">
                                        <small class="text-muted">Primary Concern</small>
                                        <p class="small"><?php echo htmlspecialchars($patient['primary_concern']); ?></p>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="mt-3">
                                    <button class="btn btn-sm btn-primary-custom" onclick="viewPatientDetails(<?php echo $patient['id']; ?>)">
                                        View Details
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary ms-2" onclick="contactPatient('<?php echo $patient['email']; ?>')">
                                        Contact
                                    </button>
                                    <?php if (isTherapist()): ?>
                                        <button class="btn btn-sm btn-outline-success ms-2" onclick="scheduleSession(<?php echo $patient['id']; ?>)">
                                            Schedule
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        function viewPatientDetails(patientId) {
            window.location.href = `patient-details.php?id=${patientId}`;
        }

        function contactPatient(email) {
            window.location.href = 'mailto:' + email;
        }

        function scheduleSession(patientId) {
            window.location.href = `schedule-session.php?patient_id=${patientId}`;
        }

        function exportPatients() {
            window.location.href = 'export-patients.php';
        }

        function clearFilters() {
            document.getElementById('searchPatients').value = '';
            document.getElementById('ageFilter').value = '';
            document.getElementById('statusFilter').value = '';
            filterPatients();
        }

        function filterPatients() {
            const searchTerm = document.getElementById('searchPatients').value.toLowerCase();
            const ageFilter = document.getElementById('ageFilter').value;
            const statusFilter = document.getElementById('statusFilter').value;
            const cards = document.querySelectorAll('.patient-card');

            cards.forEach(card => {
                const text = card.textContent.toLowerCase();
                const badge = card.querySelector('.badge').textContent.toLowerCase();
                
                let showCard = true;
                
                if (searchTerm && !text.includes(searchTerm)) {
                    showCard = false;
                }
                
                if (statusFilter && !badge.includes(statusFilter)) {
                    showCard = false;
                }
                
                card.style.display = showCard ? 'block' : 'none';
            });
        }

        document.getElementById('searchPatients').addEventListener('input', filterPatients);
        document.getElementById('ageFilter').addEventListener('change', filterPatients);
        document.getElementById('statusFilter').addEventListener('change', filterPatients);
    </script>

    <?php include '../templates/footer.php'; ?>
</body>
</html>
