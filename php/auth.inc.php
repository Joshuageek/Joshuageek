<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once '../config/db.php';
require_once '../php/functions.php';

    // create account
    if (isset($_POST['create_account'])) {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirmPassword'] ?? '';

       
        if (empty($email) || empty($password) || empty($confirmPassword)) {
            $_SESSION['error'] = 'Please fill in all fields.';
            header("Location: ../signup.php");
            exit();
        }

        
        if (!is_valid_email($email)) {
            $_SESSION['error'] = 'Please enter a valid email address.';
            header("Location: ../signup.php");
            exit();
        }

      
        if (email_exists($email)) {
            $_SESSION['error'] = 'Email already exists.';
            header("Location: ../signup.php");
            exit();
        }

        
        if (strlen($password) < 8) {
            $_SESSION['error'] = 'Password must be at least 8 characters.';
            header("Location: ../signup.php");
            exit();
        }

       
        if (!preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password)) {
            $_SESSION['error'] = 'Password must include both letters and numbers.';
            header("Location: ../signup.php");
            exit();
        }

        
        if ($password !== $confirmPassword) {
            $_SESSION['error'] = 'Passwords do not match.';
            header("Location: ../signup.php");
            exit();
        }

        $hashedPwd = password_hash($password, PASSWORD_DEFAULT);

        try {
            $sql = "INSERT INTO users (email, password) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$email, $hashedPwd]);

            $user_id = $conn->lastInsertId();

            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_email'] = $email;

            $_SESSION['success'] = 'Please choose your role.';

            if (!admin_email($email)) {
                header("Location: ../choose_role.php");
            } else {
                $sql = 'UPDATE users SET role = ? WHERE id = ?';
                $stmt = $conn->prepare($sql);
                $stmt->execute(['admin', $user_id]);

                $_SESSION['user_role'] = 'admin';

                header("Location: ../admin-dashboard.php");
            }
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
                if(empty($user['role'])){
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_email'] = $user['email'];
                    $_SESSION['success'] = 'Please complete your profile.';

                    header('Location: ../choose_role.php');
                    exit();
                }

                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['role'];
                
                // Redirect based on questionnaire completion
                if (!has_completed_questionnaire($user['id']) && get_user_role($user['id']) == 'patient') {
                    header("Location: ../question.php");
                    exit();
                } elseif(get_user_role($user['id']) == 'therapist'){
                    header('Location: ../therapist-dashboard.php');
                    exit();
                } else {
                    header("Location: ../admin-dashboard.php");
                    exit();
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

    elseif(isset($_POST['choose_role_btn'])){
        $role = $_POST['role'] ?? '';
       
        try {
            if (empty($role)) {
            $_SESSION['error'] = 'Please select a role before continuing.';
            header("Location: ../choose_role.php");
            exit();
        }

        $_SESSION['user_role'] = $role;

        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
            $sql = "UPDATE users SET role = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$role, $userId]);
        }

        if ($role === 'patient'){
            header("Location: ../question.php");
            exit();
        } else {
            header('Location: ../therapist-dashboard.php');
        }
        exit();
        } catch (PDOException $e) {
            $_SESSION['error'] = 'Database error. Please try again later.';
            header("Location: ../choose_role.php");
            exit();
        }
    }