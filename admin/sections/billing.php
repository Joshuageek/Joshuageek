<?php
session_start();
require_once '../includes/auth.php';

if (!isLoggedIn() || getUserRole() !== 'admin') {
    header('Location: ../index.php');
    exit();
}

// Sample billing data
$billing_summary = [
    'total_revenue' => 125400,
    'pending_payments' => 8750,
    'overdue_payments' => 2340,
    'processed_this_month' => 98650,
    'refunds_issued' => 1250,
    'average_session_cost' => 120
];

$recent_transactions = [
    [
        'id' => 'TXN-001',
        'patient_name' => 'Emily Rodriguez',
        'therapist' => 'Dr. Sarah Johnson',
        'amount' => 120.00,
        'date' => '2024-06-25 14:30:00',
        'status' => 'completed',
        'payment_method' => 'Credit Card',
        'session_type' => 'CBT Session'
    ],
    [
        'id' => 'TXN-002',
        'patient_name' => 'Michael Chen',
        'therapist' => 'Dr. Michael Wilson',
        'amount' => 150.00,
        'date' => '2024-06-25 10:15:00',
        'status' => 'completed',
        'payment_method' => 'Insurance',
        'session_type' => 'PTSD Therapy'
    ],
    [
        'id' => 'TXN-003',
        'patient_name' => 'Sarah Davis',
        'therapist' => 'Dr. Lisa Anderson',
        'amount' => 180.00,
        'date' => '2024-06-24 16:45:00',
        'status' => 'pending',
        'payment_method' => 'Bank Transfer',
        'session_type' => 'Family Therapy'
    ],
    [
        'id' => 'TXN-004',
        'patient_name' => 'David Thompson',
        'therapist' => 'Dr. Sarah Johnson',
        'amount' => 120.00,
        'date' => '2024-06-24 11:20:00',
        'status' => 'failed',
        'payment_method' => 'Credit Card',
        'session_type' => 'Initial Assessment'
    ]
];

$payment_methods = [
    ['method' => 'Credit Card', 'percentage' => 45, 'amount' => 56430],
    ['method' => 'Insurance', 'percentage' => 35, 'amount' => 43890],
    ['method' => 'Bank Transfer', 'percentage' => 15, 'amount' => 18810],
    ['method' => 'Cash', 'percentage' => 5, 'amount' => 6270]
];

$outstanding_invoices = [
    [
        'invoice_id' => 'INV-2024-001',
        'patient_name' => 'Jessica Martinez',
        'amount' => 240.00,
        'due_date' => '2024-06-30',
        'days_overdue' => 0,
        'status' => 'pending'
    ],
    [
        'invoice_id' => 'INV-2024-002',
        'patient_name' => 'Robert Johnson',
        'amount' => 360.00,
        'due_date' => '2024-06-25',
        'days_overdue' => 2,
        'status' => 'overdue'
    ],
    [
        'invoice_id' => 'INV-2024-003',
        'patient_name' => 'Maria Garcia',
        'amount' => 180.00,
        'due_date' => '2024-06-20',
        'days_overdue' => 7,
        'status' => 'overdue'
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<?php include '../templates/header.php'; ?>
<body>
    <?php include '../templates/sidebar.php'; ?>
    
    <div class="main-content">
        <div class="top-bar">
            <div class="page-info d-flex align-items-center">
                <button class="btn me-3" id="sidebarToggle" style="background: var(--luna-primary); color: white; border-radius: 8px;">
                    <i class="fas fa-bars"></i>
                </button>
                <div>
                    <h1 class="page-title">Billing & Payments</h1>
                    <p class="page-subtitle">Financial management and payment processing</p>
                </div>
            </div>
            <div class="top-bar-actions">
                <button class="btn btn-outline-secondary me-2" onclick="exportBilling()">
                    <i class="fas fa-download me-2"></i>Export
                </button>
                <button class="btn btn-luna-primary" data-bs-toggle="modal" data-bs-target="#createInvoiceModal">
                    <i class="fas fa-file-invoice me-2"></i>Create Invoice
                </button>
            </div>
        </div>
        
        <div class="container-fluid p-4">
            <!-- Financial Overview -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card animate-in">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="stat-label">Total Revenue</p>
                                <h3 class="stat-number">$<?php echo number_format($billing_summary['total_revenue']); ?></h3>
                                <span class="stat-change positive">
                                    <i class="fas fa-arrow-up"></i> +12.5% this month
                                </span>
                            </div>
                            <div class="stat-icon icon-success">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card animate-in animate-delay-1">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="stat-label">Pending Payments</p>
                                <h3 class="stat-number">$<?php echo number_format($billing_summary['pending_payments']); ?></h3>
                                <span class="stat-change warning">
                                    <i class="fas fa-clock"></i> Awaiting payment
                                </span>
                            </div>
                            <div class="stat-icon icon-warning">
                                <i class="fas fa-clock"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card animate-in animate-delay-2">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="stat-label">Overdue Payments</p>
                                <h3 class="stat-number">$<?php echo number_format($billing_summary['overdue_payments']); ?></h3>
                                <span class="stat-change negative">
                                    <i class="fas fa-exclamation-triangle"></i> Requires attention
                                </span>
                            </div>
                            <div class="stat-icon icon-danger">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card animate-in animate-delay-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="stat-label">Avg Session Cost</p>
                                <h3 class="stat-number">$<?php echo $billing_summary['average_session_cost']; ?></h3>
                                <span class="stat-change positive">
                                    <i class="fas fa-chart-line"></i> Market rate
                                </span>
                            </div>
                            <div class="stat-icon icon-primary">
                                <i class="fas fa-chart-line"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Recent Transactions -->
                <div class="col-lg-8 mb-4">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0">
                                <i class="fas fa-credit-card text-primary me-2"></i>
                                Recent Transactions
                            </h5>
                            <div class="d-flex gap-2">
                                <select class="form-select" style="width: auto;">
                                    <option>All Status</option>
                                    <option>Completed</option>
                                    <option>Pending</option>
                                    <option>Failed</option>
                                </select>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Transaction ID</th>
                                        <th>Patient</th>
                                        <th>Therapist</th>
                                        <th>Amount</th>
                                        <th>Payment Method</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recent_transactions as $transaction): ?>
                                    <tr>
                                        <td>
                                            <span class="fw-bold text-primary"><?php echo $transaction['id']; ?></span>
                                        </td>
                                        <td><?php echo htmlspecialchars($transaction['patient_name']); ?></td>
                                        <td><?php echo htmlspecialchars($transaction['therapist']); ?></td>
                                        <td>
                                            <span class="fw-bold">$<?php echo number_format($transaction['amount'], 2); ?></span>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary"><?php echo $transaction['payment_method']; ?></span>
                                        </td>
                                        <td>
                                            <span class="badge <?php 
                                                echo $transaction['status'] === 'completed' ? 'bg-success' : 
                                                    ($transaction['status'] === 'pending' ? 'bg-warning' : 'bg-danger'); 
                                            ?>">
                                                <?php echo ucfirst($transaction['status']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="small">
                                                <?php echo date('M j, Y', strtotime($transaction['date'])); ?>
                                                <div class="text-muted"><?php echo date('g:i A', strtotime($transaction['date'])); ?></div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="#" onclick="viewTransaction('<?php echo $transaction['id']; ?>')">
                                                        <i class="fas fa-eye me-2"></i>View Details
                                                    </a></li>
                                                    <?php if ($transaction['status'] === 'failed'): ?>
                                                    <li><a class="dropdown-item" href="#" onclick="retryPayment('<?php echo $transaction['id']; ?>')">
                                                        <i class="fas fa-redo me-2"></i>Retry Payment
                                                    </a></li>
                                                    <?php endif; ?>
                                                    <li><a class="dropdown-item" href="#" onclick="refundTransaction('<?php echo $transaction['id']; ?>')">
                                                        <i class="fas fa-undo me-2"></i>Issue Refund
                                                    </a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Payment Methods -->
                <div class="col-lg-4 mb-4">
                    <div class="stat-card">
                        <h5 class="mb-4">
                            <i class="fas fa-chart-pie text-info me-2"></i>
                            Payment Methods
                        </h5>
                        <div class="payment-methods-list">
                            <?php foreach ($payment_methods as $method): ?>
                            <div class="payment-method-item mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="fw-semibold"><?php echo $method['method']; ?></span>
                                    <span class="text-muted">$<?php echo number_format($method['amount']); ?></span>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-info" style="width: <?php echo $method['percentage']; ?>%"></div>
                                </div>
                                <small class="text-muted"><?php echo $method['percentage']; ?>% of total revenue</small>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Outstanding Invoices -->
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0">
                        <i class="fas fa-file-invoice text-warning me-2"></i>
                        Outstanding Invoices
                    </h5>
                    <button class="btn btn-outline-warning" onclick="sendReminders()">
                        <i class="fas fa-envelope me-2"></i>Send Reminders
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Invoice ID</th>
                                <th>Patient</th>
                                <th>Amount</th>
                                <th>Due Date</th>
                                <th>Days Overdue</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($outstanding_invoices as $invoice): ?>
                            <tr>
                                <td>
                                    <span class="fw-bold text-primary"><?php echo $invoice['invoice_id']; ?></span>
                                </td>
                                <td><?php echo htmlspecialchars($invoice['patient_name']); ?></td>
                                <td>
                                    <span class="fw-bold">$<?php echo number_format($invoice['amount'], 2); ?></span>
                                </td>
                                <td><?php echo date('M j, Y', strtotime($invoice['due_date'])); ?></td>
                                <td>
                                    <?php if ($invoice['days_overdue'] > 0): ?>
                                        <span class="text-danger fw-bold"><?php echo $invoice['days_overdue']; ?> days</span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge <?php echo $invoice['status'] === 'pending' ? 'bg-warning' : 'bg-danger'; ?>">
                                        <?php echo ucfirst($invoice['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <button class="btn btn-sm btn-outline-primary" onclick="viewInvoice('<?php echo $invoice['invoice_id']; ?>')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-success" onclick="sendReminder('<?php echo $invoice['invoice_id']; ?>')">
                                            <i class="fas fa-envelope"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-warning" onclick="editInvoice('<?php echo $invoice['invoice_id']; ?>')">
                                            <i class="fas fa-edit"></i>
                                        </button>
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

    <!-- Create Invoice Modal -->
    <div class="modal fade" id="createInvoiceModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create New Invoice</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="createInvoiceForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Patient *</label>
                                <select class="form-select" name="patient" required>
                                    <option value="">Select Patient</option>
                                    <option value="1">Emily Rodriguez</option>
                                    <option value="2">Michael Chen</option>
                                    <option value="3">Sarah Davis</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Therapist *</label>
                                <select class="form-select" name="therapist" required>
                                    <option value="">Select Therapist</option>
                                    <option value="1">Dr. Sarah Johnson</option>
                                    <option value="2">Dr. Michael Wilson</option>
                                    <option value="3">Dr. Lisa Anderson</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Service Date *</label>
                                <input type="date" class="form-control" name="service_date" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Due Date *</label>
                                <input type="date" class="form-control" name="due_date" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Services</label>
                            <div class="services-list">
                                <div class="service-item d-flex align-items-center mb-2">
                                    <input type="text" class="form-control me-2" placeholder="Service description" name="service_desc[]">
                                    <input type="number" class="form-control me-2" placeholder="Amount" name="service_amount[]" style="width: 120px;">
                                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeService(this)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="addService()">
                                <i class="fas fa-plus me-1"></i>Add Service
                            </button>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Subtotal</label>
                                <input type="number" class="form-control" name="subtotal" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tax (%)</label>
                                <input type="number" class="form-control" name="tax" value="8.5" step="0.1">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Notes</label>
                            <textarea class="form-control" name="notes" rows="3" placeholder="Additional notes or payment instructions..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-luna-primary" onclick="createInvoice()">
                        <i class="fas fa-file-invoice me-2"></i>Create Invoice
                    </button>
                </div>
            </div>
        </div>
    </div>

    <?php include '../templates/footer.php'; ?>
    <script src="../assets/js/simple-luna.js"></script>
    
    <script>
        function viewTransaction(id) {
            showToast(`Viewing transaction ${id}`, 'info');
        }

        function retryPayment(id) {
            showToast(`Retrying payment for ${id}`, 'info');
        }

        function refundTransaction(id) {
            if (confirm('Are you sure you want to issue a refund for this transaction?')) {
                showToast(`Refund initiated for ${id}`, 'success');
            }
        }

        function viewInvoice(id) {
            showToast(`Opening invoice ${id}`, 'info');
        }

        function sendReminder(id) {
            showToast(`Payment reminder sent for ${id}`, 'success');
        }

        function editInvoice(id) {
            showToast(`Editing invoice ${id}`, 'info');
        }

        function sendReminders() {
            showToast('Payment reminders sent to all overdue accounts', 'success');
        }

        function exportBilling() {
            showToast('Exporting billing data...', 'info');
        }

        function addService() {
            const servicesList = document.querySelector('.services-list');
            const newService = document.createElement('div');
            newService.className = 'service-item d-flex align-items-center mb-2';
            newService.innerHTML = `
                <input type="text" class="form-control me-2" placeholder="Service description" name="service_desc[]">
                <input type="number" class="form-control me-2" placeholder="Amount" name="service_amount[]" style="width: 120px;">
                <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeService(this)">
                    <i class="fas fa-trash"></i>
                </button>
            `;
            servicesList.appendChild(newService);
        }

        function removeService(button) {
            button.closest('.service-item').remove();
            calculateSubtotal();
        }

        function calculateSubtotal() {
            const amounts = document.querySelectorAll('input[name="service_amount[]"]');
            let subtotal = 0;
            amounts.forEach(input => {
                if (input.value) {
                    subtotal += parseFloat(input.value);
                }
            });
            document.querySelector('input[name="subtotal"]').value = subtotal.toFixed(2);
        }

        function createInvoice() {
            showToast('Invoice created successfully!', 'success');
            bootstrap.Modal.getInstance(document.getElementById('createInvoiceModal')).hide();
        }

        // Auto-calculate subtotal when service amounts change
        document.addEventListener('input', function(e) {
            if (e.target.name === 'service_amount[]') {
                calculateSubtotal();
            }
        });
    </script>

    <style>
        .payment-method-item {
            padding: 0.75rem;
            border-radius: 8px;
            background: var(--luna-light);
        }

        .service-item {
            padding: 0.5rem;
            border: 1px solid #e9ecef;
            border-radius: 6px;
            background: #f8f9fa;
        }
    </style>
</body>
</html>
