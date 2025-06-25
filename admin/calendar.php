<?php
session_start();
require_once 'includes/auth.php';
include 'templates/header.php';

if (!isLoggedIn()) {
    header('Location: ../login.php');
    exit();
}

$user_role = getUserRole();
$user_name = $_SESSION['user_name'] ?? 'User';

// Sample calendar events based on user role
$events = [];
if ($user_role === 'admin') {
    $events = [
        ['id' => 1, 'title' => 'System Maintenance', 'start' => '2024-06-27T02:00:00', 'end' => '2024-06-27T04:00:00', 'color' => '#ef4444'],
        ['id' => 2, 'title' => 'Staff Meeting', 'start' => '2024-06-28T10:00:00', 'end' => '2024-06-28T11:00:00', 'color' => '#3b82f6'],
        ['id' => 3, 'title' => 'Monthly Review', 'start' => '2024-06-30T14:00:00', 'end' => '2024-06-30T16:00:00', 'color' => '#10b981']
    ];
} elseif ($user_role === 'therapist') {
    $events = [
        ['id' => 1, 'title' => 'Emily Rodriguez - CBT Session', 'start' => '2024-06-27T14:00:00', 'end' => '2024-06-27T15:00:00', 'color' => '#10b981'],
        ['id' => 2, 'title' => 'Michael Chen - PTSD Therapy', 'start' => '2024-06-28T10:00:00', 'end' => '2024-06-28T11:00:00', 'color' => '#10b981'],
        ['id' => 3, 'title' => 'Sarah Davis - Follow-up', 'start' => '2024-06-29T16:00:00', 'end' => '2024-06-29T17:00:00', 'color' => '#10b981'],
        ['id' => 4, 'title' => 'Team Consultation', 'start' => '2024-06-30T09:00:00', 'end' => '2024-06-30T10:00:00', 'color' => '#3b82f6']
    ];
} else {
    $events = [
        ['id' => 1, 'title' => 'Therapy Session with Dr. Johnson', 'start' => '2024-06-27T14:00:00', 'end' => '2024-06-27T15:00:00', 'color' => '#10b981'],
        ['id' => 2, 'title' => 'Mood Check-in Reminder', 'start' => '2024-06-28T09:00:00', 'end' => '2024-06-28T09:15:00', 'color' => '#f59e0b'],
        ['id' => 3, 'title' => 'Meditation Session', 'start' => '2024-06-29T18:00:00', 'end' => '2024-06-29T18:30:00', 'color' => '#8b5cf6']
    ];
}
?>
    
    <div class="">
        <div class="m-5 d-flex justify-content-between">
            <div class="page-info d-flex align-items-center">
               
                <div>
                    <h1 class="page-title">Calendar</h1>
                    <p class="page-subtitle">Manage your schedule and appointments</p>
                </div>
            </div>
            <div class="top-bar-actions">
                <button class="btn btn-luna-primary" data-bs-toggle="modal" data-bs-target="#addEventModal">
                    <i class="fas fa-plus me-2"></i>Add Event
                </button>
            </div>
        </div>
        
        <div class="container-fluid p-4">
            <div class="stat-card">
                <div id="calendar"></div>
            </div>
        </div>
    </div>

    <!-- Add Event Modal -->
    <div class="modal fade" id="addEventModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addEventForm">
                        <div class="mb-3">
                            <label class="form-label">Event Title</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Start Date</label>
                                <input type="datetime-local" class="form-control" name="start" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">End Date</label>
                                <input type="datetime-local" class="form-control" name="end" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-luna-primary" onclick="submitEvent()">Add Event</button>
                </div>
            </div>
        </div>
    </div>

    <?php include 'templates/footer.php'; ?>
    
    <!-- FullCalendar -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script src="assets/js/simple-luna.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: <?php echo json_encode($events); ?>,
                eventClick: function(info) {
                    showToast('Event: ' + info.event.title, 'info');
                },
                height: 'auto'
            });
            calendar.render();
        });

        function submitEvent() {
            showToast('Event added successfully!', 'success');
            bootstrap.Modal.getInstance(document.getElementById('addEventModal')).hide();
        }
    </script>
