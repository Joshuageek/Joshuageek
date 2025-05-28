<?php
session_start();
require_once '../../config/db.php';

if (isset($_POST['add_booking'])) {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $date = $_POST['booking_date'];
    $time = $_POST['booking_time'];
    $number_of_people = $_POST['number_of_people'];

    try {
        $stmt = $conn->prepare("
            INSERT INTO booking_submissions 
                (full_name, email, phone, booking_date, number_of_people, booking_time, status)
            VALUES 
                (:full_name, :email, :phone, :booking_date, :number_of_people, :booking_time, 'pending')
        ");

        $stmt->bindParam(':full_name', $full_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':booking_date', $date);
        $stmt->bindParam(':number_of_people', $number_of_people);
        $stmt->bindParam(':booking_time', $time);

        $stmt->execute();

        $_SESSION['success'] = "Booking submitted successfully!";
    } catch (PDOException $e) {
        // Log the error if needed: error_log($e->getMessage());
        $_SESSION['error'] = "Failed to submit booking. Please try again.";
    }

    header("Location: ../dashboard.php");
    exit();
}

elseif(isset($_POST['update_booking'])) {
    $bookingId = $_POST['booking_id'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $date = $_POST['booking_date'];
    $time = $_POST['booking_time'];
    $number_of_people = $_POST['number_of_people'];
    
    try {
        // Check if the email exists in the database, excluding the current booking
        $sql = "SELECT * FROM booking_submissions WHERE email = ? AND id != ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$email, $bookingId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $_SESSION['error'] = "Email already exists in the database.";
            header("Location: ../dashboard.php");
            exit();
        }

        $sql = "UPDATE booking_submissions SET full_name = ?, email = ?, phone = ?, booking_date = ?, number_of_people = ?, booking_time = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$full_name, $email, $phone, $date, $number_of_people, $time, $bookingId]);
        $_SESSION['success'] = "Booking updated successfully!";
        header("Location: ../dashboard.php");
        exit();
    } catch (PDOException $e) {
        // Log the error for debugging purposes
        error_log($e->getMessage());
        $_SESSION['error'] = "Failed to update booking. Please try again.";
        header("Location: ../dashboard.php");
        exit();
    }
}

elseif(isset($_POST['delete_booking'])) {
    $bookingId = $_POST['booking_id'];
    try {
        $sql = "DELETE FROM booking_submissions WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$bookingId]);
        $_SESSION['success'] = "Booking deleted successfully!";
        header("Location: ../dashboard.php");
        exit();
    } catch (PDOException $e) {
        // Log the error if needed: error_log($e->getMessage());
        $_SESSION['error'] = "Failed to delete booking. Please try again.";
    }
}
