<div class="card-body">
    <div class="stats-grid">
        <div class="stat-item">
            <div class="stat-icon bg-primary">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="stat-info">
                <h3><?php echo $activeBookings ?></h3>
                <p>Bookings</p>
            </div>
        </div>
        <div class="stat-item">
            <div class="stat-icon bg-success">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="stat-info">
                <h3><?php echo $patientsCounts ?></h3>
                <p>Active Patients</p>
            </div>
        </div>
        <div class="stat-item">
            <div class="stat-icon bg-info">
                <i class="fas fa-user-md"></i>
            </div>
            <div class="stat-info">
                <h3><?php echo $therapistsCount ?></h3>
                <p>Therapists</p>
            </div>
        </div>
        <div class="stat-item">
            <div class="stat-icon bg-warning">
                <i class="fas fa-comments"></i>
            </div>
            <div class="stat-info">
                <h3><?php echo $pendingResponses ?></h3>
                <p>Pending Responses</p>
            </div>
        </div>
    </div>
</div>