<?php
session_start();
require_once '../connection/db.php'; // Make sure your DB connection is valid

if (isset($_POST['first_pwd'])) {
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

elseif(isset($_POST['login_btn'])){
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Check for empty fields
    if (empty($email) || empty($password)) {
        $_SESSION['error'] = 'Please enter both email and password.';
        header("Location: ../login.php");
        exit();
    }

    try {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Verify password
            if (password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['success'] = 'Login successful!';

                // Redirect to protected page
                header("Location: ../index.php");
                exit();
            } else {
                $_SESSION['error'] = 'Incorrect password.';
                header("Location: ../login.php");
                exit();
            }
        } else {
            $_SESSION['error'] = 'No account found with that email.';
            header("Location: ../login.php");
            exit();
        }

    } catch (PDOException $e) {
        $_SESSION['error'] = 'Database error. Please try again later.';
        header("Location: ../login.php");
        exit();
    }
}

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

