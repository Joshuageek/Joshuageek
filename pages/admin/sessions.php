<?php
session_start();
require_once 'includes/auth.php';
include 'templates/header.php';

// Check if user is authenticated
if (!isLoggedIn()) {
    header('Location: ../login.php');
    exit();
}

$user_role = getUserRole();
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'] ?? 'User';

// Role-based data and configuration
if ($user_role === 'therapist') {
    $page_title = 'My Sessions & Patients';
    $page_subtitle = 'Manage your therapy sessions, view patient progress, and track treatment outcomes';
    $sessions_data = [
        'total_sessions' => 156,
        'this_week' => 12,
        'completed' => 142,
        'upcoming' => 8,
        'active_patients' => 28,
        'avg_session_duration' => 52,
        'completion_rate' => 94.2,
        'patient_satisfaction' => 4.8
    ];
} else {
    $page_title = 'My Sessions & Progress';
    $page_subtitle = 'Track your therapy journey, view session history, and monitor your mental wellness progress';
    $sessions_data = [
        'total_sessions' => 24,
        'this_week' => 2,
        'completed' => 22,
        'upcoming' => 1,
        'current_streak' => 8,
        'avg_mood_rating' => 7.2,
        'goals_completed' => 12,
        'progress_score' => 78.5
    ];
}

// Sample sessions (role-based)
if ($user_role === 'therapist') {
    $recent_sessions = [
        [
            'id' => 1,
            'patient_name' => 'Sarah M.',
            'patient_id' => 'PT001',
            'date' => date('Y-m-d H:i:s', strtotime('-2 hours')),
            'duration' => 50,
            'type' => 'CBT Session',
            'status' => 'completed',
            'notes_count' => 3,
            'mood_before' => 4,
            'mood_after' => 7,
            'next_session' => date('Y-m-d H:i:s', strtotime('+5 days'))
        ],
        [
            'id' => 2,
            'patient_name' => 'John D.',
            'patient_id' => 'PT002',
            'date' => date('Y-m-d H:i:s', strtotime('-1 day')),
            'duration' => 45,
            'type' => 'PTSD Therapy',
            'status' => 'completed',
            'notes_count' => 5,
            'mood_before' => 3,
            'mood_after' => 6,
            'next_session' => date('Y-m-d H:i:s', strtotime('+3 days'))
        ],
        [
            'id' => 3,
            'patient_name' => 'Emily R.',
            'patient_id' => 'PT003',
            'date' => date('Y-m-d H:i:s', strtotime('+2 hours')),
            'duration' => 60,
            'type' => 'Family Therapy',
            'status' => 'upcoming',
            'notes_count' => 0,
            'mood_before' => null,
            'mood_after' => null,
            'next_session' => null
        ]
    ];
} else {
    $recent_sessions = [
        [
            'id' => 1,
            'therapist_name' => 'Dr. Sarah Johnson',
            'date' => date('Y-m-d H:i:s', strtotime('-2 hours')),
            'duration' => 50,
            'type' => 'CBT Session',
            'status' => 'completed',
            'mood_before' => 4,
            'mood_after' => 7,
            'goals_worked' => ['Anxiety Management', 'Sleep Improvement'],
            'homework_assigned' => true,
            'next_session' => date('Y-m-d H:i:s', strtotime('+5 days'))
        ],
        [
            'id' => 2,
            'therapist_name' => 'Dr. Sarah Johnson',
            'date' => date('Y-m-d H:i:s', strtotime('-1 week')),
            'duration' => 45,
            'type' => 'Progress Review',
            'status' => 'completed',
            'mood_before' => 5,
            'mood_after' => 8,
            'goals_worked' => ['Stress Management'],
            'homework_assigned' => false,
            'next_session' => null
        ],
        [
            'id' => 3,
            'therapist_name' => 'Dr. Sarah Johnson',
            'date' => date('Y-m-d H:i:s', strtotime('+2 hours')),
            'duration' => 50,
            'type' => 'CBT Session',
            'status' => 'upcoming',
            'mood_before' => null,
            'mood_after' => null,
            'goals_worked' => [],
            'homework_assigned' => false,
            'next_session' => null
        ]
    ];
}

// Quick actions based on role
if ($user_role === 'therapist') {
    $quick_actions = [
        ['title' => 'Add Session Notes', 'icon' => 'fa-sticky-note', 'color' => 'primary', 'action' => 'addNotes()'],
        ['title' => 'Schedule Appointment', 'icon' => 'fa-calendar-plus', 'color' => 'success', 'action' => 'scheduleAppointment()'],
        ['title' => 'View Patient Reports', 'icon' => 'fa-chart-bar', 'color' => 'info', 'action' => 'viewReports()'],
        ['title' => 'Message Patient', 'icon' => 'fa-envelope', 'color' => 'warning', 'action' => 'messagePatient()']
    ];
} else {
    $quick_actions = [
        ['title' => 'Track Mood', 'icon' => 'fa-smile', 'color' => 'primary', 'action' => 'trackMood()'],
        ['title' => 'View Progress', 'icon' => 'fa-chart-line', 'color' => 'success', 'action' => 'viewProgress()'],
        ['title' => 'Set Goals', 'icon' => 'fa-bullseye', 'color' => 'info', 'action' => 'setGoals()'],
        ['title' => 'Message Therapist', 'icon' => 'fa-envelope', 'color' => 'warning', 'action' => 'messageTherapist()']
    ];
}
?>

<!-- Sessions Management Content -->
<div class="container-fluid p-4">
    <!-- Sessions Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">
                <i class="fas fa-calendar-check me-2"></i>
                <?php echo $user_role === 'therapist' ? 'Session Management' : 'My Sessions'; ?>
            </h2>
            <p class="text-muted mb-0">
                <?php echo $user_role === 'therapist' ? 'Manage and track all therapy sessions' : 'View your therapy session history and upcoming appointments'; ?>
            </p>
        </div>
        <div class="d-flex gap-2">
            <?php if ($user_role === 'therapist'): ?>
                <button class="btn btn-luna-primary" onclick="createSession()">
                    <i class="fas fa-plus me-2"></i>New Session
                </button>
            <?php else: ?>
                <button class="btn btn-luna-primary" onclick="requestSession()">
                    <i class="fas fa-calendar-plus me-2"></i>Request Session
                </button>
            <?php endif; ?>
            <button class="btn btn-luna-outline" onclick="exportSessions()">
                <i class="fas fa-download me-2"></i>Export
            </button>
        </div>
    </div>

    <!-- Key Metrics -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card animate-in">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="stat-label">Total Sessions</p>
                        <h3 class="stat-number"><?php echo $sessions_data['total_sessions']; ?></h3>
                        <span class="stat-change positive">
                            <i class="fas fa-arrow-up"></i> +8.5% this month
                        </span>
                    </div>
                    <div class="stat-icon icon-primary">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card animate-in animate-delay-1">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="stat-label">This Week</p>
                        <h3 class="stat-number"><?php echo $sessions_data['this_week']; ?></h3>
                        <span class="stat-change positive">
                            <i class="fas fa-calendar"></i> On schedule
                        </span>
                    </div>
                    <div class="stat-icon icon-success">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card animate-in animate-delay-2">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="stat-label">Completed</p>
                        <h3 class="stat-number"><?php echo $sessions_data['completed']; ?></h3>
                        <span class="stat-change positive">
                            <i class="fas fa-check-circle"></i> Great progress
                        </span>
                    </div>
                    <div class="stat-icon icon-warning">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card animate-in animate-delay-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="stat-label">Upcoming</p>
                        <h3 class="stat-number"><?php echo $sessions_data['upcoming']; ?></h3>
                        <span class="stat-change neutral">
                            <i class="fas fa-calendar-alt"></i> Next 7 days
                        </span>
                    </div>
                    <div class="stat-icon icon-info">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Sessions -->
    <div class="row">
        <div class="col-lg-8">
            <div class="stat-card animate-in">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0">
                        <i class="fas fa-history text-primary me-2"></i>
                        Recent Sessions
                    </h5>
                    <div class="d-flex gap-2">
                        <select class="form-select form-select-sm" style="width: auto;">
                            <option>All Sessions</option>
                            <option>This Week</option>
                            <option>This Month</option>
                            <option>Completed</option>
                            <option>Upcoming</option>
                        </select>
                        <button class="btn btn-sm btn-outline-secondary" onclick="refreshSessions()">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </div>
                </div>

                <?php foreach ($recent_sessions as $session): ?>
                    <div class="activity-item">
                        <div class="activity-avatar <?php echo $session['status'] === 'completed' ? 'bg-success' : ($session['status'] === 'upcoming' ? 'bg-primary' : 'bg-secondary'); ?>">
                            <i class="fas <?php echo $session['status'] === 'completed' ? 'fa-check' : ($session['status'] === 'upcoming' ? 'fa-clock' : 'fa-calendar'); ?>"></i>
                        </div>
                        <div class="activity-content flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1">
                                        <?php if ($user_role === 'therapist'): ?>
                                            <?php echo $session['patient_name']; ?> - <?php echo $session['type']; ?>
                                        <?php else: ?>
                                            <?php echo $session['type']; ?> with <?php echo $session['therapist_name']; ?>
                                        <?php endif; ?>
                                    </h6>
                                    <p class="mb-2">
                                        <?php echo date('M j, Y g:i A', strtotime($session['date'])); ?> •
                                        <?php echo $session['duration']; ?> minutes
                                        <?php if ($session['status'] === 'completed'): ?>
                                            • Mood: <?php echo $session['mood_before']; ?> → <?php echo $session['mood_after']; ?>
                                        <?php endif; ?>
                                    </p>
                                    <?php if ($user_role === 'patient' && !empty($session['goals_worked'])): ?>
                                        <div class="mb-2">
                                            <small class="text-muted">Goals worked on:</small>
                                            <?php foreach ($session['goals_worked'] as $goal): ?>
                                                <span class="badge bg-light text-dark me-1"><?php echo $goal; ?></span>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-<?php echo $session['status'] === 'completed' ? 'success' : ($session['status'] === 'upcoming' ? 'primary' : 'secondary'); ?>">
                                        <?php echo ucfirst($session['status']); ?>
                                    </span>
                                    <?php if ($user_role === 'therapist' && $session['status'] === 'completed'): ?>
                                        <div class="small text-muted mt-1">
                                            <?php echo $session['notes_count']; ?> notes
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php if ($session['next_session']): ?>
                                <div class="small text-muted">
                                    <i class="fas fa-calendar me-1"></i>
                                    Next: <?php echo date('M j, Y g:i A', strtotime($session['next_session'])); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <?php if ($user_role === 'therapist'): ?>
                                    <li><a class="dropdown-item" href="#" onclick="viewSessionDetails(<?php echo $session['id']; ?>)">
                                            <i class="fas fa-eye me-2"></i>View Details</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="addNotes(<?php echo $session['id']; ?>)">
                                            <i class="fas fa-sticky-note me-2"></i>Add Notes</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="scheduleFollowUp(<?php echo $session['id']; ?>)">
                                            <i class="fas fa-calendar-plus me-2"></i>Schedule Follow-up</a></li>
                                <?php else: ?>
                                    <li><a class="dropdown-item" href="#" onclick="viewSessionSummary(<?php echo $session['id']; ?>)">
                                            <i class="fas fa-eye me-2"></i>View Summary</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="provideFeedback(<?php echo $session['id']; ?>)">
                                            <i class="fas fa-star me-2"></i>Rate Session</a></li>
                                    <?php if ($session['homework_assigned']): ?>
                                        <li><a class="dropdown-item" href="#" onclick="viewHomework(<?php echo $session['id']; ?>)">
                                                <i class="fas fa-tasks me-2"></i>View Homework</a></li>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Side Panel -->
        <div class="col-lg-4">
            <!-- Today's Schedule -->
            <div class="stat-card animate-in animate-delay-2">
                <h5 class="mb-3">
                    <i class="fas fa-calendar-day text-warning me-2"></i>
                    Today's Schedule
                </h5>
                <div class="schedule-item">
                    <div class="d-flex align-items-center">
                        <div class="schedule-time">
                            <div class="fw-bold">2:00 PM</div>
                            <div class="small text-muted">50 min</div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <?php if ($user_role === 'therapist'): ?>
                                <div class="fw-semibold">Emily R.</div>
                                <div class="small text-muted">Family Therapy</div>
                            <?php else: ?>
                                <div class="fw-semibold">CBT Session</div>
                                <div class="small text-muted">Dr. Sarah Johnson</div>
                            <?php endif; ?>
                        </div>
                        <span class="badge bg-primary">Upcoming</span>
                    </div>
                </div>
                <div class="d-grid mt-3">
                    <button class="btn btn-outline-warning btn-sm" onclick="viewFullSchedule()">
                        <i class="fas fa-calendar me-2"></i>View Full Schedule
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Role-based JavaScript functions
    document.addEventListener('DOMContentLoaded', function() {
        initializeSessions();
    });

    function initializeSessions() {
        // Initialize based on user role
        const userRole = '<?php echo $user_role; ?>';

        if (userRole === 'therapist') {
            initializeTherapistFunctions();
        } else {
            initializePatientFunctions();
        }
    }

    // Therapist Functions
    function initializeTherapistFunctions() {
        console.log('Therapist dashboard initialized');
    }

    function scheduleSession() {
        window.showToast('Opening session scheduler...', 'info');
    }

    function viewAllPatients() {
        window.showToast('Loading all patients...', 'info');
    }

    function addNotes(sessionId = null) {
        const message = sessionId ? `Adding notes for session ${sessionId}...` : 'Opening notes editor...';
        window.showToast(message, 'info');
    }

    function scheduleAppointment() {
        window.showToast('Opening appointment scheduler...', 'info');
    }

    function viewReports() {
        window.showToast('Loading patient reports...', 'info');
    }

    function messagePatient() {
        window.showToast('Opening patient messaging...', 'info');
    }

    function addNewPatient() {
        window.showToast('Opening new patient form...', 'info');
    }

    function scheduleFollowUp(sessionId) {
        window.showToast(`Scheduling follow-up for session ${sessionId}...`, 'info');
    }

    // Patient Functions
    function initializePatientFunctions() {
        console.log('Patient dashboard initialized');
    }

    function trackMood() {
        window.showToast('Opening mood tracker...', 'info');
    }

    function viewProgress() {
        window.showToast('Loading your progress...', 'info');
    }

    function setGoals() {
        window.showToast('Opening goal setting...', 'info');
    }

    function messageTherapist() {
        window.showToast('Opening therapist messaging...', 'info');
    }

    function viewSessionSummary(sessionId) {
        window.showToast(`Loading session ${sessionId} summary...`, 'info');
    }

    function provideFeedback(sessionId) {
        window.showToast(`Opening feedback form for session ${sessionId}...`, 'info');
    }

    function viewHomework(sessionId) {
        window.showToast(`Loading homework for session ${sessionId}...`, 'info');
    }

    // Shared Functions
    function exportSessions() {
        window.showToast('Exporting session data...', 'info');
        setTimeout(() => {
            window.showToast('Sessions exported successfully!', 'success');
        }, 2000);
    }

    function refreshSessions() {
        window.showToast('Refreshing sessions...', 'info');
        setTimeout(() => {
            window.location.reload();
        }, 1000);
    }

    function viewSessionDetails(sessionId) {
        window.showToast(`Loading session ${sessionId} details...`, 'info');
    }

    function viewFullSchedule() {
        window.showToast('Loading full schedule...', 'info');
    }

    function createSession() {
        window.showToast('Opening new session form...', 'info');
    }

    function requestSession() {
        window.showToast('Opening session request form...', 'info');
    }
</script>

<style>
    .schedule-item {
        padding: 1rem;
        border-radius: 8px;
        background: var(--luna-light);
        margin-bottom: 1rem;
    }

    .schedule-time {
        text-align: center;
        min-width: 60px;
    }

    .activity-item {
        padding: 1.5rem;
        border-radius: 12px;
        background: var(--luna-light);
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .activity-item:hover {
        background: white;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .activity-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        margin-right: 1rem;
    }

    .activity-content {
        flex: 1;
    }

    @media (max-width: 768px) {
        .activity-item {
            padding: 1rem;
        }

        .schedule-item {
            padding: 0.75rem;
        }
    }
</style>

<?php include 'templates/footer.php'; ?>
