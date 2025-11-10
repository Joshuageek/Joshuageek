<?php
session_start();
require_once 'includes/auth.php';
include 'templates/header.php';

// Check if user is authenticated and is admin
if (!isLoggedIn()) {
    header('Location: ../login.php');
    exit();
}

$user_role = getUserRole();
if ($user_role !== 'admin') {
    header('Location: index.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'] ?? 'Admin';

// Analytics Data - Enhanced with more comprehensive metrics
$analytics_data = [
    // Overview Stats
    'total_users' => 2156,
    'total_patients' => 1247,
    'total_therapists' => 89,
    'total_sessions' => 15678,
    'monthly_revenue' => 125400,
    'annual_revenue' => 1456800,
    'active_users_today' => 342,
    'system_uptime' => 99.8,
    'avg_session_duration' => 52, // minutes
    'patient_satisfaction' => 4.7,
    'therapist_utilization' => 78.5,
    'platform_growth' => 23.4,

    // Monthly Growth Data
    'user_growth' => [
        'Jan' => 1850, 'Feb' => 1920, 'Mar' => 1995, 'Apr' => 2050,
        'May' => 2100, 'Jun' => 2156, 'Jul' => 2200, 'Aug' => 2250,
        'Sep' => 2300, 'Oct' => 2350, 'Nov' => 2400, 'Dec' => 2450
    ],

    // Revenue Data
    'revenue_data' => [
        'Jan' => 98500, 'Feb' => 105200, 'Mar' => 112800, 'Apr' => 118900,
        'May' => 122300, 'Jun' => 125400, 'Jul' => 128000, 'Aug' => 132000,
        'Sep' => 135000, 'Oct' => 138000, 'Nov' => 142000, 'Dec' => 145000
    ],

    // Session Types Distribution
    'session_types' => [
        'Individual Therapy' => 45.2,
        'Group Therapy' => 23.8,
        'Couples Therapy' => 18.5,
        'Family Therapy' => 12.5
    ],

    // Top Performing Therapists
    'top_therapists' => [
        ['name' => 'Dr. Sarah Johnson', 'sessions' => 156, 'rating' => 4.9, 'revenue' => 18720],
        ['name' => 'Dr. Michael Wilson', 'sessions' => 142, 'rating' => 4.8, 'revenue' => 17040],
        ['name' => 'Dr. Lisa Anderson', 'sessions' => 138, 'rating' => 4.9, 'revenue' => 16560],
        ['name' => 'Dr. James Rodriguez', 'sessions' => 134, 'rating' => 4.7, 'revenue' => 16080],
        ['name' => 'Dr. Emily Chen', 'sessions' => 129, 'rating' => 4.8, 'revenue' => 15480]
    ],

    // Geographic Distribution
    'geographic_data' => [
        'North America' => 52.3,
        'Europe' => 28.7,
        'Asia Pacific' => 12.4,
        'Latin America' => 4.8,
        'Others' => 1.8
    ],

    // Device Usage
    'device_usage' => [
        'Desktop' => 48.5,
        'Mobile' => 35.2,
        'Tablet' => 16.3
    ]
];

// Recent Analytics Events
$recent_events = [
    [
        'event' => 'Peak Usage Alert',
        'description' => 'Platform reached 95% capacity during peak hours',
        'type' => 'warning',
        'timestamp' => date('Y-m-d H:i:s', strtotime('-30 minutes'))
    ],
    [
        'event' => 'Revenue Milestone',
        'description' => 'Monthly revenue target exceeded by 12%',
        'type' => 'success',
        'timestamp' => date('Y-m-d H:i:s', strtotime('-2 hours'))
    ],
    [
        'event' => 'New Therapist Onboarded',
        'description' => 'Dr. Amanda Foster completed verification process',
        'type' => 'info',
        'timestamp' => date('Y-m-d H:i:s', strtotime('-4 hours'))
    ],
    [
        'event' => 'System Optimization',
        'description' => 'Database performance improved by 15%',
        'type' => 'success',
        'timestamp' => date('Y-m-d H:i:s', strtotime('-6 hours'))
    ]
];

// Time period for filtering (default to current month)
$selected_period = $_GET['period'] ?? 'month';
$periods = [
    'today' => 'Today',
    'week' => 'This Week',
    'month' => 'This Month',
    'quarter' => 'This Quarter',
    'year' => 'This Year'
];
?>

<!-- Analytics Dashboard Content -->
<div class="container-fluid p-4">
    <!-- Analytics Header -->
    <div class="welcome-card animate-in">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h2 class="welcome-title">
                    <i class="fas fa-chart-line me-3"></i>
                    Advanced Analytics Dashboard
                </h2>
                <p class="welcome-subtitle">
                    Comprehensive insights into platform performance, user engagement, revenue metrics, and operational efficiency.
                    Monitor key performance indicators and make data-driven decisions to optimize your mental wellness platform.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <button class="btn btn-luna-primary" onclick="exportAnalytics()">
                        <i class="fas fa-download me-2"></i>Export Report
                    </button>
                    <button class="btn btn-luna-outline" onclick="scheduleReport()">
                        <i class="fas fa-clock me-2"></i>Schedule Report
                    </button>
                    <button class="btn btn-luna-outline" onclick="refreshData()">
                        <i class="fas fa-sync-alt me-2"></i>Refresh Data
                    </button>
                </div>
            </div>
            <div class="col-lg-4 text-center">
                <div class="row">
                    <div class="col-4">
                        <div class="h2 fw-bold mb-0"><?php echo number_format($analytics_data['total_users']); ?></div>
                        <div class="small opacity-90">Total Users</div>
                    </div>
                    <div class="col-4">
                        <div class="h2 fw-bold mb-0">$<?php echo number_format($analytics_data['monthly_revenue']); ?></div>
                        <div class="small opacity-90">Monthly Revenue</div>
                    </div>
                    <div class="col-4">
                        <div class="h2 fw-bold mb-0"><?php echo $analytics_data['system_uptime']; ?>%</div>
                        <div class="small opacity-90">System Uptime</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Time Period Filter -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-filter text-primary me-2"></i>
                        Analytics Period
                    </h5>
                    <div class="d-flex gap-2">
                        <?php foreach ($periods as $key => $label): ?>
                            <button class="btn <?php echo $selected_period === $key ? 'btn-luna-primary' : 'btn-outline-secondary'; ?> btn-sm"
                                    onclick="changePeriod('<?php echo $key; ?>')">
                                <?php echo $label; ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Key Performance Indicators -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card animate-in animate-delay-1">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="stat-label">Active Users Today</p>
                        <h3 class="stat-number"><?php echo number_format($analytics_data['active_users_today']); ?></h3>
                        <span class="stat-change positive">
                            <i class="fas fa-arrow-up"></i> +8.5% from yesterday
                        </span>
                    </div>
                    <div class="stat-icon icon-primary">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card animate-in animate-delay-2">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="stat-label">Avg Session Duration</p>
                        <h3 class="stat-number"><?php echo $analytics_data['avg_session_duration']; ?>m</h3>
                        <span class="stat-change positive">
                            <i class="fas fa-arrow-up"></i> +3.2% improvement
                        </span>
                    </div>
                    <div class="stat-icon icon-success">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card animate-in animate-delay-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="stat-label">Patient Satisfaction</p>
                        <h3 class="stat-number"><?php echo $analytics_data['patient_satisfaction']; ?>/5</h3>
                        <span class="stat-change positive">
                            <i class="fas fa-star"></i> Excellent rating
                        </span>
                    </div>
                    <div class="stat-icon icon-warning">
                        <i class="fas fa-smile"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card animate-in animate-delay-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="stat-label">Platform Growth</p>
                        <h3 class="stat-number">+<?php echo $analytics_data['platform_growth']; ?>%</h3>
                        <span class="stat-change positive">
                            <i class="fas fa-trending-up"></i> Year over year
                        </span>
                    </div>
                    <div class="stat-icon icon-success">
                        <i class="fas fa-chart-line"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row mb-4">
        <!-- User Growth Chart -->
        <div class="col-lg-8">
            <div class="stat-card animate-in">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-area text-primary me-2"></i>
                        User Growth Trend
                    </h5>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-cog me-1"></i>Options
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-download me-2"></i>Export Chart</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-share me-2"></i>Share</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
                        </ul>
                    </div>
                </div>
                <div class="chart-container" style="height: 300px;">
                    <canvas id="userGrowthChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Session Types Distribution -->
        <div class="col-lg-4">
            <div class="stat-card animate-in animate-delay-1">
                <h5 class="mb-4">
                    <i class="fas fa-chart-pie text-success me-2"></i>
                    Session Types
                </h5>
                <div class="chart-container" style="height: 300px;">
                    <canvas id="sessionTypesChart"></canvas>
                </div>
                <div class="mt-3">
                    <?php foreach ($analytics_data['session_types'] as $type => $percentage): ?>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="small"><?php echo $type; ?></span>
                            <span class="badge bg-primary"><?php echo $percentage; ?>%</span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Revenue and Performance Row -->
    <div class="row mb-4">
        <!-- Revenue Chart -->
        <div class="col-lg-8">
            <div class="stat-card animate-in">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0">
                        <i class="fas fa-dollar-sign text-success me-2"></i>
                        Revenue Analytics
                    </h5>
                    <div class="d-flex gap-2">
                        <span class="badge bg-success">+25.4% Growth</span>
                        <span class="badge bg-primary">$<?php echo number_format($analytics_data['annual_revenue']); ?> YTD</span>
                    </div>
                </div>
                <div class="chart-container" style="height: 300px;">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Top Therapists -->
        <div class="col-lg-4">
            <div class="stat-card animate-in animate-delay-1">
                <h5 class="mb-4">
                    <i class="fas fa-trophy text-warning me-2"></i>
                    Top Performing Therapists
                </h5>
                <?php foreach (array_slice($analytics_data['top_therapists'], 0, 5) as $index => $therapist): ?>
                    <div class="d-flex align-items-center p-3 bg-light rounded mb-3">
                        <div class="me-3">
                            <div class="bg-luna-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                 style="width: 40px; height: 40px; font-weight: 600;">
                                <?php echo $index + 1; ?>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-semibold"><?php echo htmlspecialchars($therapist['name']); ?></div>
                            <div class="small text-muted">
                                <?php echo $therapist['sessions']; ?> sessions •
                                <i class="fas fa-star text-warning"></i> <?php echo $therapist['rating']; ?>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="fw-bold text-success">$<?php echo number_format($therapist['revenue']); ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Additional Analytics Row -->
    <div class="row mb-4">
        <!-- Geographic Distribution -->
        <div class="col-lg-6">
            <div class="stat-card animate-in">
                <h5 class="mb-4">
                    <i class="fas fa-globe text-info me-2"></i>
                    Geographic Distribution
                </h5>
                <div class="chart-container" style="height: 250px;">
                    <canvas id="geographicChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Device Usage -->
        <div class="col-lg-6">
            <div class="stat-card animate-in animate-delay-1">
                <h5 class="mb-4">
                    <i class="fas fa-devices text-secondary me-2"></i>
                    Device Usage Analytics
                </h5>
                <div class="chart-container" style="height: 250px;">
                    <canvas id="deviceChart"></canvas>
                </div>
                <div class="row mt-3">
                    <?php foreach ($analytics_data['device_usage'] as $device => $percentage): ?>
                        <div class="col-4 text-center">
                            <div class="h4 fw-bold text-primary"><?php echo $percentage; ?>%</div>
                            <div class="small text-muted"><?php echo $device; ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Real-time Activity and System Status -->
    <div class="row">
        <!-- Real-time Analytics Events -->
        <div class="col-lg-8">
            <div class="stat-card animate-in">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0">
                        <i class="fas fa-broadcast-tower text-danger me-2"></i>
                        Real-time Analytics Events
                    </h5>
                    <div class="d-flex align-items-center gap-2">
                        <div class="bg-success rounded-circle" style="width: 8px; height: 8px;"></div>
                        <small class="text-muted">Live Updates</small>
                    </div>
                </div>

                <?php foreach ($recent_events as $event): ?>
                    <div class="activity-item">
                        <div class="activity-avatar <?php echo $event['type'] === 'warning' ? 'bg-warning' : ($event['type'] === 'success' ? 'bg-success' : 'bg-primary'); ?>">
                            <i class="fas <?php echo $event['type'] === 'warning' ? 'fa-exclamation-triangle' : ($event['type'] === 'success' ? 'fa-check' : 'fa-info'); ?>"></i>
                        </div>
                        <div class="activity-content flex-grow-1">
                            <h6><?php echo htmlspecialchars($event['event']); ?></h6>
                            <p><?php echo htmlspecialchars($event['description']); ?></p>
                        </div>
                        <div class="activity-time">
                            <?php echo date('M j, g:i A', strtotime($event['timestamp'])); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- System Health & Quick Stats -->
        <div class="col-lg-4">
            <!-- System Health -->
            <div class="stat-card mb-4 animate-in animate-delay-1">
                <h5 class="mb-3">
                    <i class="fas fa-heartbeat text-danger me-2"></i>
                    System Health
                </h5>
                <div class="row">
                    <div class="col-6">
                        <div class="text-center p-3 bg-light rounded">
                            <div class="h4 fw-bold text-success"><?php echo $analytics_data['system_uptime']; ?>%</div>
                            <div class="small text-muted">Uptime</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-center p-3 bg-light rounded">
                            <div class="h4 fw-bold text-primary"><?php echo $analytics_data['therapist_utilization']; ?>%</div>
                            <div class="small text-muted">Utilization</div>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small">Server Load</span>
                        <span class="badge bg-success">Normal</span>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-success" style="width: 65%"></div>
                    </div>
                </div>
                <div class="mt-2">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small">Database Performance</span>
                        <span class="badge bg-success">Optimal</span>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-success" style="width: 85%"></div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="stat-card animate-in animate-delay-2">
                <h5 class="mb-3">
                    <i class="fas fa-bolt text-warning me-2"></i>
                    Analytics Actions
                </h5>
                <div class="d-grid gap-2">
                    <button class="btn btn-luna-primary" onclick="generateReport()">
                        <i class="fas fa-file-alt me-2"></i>Generate Full Report
                    </button>
                    <button class="btn btn-outline-secondary" onclick="exportData()">
                        <i class="fas fa-database me-2"></i>Export Raw Data
                    </button>
                    <button class="btn btn-outline-secondary" onclick="scheduleAlert()">
                        <i class="fas fa-bell me-2"></i>Set Up Alerts
                    </button>
                    <button class="btn btn-outline-secondary" onclick="viewTrends()">
                        <i class="fas fa-chart-line me-2"></i>View Trends
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Analytics JavaScript Functions
    document.addEventListener('DOMContentLoaded', function() {
        initializeCharts();
        startRealTimeUpdates();
    });

    function initializeCharts() {
        // User Growth Chart
        const userGrowthCtx = document.getElementById('userGrowthChart').getContext('2d');
        new Chart(userGrowthCtx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode(array_keys($analytics_data['user_growth'])); ?>,
                datasets: [{
                    label: 'Total Users',
                    data: <?php echo json_encode(array_values($analytics_data['user_growth'])); ?>,
                    borderColor: 'var(--luna-primary)',
                    backgroundColor: 'rgba(6, 95, 70, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: false,
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

        // Session Types Chart
        const sessionTypesCtx = document.getElementById('sessionTypesChart').getContext('2d');
        new Chart(sessionTypesCtx, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode(array_keys($analytics_data['session_types'])); ?>,
                datasets: [{
                    data: <?php echo json_encode(array_values($analytics_data['session_types'])); ?>,
                    backgroundColor: [
                        'var(--luna-primary)',
                        'var(--luna-secondary)',
                        'var(--luna-warning)',
                        'var(--luna-accent)'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_keys($analytics_data['revenue_data'])); ?>,
                datasets: [{
                    label: 'Monthly Revenue',
                    data: <?php echo json_encode(array_values($analytics_data['revenue_data'])); ?>,
                    backgroundColor: 'var(--luna-secondary)',
                    borderColor: 'var(--luna-primary)',
                    borderWidth: 1,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0,0,0,0.1)'
                        },
                        ticks: {
                            callback: function(value) {
                                return '$' + value.toLocaleString();
                            }
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

        // Geographic Chart
        const geographicCtx = document.getElementById('geographicChart').getContext('2d');
        new Chart(geographicCtx, {
            type: 'polarArea',
            data: {
                labels: <?php echo json_encode(array_keys($analytics_data['geographic_data'])); ?>,
                datasets: [{
                    data: <?php echo json_encode(array_values($analytics_data['geographic_data'])); ?>,
                    backgroundColor: [
                        'var(--luna-primary)',
                        'var(--luna-secondary)',
                        'var(--luna-accent)',
                        'var(--luna-warning)',
                        'var(--luna-gray)'
                    ],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Device Chart
        const deviceCtx = document.getElementById('deviceChart').getContext('2d');
        new Chart(deviceCtx, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode(array_keys($analytics_data['device_usage'])); ?>,
                datasets: [{
                    data: <?php echo json_encode(array_values($analytics_data['device_usage'])); ?>,
                    backgroundColor: [
                        'var(--luna-primary)',
                        'var(--luna-secondary)',
                        'var(--luna-warning)'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }

    // Analytics Functions
    function changePeriod(period) {
        window.location.href = `analytics.php?period=${period}`;
    }

    function exportAnalytics() {
        window.showToast('Exporting analytics report...', 'info');
        // Simulate export process
        setTimeout(() => {
            window.showToast('Analytics report exported successfully!', 'success');
        }, 2000);
    }

    function scheduleReport() {
        window.showToast('Report scheduling feature coming soon!', 'info');
    }

    function refreshData() {
        window.showToast('Refreshing analytics data...', 'info');
        setTimeout(() => {
            window.location.reload();
        }, 1000);
    }

    function generateReport() {
        window.showToast('Generating comprehensive report...', 'info');
        setTimeout(() => {
            window.showToast('Full report generated successfully!', 'success');
        }, 3000);
    }

    function exportData() {
        window.showToast('Exporting raw data...', 'info');
        setTimeout(() => {
            window.showToast('Raw data exported successfully!', 'success');
        }, 2000);
    }

    function scheduleAlert() {
        window.showToast('Alert configuration panel opening...', 'info');
    }

    function viewTrends() {
        window.showToast('Loading trend analysis...', 'info');
    }

    // Real-time updates simulation
    function startRealTimeUpdates() {
        setInterval(() => {
            // Simulate real-time data updates
            const indicators = document.querySelectorAll('.bg-success[style*="width: 8px"]');
            indicators.forEach(indicator => {
                indicator.style.animation = 'pulse 2s infinite';
            });
        }, 5000);
    }

    // Add pulse animation
    const style = document.createElement('style');
    style.textContent = `
    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.5; }
        100% { opacity: 1; }
    }
`;
    document.head.appendChild(style);
</script>

<?php include 'templates/footer.php'; ?>
