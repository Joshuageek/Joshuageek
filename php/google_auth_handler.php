<?php
require_once '../vendor/autoload.php';
require_once '../config/db.php'; // adjust path to your DB connection
require_once '../php/functions.php'; // contains email_exists(), has_completed_questionnaire()
$config = include 'config.php';

session_start();

// Ensure the Google ID token is posted
if (!isset($_POST['credential'])) {
    $_SESSION['error'] = 'Google token not received.';
    header('Location: ../login.php');
    exit();
}

$id_token = $_POST['credential'];

// Initialize Google Client
$client = new Google_Client([
    'client_id' => $config['google_client_id'] // Your Google Client ID
]);

// Verify the token
$payload = $client->verifyIdToken($id_token);

if ($payload) {
    // Extract user data from token
    $email = $payload['email'];
    $name = $payload['name'];
    $google_id = $payload['sub'];

    try {
        // Check if the user already exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Existing user
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['success'] = "Welcome back, $name!";

            $user_id = $user['id'];
            $user_role = get_user_role($user_id);
        } else {
            // New user → Register them
            $stmt = $conn->prepare("INSERT INTO users (email, password, google_id, created_on) VALUES (?, ?, ?, NOW())");
            $stmt->execute([$email, null, $google_id]);

            $user_id = $conn->lastInsertId();
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_email'] = $email;
            $_SESSION['user_role'] = $user_role;
            $_SESSION['success'] = "Welcome, $name!";

            $user_role = null;
        }

        if(empty($user_role)){
            header('Location: ../choose_role.php');
            exit();
        }

        // Redirect based on whether they completed the questionnaire
        $uid = $_SESSION['user_id'];
        if (!has_completed_questionnaire($user['id']) && $user_role == 'patient') {
            header("Location: ../question.php");
        } else {
            header("Location: ../index.php");
        }

        exit();

    } catch (PDOException $e) {
        $_SESSION['error'] = "Login error: " . $e->getMessage();
        header("Location: ../login.php");
        exit();
    }

} else {
    // Token could not be verified
    $_SESSION['error'] = 'Invalid Google ID token.';
    header("Location: ../login.php");
    exit();
}
