<?php
session_start();
require_once 'includes/auth.php';
include 'templates/header.php';

if (!isLoggedIn()) {
    header('Location: ../login.php');
    exit();
}

$user_role = getUserRole();
$user_name = $_SESSION['user_name'] ?? 'User';

// Sample notifications based on user role
$notifications = [];
if ($user_role === 'admin') {
    $notifications = [
        [
            'id' => 1,
            'type' => 'system',
            'title' => 'System Backup Completed',
            'message' => 'Daily system backup completed successfully at 2:00 AM',
            'timestamp' => '2024-06-25 02:00:00',
            'read' => false,
            'priority' => 'low',
            'icon' => 'fa-database'
        ],
        [
            'id' => 2,
            'type' => 'user',
            'title' => 'New Therapist Registration',
            'message' => 'Dr. Jennifer Smith has submitted credentials for review',
            'timestamp' => '2024-06-24 16:30:00',
            'read' => false,
            'priority' => 'medium',
            'icon' => 'fa-user-md'
        ],
        [
            'id' => 3,
            'type' => 'billing',
            'title' => 'Monthly Revenue Report',
            'message' => 'June revenue report is ready for review - $125,400 total',
            'timestamp' => '2024-06-24 09:00:00',
            'read' => true,
            'priority' => 'high',
            'icon' => 'fa-chart-line'
        ],
        [
            'id' => 4,
            'type' => 'security',
            'title' => 'Security Alert',
            'message' => 'Multiple failed login attempts detected from IP 192.168.1.100',
            'timestamp' => '2024-06-23 14:22:00',
            'read' => true,
            'priority' => 'high',
            'icon' => 'fa-shield-alt'
        ]
    ];
} elseif ($user_role === 'therapist') {
    $notifications = [
        [
            'id' => 1,
            'type' => 'appointment',
            'title' => 'New Appointment Request',
            'message' => 'Emily Rodriguez requested a session for June 30th at 2:00 PM',
            'timestamp' => '2024-06-25 11:30:00',
            'read' => false,
            'priority' => 'medium',
            'icon' => 'fa-calendar-plus'
        ],
        [
            'id' => 2,
            'type' => 'message',
            'title' => 'New Message from Patient',
            'message' => 'Michael Chen sent you a message about his progress',
            'timestamp' => '2024-06-25 09:15:00',
            'read' => false,
            'priority' => 'medium',
            'icon' => 'fa-envelope'
        ],
        [
            'id' => 3,
            'type' => 'reminder',
            'title' => 'Session Starting Soon',
            'message' => 'Session with Sarah Davis starts in 30 minutes',
            'timestamp' => '2024-06-25 13:30:00',
            'read' => true,
            'priority' => 'high',
            'icon' => 'fa-clock'
        ],
        [
            'id' => 4,
            'type' => 'assessment',
            'title' => 'Assessment Completed',
            'message' => 'David Thompson completed his weekly mood assessment',
            'timestamp' => '2024-06-24 18:45:00',
            'read' => true,
            'priority' => 'low',
            'icon' => 'fa-clipboard-check'
        ]
    ];
} else {
    $notifications = [
        [
            'id' => 1,
            'type' => 'appointment',
            'title' => 'Appointment Confirmed',
            'message' => 'Your session with Dr. Johnson on June 27th has been confirmed',
            'timestamp' => '2024-06-25 10:00:00',
            'read' => false,
            'priority' => 'medium',
            'icon' => 'fa-calendar-check'
        ],
        [
            'id' => 2,
            'type' => 'reminder',
            'title' => 'Mood Check-in Reminder',
            'message' => 'Don\'t forget to log your daily mood - it helps track your progress!',
            'timestamp' => '2024-06-25 09:00:00',
            'read' => false,
            'priority' => 'low',
            'icon' => 'fa-smile'
        ],
        [
            'id' => 3,
            'type' => 'message',
            'title' => 'New Message from Dr. Johnson',
            'message' => 'Your therapist sent you session notes and homework',
            'timestamp' => '2024-06-24 17:30:00',
            'read' => true,
            'priority' => 'medium',
            'icon' => 'fa-envelope'
        ],
        [
            'id' => 4,
            'type' => 'wellness',
            'title' => 'New Meditation Available',
            'message' => 'A new guided meditation for anxiety relief has been added',
            'timestamp' => '2024-06-24 12:00:00',
            'read' => true,
            'priority' => 'low',
            'icon' => 'fa-spa'
        ]
    ];
}

$unread_count = count(array_filter($notifications, fn($n) => !$n['read']));
?>
    
    <div class="">
        <div class="m-5 d-flex justify-content-between">
            <div class="page-info d-flex align-items-center">
               
                <div>
                    <h1 class="page-title">Notifications</h1>
                    <p class="page-subtitle">Stay updated with important alerts and messages</p>
                </div>
            </div>
            <div class="top-bar-actions">
                <button class="btn btn-outline-secondary" onclick="markAllRead()">
                    <i class="fas fa-check-double me-2"></i>Mark All Read
                </button>
                <button class="btn btn-luna-primary" data-bs-toggle="modal" data-bs-target="#notificationSettings">
                    <i class="fas fa-cog me-2"></i>Settings
                </button>
            </div>
        </div>
        
        <div class="container-fluid p-4">
            <!-- Notification Stats -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="stat-label">Total Notifications</p>
                                <h3 class="stat-number"><?php echo count($notifications); ?></h3>
                                <span class="stat-change positive">
                                    <i class="fas fa-bell"></i> All time
                                </span>
                            </div>
                            <div class="stat-icon icon-primary">
                                <i class="fas fa-bell"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="stat-label">Unread</p>
                                <h3 class="stat-number"><?php echo $unread_count; ?></h3>
                                <span class="stat-change <?php echo $unread_count > 0 ? 'warning' : 'positive'; ?>">
                                    <i class="fas fa-envelope"></i> Needs attention
                                </span>
                            </div>
                            <div class="stat-icon icon-warning">
                                <i class="fas fa-envelope-open"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="stat-label">High Priority</p>
                                <h3 class="stat-number"><?php echo count(array_filter($notifications, fn($n) => $n['priority'] === 'high')); ?></h3>
                                <span class="stat-change warning">
                                    <i class="fas fa-exclamation-triangle"></i> Important
                                </span>
                            </div>
                            <div class="stat-icon icon-danger">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="stat-label">Today</p>
                                <h3 class="stat-number"><?php echo count(array_filter($notifications, fn($n) => date('Y-m-d', strtotime($n['timestamp'])) === date('Y-m-d'))); ?></h3>
                                <span class="stat-change positive">
                                    <i class="fas fa-calendar-day"></i> Recent
                                </span>
                            </div>
                            <div class="stat-icon icon-success">
                                <i class="fas fa-calendar-day"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notifications List -->
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0">
                        <i class="fas fa-list text-primary me-2"></i>
                        All Notifications
                    </h5>
                    <div class="d-flex gap-2">
                        <select class="form-select" style="width: auto;" id="typeFilter">
                            <option value="">All Types</option>
                            <option value="appointment">Appointments</option>
                            <option value="message">Messages</option>
                            <option value="reminder">Reminders</option>
                            <option value="system">System</option>
                        </select>
                        <select class="form-select" style="width: auto;" id="priorityFilter">
                            <option value="">All Priority</option>
                            <option value="high">High</option>
                            <option value="medium">Medium</option>
                            <option value="low">Low</option>
                        </select>
                    </div>
                </div>

                <div class="notifications-list">
                    <?php foreach ($notifications as $notification): ?>
                    <div class="notification-item <?php echo !$notification['read'] ? 'unread' : ''; ?> priority-<?php echo $notification['priority']; ?>" 
                         data-type="<?php echo $notification['type']; ?>" 
                         data-priority="<?php echo $notification['priority']; ?>">
                        <div class="notification-icon">
                            <i class="fas <?php echo $notification['icon']; ?>"></i>
                        </div>
                        <div class="notification-content">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <h6 class="notification-title"><?php echo htmlspecialchars($notification['title']); ?></h6>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge priority-badge priority-<?php echo $notification['priority']; ?>">
                                        <?php echo ucfirst($notification['priority']); ?>
                                    </span>
                                    <small class="text-muted"><?php echo date('M j, g:i A', strtotime($notification['timestamp'])); ?></small>
                                </div>
                            </div>
                            <p class="notification-message"><?php echo htmlspecialchars($notification['message']); ?></p>
                            <div class="notification-actions">
                                <?php if (!$notification['read']): ?>
                                <button class="btn btn-sm btn-outline-primary" onclick="markAsRead(<?php echo $notification['id']; ?>)">
                                    <i class="fas fa-check me-1"></i>Mark Read
                                </button>
                                <?php endif; ?>
                                <button class="btn btn-sm btn-outline-secondary" onclick="viewDetails(<?php echo $notification['id']; ?>)">
                                    <i class="fas fa-eye me-1"></i>View
                                </button>
                                <button class="btn btn-sm btn-outline-danger" onclick="deleteNotification(<?php echo $notification['id']; ?>)">
                                    <i class="fas fa-trash me-1"></i>Delete
                                </button>
                            </div>
                        </div>
                        <?php if (!$notification['read']): ?>
                        <div class="unread-indicator"></div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Notification Settings Modal -->
    <div class="modal fade" id="notificationSettings" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Notification Settings</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="notificationSettingsForm">
                        <div class="mb-4">
                            <h6>Email Notifications</h6>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="emailAppointments" checked>
                                <label class="form-check-label" for="emailAppointments">
                                    Appointment reminders and confirmations
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="emailMessages" checked>
                                <label class="form-check-label" for="emailMessages">
                                    New messages from therapist/patients
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="emailSystem">
                                <label class="form-check-label" for="emailSystem">
                                    System updates and maintenance
                                </label>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h6>Push Notifications</h6>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="pushAppointments" checked>
                                <label class="form-check-label" for="pushAppointments">
                                    Appointment reminders (15 min before)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="pushMessages" checked>
                                <label class="form-check-label" for="pushMessages">
                                    Instant message notifications
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="pushReminders" checked>
                                <label class="form-check-label" for="pushReminders">
                                    Daily wellness reminders
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Quiet Hours</label>
                            <div class="row">
                                <div class="col-6">
                                    <label class="form-label small">From</label>
                                    <input type="time" class="form-control" value="22:00">
                                </div>
                                <div class="col-6">
                                    <label class="form-label small">To</label>
                                    <input type="time" class="form-control" value="08:00">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-luna-primary" onclick="saveSettings()">Save Settings</button>
                </div>
            </div>
        </div>
    </div>

    <?php include 'templates/footer.php'; ?>
    <script src="assets/js/simple-luna.js"></script>
    
    <script>
        function markAsRead(id) {
            const item = document.querySelector(`[data-id="${id}"]`);
            if (item) {
                item.classList.remove('unread');
                showToast('Notification marked as read', 'success');
            }
        }

        function markAllRead() {
            document.querySelectorAll('.notification-item.unread').forEach(item => {
                item.classList.remove('unread');
            });
            showToast('All notifications marked as read', 'success');
        }

        function viewDetails(id) {
            showToast(`Viewing notification details ${id}`, 'info');
        }

        function deleteNotification(id) {
            if (confirm('Are you sure you want to delete this notification?')) {
                showToast('Notification deleted', 'success');
            }
        }

        function saveSettings() {
            showToast('Notification settings saved', 'success');
            bootstrap.Modal.getInstance(document.getElementById('notificationSettings')).hide();
        }

        // Filter functionality
        document.getElementById('typeFilter').addEventListener('change', function() {
            filterNotifications();
        });

        document.getElementById('priorityFilter').addEventListener('change', function() {
            filterNotifications();
        });

        function filterNotifications() {
            const typeFilter = document.getElementById('typeFilter').value;
            const priorityFilter = document.getElementById('priorityFilter').value;
            const items = document.querySelectorAll('.notification-item');

            items.forEach(item => {
                const type = item.dataset.type;
                const priority = item.dataset.priority;
                
                const typeMatch = !typeFilter || type === typeFilter;
                const priorityMatch = !priorityFilter || priority === priorityFilter;
                
                if (typeMatch && priorityMatch) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        }
    </script>

    <style>
        .notifications-list {
            max-height: 600px;
            overflow-y: auto;
        }

        .notification-item {
            display: flex;
            align-items: flex-start;
            padding: 1.5rem;
            border: 1px solid #e9ecef;
            border-radius: 12px;
            margin-bottom: 1rem;
            position: relative;
            transition: all 0.3s ease;
        }

        .notification-item:hover {
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .notification-item.unread {
            background: rgba(6, 95, 70, 0.02);
            border-left: 4px solid var(--luna-primary);
        }

        .notification-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            font-size: 1.2rem;
            color: white;
        }

        .priority-high .notification-icon {
            background: var(--luna-danger);
        }

        .priority-medium .notification-icon {
            background: var(--luna-warning);
        }

        .priority-low .notification-icon {
            background: var(--luna-success);
        }

        .notification-content {
            flex: 1;
        }

        .notification-title {
            margin: 0;
            font-weight: 600;
            color: var(--luna-dark);
        }

        .notification-message {
            margin: 0.5rem 0;
            color: var(--luna-gray);
            line-height: 1.5;
        }

        .notification-actions {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            margin-top: 1rem;
        }

        .priority-badge {
            font-size: 0.7rem;
            padding: 2px 6px;
        }

        .priority-badge.priority-high {
            background: var(--luna-danger);
        }

        .priority-badge.priority-medium {
            background: var(--luna-warning);
        }

        .priority-badge.priority-low {
            background: var(--luna-success);
        }

        .unread-indicator {
            position: absolute;
            top: 1rem;
            right: 1rem;
            width: 8px;
            height: 8px;
            background: var(--luna-primary);
            border-radius: 50%;
        }
    </style>