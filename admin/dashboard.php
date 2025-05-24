<?php
require_once 'includes/header.php';
require_once 'includes/functions.php';
require_once 'php/data.php';

if(get_user_role($user_id) !== 'admin') {
    header('Location: ../index.php');
    exit();
}

?>

<main class="admin-dashboard-scope">
    <div class="container dashboard-container my-5">
        <!-- Dashboard Header -->
        <div class="row dashboard-header">
            <div class="col-12">
                <h1><i class="fas fa-tachometer-alt me-2"></i>Dashboard Overview</h1>
                <p class="text-muted">Welcome back! Here's what's happening with your business today.</p>
            </div>
            <div class="my-2 col-12">
                <a href="../index.php" class="btn btn-outline-secondary rounded btn-sm">
                    <i class="fas fa-arrow-left me-2"></i> Back to Website
                </a>
            </divc>
        </div>

        <!-- Stats Cards -->
        <?php include 'includes/dashboard/stats_cards.php'; ?>
        
        <!-- Main Content -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">System Data</h6>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" 
                                    id="dashboardDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dashboardDropdown">
                                <li><h6 class="dropdown-header">View Options</h6></li>
                                <li><a class="dropdown-item" href="#" id="refresh-all"><i class="fas fa-sync-alt me-2"></i>Refresh Data</a></li>
                                <li><a class="dropdown-item" href="#" id="export-dashboard"><i class="fas fa-download me-2"></i>Export</a></li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <!-- Tab Navigation -->
                        <ul class="nav nav-tabs mb-4" id="dashboardTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="bookings-tab" data-bs-toggle="tab" 
                                        data-bs-target="#bookings" type="button" role="tab">
                                    <i class="fas fa-calendar-alt me-2"></i>Bookings
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="users-tab" data-bs-toggle="tab" 
                                        data-bs-target="#users" type="button" role="tab">
                                    <i class="fas fa-users me-2"></i>Users
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="therapists-tab" data-bs-toggle="tab" 
                                        data-bs-target="#therapists" type="button" role="tab">
                                    <i class="fas fa-user-md me-2"></i>Therapists
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="responses-tab" data-bs-toggle="tab" 
                                        data-bs-target="#responses" type="button" role="tab">
                                    <i class="fas fa-comments me-2"></i>Responses
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="reports-tab" data-bs-toggle="tab" 
                                        data-bs-target="#reports" type="button" role="tab">
                                    <i class="fas fa-chart-pie me-2"></i>Reports
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
                            
                            <!-- Reports Tab -->
                            <div class="tab-pane fade" id="reports" role="tabpanel">
                                <?php include 'includes/dashboard/reports_tab.php'; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modals -->
    <?php include 'includes/modals/modals.php'; ?>
</main>

<!-- JavaScript Libraries -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Custom JavaScript -->
<script src="assets/js/dashboard.js"></script>

<?php include 'includes/footer.php'; ?>