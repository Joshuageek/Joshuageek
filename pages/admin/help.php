<?php
session_start();
// require_once 'config/database.php';
require_once 'includes/auth.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_role = getUserRole();
$user_name = $_SESSION['user_name'] ?? 'User';

// Sample FAQ data
$faqs = [
    [
        'category' => 'Getting Started',
        'questions' => [
            [
                'question' => 'How do I log into my Luna account?',
                'answer' => 'You can log into your Luna account using your registered email address and password. If you\'ve forgotten your password, click the "Forgot Password" link on the login page.'
            ],
            [
                'question' => 'How do I update my profile information?',
                'answer' => 'Navigate to "My Profile" from the sidebar menu. Click the "Edit Profile" button to update your personal information, contact details, and professional credentials.'
            ],
            [
                'question' => 'How do I change my password?',
                'answer' => 'Go to your profile page and click on "Change Password" in the Quick Actions section. You\'ll need to enter your current password and then your new password twice.'
            ]
        ]
    ],
    [
        'category' => 'Appointments & Sessions',
        'questions' => [
            [
                'question' => 'How do I schedule an appointment?',
                'answer' => 'Go to the Calendar section and click on your desired time slot. Fill out the appointment details including patient information, session type, and any special notes.'
            ],
            [
                'question' => 'Can I reschedule or cancel appointments?',
                'answer' => 'Yes, you can reschedule or cancel appointments by clicking on the appointment in your calendar and selecting the appropriate option. Please note cancellation policies may apply.'
            ],
            [
                'question' => 'How do I join a video session?',
                'answer' => 'Click on the "Join Session" button in your appointment details 5 minutes before the scheduled time. Make sure your camera and microphone are working properly.'
            ]
        ]
    ],
    [
        'category' => 'Technical Support',
        'questions' => [
            [
                'question' => 'What browsers are supported?',
                'answer' => 'Luna works best with the latest versions of Chrome, Firefox, Safari, and Edge. We recommend keeping your browser updated for the best experience.'
            ],
            [
                'question' => 'I\'m having trouble with video calls',
                'answer' => 'First, check your internet connection and ensure your camera/microphone permissions are enabled. Try refreshing the page or using a different browser if issues persist.'
            ],
            [
                'question' => 'How do I report a bug or technical issue?',
                'answer' => 'Use the "Report Issue" button below or contact our technical support team directly. Please include details about what you were doing when the issue occurred.'
            ]
        ]
    ]
];

// Sample support tickets
$recent_tickets = [
    [
        'id' => 'TK-2024-001',
        'subject' => 'Unable to access patient records',
        'status' => 'Open',
        'priority' => 'High',
        'created' => '2024-01-20 09:30:00',
        'last_update' => '2024-01-20 14:15:00'
    ],
    [
        'id' => 'TK-2024-002',
        'subject' => 'Calendar sync issues',
        'status' => 'In Progress',
        'priority' => 'Medium',
        'created' => '2024-01-19 16:45:00',
        'last_update' => '2024-01-20 10:20:00'
    ],
    [
        'id' => 'TK-2024-003',
        'subject' => 'Password reset request',
        'status' => 'Resolved',
        'priority' => 'Low',
        'created' => '2024-01-18 11:20:00',
        'last_update' => '2024-01-18 12:30:00'
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help & Support - Luna Mental Wellness</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="assets/css/luna-style.css" rel="stylesheet">
    <style>
        .help-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 3rem 0;
            margin-bottom: 2rem;
        }
        
        .help-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            border: none;
            margin-bottom: 1.5rem;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .help-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        
        .help-card .card-header {
            background: linear-gradient(45deg, #f8f9fa, #e9ecef);
            border-bottom: 1px solid #dee2e6;
            padding: 1.25rem;
            font-weight: 600;
            color: #495057;
        }
        
        .faq-item {
            border-bottom: 1px solid #f1f3f4;
            padding: 1rem 0;
        }
        
        .faq-item:last-child {
            border-bottom: none;
        }
        
        .faq-question {
            font-weight: 600;
            color: #495057;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0;
            transition: color 0.3s ease;
        }
        
        .faq-question:hover {
            color: #667eea;
        }
        
        .faq-answer {
            color: #6c757d;
            line-height: 1.6;
            margin-top: 0.5rem;
            padding-left: 1rem;
            border-left: 3px solid #667eea;
            display: none;
        }
        
        .faq-answer.show {
            display: block;
            animation: fadeIn 0.3s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .support-option {
            text-align: center;
            padding: 2rem;
            border-radius: 15px;
            background: white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .support-option:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        
        .support-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 2rem;
            color: white;
        }
        
        .support-email { background: linear-gradient(45deg, #28a745, #20c997); }
        .support-phone { background: linear-gradient(45deg, #17a2b8, #6f42c1); }
        .support-chat { background: linear-gradient(45deg, #ffc107, #fd7e14); }
        .support-ticket { background: linear-gradient(45deg, #dc3545, #e83e8c); }
        
        .ticket-status {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }
        
        .status-open { background: #fff3cd; color: #856404; }
        .status-progress { background: #cce5ff; color: #004085; }
        .status-resolved { background: #d4edda; color: #155724; }
        
        .priority-high { color: #dc3545; }
        .priority-medium { color: #ffc107; }
        .priority-low { color: #28a745; }
        
        .search-box {
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 25px;
            padding: 0.75rem 1.5rem;
            color: white;
            width: 100%;
            max-width: 500px;
        }
        
        .search-box::placeholder {
            color: rgba(255,255,255,0.7);
        }
        
        .search-box:focus {
            background: rgba(255,255,255,0.2);
            border-color: rgba(255,255,255,0.4);
            color: white;
            box-shadow: none;
        }
    </style>
</head>
<body>
    <?php include 'templates/header.php'; ?>
    
    <div class="main-wrapper">
        <?php include 'templates/sidebar.php'; ?>
        
        <div class="main-content">
            <!-- Help Header -->
            <div class="help-header">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <h1 class="display-5 fw-bold mb-3">How can we help you?</h1>
                            <p class="lead mb-4">Find answers to common questions or get in touch with our support team.</p>
                        </div>
                        <div class="col-lg-6">
                            <div class="text-center">
                                <input type="text" class="form-control search-box" placeholder="Search for help articles..." id="helpSearch">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="container-fluid">
                <div class="row">
                    <!-- Support Options -->
                    <div class="col-12 mb-4">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 mb-3">
                                <div class="support-option">
                                    <div class="support-icon support-email">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <h5>Email Support</h5>
                                    <p class="text-muted mb-3">Get help via email within 24 hours</p>
                                    <a href="mailto:support@luna-wellness.com" class="btn btn-outline-success">Send Email</a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <div class="support-option">
                                    <div class="support-icon support-phone">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                    <h5>Phone Support</h5>
                                    <p class="text-muted mb-3">Call us for immediate assistance</p>
                                    <a href="tel:+1-800-LUNA-HELP" class="btn btn-outline-info">Call Now</a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <div class="support-option">
                                    <div class="support-icon support-chat">
                                        <i class="fas fa-comments"></i>
                                    </div>
                                    <h5>Live Chat</h5>
                                    <p class="text-muted mb-3">Chat with our support team online</p>
                                    <button class="btn btn-outline-warning" onclick="startLiveChat()">Start Chat</button>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <div class="support-option">
                                    <div class="support-icon support-ticket">
                                        <i class="fas fa-ticket-alt"></i>
                                    </div>
                                    <h5>Support Ticket</h5>
                                    <p class="text-muted mb-3">Submit a detailed support request</p>
                                    <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#ticketModal">Create Ticket</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- FAQ Section -->
                    <div class="col-lg-8">
                        <div class="help-card">
                            <div class="card-header">
                                <i class="fas fa-question-circle me-2"></i>Frequently Asked Questions
                            </div>
                            <div class="card-body">
                                <?php foreach ($faqs as $category): ?>
                                <div class="mb-4">
                                    <h5 class="text-primary mb-3">
                                        <i class="fas fa-folder me-2"></i><?php echo $category['category']; ?>
                                    </h5>
                                    <?php foreach ($category['questions'] as $faq): ?>
                                    <div class="faq-item">
                                        <div class="faq-question" onclick="toggleFaq(this)">
                                            <?php echo $faq['question']; ?>
                                            <i class="fas fa-chevron-down"></i>
                                        </div>
                                        <div class="faq-answer">
                                            <?php echo $faq['answer']; ?>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Support Tickets -->
                    <div class="col-lg-4">
                        <div class="help-card">
                            <div class="card-header">
                                <i class="fas fa-ticket-alt me-2"></i>My Support Tickets
                            </div>
                            <div class="card-body">
                                <?php if (empty($recent_tickets)): ?>
                                <div class="text-center py-4">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No support tickets found</p>
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#ticketModal">
                                        Create First Ticket
                                    </button>
                                </div>
                                <?php else: ?>
                                <?php foreach ($recent_tickets as $ticket): ?>
                                <div class="border-bottom pb-3 mb-3">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h6 class="mb-1"><?php echo htmlspecialchars($ticket['subject']); ?></h6>
                                        <span class="ticket-status status-<?php echo strtolower(str_replace(' ', '', $ticket['status'])); ?>">
                                            <?php echo $ticket['status']; ?>
                                        </span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            <i class="fas fa-hashtag"></i> <?php echo $ticket['id']; ?>
                                        </small>
                                        <small class="priority-<?php echo strtolower($ticket['priority']); ?>">
                                            <i class="fas fa-flag"></i> <?php echo $ticket['priority']; ?>
                                        </small>
                                    </div>
                                    <small class="text-muted d-block mt-1">
                                        Updated: <?php echo date('M j, g:i A', strtotime($ticket['last_update'])); ?>
                                    </small>
                                </div>
                                <?php endforeach; ?>
                                <div class="text-center">
                                    <button class="btn btn-outline-primary btn-sm">View All Tickets</button>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <!-- Quick Links -->
                        <div class="help-card">
                            <div class="card-header">
                                <i class="fas fa-external-link-alt me-2"></i>Quick Links
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <a href="#" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-book me-2"></i>User Manual
                                    </a>
                                    <a href="#" class="btn btn-outline-info btn-sm">
                                        <i class="fas fa-video me-2"></i>Video Tutorials
                                    </a>
                                    <a href="#" class="btn btn-outline-success btn-sm">
                                        <i class="fas fa-download me-2"></i>System Requirements
                                    </a>
                                    <a href="#" class="btn btn-outline-warning btn-sm">
                                        <i class="fas fa-shield-alt me-2"></i>Privacy Policy
                                    </a>
                                    <a href="#" class="btn btn-outline-secondary btn-sm">
                                        <i class="fas fa-file-contract me-2"></i>Terms of Service
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Create Ticket Modal -->
    <div class="modal fade" id="ticketModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Support Ticket</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="ticketForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Subject *</label>
                                    <input type="text" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Priority</label>
                                    <select class="form-select">
                                        <option value="low">Low</option>
                                        <option value="medium" selected>Medium</option>
                                        <option value="high">High</option>
                                        <option value="urgent">Urgent</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Category</label>
                                    <select class="form-select">
                                        <option>Technical Issue</option>
                                        <option>Account Problem</option>
                                        <option>Feature Request</option>
                                        <option>Billing Question</option>
                                        <option>Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Description *</label>
                                    <textarea class="form-control" rows="5" placeholder="Please describe your issue in detail..." required></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Attachments</label>
                                    <input type="file" class="form-control" multiple accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                                    <small class="text-muted">Max 5 files, 10MB each</small>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="submitTicket()">Create Ticket</button>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/simple-luna.js"></script>
    <script>
        // FAQ Toggle
        function toggleFaq(element) {
            const answer = element.nextElementSibling;
            const icon = element.querySelector('i');
            
            if (answer.classList.contains('show')) {
                answer.classList.remove('show');
                icon.classList.remove('fa-chevron-up');
                icon.classList.add('fa-chevron-down');
            } else {
                // Close all other FAQs
                document.querySelectorAll('.faq-answer.show').forEach(item => {
                    item.classList.remove('show');
                });
                document.querySelectorAll('.faq-question i').forEach(item => {
                    item.classList.remove('fa-chevron-up');
                    item.classList.add('fa-chevron-down');
                });
                
                // Open clicked FAQ
                answer.classList.add('show');
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-up');
            }
        }
        
        // Search functionality
        document.getElementById('helpSearch').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const faqItems = document.querySelectorAll('.faq-item');
            
            faqItems.forEach(item => {
                const question = item.querySelector('.faq-question').textContent.toLowerCase();
                const answer = item.querySelector('.faq-answer').textContent.toLowerCase();
                
                if (question.includes(searchTerm) || answer.includes(searchTerm)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = searchTerm ? 'none' : 'block';
                }
            });
        });
        
        // Live chat
        function startLiveChat() {
            showToast('Live chat feature coming soon!', 'info');
        }
        
        // Submit ticket
        function submitTicket() {
            const form = document.getElementById('ticketForm');
            if (form.checkValidity()) {
                showToast('Support ticket created successfully! We\'ll get back to you soon.', 'success');
                bootstrap.Modal.getInstance(document.getElementById('ticketModal')).hide();
                form.reset();
            } else {
                form.reportValidity();
            }
        }
    </script>
</body>
</html>
