<?php
// fetch_dashboard_data.php
// Ensure database connection is available
if (!isset($conn)) {
    die("Database connection not established.");
}

try {
    // Initialize variables
    $userCount = 0;
    $activeBookings = 0;
    $therapistsCount = 0;
    $pendingResponses = 0;
    $bookings = [];
    $recentBookings = [];
    $users = [];
    $therapists = [];
    $responses = [];
    $topTherapists = [];

    // Fetch total users
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM users");
    $stmt->execute();
    $userCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

    // Fetch active bookings (assuming 'active' means not cancelled; since table is empty, we'll count all)
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM booking_submissions");
    $stmt->execute();
    $activeBookings = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

    // Fetch therapists count
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM therapists");
    $stmt->execute();
    $therapistsCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

    // Fetch pending responses (counting all questionnaire responses as 'pending' since no status field)
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM questionnaire_responses WHERE submitted_at IS NOT NULL");
    $stmt->execute();
    $pendingResponses = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

    // Fetch bookings
    $stmt = $conn->prepare("
        SELECT bs.id, bs.full_name as user_name, bs.booking_date, bs.booking_time, 'pending' as status, bs.created_at
        FROM booking_submissions bs
        ORDER BY bs.created_at DESC
    ");
    $stmt->execute();
    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Add placeholder for therapist_name since not in DB
    foreach ($bookings as &$booking) {
        $booking['therapist_name'] = 'N/A'; // Placeholder
    }

    // Fetch recent bookings (limit to 5)
    $stmt = $conn->prepare("
        SELECT bs.id, bs.full_name as user_name, bs.phone, bs.booking_date, bs.booking_time, 'pending' as status, bs.created_at
        FROM booking_submissions bs
        ORDER BY bs.created_at DESC
        LIMIT 5
    ");
    $stmt->execute();
    $recentBookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Add placeholder for therapist_name
    foreach ($recentBookings as &$booking) {
        $booking['therapist_name'] = 'N/A'; // Placeholder
    }

    // Fetch users
    $stmt = $conn->prepare("
        SELECT id, full_name as name, email, phone, created_on as created_at, 
               CASE WHEN role = 'admin' THEN 1 ELSE 0 END as active
        FROM users
        ORDER BY created_on DESC
    ");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Add placeholder for avatar
    foreach ($users as &$user) {
        $user['avatar'] = null; // Will use default image in dashboard
    }

    // Fetch therapists
    $stmt = $conn->prepare("
        SELECT t.id, u.full_name as name, t.specialization, t.created_at
        FROM therapists t
        LEFT JOIN users u ON t.user_id = u.id
        ORDER BY t.created_at DESC
    ");
    $stmt->execute();
    $therapists = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Add placeholders for rating, sessions_count, available, and photo
    foreach ($therapists as &$therapist) {
        $therapist['rating'] = 0; // Placeholder
        $therapist['sessions_count'] = 0; // Placeholder
        $therapist['available'] = 1; // Placeholder
        $therapist['photo'] = null; // Will use default image
    }

    // Fetch responses
    $stmt = $conn->prepare("
        SELECT qr.id, u.full_name as user_name, qr.therapyReasons as message, qr.submitted_at as created_at, 'pending' as status
        FROM questionnaire_responses qr
        LEFT JOIN users u ON qr.user_id = u.id
        ORDER BY qr.submitted_at DESC
    ");
    $stmt->execute();
    $responses = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Add placeholder for therapist_name
    foreach ($responses as &$response) {
        $response['therapist_name'] = 'N/A'; // Placeholder
    }

    // Fetch top therapists (reuse therapists list as placeholder since table is empty)
    $topTherapists = $therapists;
    foreach ($topTherapists as &$therapist) {
        $therapist['rating'] = 0; // Placeholder
        $therapist['sessions_count'] = 0; // Placeholder
        $therapist['photo'] = null; // Will use default image
    }

} catch (PDOException $e) {
    // Log error (in production, use proper logging)
    error_log("Database error: " . $e->getMessage());
    // Set default values to prevent dashboard errors
    $userCount = 0;
    $activeBookings = 0;
    $therapistsCount = 0;
    $pendingResponses = 0;
    $bookings = [];
    $recentBookings = [];
    $users = [];
    $therapists = [];
    $responses = [];
    $topTherapists = [];
}
?>