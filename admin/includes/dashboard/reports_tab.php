<?php
// Get report data from database or API
$reportData = [
    'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
    'bookings' => [12, 19, 15, 22, 18, 25],
    'users' => [5, 8, 7, 10, 12, 15]
];
?>

<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Monthly Summary</h6>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="monthlySummaryChart" height="100"></canvas>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const ctx = document.getElementById('monthlySummaryChart').getContext('2d');
                            new Chart(ctx, {
                                type: 'line',
                                data: {
                                    labels: <?= json_encode($reportData['labels']) ?>,
                                    datasets: [{
                                        label: "Bookings",
                                        data: <?= json_encode($reportData['bookings']) ?>,
                                        borderColor: "rgba(78, 115, 223, 1)",
                                        backgroundColor: "rgba(78, 115, 223, 0.05)",
                                        pointBackgroundColor: "rgba(78, 115, 223, 1)",
                                        pointBorderColor: "rgba(78, 115, 223, 1)",
                                    }, {
                                        label: "New Users",
                                        data: <?= json_encode($reportData['users']) ?>,
                                        borderColor: "rgba(28, 200, 138, 1)",
                                        backgroundColor: "rgba(28, 200, 138, 0.05)",
                                        pointBackgroundColor: "rgba(28, 200, 138, 1)",
                                        pointBorderColor: "rgba(28, 200, 138, 1)",
                                    }]
                                },
                                options: {
                                    maintainAspectRatio: false,
                                    scales: {
                                        y: {
                                            beginAtZero: true
                                        }
                                    }
                                }
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Custom Report Generator</h6>
            </div>
            <div class="card-body">
                <form id="reportGeneratorForm">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="reportType" class="form-label">Report Type</label>
                            <select class="form-select" id="reportType" required>
                                <option value="" selected disabled>Select report type</option>
                                <option value="bookings">Bookings</option>
                                <option value="users">Users</option>
                                <option value="therapists">Therapists</option>
                                <option value="responses">Responses</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="dateFrom" class="form-label">Date From</label>
                            <input type="date" class="form-control" id="dateFrom">
                        </div>
                        <div class="col-md-4">
                            <label for="dateTo" class="form-label">Date To</label>
                            <input type="date" class="form-control" id="dateTo">
                        </div>
                    </div>
                    <div class="row g-3 mt-3">
                        <div class="col-md-6">
                            <label for="statusFilter" class="form-label">Status Filter</label>
                            <select class="form-select" id="statusFilter" multiple>
                                <option value="active" selected>Active</option>
                                <option value="pending" selected>Pending</option>
                                <option value="completed" selected>Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="outputFormat" class="form-label">Output Format</label>
                            <select class="form-select" id="outputFormat" required>
                                <option value="html" selected>HTML (View in Browser)</option>
                                <option value="pdf">PDF</option>
                                <option value="excel">Excel</option>
                                <option value="csv">CSV</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-file-alt me-2"></i> Generate Report
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('reportGeneratorForm');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Get form data
        const formData = {
            reportType: document.getElementById('reportType').value,
            dateFrom: document.getElementById('dateFrom').value,
            dateTo: document.getElementById('dateTo').value,
            statusFilter: Array.from(document.getElementById('statusFilter').selectedOptions)
                              .map(option => option.value),
            outputFormat: document.getElementById('outputFormat').value
        };
        
        // Here you would typically make an AJAX request to generate the report
        console.log('Generating report with:', formData);
        toastr.success('Report generation started!');
        
        // Simulate report generation
        setTimeout(() => {
            toastr.success('Report generated successfully!');
        }, 2000);
    });
});
</script>