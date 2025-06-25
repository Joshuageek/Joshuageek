<?php
session_start();
require_once '../includes/auth.php';

// Check if user is authenticated and is patient
if (!isLoggedIn() || getUserRole() !== 'patient') {
    header('Location: ../index.php');
    exit();
}

// Sample sessions data for the logged-in patient
$sessions = [
    [
        'id' => 1,
        'therapist' => 'Dr. Sarah Johnson',
        'date' => '2024-06-24 14:00:00',
        'duration' => 60,
        'type' => 'Video Call',
        'status' => 'completed',
        'topic' => 'Anxiety Management Techniques',
        'notes_available' => true,
        'homework_assigned' => true,
        'rating' => 5,
        'mood_before' => 3,
        'mood_after' => 7
    ],
    [
        'id' => 2,
        'therapist' => 'Dr. Sarah Johnson',
        'date' => '2024-06-27 14:00:00',
        'duration' => 60,
        'type' => 'Video Call',
        'status' => 'scheduled',
        'topic' => 'Follow-up: Coping Strategies',
        'notes_available' => false,
        'homework_assigned' => false,
        'preparation_notes' => 'Review breathing exercises from last session'
    ],
    [
        'id' => 3,
        'therapist' => 'Dr. Sarah Johnson',
        'date' => '2024-06-20 14:00:00',
        'duration' => 60,
        'type' => 'In-Person',
        'status' => 'completed',
        'topic' => 'Cognitive Behavioral Therapy Introduction',
        'notes_available' => true,
        'homework_assigned' => true,
        'rating' => 5,
        'mood_before' => 4,
        'mood_after' => 6
    ],
    [
        'id' => 4,
        'therapist' => 'Dr. Sarah Johnson',
        'date' => '2024-06-17 14:00:00',
        'duration' => 60,
        'type' => 'Video Call',
        'status' => 'completed',
        'topic' => 'Initial Assessment and Goal Setting',
        'notes_available' => true,
        'homework_assigned' => false,
        'rating' => 4,
        'mood_before' => 3,
        'mood_after' => 5
    ]
];

$total_sessions = count($sessions);
$completed_sessions = count(array_filter($sessions, fn($s) => $s['status'] === 'completed'));
$upcoming_sessions = count(array_filter($sessions, fn($s) => $s['status'] === 'scheduled'));
$avg_rating = round(array_sum(array_column(array_filter($sessions, fn($s) => isset($s['rating'])), 'rating')) / $completed_sessions, 1);
?>

<!DOCTYPE html>
<html lang="en">
<?php include '../templates/header.php'; ?>
<body>
    <?php include '../templates/sidebar.php'; ?>
    
    <!-- Main Content -->
    <div class="main-content">
        <!-- Custom toolbar for this page -->
        <div class="top-bar">
            <div class="page-info d-flex align-items-center">
                <button class="btn me-3" id="sidebarToggle" style="background: var(--luna-primary); color: white; border-radius: 8px;">
                    <i class="fas fa-bars"></i>
                </button>
                <div>
                    <h1 class="page-title">My Sessions</h1>
                    <p class="page-subtitle">Track your therapy sessions and progress</p>
                </div>
            </div>
            <div class="top-bar-actions">
                <button class="btn btn-luna-primary" onclick="bookNewSession()">
                    <i class="fas fa-calendar-plus me-2"></i>Book New Session
                </button>
            </div>
        </div>
        
        <!-- Page Content -->
        <div class="container-fluid p-4">
            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card animate-in">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="stat-label">Total Sessions</p>
                                <h3 class="stat-number"><?php echo $total_sessions; ?></h3>
                                <span class="stat-change positive">
                                    <i class="fas fa-heart"></i> Your journey
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
                                <p class="stat-label">Completed</p>
                                <h3 class="stat-number"><?php echo $completed_sessions; ?></h3>
                                <span class="stat-change positive">
                                    <i class="fas fa-check-circle"></i> Well done!
                                </span>
                            </div>
                            <div class="stat-icon icon-success">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card animate-in animate-delay-2">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="stat-label">Upcoming</p>
                                <h3 class="stat-number"><?php echo $upcoming_sessions; ?></h3>
                                <span class="stat-change positive">
                                    <i class="fas fa-clock"></i> Scheduled
                                </span>
                            </div>
                            <div class="stat-icon icon-warning">
                                <i class="fas fa-clock"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card animate-in animate-delay-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="stat-label">Average Rating</p>
                                <h3 class="stat-number"><?php echo $avg_rating; ?></h3>
                                <span class="stat-change positive">
                                    <i class="fas fa-star"></i> Excellent feedback
                                </span>
                            </div>
                            <div class="stat-icon icon-warning">
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sessions Timeline -->
            <div class="stat-card animate-in">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0">
                        <i class="fas fa-history text-primary me-2"></i>
                        Session History
                    </h5>
                    <div class="d-flex gap-2">
                        <select class="form-select" style="width: auto;" id="statusFilter">
                            <option value="">All Sessions</option>
                            <option value="completed">Completed</option>
                            <option value="scheduled">Upcoming</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                </div>

                <div class="sessions-timeline">
                    <?php foreach ($sessions as $index => $session): ?>
                    <div class="session-item <?php echo $session['status']; ?>">
                        <div class="session-date">
                            <div class="date-circle <?php echo $session['status']; ?>">
                                <?php if ($session['status'] === 'completed'): ?>
                                    <i class="fas fa-check"></i>
                                <?php elseif ($session['status'] === 'scheduled'): ?>
                                    <i class="fas fa-clock"></i>
                                <?php else: ?>
                                    <i class="fas fa-calendar"></i>
                                <?php endif; ?>
                            </div>
                            <div class="date-info">
                                <div class="fw-bold"><?php echo date('M j', strtotime($session['date'])); ?></div>
                                <div class="small text-muted"><?php echo date('g:i A', strtotime($session['date'])); ?></div>
                            </div>
                        </div>

                        <div class="session-content">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="mb-1"><?php echo htmlspecialchars($session['topic']); ?></h6>
                                    <div class="text-muted small">
                                        with <?php echo htmlspecialchars($session['therapist']); ?> • 
                                        <?php echo $session['duration']; ?> minutes • 
                                        <?php echo $session['type']; ?>
                                    </div>
                                </div>
                                <span class="badge <?php 
                                    echo $session['status'] === 'completed' ? 'bg-success' : 
                                        ($session['status'] === 'scheduled' ? 'bg-primary' : 'bg-secondary'); 
                                ?>">
                                    <?php echo ucfirst($session['status']); ?>
                                </span>
                            </div>

                            <?php if ($session['status'] === 'completed'): ?>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <div class="small text-muted">Session Rating</div>
                                        <div class="text-warning">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <i class="fas fa-star<?php echo $i <= $session['rating'] ? '' : '-o'; ?>"></i>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="small text-muted">Mood Before</div>
                                        <div class="mood-indicator mood-<?php echo $session['mood_before']; ?>">
                                            <?php echo $session['mood_before']; ?>/10
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="small text-muted">Mood After</div>
                                        <div class="mood-indicator mood-<?php echo $session['mood_after']; ?>">
                                            <?php echo $session['mood_after']; ?>/10
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if (isset($session['preparation_notes'])): ?>
                                <div class="alert alert-info small mb-3">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Preparation:</strong> <?php echo htmlspecialchars($session['preparation_notes']); ?>
                                </div>
                            <?php endif; ?>

                            <div class="d-flex gap-2 flex-wrap">
                                <?php if ($session['status'] === 'scheduled'): ?>
                                    <button class="btn btn-sm btn-success" onclick="joinSession(<?php echo $session['id']; ?>)">
                                        <i class="fas fa-video me-1"></i>Join Session
                                    </button>
                                    <button class="btn btn-sm btn-outline-warning" onclick="rescheduleSession(<?php echo $session['id']; ?>)">
                                        <i class="fas fa-calendar-alt me-1"></i>Reschedule
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger" onclick="cancelSession(<?php echo $session['id']; ?>)">
                                        <i class="fas fa-times me-1"></i>Cancel
                                    </button>
                                <?php else: ?>
                                    <?php if ($session['notes_available']): ?>
                                        <button class="btn btn-sm btn-outline-primary" onclick="viewSessionNotes(<?php echo $session['id']; ?>)">
                                            <i class="fas fa-sticky-note me-1"></i>View Notes
                                        </button>
                                    <?php endif; ?>
                                    <?php if ($session['homework_assigned']): ?>
                                        <button class="btn btn-sm btn-outline-success" onclick="viewHomework(<?php echo $session['id']; ?>)">
                                            <i class="fas fa-tasks me-1"></i>Homework
                                        </button>
                                    <?php endif; ?>
                                    <button class="btn btn-sm btn-outline-secondary" onclick="provideFeedback(<?php echo $session['id']; ?>)">
                                        <i class="fas fa-comment me-1"></i>Feedback
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <?php include '../templates/footer.php'; ?>
    
    <script src="../assets/js/simple-luna.js"></script>
    
    <script>
        // Session management functions
        function bookNewSession() {
            showToast('Opening session booking form...', 'info');
            // In real app, redirect to booking page or open modal
        }

        function joinSession(sessionId) {
            showToast(`Joining session ID: ${sessionId}`, 'success');
            // In real app, redirect to video call interface
        }

        function rescheduleSession(sessionId) {
            showToast(`Opening reschedule options for session ID: ${sessionId}`, 'info');
            // In real app, open reschedule modal
        }

        function cancelSession(sessionId) {
            if (confirm('Are you sure you want to cancel this session?')) {
                showToast('Session cancelled successfully', 'warning');
                // In real app, make API call to cancel session
            }
        }

        function viewSessionNotes(sessionId) {
            showToast(`Loading session notes for session ID: ${sessionId}`, 'info');
            // In real app, open notes modal or redirect to notes page
        }

        function viewHomework(sessionId) {
            showToast(`Loading homework assignments for session ID: ${sessionId}`, 'info');
            // In real app, open homework modal or redirect to homework page
        }

        function provideFeedback(sessionId) {
            showToast(`Opening feedback form for session ID: ${sessionId}`, 'info');
            // In real app, open feedback modal
        }

        // Filter functionality
        document.getElementById('statusFilter').addEventListener('change', function() {
            const filterValue = this.value;
            const sessionItems = document.querySelectorAll('.session-item');
            
            sessionItems.forEach(item => {
                if (filterValue === '' || item.classList.contains(filterValue)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    </script>

    <style>
        .sessions-timeline {
            position: relative;
        }

        .session-item {
            display: flex;
            margin-bottom: 2rem;
            position: relative;
        }

        .session-item:not(:last-child)::after {
            content: '';
            position: absolute;
            left: 30px;
            top: 60px;
            bottom: -32px;
            width: 2px;
            background: #e9ecef;
        }

        .session-date {
            display: flex;
            align-items: center;
            margin-right: 2rem;
            min-width: 120px;
        }

        .date-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            color: white;
            font-size: 1.2rem;
        }

        .date-circle.completed {
            background: var(--luna-success);
        }

        .date-circle.scheduled {
            background: var(--luna-primary);
        }

        .date-circle.cancelled {
            background: var(--luna-gray);
        }

        .session-content {
            flex: 1;
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 12px;
            border-left: 4px solid var(--luna-primary);
        }

        .session-item.completed .session-content {
            border-left-color: var(--luna-success);
        }

        .session-item.scheduled .session-content {
            border-left-color: var(--luna-primary);
        }

        .mood-indicator {
            font-weight: bold;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.9rem;
        }

        .mood-1, .mood-2, .mood-3 { background: #fee2e2; color: #dc2626; }
        .mood-4, .mood-5, .mood-6 { background: #fef3c7; color: #d97706; }
        .mood-7, .mood-8, .mood-9, .mood-10 { background: #dcfce7; color: #16a34a; }

        @media (max-width: 768px) {
            .session-item {
                flex-direction: column;
            }
            
            .session-date {
                margin-bottom: 1rem;
                margin-right: 0;
            }
            
            .session-item::after {
                display: none;
            }
        }
    </style>
</body>
</html>
