<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once '../connection/db.php'; // Make sure your DB connection is valid
require_once '../php/functions.php';

    // create account
    if (isset($_POST['create_account'])) {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirmPassword'] ?? '';

        // Check for empty fields
        if (empty($email) || empty($password) || empty($confirmPassword)) {
            $_SESSION['error'] = 'Please fill in all fields.';
            header("Location: ../signup.php");
            exit();
        }

        // Validate email format
        if (!is_valid_email($email)) {
            $_SESSION['error'] = 'Please enter a valid email address.';
            header("Location: ../signup.php");
            exit();
        }

        // Check if email already exists
        if (email_exists($email)) {
            $_SESSION['error'] = 'Email already exists.';
            header("Location: ../signup.php");
            exit();
        }

        // Password length check
        if (strlen($password) < 8) {
            $_SESSION['error'] = 'Password must be at least 8 characters.';
            header("Location: ../signup.php");
            exit();
        }

        // Password strength check (letters and numbers)
        if (!preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password)) {
            $_SESSION['error'] = 'Password must include both letters and numbers.';
            header("Location: ../signup.php");
            exit();
        }

        // Confirm passwords match
        if ($password !== $confirmPassword) {
            $_SESSION['error'] = 'Passwords do not match.';
            header("Location: ../signup.php");
            exit();
        }

        // Hash the password before storing
        $hashedPwd = password_hash($password, PASSWORD_DEFAULT);

        try {
            $sql = "INSERT INTO users (email, password) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$email, $hashedPwd]);

            $user_id = $conn->lastInsertId();

            // Set session variables
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_email'] = $email;

            $_SESSION['success'] = 'Account created successfully! Please complete the questionnaire.';
            header("Location: ../question.php");
            exit();
        } catch (PDOException $e) {
            $_SESSION['error'] = 'Database error. Please try again later.';
            header("Location: ../signup.php");
            exit();
        }
    }

    // login
    elseif(isset($_POST['login_btn'])){
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        // Check if email format is valid
        if (!is_valid_email($email)) {
            $_SESSION['error'] = 'Please enter a valid email address.';
            header("Location: ../login.php");
            exit();
        }

        // Check if email exists in database before password verification
        if (!email_exists($email)) {
            $_SESSION['error'] = 'No account found with that email.';
            header("Location: ../login.php");
            exit();
        }

        if (empty($password)) {
            $_SESSION['error'] = 'Please enter your password.';
            header("Location: ../login.php");
            exit();
        }

        try {
            $sql = "SELECT * FROM users WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['success'] = 'Login successful!';

                // Redirect based on questionnaire completion
                if (!has_completed_questionnaire($user['id'])) {
                    header("Location: ../question.php");
                } else {
                    header("Location: ../index.php");
                }
                exit();
            } else {
                $_SESSION['error'] = 'Incorrect password.';
                header("Location: ../login.php");
                exit();
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = 'Database error. Please try again later.';
            header("Location: ../login.php");
            exit();
        }
    }

    // generate pwd - first time
    elseif (isset($_POST['first_pwd'])) {
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];

        // Check for empty fields
        if (empty($password) || empty($confirmPassword)) {
            $_SESSION['error'] = 'Please fill in all fields.';
            header("Location: ../new-pwd.php");
            exit();
        }

        // Check password length
        if (strlen($password) < 8) {
            $_SESSION['error'] = 'Password must be at least 8 characters.';
            header("Location: ../new-pwd.php");
            exit();
        }

        // Check for strength (letters and numbers)
        if (!preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password)) {
            $_SESSION['error'] = 'Password must include both letters and numbers.';
            header("Location: ../new-pwd.php");
            exit();
        }

        // Check for match
        if ($password !== $confirmPassword) {
            $_SESSION['error'] = 'Passwords do not match.';
            header("Location: ../new-pwd.php");
            exit();
        }

        // Hash the password
        $hashedPwd = password_hash($password, PASSWORD_DEFAULT);

        $userId = $_SESSION['user_id']; //    $userId = 1;

        try {
            $sql = "UPDATE users SET password = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$hashedPwd, $userId]);

            $_SESSION['success'] = 'Password successfully updated!';
            header("Location: ../paywall/paywall.php");
            exit();
        } catch (PDOException $e) {
            $_SESSION['error'] = 'Database error. Please try again later.';
            header("Location: ../new-pwd.php");
            exit();
        }

    } 

    // check email for forgotten pwd
    elseif(isset($_POST['check_email'])){
        $email = $_POST['email'] ?? '';

        // Check for empty fields
        if (empty($email)) {
            $_SESSION['error'] = 'Please enter your  email.';
            header("Location: ../forgot_pwd.php");
            exit();
        }

        try {
            $sql = "SELECT * FROM users WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                $_SESSION['error'] = 'No account found with that email.';
                header("Location: ../forgot_pwd.php");
                exit();
            }

            // Set session variables
            // $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            header("Location: ../reset-password.php");

        } catch(PDOException $e){
            $_SESSION['error'] = 'Database error. Please try again later.';
            header("Location: ../forgot_pwd.php");
            exit();
        }
    }

    // reset forgotten password
    elseif (isset($_POST['reset_pwd'])) {
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];
        $user_email = $_SESSION['user_email'] ?? null;

        // Check for missing session email (security)
        if (!$user_email) {
            $_SESSION['error'] = 'Session expired or invalid request.';
            header("Location: ../forgot_pwd.php");
            exit();
        }

        // Check for empty fields
        if (empty($password) || empty($confirmPassword)) {
            $_SESSION['error'] = 'Please fill in all fields.';
            header("Location: ../reset-password.php");
            exit();
        }

        // Check password length
        if (strlen($password) < 8) {
            $_SESSION['error'] = 'Password must be at least 8 characters.';
            header("Location: ../reset-password.php");
            exit();
        }

        // Check for strength (letters and numbers)
        if (!preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password)) {
            $_SESSION['error'] = 'Password must include both letters and numbers.';
            header("Location: ../reset-password.php");
            exit();
        }

        // Check for match
        if ($password !== $confirmPassword) {
            $_SESSION['error'] = 'Passwords do not match.';
            header("Location: ../reset-password.php");
            exit();
        }

        // Hash the password
        $hashedPwd = password_hash($password, PASSWORD_DEFAULT);

        try {
            // First, check if the email exists
            $checkSql = "SELECT * FROM users WHERE email = ?";
            $checkStmt = $conn->prepare($checkSql);
            $checkStmt->execute([$user_email]);
            $user = $checkStmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                $_SESSION['error'] = 'No account found with that email.';
                header("Location: ../forgot-password.php");
                exit();
            }

            // Now update the password
            $updateSql = "UPDATE users SET password = ? WHERE email = ?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->execute([$hashedPwd, $user_email]);

            // Optionally: unset the reset session
            // unset($_SESSION['email']);

            $_SESSION['success'] = 'Password successfully updated!';
            header("Location: ../index.php");
            exit();
        } catch (PDOException $e) {
            $_SESSION['error'] = 'Database error. Please try again later.';
            header("Location: ../reset-password.php");
            exit();
        }
    }

    // booking - form submission
    elseif (isset($_POST['booking_submittion'])) {
        // Sanitize and validate input
        $full_name = isset($_POST['register_names']) ? trim($_POST['register_names']) : '';
        $phone = isset($_POST['register_phone']) ? trim($_POST['register_phone']) : '';
        $booking_date = isset($_POST['register_date']) ? trim($_POST['register_date']) : '';
        $email = isset($_POST['register_email']) ? trim($_POST['register_email']) : '';
        $number_of_people = isset($_POST['register_ticket']) ? trim($_POST['register_ticket']) : '';
        $booking_time = isset($_POST['register_time']) ? trim($_POST['register_time']) : '';

        // Validate inputs
        if (empty($full_name) || empty($phone) || empty($booking_date) || empty($email) || empty($number_of_people) || empty($booking_time)) {
            header("Location: ../booking.php?status=error&message=All fields are required");
            exit();
        } 

        try {
            // Prepare and execute the query
            $stmt = $conn->prepare("INSERT INTO booking_submissions (full_name, phone, booking_date, email, number_of_people, booking_time) VALUES (:full_name, :phone, :booking_date, :email, :number_of_people, :booking_time)");
            $stmt->execute([
                ':full_name' => $full_name,
                ':phone' => $phone,
                ':booking_date' => $booking_date,
                ':email' => $email,
                ':number_of_people' => $number_of_people,
                ':booking_time' => $booking_time
            ]);

            // Success: Redirect to booking page
            header("Location: ../booking.php?status=success&message=We received your message and you will hear from us soon. Thank You!");
            exit();
        } catch (PDOException $e) {
            // Error: Redirect with error message
            header("Location: ../booking.php?status=error&message=Database error: " . urlencode($e->getMessage()));
            exit();
        }
    }

    elseif (isset($_POST['therapist-signup'])) {
        
        // Initialize error array
        $errors = [];
        
        // Validate required fields
        $requiredFields = [
            'full-name', 'email', 'phone', 'location', 'id-upload', 
            'specialization', 'license-upload', 'cv-upload', 'languages',
            'internet', 'video', 'teletherapy', 'consent-verification', 'consent-data'
        ];
        
        foreach ($requiredFields as $field) {
            if (empty($_POST[$field])) {
                $errors[] = ucfirst(str_replace('-', ' ', $field)) . " is required";
            }
        }
        
        // Validate email
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format";
        }
        
        // Validate phone (Uganda format)
        if (!preg_match('/^\+256\d{9}$/', str_replace(' ', '', $_POST['phone']))) {
            $errors[] = "Phone number must start with +256 followed by 9 digits";
        }
        
        // Check for errors
        if (!empty($errors)) {
            $_SESSION['form_errors'] = $errors;
            $_SESSION['form_data'] = $_POST;
            header("Location: ../signthera.php");
            exit();
        }
        
        try {
            // Begin transaction
            $conn->beginTransaction();
            
            // Insert into users table
            $userSql = "INSERT INTO users (full_name, email, phone, location, role, created_on) 
                        VALUES (:full_name, :email, :phone, :location, 'therapist', NOW())";
            
            $userStmt = $conn->prepare($userSql);
            $userStmt->execute([
                ':full_name' => $_POST['full-name'],
                ':email' => $_POST['email'],
                ':phone' => $_POST['phone'],
                ':location' => $_POST['location']
            ]);
            
            // Get the last inserted user ID
            $userId = $conn->lastInsertId();
            
            // Handle file uploads
            $idUploadPath = handleFileUpload('id-upload', $userId, 'id');
            $licenseUploadPath = handleFileUpload('license-upload', $userId, 'license');
            $cvUploadPath = handleFileUpload('cv-upload', $userId, 'cv');
            
            // Prepare languages data
            $languages = [];
            if ($_POST['languages'] === 'other' && !empty($_POST['other-language'])) {
                $languages[] = $_POST['other-language'];
            } else {
                $languages[] = $_POST['languages'];
            }
            $languagesJson = json_encode($languages);
            
            // Insert into therapists table
            $therapistSql = "INSERT INTO therapists (
                user_id, id_upload, specialization, other_specialization, 
                license_upload, licensing_body, cv_upload, languages, other_language,
                internet_connection, video_conferencing, teletherapy_experience,
                consent_verification, consent_data, created_at
            ) VALUES (
                :user_id, :id_upload, :specialization, :other_specialization,
                :license_upload, :licensing_body, :cv_upload, :languages, :other_language,
                :internet_connection, :video_conferencing, :teletherapy_experience,
                :consent_verification, :consent_data, NOW()
            )";
            
            $therapistStmt = $conn->prepare($therapistSql);
            $therapistStmt->execute([
                ':user_id' => $userId,
                ':id_upload' => $idUploadPath,
                ':specialization' => $_POST['specialization'],
                ':other_specialization' => ($_POST['specialization'] === 'other') ? $_POST['other-specialization'] : null,
                ':license_upload' => $licenseUploadPath,
                ':licensing_body' => $_POST['licensing-body'] ?? null,
                ':cv_upload' => $cvUploadPath,
                ':languages' => $languagesJson,
                ':other_language' => ($_POST['languages'] === 'other') ? $_POST['other-language'] : null,
                ':internet_connection' => $_POST['internet'],
                ':video_conferencing' => $_POST['video'],
                ':teletherapy_experience' => $_POST['teletherapy'],
                ':consent_verification' => isset($_POST['consent-verification']) ? 1 : 0,
                ':consent_data' => isset($_POST['consent-data']) ? 1 : 0
            ]);
            
            // Commit transaction
            $conn->commit();
            
            // Redirect to success page
            $_SESSION['signup_success'] = true;
            header("Location: ../new-pwd.php");
            exit();
            
        } catch (PDOException $e) {
            // Roll back transaction on error
            $conn->rollBack();
            
            $_SESSION['form_errors'] = ["An error occurred: " . $e->getMessage()];
            $_SESSION['form_data'] = $_POST;
            header("Location: ../signthera.php");
            exit();
        }
    }

// Function to handle file uploads
function handleFileUpload($fieldName, $userId, $type) {
    if (isset($_FILES[$fieldName]) && $_FILES[$fieldName]['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/therapists/' . $userId . '/';
        
        // Create directory if it doesn't exist
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        // Get file info
        $fileExt = pathinfo($_FILES[$fieldName]['name'], PATHINFO_EXTENSION);
        $fileName = $type . '_' . time() . '.' . $fileExt;
        $filePath = $uploadDir . $fileName;
        
        // Move the file
        if (move_uploaded_file($_FILES[$fieldName]['tmp_name'], $filePath)) {
            return $filePath;
        }
    }
    
    throw new Exception("Failed to upload {$fieldName} file");
}