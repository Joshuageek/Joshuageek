<?php
// Enable strict error reporting
declare(strict_types=1);
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

// Start session securely
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 86400,
        'path' => '/',
        'domain' => $_SERVER['HTTP_HOST'],
        'secure' => true,
        'httponly' => true,
        'samesite' => 'Strict'
    ]);
    session_start();
}

// Verify the request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die('Method Not Allowed');
}

// Load configuration and database
require_once __DIR__ . '/../config/db.php';

// Validate database connection
if (!isset($conn) || !($conn instanceof PDO)) {
    error_log('Database connection failed');
    http_response_code(500);
    die('Internal Server Error');
}

/**
 * Handles file upload with security checks
 * 
 * @param string $inputName Name of the file input field
 * @param string $targetDir Directory to upload to
 * @param int $maxSize Maximum file size in bytes
 * @return array [string|null $filename, array|null $errors]
 */
function handleUpload(string $inputName, string $targetDir = "../uploads/", int $maxSize = 5242880): array 
{
    if (!isset($_FILES[$inputName])) {
        return [null, ["No file uploaded for $inputName"]];
    }

    $file = $_FILES[$inputName];

    // Check for upload errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return [null, ["Upload error for $inputName: " . $file['error']]];
    }

    // Validate file size
    if ($file['size'] > $maxSize) {
        return [null, ["File for $inputName exceeds 5MB limit"]];
    }

    // Validate file type
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);
    $allowedMimes = ['application/pdf' => 'pdf'];
    
    if (!in_array($mime, array_keys($allowedMimes))) {
        return [null, ["File for $inputName must be a PDF"]];
    }

    // Generate secure filename
    $extension = $allowedMimes[$mime];
    $basename = bin2hex(random_bytes(8));
    $filename = sprintf('%s.%0.8s', $basename, $extension);

    // Create upload directory if not exists
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    // Move the file
    if (!move_uploaded_file($file['tmp_name'], $targetDir . $filename)) {
        return [null, ["Failed to upload file for $inputName"]];
    }

    return [$filename, null];
}

// Process Therapist Sign-up
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Initialize variables
    $errors = [];
    $formData = [];
    $uploads = [];

    // Define required fields
    $requiredFields = [
        'full-name' => 'Full Name',
        'email' => 'Email',
        'phone' => 'Phone',
        'location' => 'Location',
        'specialization' => 'Specialization',
        'languages' => 'Languages Spoken',
        'internet' => 'Internet connection',
        'video' => 'Video conferencing',
        'teletherapy' => 'Teletherapy experience'
    ];

    // Validate required fields
    foreach ($requiredFields as $field => $name) {
        $value = trim($_POST[$field] ?? '');
        $formData[$field] = $value;
        
        if ($value === '') {
            $errors[] = "$name is required";
        }
    }

    // Validate email
    $email = filter_var($formData['email'], FILTER_VALIDATE_EMAIL);
    if (!$email) {
        $errors[] = "A valid Email is required";
    }

    // Validate phone number
    if (!preg_match('/^\+256\d{9}$/', $formData['phone'])) {
        $errors[] = "Phone number must be in the format +256XXXXXXXXX";
    }

    // Validate checkboxes
    if (!isset($_POST['consent-verification'])) {
        $errors[] = "Consent for credential verification is required";
    }
    
    if (!isset($_POST['consent-data'])) {
        $errors[] = "Consent for data use is required";
    }

    // Handle file uploads
    $requiredFiles = ['id-upload', 'license-upload', 'cv-upload'];
    foreach ($requiredFiles as $fileField) {
        list($filename, $fileErrors) = handleUpload($fileField);
        
        if ($fileErrors) {
            $errors = array_merge($errors, $fileErrors);
        } else {
            $uploads[$fileField] = $filename;
        }
    }

    // Process languages
    $languages = $_POST['languages'] ?? [];
    if (!is_array($languages)) {
        $languages = [$languages];
    }
    
    if (empty($languages)) {
        $errors[] = "At least one language must be selected";
    }

    $otherLanguage = trim($_POST['other-language'] ?? '');
    if ($otherLanguage !== '') {
        $languages[] = $otherLanguage;
    }

    // If errors exist, return to form
    if (!empty($errors)) {
        $_SESSION['error'] = $errors;
        $_SESSION['form_data'] = $formData;
        header("Location: ../signthera.php");
        exit();
    }

    // Database operations
    try {
        $conn->beginTransaction();

        // Insert user
        $stmt = $conn->prepare("
            INSERT INTO users 
            (full_name, email, phone, location, role, created_on) 
            VALUES (?, ?, ?, ?, 'therapist', NOW())
        ");
        $stmt->execute([
            $formData['full-name'],
            $email,
            $formData['phone'],
            $formData['location']
        ]);
        $userId = $conn->lastInsertId();

        // Insert therapist
        $stmt = $conn->prepare("
            INSERT INTO therapists (
                user_id, id_upload, specialization, other_specialization, 
                license_upload, licensing_body, cv_upload, languages, 
                other_language, internet_connection, video_conferencing, 
                teletherapy_experience, consent_verification, consent_data, created_at
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
        ");

        $stmt->execute([
            $userId,
            $uploads['id-upload'],
            $formData['specialization'],
            trim($_POST['other-specialization'] ?? ''),
            $uploads['license-upload'],
            trim($_POST['licensing-body'] ?? ''),
            $uploads['cv-upload'],
            json_encode($languages),
            $otherLanguage,
            $formData['internet'],
            $formData['video'],
            $formData['teletherapy'],
            1, // consent-verification
            1  // consent-data
        ]);

        $conn->commit();

        // Send confirmation email (in production)
        // mail($email, "Thank you for your application", "Your application has been received");

        $_SESSION['success'] = "Thank you for signing up! Your application has been received.";
        header("Location: ../signthera.php");
        exit();

    } catch (PDOException $e) {
        $conn->rollBack();
        
        // Log the full error
        error_log("Database error: " . $e->getMessage());
        
        // Clean up uploaded files if any
        foreach ($uploads as $file) {
            if (file_exists("../uploads/" . $file)) {
                unlink("../uploads/" . $file);
            }
        }

        $_SESSION['error'] = ["A system error occurred. Please try again later."];
        $_SESSION['form_data'] = $formData;
        header("Location: ../signthera.php");
        exit();
    }
} else {
    // Not a therapist signup request
    http_response_code(400);
    die('Invalid Request');
}