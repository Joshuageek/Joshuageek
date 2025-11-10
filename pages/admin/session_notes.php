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

// Sample notes data
$session_notes = [
    [
        'id' => 1,
        'session_id' => 101,
        'patient_name' => $user_role === 'therapist' ? 'Sarah Mitchell' : null,
        'therapist_name' => $user_role === 'patient' ? 'Dr. Sarah Johnson' : null,
        'session_date' => date('Y-m-d H:i:s', strtotime('-2 days')),
        'session_type' => 'CBT Session',
        'duration' => 50,
        'mood_before' => 4,
        'mood_after' => 7,
        'notes' => 'Patient showed significant improvement in anxiety management techniques. Discussed coping strategies for work-related stress. Homework assigned: daily mindfulness practice.',
        'goals_addressed' => ['Anxiety Management', 'Stress Reduction'],
        'homework_assigned' => 'Daily 10-minute mindfulness meditation',
        'next_session_focus' => 'Review mindfulness progress, work on cognitive restructuring',
        'created_at' => date('Y-m-d H:i:s', strtotime('-2 days')),
        'updated_at' => date('Y-m-d H:i:s', strtotime('-1 day'))
    ],
    [
        'id' => 2,
        'session_id' => 102,
        'patient_name' => $user_role === 'therapist' ? 'John Davis' : null,
        'therapist_name' => $user_role === 'patient' ? 'Dr. Sarah Johnson' : null,
        'session_date' => date('Y-m-d H:i:s', strtotime('-1 week')),
        'session_type' => 'PTSD Therapy',
        'duration' => 45,
        'mood_before' => 3,
        'mood_after' => 5,
        'notes' => 'Continued EMDR therapy session. Patient processed traumatic memory with less distress than previous sessions. Good progress in emotional regulation.',
        'goals_addressed' => ['Trauma Processing', 'Emotional Regulation'],
        'homework_assigned' => 'Grounding exercises when triggered',
        'next_session_focus' => 'Continue EMDR, assess progress',
        'created_at' => date('Y-m-d H:i:s', strtotime('-1 week')),
        'updated_at' => date('Y-m-d H:i:s', strtotime('-1 week'))
    ]
];

$stats = [
    'total_notes' => count($session_notes),
    'this_week' => 2,
    'avg_session_duration' => 48,
    'notes_with_homework' => count(array_filter($session_notes, fn($n) => !empty($n['homework_assigned'])))
];
?>

<!-- Session Notes Content -->
<div class="container-fluid p-4">
    <!-- Notes Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">
                <i class="fas fa-sticky-note me-2"></i>
                Session Notes
            </h2>
            <p class="text-muted mb-0">
                <?php echo $user_role === 'therapist' ? 'Manage and review your session notes' : 'View your therapy session notes and progress'; ?>
            </p>
        </div>
        <div class="d-flex gap-2">
            <?php if ($user_role === 'therapist'): ?>
                <button class="btn btn-luna-primary" onclick="createNote()">
                    <i class="fas fa-plus me-2"></i>New Note
                </button>
            <?php endif; ?>
            <button class="btn btn-luna-outline" onclick="exportNotes()">
                <i class="fas fa-download me-2"></i>Export
            </button>
        </div>
    </div>

    <!-- Notes Stats -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="stat-label">Total Notes</p>
                        <h4 class="stat-number"><?php echo $stats['total_notes']; ?></h4>
                    </div>
                    <div class="stat-icon icon-primary">
                        <i class="fas fa-sticky-note"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="stat-label">This Week</p>
                        <h4 class="stat-number"><?php echo $stats['this_week']; ?></h4>
                    </div>
                    <div class="stat-icon icon-success">
                        <i class="fas fa-calendar-week"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="stat-label">Avg Duration</p>
                        <h4 class="stat-number"><?php echo $stats['avg_session_duration']; ?>m</h4>
                    </div>
                    <div class="stat-icon icon-info">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="stat-label">With Homework</p>
                        <h4 class="stat-number"><?php echo $stats['notes_with_homework']; ?></h4>
                    </div>
                    <div class="stat-icon icon-warning">
                        <i class="fas fa-tasks"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notes List -->
    <div class="row">
        <?php foreach ($session_notes as $note): ?>
            <div class="col-lg-6 mb-4">
                <div class="stat-card h-100">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h6 class="mb-1">
                                <?php if ($user_role === 'therapist'): ?>
                                    <?php echo $note['patient_name']; ?> - <?php echo $note['session_type']; ?>
                                <?php else: ?>
                                    <?php echo $note['session_type']; ?> Session
                                <?php endif; ?>
                            </h6>
                            <div class="small text-muted">
                                <?php echo date('M j, Y g:i A', strtotime($note['session_date'])); ?> •
                                <?php echo $note['duration']; ?> minutes
                            </div>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#" onclick="viewNote(<?php echo $note['id']; ?>)">
                                        <i class="fas fa-eye me-2"></i>View Full Note</a></li>
                                <?php if ($user_role === 'therapist'): ?>
                                    <li><a class="dropdown-item" href="#" onclick="editNote(<?php echo $note['id']; ?>)">
                                            <i class="fas fa-edit me-2"></i>Edit Note</a></li>
                                <?php endif; ?>
                                <li><a class="dropdown-item" href="#" onclick="exportNote(<?php echo $note['id']; ?>)">
                                        <i class="fas fa-download me-2"></i>Export</a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Mood Indicators -->
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="small text-muted">Mood Before</div>
                            <div class="d-flex align-items-center">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <i class="fas fa-circle <?php echo $i <= $note['mood_before'] ? 'text-warning' : 'text-muted'; ?> me-1" style="font-size: 0.8rem;"></i>
                                <?php endfor; ?>
                                <span class="ms-2 small"><?php echo $note['mood_before']; ?>/5</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="small text-muted">Mood After</div>
                            <div class="d-flex align-items-center">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <i class="fas fa-circle <?php echo $i <= $note['mood_after'] ? 'text-success' : 'text-muted'; ?> me-1" style="font-size: 0.8rem;"></i>
                                <?php endfor; ?>
                                <span class="ms-2 small"><?php echo $note['mood_after']; ?>/5</span>
                            </div>
                        </div>
                    </div>

                    <!-- Goals Addressed -->
                    <?php if (!empty($note['goals_addressed'])): ?>
                        <div class="mb-3">
                            <div class="small text-muted mb-1">Goals Addressed</div>
                            <?php foreach ($note['goals_addressed'] as $goal): ?>
                                <span class="badge bg-light text-dark me-1"><?php echo $goal; ?></span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Session Notes -->
                    <div class="mb-3">
                        <div class="small text-muted mb-1">Session Notes</div>
                        <p class="small"><?php echo substr($note['notes'], 0, 150) . (strlen($note['notes']) > 150 ? '...' : ''); ?></p>
                    </div>

                    <!-- Homework -->
                    <?php if (!empty($note['homework_assigned'])): ?>
                        <div class="mb-3">
                            <div class="small text-muted mb-1">Homework Assigned</div>
                            <div class="small bg-light p-2 rounded">
                                <i class="fas fa-tasks me-1"></i>
                                <?php echo $note['homework_assigned']; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Next Session Focus -->
                    <?php if (!empty($note['next_session_focus'])): ?>
                        <div class="mb-3">
                            <div class="small text-muted mb-1">Next Session Focus</div>
                            <div class="small text-primary">
                                <i class="fas fa-arrow-right me-1"></i>
                                <?php echo $note['next_session_focus']; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Footer -->
                    <div class="d-flex justify-content-between align-items-center mt-auto pt-3 border-top">
                        <div class="small text-muted">
                            Updated: <?php echo date('M j, g:i A', strtotime($note['updated_at'])); ?>
                        </div>
                        <button class="btn btn-sm btn-outline-primary" onclick="viewNote(<?php echo $note['id']; ?>)">
                            View Full Note
                        </button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    function createNote() {
        window.showToast('Opening note editor...', 'info');
    }

    function exportNotes() {
        window.showToast('Exporting session notes...', 'info');
    }

    function viewNote(id) {
        window.showToast(`Loading note ${id}...`, 'info');
    }

    function editNote(id) {
        window.showToast(`Editing note ${id}...`, 'info');
    }

    function exportNote(id) {
        window.showToast(`Exporting note ${id}...`, 'info');
    }
</script>

<?php include 'templates/footer.php'; ?>
