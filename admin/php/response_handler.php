<?php
if (isset($_GET['booking_id']) && isset($_GET['action'])) {
    $bookingId = $_GET['booking_id'];
    $action = $_GET['action'];

    if ($action === 'accept') {
        // Integrate with Google Calendar API or a local calendar system
        require 'vendor/autoload.php'; // For Google API
        $client = new Google_Client();
        $client->setApplicationName('Luna Booking');
        $client->setScopes(Google_Service_Calendar::CALENDAR);
        $client->setAuthConfig('credentials.json');
        $service = new Google_Service_Calendar($client);

        $event = new Google_Service_Calendar_Event([
            'summary' => 'Booking Confirmation',
            'start' => ['dateTime' => '2025-05-28T10:00:00+03:00'], // Dynamic from booking data
            'end' => ['dateTime' => '2025-05-28T11:00:00+03:00'], // Dynamic end time
            'attendees' => [
                ['email' => $patientEmail],
                ['email' => $therapistEmail],
            ],
        ]);

        $calendarId = 'primary';
        $event = $service->events->insert($calendarId, $event);
        // Save to database if needed
    } elseif ($action === 'reject') {
        // Update booking status to cancelled
    }

    header('Location: ../dashboard.php');
    exit;
}
?>