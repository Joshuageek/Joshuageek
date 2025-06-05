<?php
session_start();
require_once '../../config/db.php';

// ADD THERAPIST
if (isset($_POST['add_therapist'])) {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $location = $_POST['location'];
    $specialization = $_POST['specialization'];

    try {
        // Check if the email already exists
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $_SESSION['error'] = "Email already exists in the database.";
            header("Location: ../dashboard.php");
            exit();
        }

        // Add user with role 'therapist'
        $stmt = $conn->prepare("
            INSERT INTO users
                (full_name, email, phone, gender, location, age, role)
            VALUES 
                (:full_name, :email, :phone, :gender, :location, :age, 'therapist')
        ");
        $stmt->bindParam(':full_name', $full_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':location', $location);
        $stmt->bindParam(':age', $age);
        $stmt->execute();

        $user_id = $conn->lastInsertId();

        // Insert into therapists table (you can add more fields as needed)
        $stmt2 = $conn->prepare("
            INSERT INTO therapists 
                (user_id, specialization, created_at)
            VALUES 
                (?, ?, NOW())
        ");
        $stmt2->execute([$user_id, $specialization]);

        $_SESSION['success'] = "Therapist added successfully!";
    } catch (PDOException $e) {
        // Log the error if needed: error_log($e->getMessage());
        $_SESSION['error'] = "Failed to add therapist. Please try again.";
    }

    header("Location: ../dashboard.php");
    exit();
}

// UPDATE THERAPIST
elseif(isset($_POST['update_therapist'])) {
    $therapistId = $_POST['therapist_id'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $location = $_POST['location'];
    $specialization = $_POST['specialization'];

    try {
        // Find user_id from therapists table
        $sql = "SELECT user_id FROM therapists WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$therapistId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            $_SESSION['error'] = "Therapist not found.";
            header("Location: ../dashboard.php");
            exit();
        }
        $user_id = $row['user_id'];

        // Check if email exists for another user
        $sql = "SELECT * FROM users WHERE email = ? AND id != ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$email, $user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $_SESSION['error'] = "Email already exists in the database.";
            header("Location: ../dashboard.php");
            exit();
        }

        // Update users table
        $sql = "UPDATE users SET full_name = ?, email = ?, phone = ?, gender = ?, age = ?, location = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$full_name, $email, $phone, $gender, $age, $location, $user_id]);

        // Update therapists table
        $sql2 = "UPDATE therapists SET specialization = ? WHERE id = ?";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->execute([$specialization, $therapistId]);

        $_SESSION['success'] = "Therapist data updated successfully!";
        header("Location: ../dashboard.php");
        exit();
    } catch (PDOException $e) {
        error_log($e->getMessage());
        $_SESSION['error'] = "Failed to update therapist data. Please try again.";
        header("Location: ../dashboard.php");
        exit();
    }
}

// DELETE THERAPIST
elseif(isset($_POST['delete_therapist'])) {
    $therapistId = $_POST['therapist_id'];
    try {
        // Find user_id from therapists table
        $sql = "SELECT user_id FROM therapists WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$therapistId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            $_SESSION['error'] = "Therapist not found.";
            header("Location: ../dashboard.php");
            exit();
        }
        $user_id = $row['user_id'];

        // Delete from therapists table
        $sql = "DELETE FROM therapists WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$therapistId]);

        // Delete from users table
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$user_id]);

        $_SESSION['success'] = "Therapist deleted successfully!";
        header("Location: ../dashboard.php");
        exit();
    } catch (PDOException $e) {
        // Log the error if needed: error_log($e->getMessage());
        $_SESSION['error'] = "Failed to delete therapist data. Please try again.";
        header("Location: ../dashboard.php");
        exit();
    }
}
?>