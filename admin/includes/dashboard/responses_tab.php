<div class="dashboard-card">
    <div class="card-header">
        <h2>Responses Management</h2>
        <div class="card-actions">
            <div class="response-filters">
                <button class="filter-btn active">All</button>
                <button class="filter-btn">Completed</button>
                <button class="filter-btn">Pending</button>
                <button class="filter-btn">Cancelled</button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Patient</th>
                        <th>Therapist</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>R01</td>
                        <td>John Doe</td>
                        <td>Dr. Smith</td>
                        <td>Jun 12, 2023</td>
                        <td><span class="badge bg-success">Completed</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    <!-- More response rows -->
                </tbody>
            </table>
        </div>
    </div>
</div>