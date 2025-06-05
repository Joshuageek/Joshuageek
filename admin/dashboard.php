<?php 
include 'includes/header.php';
?>

<div class="dashboard-container">
    <!-- Header Section -->
    <div class="dashboard-header">
        <div class="header-left">
            <h1><i class="fas fa-tachometer-alt"></i> Dashboard</h1>
            <p class="dashboard-date">Saturday, May 24, 2025</p>
        </div>
        <div class="header-right d-flex gap-3">
            <button class="btn btn-outline-secondary btn-sm" id="refresh-page">
                <i class="fas fa-sync-alt"></i> Refresh
            </button>
            <a href="../index.php" class="btn btn-outline-primary btn-sm">
                <i class="fas fa-arrow-left"></i> Back to Website
            </a>
        </div>
    </div>

    <!-- Main Content with Tabs -->
    <div class="dashboard-grid">
        <!-- Left Column (60%) -->
        <div class="main-content">
            <!-- Tab Navigation -->
            <ul class="nav nav-tabs mb-3" id="dashboardTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="bookings-tab" data-bs-toggle="tab" data-bs-target="#bookings" type="button" role="tab">
                        <i class="fas fa-calendar-alt me-1"></i> Bookings
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="users-tab" data-bs-toggle="tab" data-bs-target="#users" type="button" role="tab">
                        <i class="fas fa-users me-1"></i> Patients
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="therapists-tab" data-bs-toggle="tab" data-bs-target="#therapists" type="button" role="tab">
                        <i class="fas fa-user-md me-1"></i> Therapists
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="responses-tab" data-bs-toggle="tab" data-bs-target="#responses" type="button" role="tab">
                        <i class="fas fa-comments me-1"></i> Responses
                    </button>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content" id="dashboardTabsContent">
                <!-- Bookings Tab -->
                <div class="tab-pane fade show active" id="bookings" role="tabpanel">
                    <?php include 'includes/dashboard/bookings_tab.php'; ?>
                </div>

                <!-- Users Tab -->
                <div class="tab-pane fade" id="users" role="tabpanel">
                    <?php include 'includes/dashboard/users_tab.php'; ?>
                </div>

                <!-- Therapists Tab -->
                <div class="tab-pane fade" id="therapists" role="tabpanel">
                    <?php include 'includes/dashboard/therapists_tab.php'; ?>
                </div>

                <!-- Responses Tab -->
                <div class="tab-pane fade" id="responses" role="tabpanel">
                    <?php include 'includes/dashboard/responses_tab.php'; ?>
                </div>
            </div>
        </div>

        <!-- Right Column (40%) - Unchanged -->
        <div class="sidebar-content">
            <!-- Quick Stats -->
            <div class="dashboard-card">
                <div class="card-header">
                    <h2><i class="fas fa-chart-pie"></i> Statistics</h2>
                </div>
                <?php include 'includes/dashboard/stats.php'; ?>
            </div>

            <!-- Recent Activity -->
            <div class="dashboard-card">
                <div class="card-header">
                    <h2><i class="fas fa-history"></i> Recent Activity</h2>
                </div>
                <?php include 'includes/dashboard/recent_activity.php'; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const tabButtons = document.querySelectorAll('#dashboardTabs .nav-link');
    const storageKey = 'dashboardActiveTab';

    const lastTab = localStorage.getItem(storageKey);
    if (lastTab) {
        const triggerTab = document.querySelector(`#dashboardTabs .nav-link[data-bs-target="${lastTab}"]`);
        if (triggerTab) {
            var tab = new bootstrap.Tab(triggerTab);
            tab.show();
        }
    }

    tabButtons.forEach(btn => {
        btn.addEventListener('shown.bs.tab', function (e) {
            const target = e.target.getAttribute('data-bs-target');
            localStorage.setItem(storageKey, target);
        });
    });
    
    document.getElementById('refresh-page').addEventListener('click', ()=> {
        location.reload()
    })
});
</script>