<?php

    require_once('../config/db.php');

    function is_valid_email($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    function email_exists($email) {
        global $conn;
        $stmt = $conn->prepare('SELECT id FROM users WHERE email = ?');
        $stmt->execute([$email]);
        return $stmt->rowCount() > 0;
    }

    function is_logged_in() {
        return isset($_SESSION['user_id']);
    }

    function has_completed_questionnaire($user_id){
        global $conn;
        
        $stmt = $conn->prepare("SELECT id FROM questionnaire_responses WHERE user_id = ?");
        $stmt->execute([$user_id]);
        return $stmt->rowCount() > 0;
    }

    function ensure_logged_in() {
        if (!is_logged_in()) {
            header("Location: ../login.php");
            exit;
        }
    }

    function ensure_questionnaire_completed() {

        if (!isset($_SESSION['user_id'])) {
            header("Location: ../login.php");
            exit;
        }

        if (!has_completed_questionnaire($_SESSION['user_id'])) {
            header("Location: ../question.php");
            exit;
        }
    }

    function get_user_role($user_id) {
        global $conn;
        $stmt = $conn->prepare("SELECT role FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result->role ?? null;
    }

    function admin_email($email) {
        
        $admin_email = [
            'admin@gmail.com',
            'superadmin@gmail.com'
        ];

        return in_array($email, $admin_email);
    }