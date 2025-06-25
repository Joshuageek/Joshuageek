<?php
// Include database connection
require_once __DIR__ . '/../../config/db.php';

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

// Check user role
function getUserRole() {
    return $_SESSION['user_role'] ?? null;
}

// Check if user is admin
function isAdmin() {
    return getUserRole() === 'admin';
}

// Check if user is therapist
function isTherapist() {
    return getUserRole() === 'therapist';
}

// Check if user is patient
function isPatient() {
    return getUserRole() === 'patient';
}

// Login function
function login($email, $password) {
    global $conn;
    
    $stmt = $conn->prepare("SELECT id, email, password, role, full_name FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['user_name'] = $user['full_name'];
        
        // Log login activity
        logActivity($user['id'], 'login', 'User logged in');
        
        return true;
    }
    
    return false;
}

// Logout function
function logout() {
    if (isset($_SESSION['user_id'])) {
        logActivity($_SESSION['user_id'], 'logout', 'User logged out');
    }
    
    session_destroy();
    header('Location: ../login.php');
    exit();
}

// Log user activity
function logActivity($user_id, $action, $description) {
    global $conn;
    
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $stmt = $conn->prepare("INSERT INTO activity_logs (performed_by, action, description, ip_address, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->execute([$user_id, $action, $description, $ip_address]);
}

// Get dashboard statistics based on user role
function getDashboardStats($user_id, $role) {
    global $conn;
    $stats = [];
    
    if ($role === 'admin') {
        // Admin sees all statistics
        $stmt = $conn->query("SELECT COUNT(*) as total FROM users WHERE role = 'patient'");
        $stats['total_patients'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        $stmt = $conn->query("SELECT COUNT(*) as total FROM users WHERE role = 'therapist'");
        $stats['total_therapists'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        $stmt = $conn->query("SELECT COUNT(*) as total FROM booking_submissions");
        $stats['total_bookings'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        $stmt = $conn->query("SELECT COUNT(*) as total FROM questionnaire_responses");
        $stats['total_questionnaires'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        $stmt = $conn->query("SELECT COUNT(*) as total FROM booking_submissions WHERE status = 'pending'");
        $stats['pending_bookings'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
    } elseif ($role === 'therapist') {
        // Therapist sees their own statistics
        $stmt = $conn->query("SELECT COUNT(*) as total FROM booking_submissions WHERE status = 'accepted'");
        $stats['accepted_bookings'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        $stmt = $conn->query("SELECT COUNT(*) as total FROM booking_submissions WHERE status = 'pending'");
        $stats['pending_bookings'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        $stmt = $conn->query("SELECT COUNT(*) as total FROM users WHERE role = 'patient'");
        $stats['total_patients'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        $stmt = $conn->query("SELECT COUNT(*) as total FROM questionnaire_responses");
        $stats['patient_questionnaires'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
    } elseif ($role === 'patient') {
        // Patient sees their own statistics
        $stmt = $conn->prepare("SELECT COUNT(*) as total FROM booking_submissions WHERE email = (SELECT email FROM users WHERE id = ?)");
        $stmt->execute([$user_id]);
        $stats['my_bookings'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        $stmt = $conn->prepare("SELECT COUNT(*) as total FROM questionnaire_responses WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $stats['my_questionnaires'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
    
    return $stats;
}

// Get users based on role permissions
function getUsers($current_user_role, $current_user_id) {
    global $conn;
    
    if ($current_user_role === 'admin') {
        // Admin can see all users
        $stmt = $conn->query("SELECT * FROM users ORDER BY created_on DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } elseif ($current_user_role === 'therapist') {
        // Therapist can see patients only
        $stmt = $conn->query("SELECT * FROM users WHERE role = 'patient' ORDER BY created_on DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        // Patient can only see their own profile
        $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$current_user_id]);
        return [$stmt->fetch(PDO::FETCH_ASSOC)];
    }
}

// Get booking submissions based on role
function getBookings($current_user_role, $current_user_id) {
    global $conn;
    
    if ($current_user_role === 'admin') {
        // Admin sees all bookings
        $stmt = $conn->query("SELECT * FROM booking_submissions ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } elseif ($current_user_role === 'therapist') {
        // Therapist sees all bookings (they can be assigned to any)
        $stmt = $conn->query("SELECT * FROM booking_submissions ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        // Patient sees only their bookings
        $stmt = $conn->prepare("SELECT * FROM booking_submissions WHERE email = (SELECT email FROM users WHERE id = ?) ORDER BY created_at DESC");
        $stmt->execute([$current_user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

// Get questionnaire responses based on role
function getQuestionnaireResponses($current_user_role, $current_user_id) {
    global $conn;
    
    if ($current_user_role === 'admin') {
        // Admin sees all questionnaires
        $stmt = $conn->query("
            SELECT qr.*, u.full_name, u.email 
            FROM questionnaire_responses qr 
            LEFT JOIN users u ON qr.user_id = u.id 
            ORDER BY qr.submitted_at DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } elseif ($current_user_role === 'therapist') {
        // Therapist sees all patient questionnaires
        $stmt = $conn->query("
            SELECT qr.*, u.full_name, u.email 
            FROM questionnaire_responses qr 
            LEFT JOIN users u ON qr.user_id = u.id 
            WHERE u.role = 'patient'
            ORDER BY qr.submitted_at DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        // Patient sees only their questionnaires
        $stmt = $conn->prepare("
            SELECT qr.*, u.full_name, u.email 
            FROM questionnaire_responses qr 
            LEFT JOIN users u ON qr.user_id = u.id 
            WHERE qr.user_id = ?
            ORDER BY qr.submitted_at DESC
        ");
        $stmt->execute([$current_user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

// Get therapist applications (admin only)
function getTherapistApplications() {
    global $conn;
    
    $stmt = $conn->query("
        SELECT t.*, u.full_name, u.email, u.created_on 
        FROM therapists t 
        JOIN users u ON t.user_id = u.id 
        ORDER BY t.created_at DESC
    ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Get recent activity based on role
function getRecentActivity($current_user_role, $current_user_id) {
    global $conn;
    
    if ($current_user_role === 'admin') {
        // Admin sees all activity
        $stmt = $conn->query("
            SELECT al.*, u.full_name 
            FROM activity_logs al 
            LEFT JOIN users u ON al.performed_by = u.id 
            ORDER BY al.created_at DESC 
            LIMIT 10
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        // Others see only their activity
        $stmt = $conn->prepare("
            SELECT al.*, u.full_name 
            FROM activity_logs al 
            LEFT JOIN users u ON al.performed_by = u.id 
            WHERE al.performed_by = ?
            ORDER BY al.created_at DESC 
            LIMIT 10
        ");
        $stmt->execute([$current_user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

// Update booking status
function updateBookingStatus($booking_id, $status) {
    global $conn;
    
    $stmt = $conn->prepare("UPDATE booking_submissions SET status = ? WHERE id = ?");
    return $stmt->execute([$status, $booking_id]);
}

// Delete user (admin only)
function deleteUser($user_id) {
    global $conn;
    
    try {
        $conn->beginTransaction();
        
        // Delete related records first
        $stmt = $conn->prepare("DELETE FROM activity_logs WHERE performed_by = ?");
        $stmt->execute([$user_id]);
        
        $stmt = $conn->prepare("DELETE FROM questionnaire_responses WHERE user_id = ?");
        $stmt->execute([$user_id]);
        
        $stmt = $conn->prepare("DELETE FROM therapists WHERE user_id = ?");
        $stmt->execute([$user_id]);
        
        // Delete user
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        
        $conn->commit();
        return true;
    } catch (Exception $e) {
        $conn->rollback();
        return false;
    }
}

// Get all users with additional statistics
function getAllUsersWithStats() {
    global $conn;
    
    $stmt = $conn->query("
        SELECT u.*, 
               (SELECT MAX(created_at) FROM activity_logs WHERE performed_by = u.id AND action = 'login') as last_login
        FROM users u 
        ORDER BY u.created_on DESC
    ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Change user role
function changeUserRole($user_id, $new_role) {
    global $conn;
    
    $stmt = $conn->prepare("UPDATE users SET role = ? WHERE id = ?");
    return $stmt->execute([$new_role, $user_id]);
}

// Get therapists data with additional info
function getTherapistsData($user_role, $user_id) {
    global $conn;
    
    if ($user_role === 'admin') {
        $stmt = $conn->query("
            SELECT u.*, t.*, 
                   (SELECT COUNT(*) FROM booking_submissions WHERE status = 'accepted') as patient_count
            FROM users u 
            LEFT JOIN therapists t ON u.id = t.user_id 
            WHERE u.role = 'therapist' 
            ORDER BY u.created_on DESC
        ");
    } else {
        $stmt = $conn->query("
            SELECT u.*, t.*, 
                   (SELECT COUNT(*) FROM booking_submissions WHERE status = 'accepted') as patient_count
            FROM users u 
            LEFT JOIN therapists t ON u.id = t.user_id 
            WHERE u.role = 'therapist' AND t.status = 'approved'
            ORDER BY u.created_on DESC
        ");
    }
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Get patients data with additional info
function getPatientsData($user_role, $user_id) {
    global $conn;
    
    $stmt = $conn->query("
        SELECT u.*, 
               (SELECT COUNT(*) FROM booking_submissions WHERE email = u.email) as session_count,
               (SELECT MAX(created_at) FROM booking_submissions WHERE email = u.email) as last_session,
               qr.therapyReasons as primary_concern
        FROM users u 
        LEFT JOIN questionnaire_responses qr ON u.id = qr.user_id
        WHERE u.role = 'patient' 
        ORDER BY u.created_on DESC
    ");
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Approve therapist
function approveTherapist($therapist_id) {
    global $conn;
    
    $stmt = $conn->prepare("UPDATE therapists SET status = 'approved' WHERE id = ?");
    return $stmt->execute([$therapist_id]);
}

// Reject therapist
function rejectTherapist($therapist_id) {
    global $conn;
    
    $stmt = $conn->prepare("UPDATE therapists SET status = 'rejected' WHERE id = ?");
    return $stmt->execute([$therapist_id]);
}

// Get activity logs with pagination
function getActivityLogs($limit = 50, $offset = 0) {
    global $conn;
    
    $stmt = $conn->prepare("
        SELECT al.*, u.full_name 
        FROM activity_logs al 
        LEFT JOIN users u ON al.performed_by = u.id 
        ORDER BY al.created_at DESC 
        LIMIT ? OFFSET ?
    ");
    $stmt->execute([$limit, $offset]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Get total activity logs count
function getTotalActivityLogs() {
    global $conn;
    
    $stmt = $conn->query("SELECT COUNT(*) as total FROM activity_logs");
    return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
}

// Get activity count by type
function getActivityCountByType($action_type) {
    global $conn;
    
    $stmt = $conn->prepare("SELECT COUNT(*) as total FROM activity_logs WHERE action LIKE ?");
    $stmt->execute(["%$action_type%"]);
    return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
}

// Get reports data
function getReportsData() {
    global $conn;
    
    // This would typically fetch actual report data from the database
    // For now, returning sample data structure
    return [
        'user_growth' => 23,
        'session_completion' => 89,
        'avg_rating' => 4.7,
        'monthly_revenue' => 12500
    ];
}
?>
