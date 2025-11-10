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

// Sample mood data
$mood_stats = [
    'current_mood' => 7.2,
    'weekly_average' => 6.8,
    'monthly_average' => 6.5,
    'mood_trend' => 'improving',
    'streak_days' => 12,
    'total_entries' => 89,
    'best_day' => date('Y-m-d', strtotime('-3 days')),
    'best_mood' => 9.1
];

// Daily mood data for the last 30 days
$daily_moods = [];
for ($i = 29; $i >= 0; $i--) {
    $date = date('Y-m-d', strtotime("-$i days"));
    $daily_moods[] = [
        'date' => $date,
        'mood' => rand(40, 95) / 10, // Random mood between 4.0 and 9.5
        'anxiety' => rand(20, 80) / 10,
        'energy' => rand(30, 90) / 10,
        'sleep_quality' => rand(40, 95) / 10,
        'notes' => $i % 5 === 0 ? 'Had a therapy session today' : null
    ];
}

// Mood patterns
$mood_patterns = [
    'best_time' => 'Morning (8-10 AM)',
    'challenging_time' => 'Evening (6-8 PM)',
    'best_day' => 'Wednesday',
    'challenging_day' => 'Monday',
    'weather_impact' => 'Sunny days: +15% mood',
    'sleep_correlation' => '8+ hours sleep: +22% mood'
];

// Mood triggers (positive and negative)
$mood_triggers = [
    'positive' => [
        'Exercise/Physical Activity',
        'Time with Friends',
        'Therapy Sessions',
        'Meditation/Mindfulness',
        'Creative Activities',
        'Good Sleep'
    ],
    'negative' => [
        'Work Stress',
        'Social Media',
        'Poor Sleep',
        'Conflict/Arguments',
        'Weather Changes',
        'Isolation'
    ]
];

// Recent mood entries
$recent_entries = array_slice($daily_moods, -7);
$recent_entries = array_reverse($recent_entries);
?>

<!-- Mood Tracker Content -->
<div class="container-fluid p-4">
    <!-- Mood Tracker Header -->
    <div class="welcome-card animate-in">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h2 class="welcome-title">
                    <i class="fas fa-smile me-3"></i>
                    Mood Tracker
                </h2>
                <p class="welcome-subtitle">
                    Monitor your emotional well-being, identify patterns, and track your mental health journey.
                    Regular mood tracking helps you and your therapist understand what affects your mental state.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <button class="btn btn-luna-primary" onclick="logMood()">
                        <i class="fas fa-plus me-2"></i>Log Today's Mood
                    </button>
                    <button class="btn btn-luna-outline" onclick="viewPatterns()">
                        <i class="fas fa-chart-line me-2"></i>View Patterns
                    </button>
                    <button class="btn btn-luna-outline" onclick="exportMoodData()">
                        <i class="fas fa-download me-2"></i>Export Data
                    </button>
                </div>
            </div>
            <div class="col-lg-4 text-center">
                <div class="mood-display">
                    <div class="mood-emoji">
                        <?php
                        $current = $mood_stats['current_mood'];
                        if ($current >= 8) echo '😊';
                        elseif ($current >= 6) echo '🙂';
                        elseif ($current >= 4) echo '😐';
                        else echo '😔';
                        ?>
                    </div>
                    <div class="h2 fw-bold text-primary"><?php echo $mood_stats['current_mood']; ?>/10</div>
                    <div class="small text-muted">Current Mood</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mood Stats -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card animate-in">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="stat-label">Weekly Average</p>
                        <h3 class="stat-number"><?php echo $mood_stats['weekly_average']; ?></h3>
                        <span class="stat-change <?php echo $mood_stats['mood_trend'] === 'improving' ? 'positive' : 'neutral'; ?>">
                            <i class="fas fa-arrow-<?php echo $mood_stats['mood_trend'] === 'improving' ? 'up' : 'right'; ?>"></i>
                            <?php echo ucfirst($mood_stats['mood_trend']); ?>
                        </span>
                    </div>
                    <div class="stat-icon icon-primary">
                        <i class="fas fa-chart-line"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card animate-in animate-delay-1">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="stat-label">Tracking Streak</p>
                        <h3 class="stat-number"><?php echo $mood_stats['streak_days']; ?></h3>
                        <span class="stat-change positive">
                            <i class="fas fa-fire"></i> Days consistent
                        </span>
                    </div>
                    <div class="stat-icon icon-warning">
                        <i class="fas fa-fire"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card animate-in animate-delay-2">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="stat-label">Total Entries</p>
                        <h3 class="stat-number"><?php echo $mood_stats['total_entries']; ?></h3>
                        <span class="stat-change positive">
                            <i class="fas fa-calendar-check"></i> Great tracking!
                        </span>
                    </div>
                    <div class="stat-icon icon-success">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card animate-in animate-delay-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="stat-label">Best Mood</p>
                        <h3 class="stat-number"><?php echo $mood_stats['best_mood']; ?></h3>
                        <span class="stat-change positive">
                            <i class="fas fa-star"></i> <?php echo date('M j', strtotime($mood_stats['best_day'])); ?>
                        </span>
                    </div>
                    <div class="stat-icon icon-info">
                        <i class="fas fa-star"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mood Chart and Quick Log -->
    <div class="row mb-4">
        <!-- Mood Trends Chart -->
        <div class="col-lg-8">
            <div class="stat-card animate-in">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-area text-primary me-2"></i>
                        30-Day Mood Trends
                    </h5>
                    <div class="d-flex gap-2">
                        <select class="form-select form-select-sm" style="width: auto;">
                            <option>Last 30 Days</option>
                            <option>Last 7 Days</option>
                            <option>Last 90 Days</option>
                        </select>
                    </div>
                </div>
                <div class="chart-container" style="height: 350px;">
                    <canvas id="moodChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Quick Mood Log -->
        <div class="col-lg-4">
            <div class="stat-card animate-in animate-delay-1">
                <h5 class="mb-4">
                    <i class="fas fa-plus text-success me-2"></i>
                    Quick Mood Log
                </h5>
                <div class="mood-selector mb-4">
                    <div class="text-center mb-3">
                        <div class="h4 mb-2">How are you feeling today?</div>
                        <div class="mood-scale">
                            <?php for ($i = 1; $i <= 10; $i++): ?>
                                <button class="mood-button" data-mood="<?php echo $i; ?>" onclick="selectMood(<?php echo $i; ?>)">
                                    <?php echo $i; ?>
                                </button>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label small">Additional Notes (Optional)</label>
                    <textarea class="form-control" rows="3" placeholder="What's affecting your mood today?"></textarea>
                </div>

                <div class="d-grid">
                    <button class="btn btn-luna-primary" onclick="saveMoodEntry()">
                        <i class="fas fa-save me-2"></i>Save Entry
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mood Patterns and Triggers -->
    <div class="row mb-4">
        <!-- Mood Patterns -->
        <div class="col-lg-6">
            <div class="stat-card animate-in">
                <h5 class="mb-4">
                    <i class="fas fa-brain text-info me-2"></i>
                    Mood Patterns & Insights
                </h5>
                <div class="pattern-grid">
                    <div class="pattern-item">
                        <div class="pattern-icon">
                            <i class="fas fa-clock text-primary"></i>
                        </div>
                        <div>
                            <div class="fw-semibold">Best Time of Day</div>
                            <div class="small text-muted"><?php echo $mood_patterns['best_time']; ?></div>
                        </div>
                    </div>
                    <div class="pattern-item">
                        <div class="pattern-icon">
                            <i class="fas fa-calendar text-success"></i>
                        </div>
                        <div>
                            <div class="fw-semibold">Best Day of Week</div>
                            <div class="small text-muted"><?php echo $mood_patterns['best_day']; ?></div>
                        </div>
                    </div>
                    <div class="pattern-item">
                        <div class="pattern-icon">
                            <i class="fas fa-sun text-warning"></i>
                        </div>
                        <div>
                            <div class="fw-semibold">Weather Impact</div>
                            <div class="small text-muted"><?php echo $mood_patterns['weather_impact']; ?></div>
                        </div>
                    </div>
                    <div class="pattern-item">
                        <div class="pattern-icon">
                            <i class="fas fa-bed text-info"></i>
                        </div>
                        <div>
                            <div class="fw-semibold">Sleep Correlation</div>
                            <div class="small text-muted"><?php echo $mood_patterns['sleep_correlation']; ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mood Triggers -->
        <div class="col-lg-6">
            <div class="stat-card animate-in animate-delay-1">
                <h5 class="mb-4">
                    <i class="fas fa-lightbulb text-warning me-2"></i>
                    Mood Triggers
                </h5>
                <div class="row">
                    <div class="col-6">
                        <h6 class="text-success mb-3">
                            <i class="fas fa-plus-circle me-1"></i>
                            Positive Triggers
                        </h6>
                        <?php foreach (array_slice($mood_triggers['positive'], 0, 4) as $trigger): ?>
                            <div class="trigger-item positive">
                                <i class="fas fa-check-circle me-2"></i>
                                <?php echo $trigger; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="col-6">
                        <h6 class="text-danger mb-3">
                            <i class="fas fa-minus-circle me-1"></i>
                            Challenging Triggers
                        </h6>
                        <?php foreach (array_slice($mood_triggers['negative'], 0, 4) as $trigger): ?>
                            <div class="trigger-item negative">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <?php echo $trigger; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Entries -->
    <div class="stat-card animate-in">
        <h5 class="mb-4">
            <i class="fas fa-history text-secondary me-2"></i>
            Recent Mood Entries
        </h5>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Mood</th>
                    <th>Anxiety</th>
                    <th>Energy</th>
                    <th>Sleep</th>
                    <th>Notes</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($recent_entries as $entry): ?>
                    <tr>
                        <td><?php echo date('M j, Y', strtotime($entry['date'])); ?></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="mood-indicator mood-<?php echo round($entry['mood']); ?>"></div>
                                <span class="ms-2"><?php echo $entry['mood']; ?>/10</span>
                            </div>
                        </td>
                        <td><?php echo $entry['anxiety']; ?>/10</td>
                        <td><?php echo $entry['energy']; ?>/10</td>
                        <td><?php echo $entry['sleep_quality']; ?>/10</td>
                        <td>
                            <?php if ($entry['notes']): ?>
                                <span class="badge bg-light text-dark"><?php echo substr($entry['notes'], 0, 20) . '...'; ?></span>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-outline-secondary" onclick="editEntry('<?php echo $entry['date']; ?>')">
                                <i class="fas fa-edit"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    let selectedMood = null;

    document.addEventListener('DOMContentLoaded', function() {
        initializeMoodChart();
    });

    function initializeMoodChart() {
        const ctx = document.getElementById('moodChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode(array_map(function($d) { return date('M j', strtotime($d['date'])); }, $daily_moods)); ?>,
                datasets: [
                    {
                        label: 'Mood',
                        data: <?php echo json_encode(array_column($daily_moods, 'mood')); ?>,
                        borderColor: 'var(--luna-primary)',
                        backgroundColor: 'rgba(6, 95, 70, 0.1)',
                        tension: 0.4,
                        fill: true,
                        borderWidth: 3
                    },
                    {
                        label: 'Energy',
                        data: <?php echo json_encode(array_column($daily_moods, 'energy')); ?>,
                        borderColor: 'var(--luna-warning)',
                        backgroundColor: 'rgba(245, 158, 11, 0.1)',
                        tension: 0.4,
                        fill: false,
                        borderWidth: 2
                    },
                    {
                        label: 'Sleep Quality',
                        data: <?php echo json_encode(array_column($daily_moods, 'sleep_quality')); ?>,
                        borderColor: 'var(--luna-secondary)',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        tension: 0.4,
                        fill: false,
                        borderWidth: 2
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

    function selectMood(mood) {
        selectedMood = mood;
        document.querySelectorAll('.mood-button').forEach(btn => {
            btn.classList.remove('selected');
        });
        document.querySelector(`[data-mood="${mood}"]`).classList.add('selected');
    }

    function logMood() {
        window.showToast('Opening mood logging form...', 'info');
    }

    function saveMoodEntry() {
        if (!selectedMood) {
            window.showToast('Please select a mood rating first', 'error');
            return;
        }

        window.showToast('Saving mood entry...', 'info');
        setTimeout(() => {
            window.showToast('Mood entry saved successfully!', 'success');
            selectedMood = null;
            document.querySelectorAll('.mood-button').forEach(btn => {
                btn.classList.remove('selected');
            });
        }, 1000);
    }

    function viewPatterns() {
        window.showToast('Loading detailed mood patterns...', 'info');
    }

    function exportMoodData() {
        window.showToast('Exporting mood data...', 'info');
    }

    function editEntry(date) {
        window.showToast(`Editing entry for ${date}...`, 'info');
    }
</script>

<style>
    .mood-display {
        text-align: center;
    }

    .mood-emoji {
        font-size: 4rem;
        margin-bottom: 1rem;
    }

    .mood-scale {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .mood-button {
        width: 40px;
        height: 40px;
        border: 2px solid #e5e7eb;
        border-radius: 50%;
        background: white;
        color: #6b7280;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .mood-button:hover {
        border-color: var(--luna-primary);
        color: var(--luna-primary);
    }

    .mood-button.selected {
        background: var(--luna-primary);
        border-color: var(--luna-primary);
        color: white;
    }

    .pattern-grid {
        display: grid;
        gap: 1rem;
    }

    .pattern-item {
        display: flex;
        align-items: center;
        padding: 1rem;
        background: var(--luna-light);
        border-radius: 8px;
    }

    .pattern-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        font-size: 1.2rem;
    }

    .trigger-item {
        padding: 0.5rem;
        margin-bottom: 0.5rem;
        border-radius: 6px;
        font-size: 0.875rem;
        display: flex;
        align-items: center;
    }

    .trigger-item.positive {
        background: rgba(34, 197, 94, 0.1);
        color: #059669;
    }

    .trigger-item.negative {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
    }

    .mood-indicator {
        width: 20px;
        height: 20px;
        border-radius: 50%;
    }

    .mood-1, .mood-2, .mood-3 { background: #ef4444; }
    .mood-4, .mood-5 { background: #f59e0b; }
    .mood-6, .mood-7 { background: #eab308; }
    .mood-8, .mood-9, .mood-10 { background: #22c55e; }
</style>

<?php include 'templates/footer.php'; ?>
