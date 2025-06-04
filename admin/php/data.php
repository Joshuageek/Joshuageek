<?php
// fetch_dashboard_data.php

if (!isset($conn)) {
    die("Database connection not established.");
}

try {
    // Dashboard counts
    $userCount = (int) $conn->query("SELECT COUNT(*) FROM users")->fetchColumn();
    $activeBookings = (int) $conn->query("SELECT COUNT(*) FROM booking_submissions")->fetchColumn();
    $therapistsCount = (int) $conn->query("SELECT COUNT(*) FROM therapists")->fetchColumn();
    $pendingResponses = (int) $conn->query("SELECT COUNT(*) FROM questionnaire_responses WHERE submitted_at IS NOT NULL")->fetchColumn();

    // All bookings (ordered by most recent)
    $stmt = $conn->prepare("SELECT * FROM booking_submissions ORDER BY created_at DESC");
    $stmt->execute();
    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Recent bookings (limit 5)
    $stmt = $conn->prepare("
        SELECT id, email, full_name, phone, booking_date, booking_time, status, created_at
        FROM booking_submissions
        ORDER BY created_at DESC
        LIMIT 5
    ");
    $stmt->execute();
    $recentBookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Users (ordered by most recent)
    $stmt = $conn->prepare("
        SELECT id, full_name, email, phone, created_on, role
        FROM users
        ORDER BY created_on DESC
    ");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Therapists with joined user name
    $stmt = $conn->prepare("
        SELECT t.id, u.full_name, t.specialization, t.created_at
        FROM therapists t
        LEFT JOIN users u ON t.user_id = u.id
        ORDER BY t.created_at DESC
    ");
    $stmt->execute();
    $therapists = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Questionnaire responses (with user name)
    $stmt = $conn->prepare("
        SELECT qr.id, u.full_name, qr.therapyReasons, qr.submitted_at, 'pending' AS status
        FROM questionnaire_responses qr
        LEFT JOIN users u ON qr.user_id = u.id
        ORDER BY qr.submitted_at DESC
    ");
    $stmt->execute();
    $responses = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Top therapists (example: just reuse therapists for now)
    $topTherapists = $therapists;

} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    // Fallback values if DB errors
    $userCount = $activeBookings = $therapistsCount = $pendingResponses = 0;
    $bookings = $recentBookings = $users = $therapists = $responses = $topTherapists = [];
}
?>