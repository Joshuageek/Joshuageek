<?php
session_start();
// require_once '../config/database.php';
require_once 'includes/auth.php';

include 'templates/header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_role = getUserRole();
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'] ?? 'User';
$user_email = $_SESSION['user_email'] ?? 'user@example.com';

// Sample user data
$user_data = [
    'id' => $user_id,
    'name' => $user_name,
    'email' => $user_email,
    'phone' => '+1 (555) 123-4567',
    'role' => $user_role,
    'department' => $user_role === 'admin' ? 'Administration' : ($user_role === 'therapist' ? 'Clinical Services' : 'Patient'),
    'joined_date' => '2023-01-15',
    'last_login' => '2024-01-20 14:30:00',
    'timezone' => 'America/New_York',
    'language' => 'English',
    'avatar' => null,
    'bio' => $user_role === 'therapist' ? 'Licensed Clinical Social Worker specializing in anxiety and depression treatment.' : '',
    'specializations' => $user_role === 'therapist' ? ['Anxiety Disorders', 'Depression', 'Trauma Therapy', 'Cognitive Behavioral Therapy'] : [],
    'license_number' => $user_role === 'therapist' ? 'LCSW-12345' : '',
    'education' => $user_role === 'therapist' ? 'MSW, Columbia University School of Social Work' : ''
];
?>

<!-- Profile Header -->
<div class="profile-header text-center mb-4">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-3">
                <div class="profile-avatar mx-auto" onclick="document.getElementById('avatarUpload').click()">
                    <?= strtoupper(substr($user_data['name'], 0, 1)); ?>
                    <div class="avatar-upload">
                        <i class="fas fa-camera"></i>
                    </div>
                </div>
                <input type="file" id="avatarUpload" style="display: none;" accept="image/*">
            </div>
            <div class="col-md-6 text-white text-start">
                <h2><?= htmlspecialchars($user_data['name']) ?></h2>
                <p><i class="fas fa-user-tag me-2"></i> <?= ucfirst($user_data['role']) ?> Account</p>
                <p><i class="fas fa-envelope me-2"></i> <?= htmlspecialchars($user_data['email']) ?></p>
                <p><i class="fas fa-calendar me-2"></i> Member since <?= date('F Y', strtotime($user_data['joined_date'])) ?></p>
            </div>
            <div class="col-md-3 text-center">
                <button class="btn btn-luna-edit" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                    <i class="fas fa-edit me-2"></i>Edit Profile
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="container-fluid">
    <div class="row">
        <!-- Personal Information -->
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white fw-bold text-<?= $user_role === 'therapist' ? 'success' : 'primary' ?>">
                    <i class="fas fa-user me-2"></i>Personal Information
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-user me-2 text-primary"></i>Full Name</span>
                        <span><?= htmlspecialchars($user_data['name']) ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-envelope me-2 text-primary"></i>Email Address</span>
                        <span><?= htmlspecialchars($user_data['email']) ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-phone me-2 text-primary"></i>Phone Number</span>
                        <span><?= htmlspecialchars($user_data['phone']) ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-building me-2 text-primary"></i>Department</span>
                        <span><?= htmlspecialchars($user_data['department']) ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-globe me-2 text-primary"></i>Timezone</span>
                        <span><?= htmlspecialchars($user_data['timezone']) ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-language me-2 text-primary"></i>Language</span>
                        <span><?= htmlspecialchars($user_data['language']) ?></span>
                    </li>
                </ul>
            </div>

            <?php if ($user_role === 'therapist'): ?>
            <!-- Professional Information -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white fw-bold text-success">
                    <i class="fas fa-user-md me-2"></i>Professional Information
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-certificate me-2 text-success"></i>License Number</span>
                        <span><?= htmlspecialchars($user_data['license_number']) ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-graduation-cap me-2 text-success"></i>Education</span>
                        <span><?= htmlspecialchars($user_data['education']) ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-stethoscope me-2 text-success"></i>Specializations</span>
                        <div>
                            <?php foreach ($user_data['specializations'] as $spec): ?>
                                <span class="specialization-tag"><?= htmlspecialchars($spec) ?></span>
                            <?php endforeach; ?>
                        </div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-info-circle me-2 text-success"></i>Bio</span>
                        <span><?= htmlspecialchars($user_data['bio']) ?></span>
                    </li>
                </ul>
            </div>
            <?php endif; ?>
        </div>

        <!-- Sidebar - Account Activity & Quick Actions -->
        <div class="col-lg-4">
            <!-- Account Activity -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white fw-bold text-primary">
                    <i class="fas fa-clock me-2"></i>Account Activity
                </div>
                <div class="card-body p-0">
                    <div class="activity-item">
                        <div class="activity-icon activity-success me-3">
                            <i class="fas fa-sign-in-alt"></i>
                        </div>
                        <div>
                            <div class="fw-bold">Last Login</div>
                            <small class="text-muted"><?= date('M j, Y g:i A', strtotime($user_data['last_login'])) ?></small>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon activity-info me-3">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div>
                            <div class="fw-bold">Account Created</div>
                            <small class="text-muted"><?= date('M j, Y', strtotime($user_data['joined_date'])) ?></small>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon activity-warning me-3">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div>
                            <div class="fw-bold">Security Status</div>
                            <small class="text-success">All security checks passed</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white fw-bold text-primary">
                    <i class="fas fa-bolt me-2"></i>Quick Actions
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                            <i class="fas fa-key me-2"></i>Change Password
                        </button>
                        <button class="btn btn-outline-info">
                            <i class="fas fa-download me-2"></i>Download My Data
                        </button>
                        <button class="btn btn-outline-warning">
                            <i class="fas fa-shield-alt me-2"></i>Security Settings
                        </button>
                        <button class="btn btn-outline-danger">
                            <i class="fas fa-user-times me-2"></i>Deactivate Account
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editProfileForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" class="form-control" value="<?= htmlspecialchars($user_data['name']) ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Email Address</label>
                                <input type="email" class="form-control" value="<?= htmlspecialchars($user_data['email']) ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" value="<?= htmlspecialchars($user_data['phone']) ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Timezone</label>
                                <select class="form-select">
                                    <option selected>America/New_York</option>
                                    <option>America/Los_Angeles</option>
                                    <option>America/Chicago</option>
                                    <option>Europe/London</option>
                                </select>
                            </div>
                        </div>
                        <?php if ($user_role === 'therapist'): ?>
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">Professional Bio</label>
                                <textarea class="form-control" rows="3"><?= htmlspecialchars($user_data['bio']) ?></textarea>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="changePasswordForm">
                    <div class="mb-3">
                        <label class="form-label">Current Password</label>
                        <input type="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Update Password</button>
            </div>
        </div>
    </div>
</div>

<?php include 'templates/footer.php'; ?>