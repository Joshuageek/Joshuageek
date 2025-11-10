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

// Sample goals data
$goals_stats = [
    'total_goals' => 15,
    'completed_goals' => 8,
    'active_goals' => 5,
    'paused_goals' => 2,
    'completion_rate' => 53.3,
    'avg_completion_time' => 28 // days
];

// Goals categories
$goal_categories = [
    'mental_health' => 'Mental Health',
    'physical_health' => 'Physical Health',
    'relationships' => 'Relationships',
    'personal_growth' => 'Personal Growth',
    'career' => 'Career & Education',
    'lifestyle' => 'Lifestyle'
];

// Sample goals
$goals = [
    [
        'id' => 1,
        'title' => 'Practice Daily Mindfulness',
        'description' => 'Meditate for 10 minutes every morning',
        'category' => 'mental_health',
        'status' => 'active',
        'progress' => 85,
        'target_date' => date('Y-m-d', strtotime('+2 weeks')),
        'created_date' => date('Y-m-d', strtotime('-6 weeks')),
        'priority' => 'high',
        'milestones' => [
            ['title' => 'Complete 7 days', 'completed' => true],
            ['title' => 'Complete 21 days', 'completed' => true],
            ['title' => 'Complete 30 days', 'completed' => false],
            ['title' => 'Complete 60 days', 'completed' => false]
        ]
    ],
    [
        'id' => 2,
        'title' => 'Improve Sleep Schedule',
        'description' => 'Sleep 8 hours nightly, bed by 10 PM',
        'category' => 'physical_health',
        'status' => 'active',
        'progress' => 72,
        'target_date' => date('Y-m-d', strtotime('+1 month')),
        'created_date' => date('Y-m-d', strtotime('-4 weeks')),
        'priority' => 'high',
        'milestones' => [
            ['title' => 'Track sleep for 1 week', 'completed' => true],
            ['title' => 'Consistent bedtime for 2 weeks', 'completed' => true],
            ['title' => 'Achieve 8+ hours for 1 week', 'completed' => false],
            ['title' => 'Maintain for 1 month', 'completed' => false]
        ]
    ],
    [
        'id' => 3,
        'title' => 'Social Connection',
        'description' => 'Meet with friends or family twice per week',
        'category' => 'relationships',
        'status' => 'active',
        'progress' => 45,
        'target_date' => date('Y-m-d', strtotime('+6 weeks')),
        'created_date' => date('Y-m-d', strtotime('-3 weeks')),
        'priority' => 'medium',
        'milestones' => [
            ['title' => 'Schedule first meetup', 'completed' => true],
            ['title' => 'Complete 2 weeks consistently', 'completed' => false],
            ['title' => 'Expand social circle', 'completed' => false],
            ['title' => 'Maintain routine for 2 months', 'completed' => false]
        ]
    ],
    [
        'id' => 4,
        'title' => 'Learn Stress Management',
        'description' => 'Complete online course on stress management techniques',
        'category' => 'personal_growth',
        'status' => 'completed',
        'progress' => 100,
        'target_date' => date('Y-m-d', strtotime('-1 week')),
        'created_date' => date('Y-m-d', strtotime('-8 weeks')),
        'priority' => 'medium',
        'milestones' => [
            ['title' => 'Enroll in course', 'completed' => true],
            ['title' => 'Complete 50% of modules', 'completed' => true],
            ['title' => 'Practice techniques daily', 'completed' => true],
            ['title' => 'Complete final assessment', 'completed' => true]
        ]
    ],
    [
        'id' => 5,
        'title' => 'Exercise Routine',
        'description' => 'Exercise 3 times per week for 30 minutes',
        'category' => 'physical_health',
        'status' => 'paused',
        'progress' => 30,
        'target_date' => date('Y-m-d', strtotime('+2 months')),
        'created_date' => date('Y-m-d', strtotime('-5 weeks')),
        'priority' => 'low',
        'milestones' => [
            ['title' => 'Choose exercise type', 'completed' => true],
            ['title' => 'Complete first week', 'completed' => false],
            ['title' => 'Build consistency for 1 month', 'completed' => false],
            ['title' => 'Achieve target frequency', 'completed' => false]
        ]
    ]
];

// Goal templates for quick creation
$goal_templates = [
    [
        'title' => 'Daily Gratitude Practice',
        'description' => 'Write down 3 things you\'re grateful for each day',
        'category' => 'mental_health',
        'duration' => '30 days'
    ],
    [
        'title' => 'Reduce Screen Time',
        'description' => 'Limit recreational screen time to 2 hours per day',
        'category' => 'lifestyle',
        'duration' => '21 days'
    ],
    [
        'title' => 'Weekly Therapy Check-ins',
        'description' => 'Attend therapy sessions consistently',
        'category' => 'mental_health',
        'duration' => 'Ongoing'
    ],
    [
        'title' => 'Learn New Skill',
        'description' => 'Dedicate 30 minutes daily to learning something new',
        'category' => 'personal_growth',
        'duration' => '60 days'
    ]
];
?>

<!-- Goals Content -->
<div class="container-fluid p-4">
    <!-- Goals Header -->
    <div class="welcome-card animate-in">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h2 class="welcome-title">
                    <i class="fas fa-bullseye me-3"></i>
                    My Goals & Milestones
                </h2>
                <p class="welcome-subtitle">
                    Set meaningful goals, track your progress, and celebrate achievements on your mental wellness journey.
                    Break down big objectives into manageable steps and build positive habits that support your well-being.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <button class="btn btn-luna-primary" onclick="createGoal()">
                        <i class="fas fa-plus me-2"></i>Create New Goal
                    </button>
                    <button class="btn btn-luna-outline" onclick="viewTemplates()">
                        <i class="fas fa-lightbulb me-2"></i>Goal Templates
                    </button>
                    <button class="btn btn-luna-outline" onclick="exportGoals()">
                        <i class="fas fa-download me-2"></i>Export Progress
                    </button>
                </div>
            </div>
            <div class="col-lg-4 text-center">
                <div class="goals-summary">
                    <div class="completion-circle">
                        <div class="h2 fw-bold text-success"><?php echo $goals_stats['completed_goals']; ?></div>
                        <div class="small text-muted">Goals Completed</div>
                    </div>
                    <div class="mt-3">
                        <div class="small text-muted">Completion Rate</div>
                        <div class="h4 fw-bold text-primary"><?php echo $goals_stats['completion_rate']; ?>%</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Goals Stats -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card animate-in">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="stat-label">Total Goals</p>
                        <h3 class="stat-number"><?php echo $goals_stats['total_goals']; ?></h3>
                        <span class="stat-change positive">
                            <i class="fas fa-target"></i> All time
                        </span>
                    </div>
                    <div class="stat-icon icon-primary">
                        <i class="fas fa-bullseye"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card animate-in animate-delay-1">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="stat-label">Active Goals</p>
                        <h3 class="stat-number"><?php echo $goals_stats['active_goals']; ?></h3>
                        <span class="stat-change positive">
                            <i class="fas fa-play"></i> In progress
                        </span>
                    </div>
                    <div class="stat-icon icon-success">
                        <i class="fas fa-play"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card animate-in animate-delay-2">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="stat-label">Completed</p>
                        <h3 class="stat-number"><?php echo $goals_stats['completed_goals']; ?></h3>
                        <span class="stat-change positive">
                            <i class="fas fa-trophy"></i> Achievements
                        </span>
                    </div>
                    <div class="stat-icon icon-warning">
                        <i class="fas fa-trophy"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card animate-in animate-delay-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="stat-label">Avg Completion</p>
                        <h3 class="stat-number"><?php echo $goals_stats['avg_completion_time']; ?>d</h3>
                        <span class="stat-change positive">
                            <i class="fas fa-clock"></i> Average time
                        </span>
                    </div>
                    <div class="stat-icon icon-info">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Goals Filter and List -->
    <div class="row">
        <div class="col-lg-8">
            <div class="stat-card animate-in">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0">
                        <i class="fas fa-list text-primary me-2"></i>
                        My Goals
                    </h5>
                    <div class="d-flex gap-2">
                        <select class="form-select form-select-sm" style="width: auto;" onchange="filterGoals(this.value)">
                            <option value="all">All Goals</option>
                            <option value="active">Active</option>
                            <option value="completed">Completed</option>
                            <option value="paused">Paused</option>
                        </select>
                        <select class="form-select form-select-sm" style="width: auto;" onchange="filterByCategory(this.value)">
                            <option value="all">All Categories</option>
                            <?php foreach ($goal_categories as $key => $category): ?>
                                <option value="<?php echo $key; ?>"><?php echo $category; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <?php foreach ($goals as $goal): ?>
                    <div class="goal-card" data-status="<?php echo $goal['status']; ?>" data-category="<?php echo $goal['category']; ?>">
                        <div class="goal-header">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <h6 class="goal-title"><?php echo $goal['title']; ?></h6>
                                    <p class="goal-description"><?php echo $goal['description']; ?></p>
                                    <div class="goal-meta">
                                    <span class="badge bg-<?php echo $goal['status'] === 'completed' ? 'success' : ($goal['status'] === 'active' ? 'primary' : 'secondary'); ?>">
                                        <?php echo ucfirst($goal['status']); ?>
                                    </span>
                                        <span class="badge bg-light text-dark">
                                        <?php echo $goal_categories[$goal['category']]; ?>
                                    </span>
                                        <span class="badge bg-<?php echo $goal['priority'] === 'high' ? 'danger' : ($goal['priority'] === 'medium' ? 'warning' : 'info'); ?>">
                                        <?php echo ucfirst($goal['priority']); ?> Priority
                                    </span>
                                    </div>
                                </div>
                                <div class="goal-progress-circle">
                                    <div class="progress-circle-small" data-progress="<?php echo $goal['progress']; ?>">
                                        <span><?php echo $goal['progress']; ?>%</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="goal-progress-bar mb-3">
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-<?php echo $goal['status'] === 'completed' ? 'success' : 'primary'; ?>"
                                     style="width: <?php echo $goal['progress']; ?>%"></div>
                            </div>
                        </div>

                        <div class="goal-milestones mb-3">
                            <div class="small text-muted mb-2">Milestones</div>
                            <div class="milestones-list">
                                <?php foreach ($goal['milestones'] as $index => $milestone): ?>
                                    <div class="milestone-item <?php echo $milestone['completed'] ? 'completed' : ''; ?>">
                                        <i class="fas fa-<?php echo $milestone['completed'] ? 'check-circle' : 'circle'; ?>"></i>
                                        <span><?php echo $milestone['title']; ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="goal-footer">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="goal-dates">
                                    <small class="text-muted">
                                        Target: <?php echo date('M j, Y', strtotime($goal['target_date'])); ?>
                                    </small>
                                </div>
                                <div class="goal-actions">
                                    <button class="btn btn-sm btn-outline-primary" onclick="editGoal(<?php echo $goal['id']; ?>)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <?php if ($goal['status'] === 'active'): ?>
                                        <button class="btn btn-sm btn-outline-success" onclick="updateProgress(<?php echo $goal['id']; ?>)">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    <?php endif; ?>
                                    <div class="dropdown d-inline">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#" onclick="viewGoalDetails(<?php echo $goal['id']; ?>)">
                                                    <i class="fas fa-eye me-2"></i>View Details</a></li>
                                            <?php if ($goal['status'] === 'active'): ?>
                                                <li><a class="dropdown-item" href="#" onclick="pauseGoal(<?php echo $goal['id']; ?>)">
                                                        <i class="fas fa-pause me-2"></i>Pause Goal</a></li>
                                            <?php elseif ($goal['status'] === 'paused'): ?>
                                                <li><a class="dropdown-item" href="#" onclick="resumeGoal(<?php echo $goal['id']; ?>)">
                                                        <i class="fas fa-play me-2"></i>Resume Goal</a></li>
                                            <?php endif; ?>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item text-danger" href="#" onclick="deleteGoal(<?php echo $goal['id']; ?>)">
                                                    <i class="fas fa-trash me-2"></i>Delete Goal</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Goal Templates and Quick Actions -->
        <div class="col-lg-4">
            <!-- Quick Goal Creation -->
            <div class="stat-card animate-in animate-delay-1 mb-4">
                <h5 class="mb-4">
                    <i class="fas fa-rocket text-success me-2"></i>
                    Quick Goal Creation
                </h5>
                <div class="d-grid gap-2">
                    <button class="btn btn-outline-primary text-start" onclick="quickGoal('mindfulness')">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-brain fa-lg me-3 text-primary"></i>
                            <div>
                                <div class="fw-semibold">Mindfulness Goal</div>
                                <small class="text-muted">Daily meditation practice</small>
                            </div>
                        </div>
                    </button>
                    <button class="btn btn-outline-success text-start" onclick="quickGoal('exercise')">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-dumbbell fa-lg me-3 text-success"></i>
                            <div>
                                <div class="fw-semibold">Exercise Goal</div>
                                <small class="text-muted">Regular physical activity</small>
                            </div>
                        </div>
                    </button>
                    <button class="btn btn-outline-warning text-start" onclick="quickGoal('sleep')">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-bed fa-lg me-3 text-warning"></i>
                            <div>
                                <div class="fw-semibold">Sleep Goal</div>
                                <small class="text-muted">Better sleep schedule</small>
                            </div>
                        </div>
                    </button>
                    <button class="btn btn-outline-info text-start" onclick="quickGoal('social')">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-users fa-lg me-3 text-info"></i>
                            <div>
                                <div class="fw-semibold">Social Goal</div>
                                <small class="text-muted">Improve relationships</small>
                            </div>
                        </div>
                    </button>
                </div>
            </div>

            <!-- Goal Templates -->
            <div class="stat-card animate-in animate-delay-2">
                <h5 class="mb-4">
                    <i class="fas fa-lightbulb text-warning me-2"></i>
                    Goal Templates
                </h5>
                <?php foreach ($goal_templates as $template): ?>
                    <div class="template-item" onclick="useTemplate('<?php echo addslashes($template['title']); ?>')">
                        <div class="template-content">
                            <h6 class="template-title"><?php echo $template['title']; ?></h6>
                            <p class="template-description"><?php echo $template['description']; ?></p>
                            <div class="template-meta">
                                <span class="badge bg-light text-dark"><?php echo $goal_categories[$template['category']]; ?></span>
                                <span class="badge bg-primary"><?php echo $template['duration']; ?></span>
                            </div>
                        </div>
                        <div class="template-action">
                            <i class="fas fa-plus"></i>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<script>
    function createGoal() {
        window.showToast('Opening goal creation form...', 'info');
    }

    function editGoal(id) {
        window.showToast(`Editing goal ${id}...`, 'info');
    }

    function updateProgress(id) {
        window.showToast(`Updating progress for goal ${id}...`, 'info');
    }

    function viewGoalDetails(id) {
        window.showToast(`Loading goal ${id} details...`, 'info');
    }

    function pauseGoal(id) {
        window.showToast(`Pausing goal ${id}...`, 'info');
    }

    function resumeGoal(id) {
        window.showToast(`Resuming goal ${id}...`, 'info');
    }

    function deleteGoal(id) {
        if (confirm('Are you sure you want to delete this goal?')) {
            window.showToast(`Deleting goal ${id}...`, 'info');
        }
    }

    function filterGoals(status) {
        const goals = document.querySelectorAll('.goal-card');
        goals.forEach(goal => {
            if (status === 'all' || goal.dataset.status === status) {
                goal.style.display = 'block';
            } else {
                goal.style.display = 'none';
            }
        });
    }

    function filterByCategory(category) {
        const goals = document.querySelectorAll('.goal-card');
        goals.forEach(goal => {
            if (category === 'all' || goal.dataset.category === category) {
                goal.style.display = 'block';
            } else {
                goal.style.display = 'none';
            }
        });
    }

    function quickGoal(type) {
        window.showToast(`Creating ${type} goal...`, 'info');
    }

    function useTemplate(title) {
        window.showToast(`Using template: ${title}...`, 'info');
    }

    function viewTemplates() {
        window.showToast('Loading goal templates...', 'info');
    }

    function exportGoals() {
        window.showToast('Exporting goals progress...', 'info');
    }

    // Initialize progress circles
    document.addEventListener('DOMContentLoaded', function() {
        const progressCircles = document.querySelectorAll('.progress-circle-small');
        progressCircles.forEach(circle => {
            const progress = circle.dataset.progress;
            const color = progress >= 80 ? '#22c55e' : progress >= 50 ? '#3b82f6' : '#f59e0b';
            circle.style.background = `conic-gradient(${color} ${progress}%, #e5e7eb 0%)`;
        });
    });
</script>

<style>
    .goals-summary {
        text-align: center;
    }

    .completion-circle {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: var(--luna-light);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    }

    .goal-card {
        background: var(--luna-light);
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .goal-card:hover {
        background: white;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        border-color: var(--luna-primary);
    }

    .goal-title {
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--luna-text);
    }

    .goal-description {
        color: var(--luna-text-muted);
        margin-bottom: 1rem;
        font-size: 0.9rem;
    }

    .goal-meta {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
        margin-bottom: 1rem;
    }

    .progress-circle-small {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.875rem;
        color: white;
        text-shadow: 0 1px 2px rgba(0,0,0,0.3);
    }

    .milestones-list {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .milestone-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        color: var(--luna-text-muted);
    }

    .milestone-item.completed {
        color: var(--luna-success);
    }

    .milestone-item i {
        width: 16px;
    }

    .template-item {
        background: var(--luna-light);
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: between;
    }

    .template-item:hover {
        background: white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .template-content {
        flex: 1;
    }

    .template-title {
        font-weight: 600;
        margin-bottom: 0.25rem;
        font-size: 0.9rem;
    }

    .template-description {
        font-size: 0.8rem;
        color: var(--luna-text-muted);
        margin-bottom: 0.5rem;
    }

    .template-meta {
        display: flex;
        gap: 0.25rem;
        flex-wrap: wrap;
    }

    .template-action {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: var(--luna-primary);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-left: 1rem;
    }

    .goal-dates {
        font-size: 0.875rem;
    }

    .goal-actions {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    @media (max-width: 768px) {
        .goal-card {
            padding: 1rem;
        }

        .goal-meta {
            flex-direction: column;
            align-items: flex-start;
        }

        .template-item {
            flex-direction: column;
            text-align: center;
        }

        .template-action {
            margin-left: 0;
            margin-top: 0.5rem;
        }
    }
</style>

<?php include 'templates/footer.php'; ?>
