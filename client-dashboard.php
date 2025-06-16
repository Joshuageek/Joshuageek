<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Luna Mental Wellness - Client Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #A8C3A4;
            --primary-dark: #8FA98B;
            --primary-light: #D4E4D1;
            --secondary-color: #F5F7FF;
            --text-primary: #2D3436;
            --text-secondary: #636E72;
            --text-muted: #5F6C7B;
            --success-color: #4CAF50;
            --warning-color: #FF9800;
            --danger-color: #F44336;
            --bg-gradient: linear-gradient(135deg, #F5F7FF 0%, #E8F4F8 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-gradient);
            color: var(--text-primary);
            line-height: 1.6;
        }

        /* Sidebar Styles */
        .sidebar {
            background: white;
            min-height: 100vh;
            box-shadow: 2px 0 20px rgba(0,0,0,0.08);
            position: fixed;
            left: 0;
            top: 0;
            width: 280px;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .sidebar-header {
            padding: 2rem 1.5rem;
            border-bottom: 1px solid #E9ECEF;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: var(--text-primary);
        }

        .logo-icon {
            background: var(--primary-color);
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
        }

        .logo-text {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        .nav-menu {
            padding: 1rem 0;
        }

        .nav-item {
            margin: 0.25rem 0;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 1.5rem;
            color: var(--text-secondary);
            text-decoration: none;
            transition: all 0.3s ease;
            border-radius: 0;
            position: relative;
        }

        .nav-link:hover,
        .nav-link.active {
            background: var(--primary-light);
            color: var(--primary-color);
            border-right: 3px solid var(--primary-color);
        }

        .nav-link i {
            width: 20px;
            text-align: center;
        }

        /* Main Content */
        .main-content {
            margin-left: 280px;
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        .topbar {
            background: white;
            padding: 1rem 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .topbar-left h1 {
            font-size: 1.75rem;
            font-weight: 600;
            margin: 0;
            color: var(--text-primary);
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .notification-btn {
            background: var(--secondary-color);
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-secondary);
            position: relative;
            transition: all 0.3s ease;
        }

        .notification-btn:hover {
            background: var(--primary-light);
            color: var(--primary-color);
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: var(--danger-color);
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            padding: 8px 12px;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .user-profile:hover {
            background: var(--secondary-color);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        .user-info h6 {
            margin: 0;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .user-info p {
            margin: 0;
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        /* Dashboard Content */
        .dashboard-content {
            padding: 2rem;
        }

        /* Cards */
        .card {
            background: white;
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.12);
        }

        .stat-card {
            padding: 1.5rem;
            position: relative;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 1rem;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
        }

        .stat-label {
            color: var(--text-muted);
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .stat-change {
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .stat-change.positive {
            color: var(--success-color);
        }

        .stat-change.negative {
            color: var(--danger-color);
        }

        /* Progress Bars */
        .progress {
            height: 8px;
            border-radius: 10px;
            background: #E9ECEF;
        }

        .progress-bar {
            border-radius: 10px;
            transition: width 1s ease;
        }

        /* Session Cards */
        .session-card {
            padding: 1.5rem;
            border-left: 4px solid var(--primary-color);
            margin-bottom: 1rem;
        }

        .session-time {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--text-muted);
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .session-therapist {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .session-type {
            background: var(--primary-light);
            color: var(--primary-color);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            display: inline-block;
        }

        /* Buttons */
        .btn-primary-custom {
            background: var(--primary-color);
            border: none;
            border-radius: 10px;
            padding: 12px 24px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary-custom:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }

        .btn-outline-custom {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            background: transparent;
            border-radius: 10px;
            padding: 10px 24px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-outline-custom:hover {
            background: var(--primary-color);
            color: white;
        }

        /* Quick Actions */
        .quick-action {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 1rem;
            background: white;
            border-radius: 12px;
            text-decoration: none;
            color: var(--text-primary);
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .quick-action:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
            color: var(--text-primary);
        }

        .quick-action-icon {
            width: 50px;
            height: 50px;
            background: var(--primary-light);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            font-size: 20px;
        }

        /* Mood Tracker */
        .mood-selector {
            display: flex;
            gap: 1rem;
            margin: 1rem 0;
        }

        .mood-option {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: 3px solid transparent;
            background: #F8F9FA;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .mood-option:hover,
        .mood-option.active {
            border-color: var(--primary-color);
            background: var(--primary-light);
        }

        /* Chart Container */
        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: 280px;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .topbar {
                padding: 1rem;
            }

            .dashboard-content {
                padding: 1rem;
            }

            .mood-selector {
                flex-wrap: wrap;
                justify-content: center;
            }
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-in {
            animation: fadeInUp 0.6s ease forwards;
        }

        .loading-skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="#" class="logo">
                <div class="logo-icon">
                    <i class="fas fa-moon"></i>
                </div>
                <span class="logo-text">Luna</span>
            </a>
        </div>
        
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="#" class="nav-link active">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Appointments</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-user-md"></i>
                    <span>My Therapist</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-chart-line"></i>
                    <span>Progress</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-heart"></i>
                    <span>Mood Tracker</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-comments"></i>
                    <span>Messages</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-file-medical-alt"></i>
                    <span>Resources</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-credit-card"></i>
                    <span>Billing</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>
            </li>
            <li class="nav-item mt-auto">
                <a href="#" class="nav-link">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Topbar -->
        <div class="topbar">
            <div class="topbar-left">
                <button class="btn d-md-none" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <h1>Welcome back, Sarah</h1>
            </div>
            <div class="topbar-right">
                <button class="notification-btn">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge">3</span>
                </button>
                <div class="user-profile">
                    <div class="user-avatar">S</div>
                    <div class="user-info">
                        <h6>Sarah Johnson</h6>
                        <p>Premium Member</p>
                    </div>
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>
        </div>

        <!-- Dashboard Content -->
        <div class="dashboard-content">
            <!-- Quick Stats -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card stat-card animate-in">
                        <div class="stat-icon" style="background: rgba(168, 195, 164, 0.1); color: #A8C3A4;">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="stat-number">12</div>
                        <div class="stat-label">Total Sessions</div>
                        <div class="stat-change positive">
                            <i class="fas fa-arrow-up"></i>
                            +2 this month
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card stat-card animate-in" style="animation-delay: 0.1s;">
                        <div class="stat-icon" style="background: rgba(76, 175, 80, 0.1); color: #4CAF50;">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="stat-number">85%</div>
                        <div class="stat-label">Progress Score</div>
                        <div class="stat-change positive">
                            <i class="fas fa-arrow-up"></i>
                            +12% this week
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card stat-card animate-in" style="animation-delay: 0.2s;">
                        <div class="stat-icon" style="background: rgba(255, 152, 0, 0.1); color: #FF9800;">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-number">4h 30m</div>
                        <div class="stat-label">Total Time</div>
                        <div class="stat-change positive">
                            <i class="fas fa-arrow-up"></i>
                            +45m this week
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card stat-card animate-in" style="animation-delay: 0.3s;">
                        <div class="stat-icon" style="background: rgba(33, 150, 243, 0.1); color: #2196F3;">
                            <i class="fas fa-smile"></i>
                        </div>
                        <div class="stat-number">7.8</div>
                        <div class="stat-label">Avg. Mood Score</div>
                        <div class="stat-change positive">
                            <i class="fas fa-arrow-up"></i>
                            +0.5 this week
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Dashboard Row -->
            <div class="row">
                <!-- Left Column -->
                <div class="col-lg-8">
                    <!-- Upcoming Sessions -->
                    <div class="card mb-4 animate-in" style="animation-delay: 0.4s;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-calendar-alt me-2" style="color: #A8C3A4;"></i>
                                    Upcoming Sessions
                                </h5>
                                <button class="btn btn-outline-custom btn-sm">View All</button>
                            </div>
                            
                            <div class="session-card">
                                <div class="session-time">
                                    <i class="fas fa-clock"></i>
                                    Today, 2:00 PM - 3:00 PM
                                </div>
                                <div class="session-therapist">Dr. Emily Rodriguez</div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="session-type">Individual Therapy</span>
                                    <button class="btn btn-primary-custom btn-sm">Join Session</button>
                                </div>
                            </div>

                            <div class="session-card">
                                <div class="session-time">
                                    <i class="fas fa-clock"></i>
                                    Tomorrow, 10:30 AM - 11:30 AM
                                </div>
                                <div class="session-therapist">Dr. Michael Chen</div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="session-type">CBT Session</span>
                                    <button class="btn btn-outline-custom btn-sm">Reschedule</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Progress Chart -->
                    <div class="card mb-4 animate-in" style="animation-delay: 0.5s;">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="fas fa-chart-area me-2" style="color: #A8C3A4;"></i>
                                Wellness Progress
                            </h5>
                            <div class="chart-container">
                                <canvas id="progressChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-lg-4">
                    <!-- Today's Mood -->
                    <div class="card mb-4 animate-in" style="animation-delay: 0.6s;">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="fas fa-heart me-2" style="color: #A8C3A4;"></i>
                                How are you feeling today?
                            </h5>
                            <div class="mood-selector">
                                <div class="mood-option" data-mood="1">😢</div>
                                <div class="mood-option" data-mood="2">😕</div>
                                <div class="mood-option active" data-mood="3">😐</div>
                                <div class="mood-option" data-mood="4">🙂</div>
                                <div class="mood-option" data-mood="5">😊</div>
                            </div>
                            <button class="btn btn-primary-custom w-100 mt-3">Save Mood</button>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="card mb-4 animate-in" style="animation-delay: 0.7s;">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="fas fa-bolt me-2" style="color: #A8C3A4;"></i>
                                Quick Actions
                            </h5>
                            <div class="d-grid gap-3">
                                <a href="#" class="quick-action">
                                    <div class="quick-action-icon">
                                        <i class="fas fa-plus"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">Book Session</div>
                                        <small class="text-muted">Schedule your next appointment</small>
                                    </div>
                                </a>
                                <a href="#" class="quick-action">
                                    <div class="quick-action-icon">
                                        <i class="fas fa-message"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">Message Therapist</div>
                                        <small class="text-muted">Send a quick message</small>
                                    </div>
                                </a>
                                <a href="#" class="quick-action">
                                    <div class="quick-action-icon">
                                        <i class="fas fa-book-open"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">Browse Resources</div>
                                        <small class="text-muted">Self-help tools & guides</small>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Current Goals -->
                    <div class="card animate-in" style="animation-delay: 0.8s;">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="fas fa-target me-2" style="color: #A8C3A4;"></i>
                                Current Goals
                            </h5>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="fw-semibold">Daily Meditation</span>
                                    <span class="text-muted">5/7 days</span>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" style="width: 71%; background-color: #A8C3A4;"></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="fw-semibold">Anxiety Management</span>
                                    <span class="text-muted">8/10 sessions</span>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" style="width: 80%; background-color: #4CAF50;"></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="fw-semibold">Sleep Schedule</span>
                                    <span class="text-muted">3/7 days</span>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" style="width: 43%; background-color: #FF9800;"></div>
                                </div>
                            </div>
                            <button class="btn btn-outline-custom w-100 mt-2">View All Goals</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script>
        // Sidebar toggle for mobile
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('show');
        });

        // Mood selector
        document.querySelectorAll('.mood-option').forEach(option => {
            option.addEventListener('click', function() {
                document.querySelectorAll('.mood-option').forEach(opt => opt.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Navigation
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Progress Chart
        // const ctx = document.getElementById('progressChart')?.getContext('2d');
        // if (ctx) {
        //     new Chart(ctx, {
        //         type: 'line',
        //         data: {
        //             labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        //             datasets: [{
        //                 label: 'Mood Score',
        //                 data: [6, 7, 8, 6, 9, 8, 8],
        //                 borderColor: '#A8C3A4',
        //                 backgroundColor: 'rgba(168, 195, 164, 0.1)',
        //                 borderWidth: 3,
        //                 fill: true,
        //                 tension: 0.4,
        //                 pointBackgroundColor: '#A8C3A4',
        //                 pointBorderColor: '#fff',
        //                 pointBorderWidth: 3,
        //                 pointRadius: 6,
        //                 pointHoverRadius: 8
        //             }, {
        //                 label: 'Anxiety Level',
        //                 data: [4, 3, 2, 4, 2, 3, 2],
        //                 borderColor: '#FF9800',
        //                 backgroundColor: 'rgba(255, 152, 0, 0.1)',
        //                 borderWidth: 3,
        //                 fill: true,
        //                 tension: 0.4,
        //                 pointBackgroundColor: '#FF9800',
        //                 pointBorderColor: '#fff',
        //                 pointBorderWidth: 3,
        //                 pointRadius: 6,
        //                 point