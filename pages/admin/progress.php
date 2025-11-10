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

// Sample progress data
$progress_data = [
    'overall_progress' => 78.5,
    'sessions_completed' => 24,
    'goals_achieved' => 12,
    'mood_improvement' => 45.2,
    'streak_days' => 18,
    'therapy_duration' => 6, // months
    'next_milestone' => 'Complete 30 sessions',
    'current_phase' => 'Active Treatment'
];

// Weekly progress data for chart
$weekly_progress = [
    ['week' => 'Week 1', 'mood' => 4.2, 'anxiety' => 7.8, 'sleep' => 5.1, 'energy' => 4.5],
    ['week' => 'Week 2', 'mood' => 4.8, 'anxiety' => 7.2, 'sleep' => 5.8, 'energy' => 5.1],
    ['week' => 'Week 3', 'mood' => 5.2, 'anxiety' => 6.9, 'sleep' => 6.2, 'energy' => 5.4],
    ['week' => 'Week 4', 'mood' => 5.8, 'anxiety' => 6.1, 'sleep' => 6.8, 'energy' => 6.2],
    ['week' => 'Week 5', 'mood' => 6.1, 'anxiety' => 5.8, 'sleep' => 7.1, 'energy' => 6.8],
    ['week' => 'Week 6', 'mood' => 6.8, 'anxiety' => 5.2, 'sleep' => 7.5, 'energy' => 7.2],
    ['week' => 'Week 7', 'mood' => 7.2, 'anxiety' => 4.8, 'sleep' => 7.8, 'energy' => 7.5],
    ['week' => 'Week 8', 'mood' => 7.5, 'anxiety' => 4.2, 'sleep' => 8.1, 'energy' => 7.8]
];

// Goals progress
$goals_progress = [
    ['goal' => 'Reduce Anxiety Levels', 'progress' => 85, 'status' => 'on_track'],
    ['goal' => 'Improve Sleep Quality', 'progress' => 92, 'status' => 'completed'],
    ['goal' => 'Daily Mindfulness Practice', 'progress' => 76, 'status' => 'on_track'],
    ['goal' => 'Social Interaction', 'progress' => 45, 'status' => 'needs_attention'],
    ['goal' => 'Exercise Routine', 'progress' => 68, 'status' => 'on_track']
];

// Recent achievements
$achievements = [
    [
        'title' => '30-Day Streak',
        'description' => 'Completed mood tracking for 30 consecutive days',
        'date' => date('Y-m-d', strtotime('-2 days')),
        'icon' => 'fa-fire',
        'color' => 'warning'
    ],
    [
        'title' => 'Sleep Goal Achieved',
        'description' => 'Maintained 8+ hours of sleep for 2 weeks',
        'date' => date('Y-m-d', strtotime('-1 week')),
        'icon' => 'fa-bed',
        'color' => 'success'
    ],
    [
        'title' => 'Anxiety Reduction',
        'description' => 'Reduced average anxiety level by 40%',
        'date' => date('Y-m-d', strtotime('-2 weeks')),
        'icon' => 'fa-heart',
        'color' => 'primary'
    ]
];

// Session outcomes
$session_outcomes = [
    ['date' => date('Y-m-d', strtotime('-3 days')), 'type' => 'CBT', 'mood_before' => 4, 'mood_after' => 7, 'progress_rating' => 8],
    ['date' => date('Y-m-d', strtotime('-1 week')), 'type' => 'CBT', 'mood_before' => 5, 'mood_after' => 7, 'progress_rating' => 7],
    ['date' => date('Y-m-d', strtotime('-2 weeks')), 'type' => 'Assessment', 'mood_before' => 3, 'mood_after' => 6, 'progress_rating' => 9],
    ['date' => date('Y-m-d', strtotime('-3 weeks')), 'type' => 'CBT', 'mood_before' => 4, 'mood_after' => 6, 'progress_rating' => 6]
];
?>

<!-- Progress Content -->
<div class="container-fluid p-4">
    <!-- Progress Header -->
    <div class="welcome-card animate-in">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h2 class="welcome-title">
                    <i class="fas fa-chart-line me-3"></i>
                    My Progress Journey
                </h2>
                <p class="welcome-subtitle">
                    Track your mental wellness journey, celebrate achievements, and monitor your therapeutic progress.
                    See how far you've come and stay motivated for continued growth and healing.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <button class="btn btn-luna-primary" onclick="viewDetailedProgress()">
                        <i class="fas fa-chart-bar me-2"></i>Detailed View
                    </button>
                    <button class="btn btn-luna-outline" onclick="shareProgress()">
                        <i class="fas fa-share me-2"></i>Share with Therapist
                    </button>
                    <button class="btn btn-luna-outline" onclick="exportProgress()">
                        <i class="fas fa-download me-2"></i>Export Report
                    </button>
                </div>
            </div>
            <div class="col-lg-4 text-center">
                <div class="progress-circle">
                    <div class="progress-circle-inner">
                        <div class="h1 fw-bold text-primary"><?php echo $progress_data['overall_progress']; ?>%</div>
                        <div class="small text-muted">Overall Progress</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Key Progress Metrics -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card animate-in">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="stat-label">Sessions Completed</p>
                        <h3 class="stat-number"><?php echo $progress_data['sessions_completed']; ?></h3>
                        <span class="stat-change positive">
                            <i class="fas fa-calendar-check"></i> <?php echo $progress_data['therapy_duration']; ?> months in therapy
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
                        <p class="stat-label">Goals Achieved</p>
                        <h3 class="stat-number"><?php echo $progress_data['goals_achieved']; ?></h3>
                        <span class="stat-change positive">
                            <i class="fas fa-trophy"></i> Great achievements!
                        </span>
                    </div>
                    <div class="stat-icon icon-success">
                        <i class="fas fa-bullseye"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card animate-in animate-delay-2">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="stat-label">Mood Improvement</p>
                        <h3 class="stat-number">+<?php echo $progress_data['mood_improvement']; ?>%</h3>
                        <span class="stat-change positive">
                            <i class="fas fa-arrow-up"></i> Significant progress
                        </span>
                    </div>
                    <div class="stat-icon icon-warning">
                        <i class="fas fa-smile"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card animate-in animate-delay-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="stat-label">Current Streak</p>
                        <h3 class="stat-number"><?php echo $progress_data['streak_days']; ?></h3>
                        <span class="stat-change positive">
                            <i class="fas fa-fire"></i> Days consistent
                        </span>
                    </div>
                    <div class="stat-icon icon-info">
                        <i class="fas fa-fire"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Progress Charts -->
    <div class="row mb-4">
        <!-- Weekly Progress Trends -->
        <div class="col-lg-8">
            <div class="stat-card animate-in">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-area text-primary me-2"></i>
                        Weekly Progress Trends
                    </h5>
                    <div class="d-flex gap-2">
                        <select class="form-select form-select-sm" style="width: auto;">
                            <option>Last 8 Weeks</option>
                            <option>Last 12 Weeks</option>
                            <option>Last 6 Months</option>
                        </select>
                    </div>
                </div>
                <div class="chart-container" style="height: 350px;">
                    <canvas id="progressChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Goals Progress -->
        <div class="col-lg-4">
            <div class="stat-card animate-in animate-delay-1">
                <h5 class="mb-4">
                    <i class="fas fa-bullseye text-success me-2"></i>
                    Goals Progress
                </h5>
                <?php foreach ($goals_progress as $goal): ?>
                    <div class="goal-item mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-semibold small"><?php echo $goal['goal']; ?></span>
                            <span class="badge bg-<?php echo $goal['status'] === 'completed' ? 'success' : ($goal['status'] === 'on_track' ? 'primary' : 'warning'); ?>">
                                <?php echo $goal['progress']; ?>%
                            </span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-<?php echo $goal['status'] === 'completed' ? 'success' : ($goal['status'] === 'on_track' ? 'primary' : 'warning'); ?>"
                                 style="width: <?php echo $goal['progress']; ?>%"></div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="d-grid mt-3">
                    <button class="btn btn-outline-primary btn-sm" onclick="manageGoals()">
                        <i class="fas fa-cog me-2"></i>Manage Goals
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Achievements and Session Outcomes -->
    <div class="row">
        <!-- Recent Achievements -->
        <div class="col-lg-6">
            <div class="stat-card animate-in">
                <h5 class="mb-4">
                    <i class="fas fa-trophy text-warning me-2"></i>
                    Recent Achievements
                </h5>
                <?php foreach ($achievements as $achievement): ?>
                    <div class="achievement-item">
                        <div class="achievement-icon bg-<?php echo $achievement['color']; ?>">
                            <i class="fas <?php echo $achievement['icon']; ?>"></i>
                        </div>
                        <div class="achievement-content flex-grow-1">
                            <h6><?php echo $achievement['title']; ?></h6>
                            <p><?php echo $achievement['description']; ?></p>
                        </div>
                        <div class="achievement-date">
                            <?php echo date('M j', strtotime($achievement['date'])); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Session Outcomes -->
        <div class="col-lg-6">
            <div class="stat-card animate-in animate-delay-1">
                <h5 class="mb-4">
                    <i class="fas fa-chart-bar text-info me-2"></i>
                    Recent Session Outcomes
                </h5>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Mood Change</th>
                            <th>Progress</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($session_outcomes as $outcome): ?>
                            <tr>
                                <td><?php echo date('M j', strtotime($outcome['date'])); ?></td>
                                <td><span class="badge bg-light text-dark"><?php echo $outcome['type']; ?></span></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="small me-2"><?php echo $outcome['mood_before']; ?></span>
                                        <i class="fas fa-arrow-right text-muted me-2"></i>
                                        <span class="small fw-bold text-success"><?php echo $outcome['mood_after']; ?></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <i class="fas fa-star <?php echo $i <= ($outcome['progress_rating']/2) ? 'text-warning' : 'text-muted'; ?> me-1" style="font-size: 0.8rem;"></i>
                                        <?php endfor; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        initializeProgressChart();
    });

    function initializeProgressChart() {
        const ctx = document.getElementById('progressChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode(array_column($weekly_progress, 'week')); ?>,
                datasets: [
                    {
                        label: 'Mood',
                        data: <?php echo json_encode(array_column($weekly_progress, 'mood')); ?>,
                        borderColor: 'var(--luna-primary)',
                        backgroundColor: 'rgba(6, 95, 70, 0.1)',
                        tension: 0.4,
                        fill: false
                    },
                    {
                        label: 'Sleep Quality',
                        data: <?php echo json_encode(array_column($weekly_progress, 'sleep')); ?>,
                        borderColor: 'var(--luna-secondary)',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        tension: 0.4,
                        fill: false
                    },
                    {
                        label: 'Energy Level',
                        data: <?php echo json_encode(array_column($weekly_progress, 'energy')); ?>,
                        borderColor: 'var(--luna-warning)',
                        backgroundColor: 'rgba(245, 158, 11, 0.1)',
                        tension: 0.4,
                        fill: false
                    },
                    {
                        label: 'Anxiety (Inverted)',
                        data: <?php echo json_encode(array_map(function($val) { return 10 - $val; }, array_column($weekly_progress, 'anxiety'))); ?>,
                        borderColor: 'var(--luna-accent)',
                        backgroundColor: 'rgba(139, 92, 246, 0.1)',
                        tension: 0.4,
                        fill: false
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 10,
                        grid: {
                            color: 'rgba(0,0,0,0.1)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }

    function viewDetailedProgress() {
        window.showToast('Loading detailed progress view...', 'info');
    }

    function shareProgress() {
        window.showToast('Sharing progress with therapist...', 'info');
    }

    function exportProgress() {
        window.showToast('Exporting progress report...', 'info');
    }

    function manageGoals() {
        window.location.href = 'goals.php';
    }
</script>

<style>
    .progress-circle {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: conic-gradient(var(--luna-primary) <?php echo $progress_data['overall_progress']; ?>%, #e5e7eb 0%);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    }

    .progress-circle-inner {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        background: white;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .goal-item {
        padding: 1rem;
        border-radius: 8px;
        background: var(--luna-light);
        transition: all 0.3s ease;
    }

    .goal-item:hover {
        background: white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .achievement-item {
        display: flex;
        align-items: center;
        padding: 1rem;
        border-radius: 8px;
        background: var(--luna-light);
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .achievement-item:hover {
        background: white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .achievement-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        margin-right: 1rem;
    }

    .achievement-content {
        flex: 1;
    }

    .achievement-content h6 {
        margin-bottom: 0.25rem;
        font-weight: 600;
    }

    .achievement-content p {
        margin-bottom: 0;
        font-size: 0.875rem;
        color: var(--luna-text-muted);
    }

    .achievement-date {
        font-size: 0.75rem;
        color: var(--luna-text-muted);
        text-align: center;
    }
</style>

<?php include 'templates/footer.php'; ?>
