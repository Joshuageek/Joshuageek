<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();
require_once __DIR__ . '/../../config/db.php';

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bookingId = $_POST['booking_id'];
    $patientEmail = $_POST['patient_email'];
    $therapistEmail = $_POST['therapist_email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Validate emails
    if (!filter_var($patientEmail, FILTER_VALIDATE_EMAIL) || !filter_var($therapistEmail, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'Invalid email address';
        header('Location: ../dashboard.php');
        exit;
    }

    require_once __DIR__ . '/../../vendor/autoload.php';

    // Initialize PHPMailer
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'ddryn970@gmail.com';
        $mail->Password = 'yfoe aapk herc bvtn';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Extract patient name and booking details from the message
        preg_match('/Dear\s+(.+?),/', $message, $matches);
        $patientName = $matches[1] ?? 'Patient';
        preg_match('/on\s+(.+?)\s+at\s+(.+?)\./', $message, $dateTimeMatches);
        $bookingDate = $dateTimeMatches[1] ?? 'Date';
        $bookingTime = $dateTimeMatches[2] ?? 'Time';

        // Patient Email
        $mail->clearAddresses(); // Clear previous recipients
        $mail->setFrom('ddryn970@gmail.com', 'Luna Team');
        $mail->addAddress($patientEmail);
        $patientBody = "
            <!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <style>
                    body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
                    .container { max-width: 600px; margin: 20px auto; background-color: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
                    .header { background-color: #007bff; color: #ffffff; padding: 10px 20px; text-align: center; border-radius: 8px 8px 0 0; }
                    .content { padding: 20px; color: #333333; }
                    .cta-button { display: inline-block; padding: 10px 20px; margin: 10px 5px; text-decoration: none; border-radius: 5px; }
                    .accept { background-color: #28a745; color: #ffffff; }
                    .reject { background-color: #dc3545; color: #ffffff; }
                    .footer { text-align: center; font-size: 12px; color: #777777; padding-top: 20px; border-top: 1px solid #eee; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <h2>Luna Booking Confirmation</h2>
                    </div>
                    <div class='content'>
                        <p>Dear {$patientName},</p>
                        <p>A booking request has been scheduled for you on <strong>{$bookingDate}</strong> at <strong>{$bookingTime}</strong>. Please take a moment to confirm or decline this appointment.</p>
                        <p>Please use the buttons below to respond:</p>
                        <a href='http://localhost/luna/response_handler.php?booking_id={$bookingId}&action=accept' class='cta-button accept'>Accept</a>
                        <a href='http://localhost/luna/response_handler.php?booking_id={$bookingId}&action=reject' class='cta-button reject'>Reject</a>
                        <p>If you have any questions, feel free to reply to this email.</p>
                    </div>
                    <div class='footer'>
                        <p>© 2025 Luna Team. All rights reserved.</p>
                        <p>This is an automated message. Please do not reply directly to this email.</p>
                    </div>
                </div>
            </body>
            </html>
        ";
        $mail->isHTML(true);
        $mail->Subject = $subject ?: 'Booking Confirmation Request';
        $mail->Body = $patientBody;
        $mail->AltBody = strip_tags(str_replace('<br>', "\n", $patientBody));
        $mail->send();

        // Therapist Email
        $mail->clearAddresses(); // Clear previous recipients
        $mail->setFrom('ddryn970@gmail.com', 'Luna Team');
        $mail->addAddress($therapistEmail);
        $therapistBody = "
            <!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <style>
                    body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
                    .container { max-width: 600px; margin: 20px auto; background-color: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
                    .header { background-color: #007bff; color: #ffffff; padding: 10px 20px; text-align: center; border-radius: 8px 8px 0 0; }
                    .content { padding: 20px; color: #333333; }
                    .footer { text-align: center; font-size: 12px; color: #777777; padding-top: 20px; border-top: 1px solid #eee; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <h2>Luna Booking Notification</h2>
                    </div>
                    <div class='content'>
                        <p>Dear Therapist,</p>
                        <p>A new booking request has been scheduled for <strong>{$patientName}</strong> on <strong>{$bookingDate}</strong> at <strong>{$bookingTime}</strong>.</p>
                        <p><strong>Patient Email:</strong> {$patientEmail}</p>
                        <p><strong>Booking ID:</strong> {$bookingId}</p>
                        <p>Please contact the patient to confirm or follow up as needed.</p>
                    </div>
                    <div class='footer'>
                        <p>© 2025 Luna Team. All rights reserved.</p>
                        <p>This is an automated message. Please do not reply directly to this email.</p>
                    </div>
                </div>
            </body>
            </html>
        ";
        $mail->isHTML(true);
        $mail->Subject = $subject ?: 'New Booking Notification';
        $mail->Body = $therapistBody;
        $mail->AltBody = strip_tags(str_replace('<br>', "\n", $therapistBody));
        $mail->send();

        // change user status to accepted
        $stmt = $conn->prepare("UPDATE booking_submissions SET status = 'accepted' WHERE id = :userId");
        $stmt->bindParam(':userId', $bookingId);
        $stmt->execute();

        $_SESSION['success'] = 'Email sent successfully to patient and therapist.';
    } catch (Exception $e) {
        error_log("Email Error: {$mail->ErrorInfo}", 3, __DIR__ . '/email_errors.log');
        $_SESSION['error'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

    header('Location: ../dashboard.php');
    exit;
}
?>

### Changes and Explanations

#### 1. **Separate Email Formats**
- **Patient Email**:
  - Retains the styled HTML with a blue header, action buttons (accept/reject), and a focus on confirmation.
  - Links point to `http://localhost/luna/response_handler.php` (adjust to your domain when live).
  - No therapist email is included in the body, as the patient doesn’t need it directly.
- **Therapist Email**:
  - Uses a similar styled layout but with a "Luna Booking Notification" header.
  - Includes booking details (patient name, date, time, email, and ID) for administrative purposes.
  - No action buttons, as the therapist is notified rather than prompted to act directly.

#### 2. **Subject Handling**
- The `Subject` is now explicitly set from `$_POST['subject']` for both emails, with a fallback (`?: 'Booking Confirmation Request'` for patient, `?: 'New Booking Notification'` for therapist) if the form field is empty.
- This ensures the subject is always present and reflects the user’s input from the `#bookingEmailModal`.

#### 3. **PHPMailer Logic**
- `clearAddresses()` is called before setting new recipients to avoid duplicating addresses between emails.
- Two separate `send()` calls are used: one for the patient and one for the therapist, each with its own body content.

#### 4. **Dynamic Data**
- The `preg_match` logic extracts `patientName`, `bookingDate`, and `bookingTime` from the `$message`, which is pre-filled in the modal’s JavaScript.
- These values are used in both email bodies for consistency.

### Testing
- **Submit the Form**: Open the `#bookingEmailModal`, fill in the therapist email and subject, and submit. Check both the patient’s and therapist’s inboxes.
- **Verify Content**: Ensure the patient email has the accept/reject buttons, and the therapist email has the notification details.
- **Check Subject**: Confirm the subject matches your input or the fallback value.
- **Debug**: If emails fail, check `email_errors.log` in `/admin/php/` for issues.

### Next Steps
- **Update Modal JavaScript**: The current JavaScript pre-fills the message, but you might want to adjust it to include the subject field population or validate it. Let me know if you need help with this.
- **Implement `response_handler.php`**: The accept/reject links won’t work until this script is created. I can provide a detailed implementation if you’re ready.
- **Customize Design**: If you want different colors or layouts for the emails, let me know, and I can adjust the CSS.

This update should provide a tailored experience for both the patient and therapist while ensuring the subject is included. Let me know how it works or if you need further refinements!