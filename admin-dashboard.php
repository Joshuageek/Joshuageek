<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Luna Mental Wellness - Admin Dashboard</title>
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
            --info-color: #2196F3;
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

        .admin-badge {
            background: linear-gradient(45deg, #FF6B6B, #4ECDC4);
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.7rem;
            font-weight: 600;
            margin-left: 8px;
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

        .nav-badge {
            background: var(--danger-color);
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: auto;
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

        .search-box {
            position: relative;
            width: 300px;
        }

        .search-box input {
            width: 100%;
            padding: 10px 40px 10px 16px;
            border: 2px solid #E9ECEF;
            border-radius: 25px;
            background: var(--secondary-color);
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .search-box input:focus {
            outline: none;
            border-color: var(--primary-color);
            background: white;
        }

        .search-box i {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
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
            background: linear-gradient(45deg, #667eea 0%, #764ba2 100%);
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
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
            height: 100px;
            background: linear-gradient(45deg, rgba(255,255,255,0.1), rgba(255,255,255,0.05));
            border-radius: 50%;
            transform: translate(30px, -30px);
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
            position: relative;
            z-index: 1;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
            position: relative;
            z-index: 1;
        }

        .stat-label {
            color: var(--text-muted);
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 1;
        }

        .stat-change {
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            gap: 4px;
            position: relative;
            z-index: 1;
        }

        .stat-change.positive {
            color: var(--success-color);
        }

        .stat-change.negative {
            color: var(--danger-color);
        }

        /* User Management Cards */
        .user-card {
            padding: 1rem;
            border-left: 4px solid var(--primary-color);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            justify-content: between;
        }

        .user-avatar-small {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 1rem;
        }

        .user-details {
            flex: 1;
        }

        .user-name {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
        }

        .user-role {
            color: var(--text-muted);
            font-size: 0.85rem;
            margin-bottom: 0.25rem;
        }

        .user-status {
            font-size: 0.8rem;
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .status-active {
            background: rgba(76, 175, 80, 0.1);
            color: var(--success-color);
        }

        .status-pending {
            background: rgba(255, 152, 0, 0.1);
            color: var(--warning-color);
        }

        .status-inactive {
            background: rgba(244, 67, 54, 0.1);
            color: var(--danger-color);
        }

        /* Action Buttons */
        .btn-primary-custom {
            background: var(--primary-color);
            border: none;
            border-radius: 10px;
            padding: 8px 16px;
            font-weight: 600;
            transition: all 0.3s ease;
            font-size: 0.85rem;
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
            padding: 6px 16px;
            font-weight: 600;
            transition: all 0.3s ease;
            font-size: 0.85rem;
        }

        .btn-outline-custom:hover {
            background: var(--primary-color);
            color: white;
        }

        .btn-danger-custom {
            background: var(--danger-color);
            border: none;
            border-radius: 10px;
            padding: 6px 16px;
            font-weight: 600;
            transition: all 0.3s ease;
            font-size: 0.85rem;
            color: white;
        }

        .btn-success-custom {
            background: var(--success-color);
            border: none;
            border-radius: 10px;
            padding: 6px 16px;
            font-weight: 600;
            transition: all 0.3s ease;
            font-size: 0.85rem;
            color: white;
        }

        /* System Alerts */
        .alert-item {
            display: flex;
            align-items: start;
            gap: 12px;
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 0.75rem;
            transition: all 0.3s ease;
        }

        .alert-item:hover {
            background: rgba(0,0,0,0.02);
        }

        .alert-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .alert-warning {
            background: rgba(255, 152, 0, 0.1);
            color: var(--warning-color);
        }

        .alert-success {
            background: rgba(76, 175, 80, 0.1);
            color: var(--success-color);
        }

        .alert-info {
            background: rgba(33, 150, 243, 0.1);
            color: var(--info-color);
        }

        .alert-content h6 {
            margin: 0 0 0.25rem 0;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .alert-content p {
            margin: 0 0 0.25rem 0;
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .alert-time {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        /* Tables */
        .table-custom {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }

        .table-custom th {
            background: var(--primary-light);
            color: var(--primary-color);
            font-weight: 600;
            border: none;
            padding: 1rem;
        }

        .table-custom td {
            padding: 1rem;
            border: none;
            border-bottom: 1px solid #F1F3F4;
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

            .search-box {
                width: 200px;
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

        /* Chart Container */
        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="#" class="logo">
                <div class="logo-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div>
                    <span class="logo-text">Luna</span>
                    <span class="admin-badge">ADMIN</span>
                </div>
            </a>
        </div>
        
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="#" class="nav-link active">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-users"></i>
                    <span>User Management</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-user-md"></i>
                    <span>Therapist Approval</span>
                    <span class="nav-badge">5</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-video"></i>
                    <span>Session Monitoring</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-chart-bar"></i>
                    <span>Analytics</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-dollar-sign"></i>
                    <span>Financial Reports</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>System Alerts</span>
                    <span class="nav-badge">3</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-comments"></i>
                    <span>Support Tickets</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-cog"></i>
                    <span>Platform Settings</span>
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
                <h1>Admin Control Panel</h1>
            </div>
            <div class="topbar-right">
                <div class="search-box">
                    <input type="text" placeholder="Search users, sessions, reports...">
                    <i class="fas fa-search"></i>
                </div>
                <button class="notification-btn">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge">8</span>
                </button>
                <div class="user-profile">
                    <div class="user-avatar">A</div>
                    <div class="user-info">
                        <h6>Admin User</h6>
                        <p>System Administrator</p>
                    </div>
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>
        </div>

        <!-- Dashboard Content -->
        <div class="dashboard-content">
            <!-- Platform Overview Stats -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card stat-card animate-in">
                        <div class="stat-icon" style="background: rgba(168, 195, 164, 0.1); color: #A8C3A4;">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-number">1,247</div>
                        <div class="stat-label">Total Users</div>
                        <div class="stat-change positive">
                            <i class="fas fa-arrow-up"></i>
                            +12% this month
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card stat-card animate-in" style="animation-delay: 0.1s;">
                        <div class="stat-icon" style="background: rgba(76, 175, 80, 0.1); color: #4CAF50;">
                            <i class="fas fa-user-md"></i>
                        </div>
                        <div class="stat-number">89</div>
                        <div class="stat-label">Active Therapists</div>
                        <div class="stat-change positive">
                            <i class="fas fa-arrow-up"></i>
                            +5 this week
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card stat-card animate-in" style="animation-delay: 0.2s;">
                        <div class="stat-icon" style="background: rgba(33, 150, 243, 0.1); color: #2196F3;">
                            <i class="fas fa-video"></i>
                        </div>
                        <div class="stat-number">3,456</div>
                        <div class="stat-label">Sessions This Month</div>
                        <div class="stat-change positive">
                            <i class="fas fa-arrow-up"></i>
                            +18% vs last month
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card stat-card animate-in" style="animation-delay: 0.3s;">
                        <div class="stat-icon" style="background: rgba(255, 152, 0, 0.1); color: #FF9800;">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="stat-number">$127K</div>
                        <div class="stat-label">Monthly Revenue</div>
                        <div class="stat-change positive">
                            <i class="fas fa-arrow-up"></i>
                            +24% growth
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Dashboard Row -->
            <div class="row">
                <!-- Left Column -->
                <div class="col-lg-8">
                    <!-- Pending Therapist Approvals -->
                    <div class="card mb-4 animate-in" style="animation-delay: 0.4s;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-user-check me-2" style="color: #A8C3A4;"></i>
                                    Pending Therapist Approvals
                                </h5>
                                <button class="btn btn-outline-custom btn-sm">View All</button>
                            </div>
                            
                            <div class="user-card">
                                <img src="https://images.unsplash.com/photo-1559839734-2b71ea197ec2?w=50&h=50&fit=crop&crop=face" 
                                     class="user-avatar-small rounded-circle" alt="Dr. Sarah Mitchell">
                                <div class="user-details">
                                    <div class="user-name">Dr. Sarah Mitchell</div>
                                    <div class="user-role">Clinical Psychologist • 8 years experience</div>
                                    <div class="user-status">
                                        <span class="status-badge status-pending">Pending Review</span>
                                    </div>
                                </div>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-success-custom">Approve</button>
                                    <button class="btn btn-outline-custom">Review</button>
                                </div>
                            </div>

                            <div class="user-card">
                                <img src="https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?w=50&h=50&fit=crop&crop=face" 
                                     class="user-avatar-small rounded-circle" alt="Dr. Michael Torres">
                                <div class="user-details">
                                    <div class="user-name">Dr. Michael Torres</div>
                                    <div class="user-role">Marriage & Family Therapist • 12 years experience</div>
                                    <div class="user-status">
                                        <span class="status-badge status-pending">Pending Review</span>
                                    </div>
                                </div>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-success-custom">Approve</button>
                                    <button class="btn btn-outline-custom">Review</button>
                                </div>
                            </div>

                            <div class="user-card">
                                <img src="https://images.unsplash.com/photo-1594824388853-d0c2d4e5b1b5?w=50&h=50&fit=crop&crop=face" 
                                     class="user-avatar-small rounded-circle" alt="Dr. Jennifer Lee">
                                <div class="user-details">
                                    <div class="user-name">Dr. Jennifer Lee</div>
                                    <div class="user-role">Child & Adolescent Therapist • 6 years experience</div>
                                    <div class="user-status">
                                        <span class="status-badge status-pending">Pending Review</span>
                                    </div>
                                </div>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-success-custom">Approve</button>
                                    <button class="btn btn-outline-custom">Review</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Platform Activity -->
                    <div class="card mb-4 animate-in" style="animation-delay: 0.5s;">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="fas fa-activity me-2" style="color: #A8C3A4;"></i>
                                Recent Platform Activity
                            </h5>
                            <div class="table-responsive">
                                <table class="table table-custom">
                                    <thead>
                                        <tr>
                                            <th>User</th>
                                            <th>Action</th>
                                            <th>Status</th>
                                            <th>Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="https://images.unsplash.com/photo-1494790108755-2616b612b95d?w=30&h=30&fit=crop&crop=face" 
                                                         class="rounded-circle me-2" width="30" height="30">
                                                    <span>Sarah Johnson</span>
                                                </div>
                                            </td>
                                            <td>Completed session with Dr. Rodriguez</td>
                                            <td><span class="status-badge status-active">Completed</span></td>
                                            <td>2 min ago</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=30&h=30&fit=crop&crop=face" 
                                                         class="rounded-circle me-2" width="30" height="30">
                                                    <span>Dr. Emily Rodriguez</span>
                                                </div>
                                            </td>
                                            <td>Updated session notes</td>
                                            <td><span class="status-badge status-active">Active</span></td>
                                            <td>5 min ago</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=30&h=30&fit=crop&crop=face" 
                                                         class="rounded-circle me-2" width="30" height="30">
                                                    <span>Michael Chen</span>
                                                </div>
                                            </td>
                                            <td>Scheduled new appointment</td>
                                            <td><span class="status-badge status-pending">Scheduled</span></td>
                                            <td>12 min ago</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=30&h=30&fit=crop&crop=face" 
                                                         class="rounded-circle me-2" width="30" height="30">
                                                    <span>Dr. David Wilson</span>
                                                </div>
                                            </td>
                                            <td>Joined platform</td>
                                            <td><span class="status-badge status-active">New User</span></td>
                                            <td>1 hour ago</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-lg-4">
                    <!-- System Alerts -->
                    <div class="card mb-4 animate-in" style="animation-delay: 0.6s;">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="fas fa-exclamation-triangle me-2" style="color: #A8C3A4;"></i>
                                System Alerts
                            </h5>
                            
                            <div class="alert-item">
                                <div class="alert-icon alert-warning">
                                    <i class="fas fa-server"></i>
                                </div>
                                <div class="alert-content">
                                    <h6>High Server Load</h6>
                                    <p>Response time increased by 15%</p>
                                    <div class="alert-time">5 minutes ago</div>
                                </div>
                            </div>

                            <div class="alert-item">
                                <div class="alert-icon alert-info">
                                    <i class="fas fa-user-plus"></i>
                                </div>
                                <div class="alert-content">
                                    <h6>New Therapist Application</h6>
                                    <p>Dr. Sarah Mitchell submitted credentials</p>
                                    <div class="alert-time">1 hour ago</div>
                                </div>
                            </div>

                            <div class="alert-item">
                                <div class="alert-icon alert-success">
                                    <i class="fas fa-credit-card"></i>
                                </div>
                                <div class="alert-content">
                                    <h6>Payment Processed</h6>
                                    <p>Monthly subscriptions renewed</p>
                                    <div class="alert-time">2 hours ago</div>
                                </div>
                            </div>

                            <button class="btn btn-outline-custom w-100 mt-3">View All Alerts</button>
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
                                <button class="btn btn-primary-custom">
                                    <i class="fas fa-user-check me-2"></i>
                                    Review Therapist Applications
                                </button>
                                <button class="btn btn-outline-custom">
                                    <i class="fas fa-chart-bar me-2"></i>
                                    Generate Platform Report
                                </button>
                                <button class="btn btn-outline-custom">
                                    <i class="fas fa-envelope me-2"></i>
                                    Send Platform Announcement
                                </button>
                                <button class="btn btn-outline-custom">
                                    <i class="fas fa-cog me-2"></i>
                                    System Configuration
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Top Performing Therapists -->
                    <div class="card animate-in" style="animation-delay: 0.8s;">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="fas fa-star me-2" style="color: #A8C3A4;"></i>
                                Top Performing Therapists
                            </h5>
                            
                            <div class="d-flex align-items-center mb-3">
                                <img src="https://images.unsplash.com/photo-1559839734-2b71ea197ec2?w=40&h=40&fit=crop&crop=face" 
                                     class="rounded-circle me-3" width="40" height="40">
                                <div class="flex-grow-1">
                                    <div class="fw-semibold">Dr. Emily Rodriguez</div>
                                    <small class="text-muted">4.9 ⭐ • 156 sessions</small>
                                </div>
                                <div class="text-end">
                                    <div class="fw-bold text-success">$18.5K</div>
                                    <small class="text-muted">revenue</small>
                                </div>
                            </div>

                            <div class="d-flex align-items-center mb-3">
                                <img src="https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?w=40&h=40&fit=crop&crop=face" 
                                     class="rounded-circle me-3" width="40" height="40">
                                <div class="flex-grow-1">
                                    <div class="fw-semibold">Dr. David Wilson</div>
                                    <small class="text-muted">4.8 ⭐ • 142 sessions</small>
                                </div>
                                <div class="text-end">
                                    <div class="fw-bold text-success">$16.8K</div>
                                    <small class="text-muted">revenue</small>
                                </div>
                            </div>

                            <div class="d-flex align-items-center">
                                <img src="https://images.unsplash.com/photo-1594824388853-d0c2d4e5b1b5?w=40&h=40&fit=crop&crop=face" 
                                     class="rounded-circle me-3" width="40" height="40">
                                <div class="flex-grow-1">
                                    <div class="fw-semibold">Dr. Lisa Thompson</div>
                                    <small class="text-muted">4.7 ⭐ • 98 sessions</small>
                                </div>
                                <div class="text-end">
                                    <div class="fw-bold text-success">$14.2K</div>
                                    <small class="text-muted">revenue</small>
                                </div>
                            </div>

                            <button class="btn btn-outline-custom w-100 mt-3">View All Therapists</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar toggle for mobile
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('show');
        });

        // Navigation
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Approval buttons
        document.querySelectorAll('.btn-success-custom').forEach(btn => {
            btn.addEventListener('click', function() {
                if(confirm('Are you sure you want to approve this therapist?')) {
                    this.textContent = 'Approved';
                    this.disabled = true;
                    this.classList.remove('btn-success-custom');
                    this.classList.add('btn-outline-custom');
                }
            });
        });

        // Search functionality
        document.querySelector('.search-box input').addEventListener('input', function() {
            // Implement search functionality here
            console.log('Searching for:', this.value);
        });

        // Notification click
        document.querySelector('.notification-btn').addEventListener('click', function() {
            // Show notifications dropdown
            alert('System notifications would appear here');
        });

        // Auto-refresh data every 30 seconds
        setInterval(function() {
            // Refresh dashboard data
            console.log('Refreshing dashboard data...');
        }, 30000);
    </script>
</body>
</html>