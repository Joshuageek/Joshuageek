<?php
session_start();
require_once '../../config/db.php';

if (isset($_POST['add_patient'])) {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $location = $_POST['location'];

    try {
        $stmt = $conn->prepare("
            INSERT INTO users
                (full_name, email, phone, gender, location, age, role)
            VALUES 
                (:full_name, :email, :phone, :gender, :location, :age, 'patient')
        ");

        $stmt->bindParam(':full_name', $full_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':location', $location);
        $stmt->bindParam(':age', $age);

        $stmt->execute();

        $_SESSION['success'] = "Patient added successfully!";
    } catch (PDOException $e) {
        // Log the error if needed: error_log($e->getMessage());
        $_SESSION['error'] = "Failed to add patient. Please try again.";
    }

    header("Location: ../dashboard.php");
    exit();
}

elseif(isset($_POST['update_patient'])) {
    $patientId = $_POST['patient_id'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $location = $_POST['location'];
    
    try {
        // Check if the email exists in the database, excluding the current booking
        $sql = "SELECT * FROM users WHERE email = ? AND id != ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$email, $patientId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $_SESSION['error'] = "Email already exists in the database.";
            header("Location: ../dashboard.php");
            exit();
        }

        $sql = "UPDATE users SET full_name = ?, email = ?, phone = ?, gender = ?, age = ?, location = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$full_name, $email, $phone, $gender, $age, $location, $patientId]);
        $_SESSION['success'] = "Patient data updated successfully!";
        header("Location: ../dashboard.php");
        exit();
    } catch (PDOException $e) {
        // Log the error for debugging purposes
        error_log($e->getMessage());
        $_SESSION['error'] = "Failed to update patient data. Please try again.";
        header("Location: ../dashboard.php");
        exit();
    }
}

elseif(isset($_POST['delete_patient'])) {
    $patientId = $_POST['patient_id'];
    try {
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$patientId]);
        $_SESSION['success'] = "Patient deleted successfully!";
        header("Location: ../dashboard.php");
        exit();
    } catch (PDOException $e) {
        // Log the error if needed: error_log($e->getMessage());
        $_SESSION['error'] = "Failed to delete patient data. Please try again.";
    }
}
