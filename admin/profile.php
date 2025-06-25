<?php
session_start();
// require_once 'config/database.php';
require_once 'includes/auth.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_role = getUserRole();
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'] ?? 'User';
$user_email = $_SESSION['user_email'] ?? 'user@example.com';

// Sample user data (replace with database queries)
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - Luna Mental Wellness</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="assets/css/luna-style.css" rel="stylesheet">
<style>
    .profile-header {
        background: linear-gradient(135deg, var(--luna-primary-dark) 0%, var(--luna-primary) 100%);
        color: white;
        padding: 2rem 0;
        margin-bottom: 2rem;
    }

    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        font-weight: bold;
        margin: 0 auto 1rem;
        border: 4px solid rgba(255,255,255,0.3);
        position: relative;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .profile-avatar:hover {
        transform: scale(1.05);
        border-color: rgba(255,255,255,0.5);
    }

    .avatar-upload {
        position: absolute;
        bottom: 0;
        right: 0;
        background: var(--luna-secondary);
        border-radius: 50%;
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .avatar-upload:hover {
        background: var(--luna-accent);
        transform: scale(1.1);
    }

    .profile-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        border: none;
        margin-bottom: 1.5rem;
        overflow: hidden;
        position: relative;
        transition: all 0.3s ease;
    }

    .profile-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--luna-primary), var(--luna-secondary));
    }

    .profile-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.15);
    }

    .profile-card .card-header {
        background: linear-gradient(45deg, var(--luna-light), #e9ecef);
        border-bottom: 1px solid var(--luna-gray-light);
        padding: 1.25rem;
        font-weight: 600;
        color: var(--luna-dark);
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid var(--luna-gray-light);
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-label {
        font-weight: 500;
        color: var(--luna-gray);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-label i {
        color: var(--luna-primary);
        width: 20px;
    }

    .info-value {
        color: var(--luna-dark);
        font-weight: 500;
    }

    .specialization-tag {
        background: linear-gradient(45deg, var(--luna-primary), var(--luna-secondary));
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.85rem;
        margin: 0.25rem;
        display: inline-block;
        box-shadow: 0 2px 8px rgba(6, 95, 70, 0.2);
    }

    .edit-btn {
        background: linear-gradient(45deg, var(--luna-primary), var(--luna-secondary));
        border: none;
        border-radius: 25px;
        padding: 0.75rem 1.5rem;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(6, 95, 70, 0.3);
    }

    .edit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(6, 95, 70, 0.4);
        color: white;
        background: linear-gradient(45deg, var(--luna-primary-light), var(--luna-accent));
    }

    .activity-item {
        display: flex;
        align-items: center;
        padding: 1rem;
        border-bottom: 1px solid var(--luna-gray-light);
        transition: all 0.3s ease;
    }

    .activity-item:hover {
        background: var(--luna-light);
    }

    .activity-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        font-size: 0.9rem;
    }

    .activity-success { 
        background: rgba(16, 185, 129, 0.1); 
        color: var(--luna-success); 
    }
    .activity-info { 
        background: rgba(6, 95, 70, 0.1); 
        color: var(--luna-primary); 
    }
    .activity-warning { 
        background: rgba(245, 158, 11, 0.1); 
        color: var(--luna-warning); 
    }

    .btn-outline-primary {
        border-color: var(--luna-primary);
        color: var(--luna-primary);
    }

    .btn-outline-primary:hover {
        background: var(--luna-primary);
        border-color: var(--luna-primary);
        color: white;
    }

    .btn-outline-info {
        border-color: var(--luna-secondary);
        color: var(--luna-secondary);
    }

    .btn-outline-info:hover {
        background: var(--luna-secondary);
        border-color: var(--luna-secondary);
        color: white;
    }

    .btn-outline-warning {
        border-color: var(--luna-warning);
        color: var(--luna-warning);
    }

    .btn-outline-warning:hover {
        background: var(--luna-warning);
        border-color: var(--luna-warning);
        color: white;
    }

    .btn-outline-danger {
        border-color: var(--luna-danger);
        color: var(--luna-danger);
    }

    .btn-outline-danger:hover {
        background: var(--luna-danger);
        border-color: var(--luna-danger);
        color: white;
    }

    .modal-header {
        background: linear-gradient(45deg, var(--luna-light), #e9ecef);
        border-bottom: 1px solid var(--luna-gray-light);
    }

    .btn-primary {
        background: var(--luna-primary);
        border-color: var(--luna-primary);
    }

    .btn-primary:hover {
        background: var(--luna-primary-light);
        border-color: var(--luna-primary-light);
    }

    .form-control:focus {
        border-color: var(--luna-primary);
        box-shadow: 0 0 0 0.2rem rgba(6, 95, 70, 0.25);
    }

    .form-select:focus {
        border-color: var(--luna-primary);
        box-shadow: 0 0 0 0.2rem rgba(6, 95, 70, 0.25);
    }
</style>
</head>
<body>
    <?php include 'templates/header.php'; ?>
    
    <div class="main-wrapper">
        <?php include 'templates/sidebar.php'; ?>
        
        <div class="main-content">
            <!-- Profile Header -->
            <div class="profile-header">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-3 text-center">
                            <div class="profile-avatar" onclick="document.getElementById('avatarUpload').click()">
                                <?php echo strtoupper(substr($user_data['name'], 0, 1)); ?>
                                <div class="avatar-upload">
                                    <i class="fas fa-camera"></i>
                                </div>
                            </div>
                            <input type="file" id="avatarUpload" style="display: none;" accept="image/*">
                        </div>
                        <div class="col-md-6">
                            <h2 class="mb-2"><?php echo htmlspecialchars($user_data['name']); ?></h2>
                            <p class="mb-1 opacity-75">
                                <i class="fas fa-user-tag me-2"></i>
                                <?php echo ucfirst($user_data['role']); ?> Account
                            </p>
                            <p class="mb-1 opacity-75">
                                <i class="fas fa-envelope me-2"></i>
                                <?php echo htmlspecialchars($user_data['email']); ?>
                            </p>
                            <p class="mb-0 opacity-75">
                                <i class="fas fa-calendar me-2"></i>
                                Member since <?php echo date('F Y', strtotime($user_data['joined_date'])); ?>
                            </p>
                        </div>
                        <div class="col-md-3 text-center">
                            <button class="btn edit-btn" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                                <i class="fas fa-edit me-2"></i>Edit Profile
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="container-fluid">
                <div class="row">
                    <!-- Personal Information -->
                    <div class="col-lg-8">
                        <div class="profile-card">
                            <div class="card-header">
                                <i class="fas fa-user me-2"></i>Personal Information
                            </div>
                            <div class="card-body">
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-user"></i>Full Name
                                    </div>
                                    <div class="info-value"><?php echo htmlspecialchars($user_data['name']); ?></div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-envelope"></i>Email Address
                                    </div>
                                    <div class="info-value"><?php echo htmlspecialchars($user_data['email']); ?></div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-phone"></i>Phone Number
                                    </div>
                                    <div class="info-value"><?php echo htmlspecialchars($user_data['phone']); ?></div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-building"></i>Department
                                    </div>
                                    <div class="info-value"><?php echo htmlspecialchars($user_data['department']); ?></div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-globe"></i>Timezone
                                    </div>
                                    <div class="info-value"><?php echo htmlspecialchars($user_data['timezone']); ?></div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-language"></i>Language
                                    </div>
                                    <div class="info-value"><?php echo htmlspecialchars($user_data['language']); ?></div>
                                </div>
                            </div>
                        </div>
                        
                        <?php if ($user_role === 'therapist'): ?>
                        <!-- Professional Information -->
                        <div class="profile-card">
                            <div class="card-header">
                                <i class="fas fa-user-md me-2"></i>Professional Information
                            </div>
                            <div class="card-body">
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-certificate"></i>License Number
                                    </div>
                                    <div class="info-value"><?php echo htmlspecialchars($user_data['license_number']); ?></div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-graduation-cap"></i>Education
                                    </div>
                                    <div class="info-value"><?php echo htmlspecialchars($user_data['education']); ?></div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-stethoscope"></i>Specializations
                                    </div>
                                    <div class="info-value">
                                        <?php foreach ($user_data['specializations'] as $spec): ?>
                                            <span class="specialization-tag"><?php echo htmlspecialchars($spec); ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-info-circle"></i>Bio
                                    </div>
                                    <div class="info-value"><?php echo htmlspecialchars($user_data['bio']); ?></div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Account Activity -->
                    <div class="col-lg-4">
                        <div class="profile-card">
                            <div class="card-header">
                                <i class="fas fa-clock me-2"></i>Account Activity
                            </div>
                            <div class="card-body p-0">
                                <div class="activity-item">
                                    <div class="activity-icon activity-success">
                                        <i class="fas fa-sign-in-alt"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold">Last Login</div>
                                        <small class="text-muted"><?php echo date('M j, Y g:i A', strtotime($user_data['last_login'])); ?></small>
                                    </div>
                                </div>
                                <div class="activity-item">
                                    <div class="activity-icon activity-info">
                                        <i class="fas fa-user-plus"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold">Account Created</div>
                                        <small class="text-muted"><?php echo date('M j, Y', strtotime($user_data['joined_date'])); ?></small>
                                    </div>
                                </div>
                                <div class="activity-item">
                                    <div class="activity-icon activity-warning">
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
                        <div class="profile-card">
                            <div class="card-header">
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
        </div>
    </div>
    
    <!-- Edit Profile Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editProfileForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($user_data['name']); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Email Address</label>
                                    <input type="email" class="form-control" value="<?php echo htmlspecialchars($user_data['email']); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" value="<?php echo htmlspecialchars($user_data['phone']); ?>">
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
                                    <textarea class="form-control" rows="3"><?php echo htmlspecialchars($user_data['bio']); ?></textarea>
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
    <div class="modal fade" id="changePasswordModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Change Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
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
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/simple-luna.js"></script>
    <script>
        // Avatar upload preview
        document.getElementById('avatarUpload').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Here you would typically upload the file and update the avatar
                    showToast('Avatar uploaded successfully!', 'success');
                };
                reader.readAsDataURL(file);
            }
        });
        
        // Form submissions
        document.querySelector('#editProfileForm').addEventListener('submit', function(e) {
            e.preventDefault();
            showToast('Profile updated successfully!', 'success');
            bootstrap.Modal.getInstance(document.getElementById('editProfileModal')).hide();
        });
        
        document.querySelector('#changePasswordForm').addEventListener('submit', function(e) {
            e.preventDefault();
            showToast('Password changed successfully!', 'success');
            bootstrap.Modal.getInstance(document.getElementById('changePasswordModal')).hide();
        });
    </script>
</body>
</html>
