<?php
session_start();
require_once 'includes/auth.php';

if (!isLoggedIn()) {
    header('Location: ../login.php');
    exit();
}

$user_role = getUserRole();
$user_name = $_SESSION['user_name'] ?? 'User';

// Sample messages based on user role
$conversations = [
    [
        'id' => 1,
        'name' => 'Dr. Sarah Johnson',
        'role' => 'therapist',
        'last_message' => 'How are you feeling about our last session?',
        'timestamp' => '2024-06-25 10:30:00',
        'unread' => true,
        'avatar' => 'SJ'
    ],
    [
        'id' => 2,
        'name' => 'Emily Rodriguez',
        'role' => 'patient',
        'last_message' => 'Thank you for the session notes!',
        'timestamp' => '2024-06-24 16:45:00',
        'unread' => false,
        'avatar' => 'ER'
    ],
    [
        'id' => 3,
        'name' => 'System Admin',
        'role' => 'admin',
        'last_message' => 'System maintenance scheduled for tonight',
        'timestamp' => '2024-06-24 09:15:00',
        'unread' => true,
        'avatar' => 'SA'
    ]
];

$current_messages = [
    [
        'sender' => 'Dr. Sarah Johnson',
        'message' => 'Hi! How are you feeling today?',
        'timestamp' => '2024-06-25 10:00:00',
        'is_me' => false
    ],
    [
        'sender' => 'You',
        'message' => 'I\'m doing better, thank you for asking.',
        'timestamp' => '2024-06-25 10:15:00',
        'is_me' => true
    ],
    [
        'sender' => 'Dr. Sarah Johnson',
        'message' => 'That\'s great to hear! How are you feeling about our last session?',
        'timestamp' => '2024-06-25 10:30:00',
        'is_me' => false
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'templates/header.php'; ?>
<body>
    <?php include 'templates/sidebar.php'; ?>
    
    <div class="main-content">
        <div class="top-bar">
            <div class="page-info d-flex align-items-center">
                <button class="btn me-3" id="sidebarToggle" style="background: var(--luna-primary); color: white; border-radius: 8px;">
                    <i class="fas fa-bars"></i>
                </button>
                <div>
                    <h1 class="page-title">Messages</h1>
                    <p class="page-subtitle">Secure communication with your care team</p>
                </div>
            </div>
        </div>
        
        <div class="container-fluid p-4">
            <div class="row">
                <!-- Conversations List -->
                <div class="col-lg-4">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0">Conversations</h6>
                            <button class="btn btn-sm btn-luna-primary">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        
                        <div class="search-box mb-3">
                            <i class="fas fa-search"></i>
                            <input type="text" placeholder="Search conversations..." class="form-control">
                        </div>

                        <div class="conversations-list">
                            <?php foreach ($conversations as $conv): ?>
                            <div class="conversation-item <?php echo $conv['unread'] ? 'unread' : ''; ?>" onclick="openConversation(<?php echo $conv['id']; ?>)">
                                <div class="d-flex align-items-center">
                                    <div class="user-avatar me-3">
                                        <?php echo $conv['avatar']; ?>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <h6 class="mb-0"><?php echo htmlspecialchars($conv['name']); ?></h6>
                                            <small class="text-muted"><?php echo date('g:i A', strtotime($conv['timestamp'])); ?></small>
                                        </div>
                                        <p class="mb-0 text-muted small"><?php echo htmlspecialchars($conv['last_message']); ?></p>
                                        <small class="text-muted"><?php echo ucfirst($conv['role']); ?></small>
                                    </div>
                                    <?php if ($conv['unread']): ?>
                                    <div class="unread-indicator"></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Chat Area -->
                <div class="col-lg-8">
                    <div class="stat-card chat-container">
                        <div class="chat-header">
                            <div class="d-flex align-items-center">
                                <div class="user-avatar me-3">SJ</div>
                                <div>
                                    <h6 class="mb-0">Dr. Sarah Johnson</h6>
                                    <small class="text-success">
                                        <i class="fas fa-circle"></i> Online
                                    </small>
                                </div>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-video me-2"></i>Video Call</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-phone me-2"></i>Voice Call</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-archive me-2"></i>Archive</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="chat-messages" id="chatMessages">
                            <?php foreach ($current_messages as $msg): ?>
                            <div class="message <?php echo $msg['is_me'] ? 'message-sent' : 'message-received'; ?>">
                                <div class="message-content">
                                    <?php echo htmlspecialchars($msg['message']); ?>
                                </div>
                                <div class="message-time">
                                    <?php echo date('g:i A', strtotime($msg['timestamp'])); ?>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="chat-input">
                            <div class="input-group">
                                <button class="btn btn-outline-secondary" type="button">
                                    <i class="fas fa-paperclip"></i>
                                </button>
                                <input type="text" class="form-control" placeholder="Type your message..." id="messageInput">
                                <button class="btn btn-luna-primary" type="button" onclick="sendMessage()">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'templates/footer.php'; ?>
    <script src="assets/js/simple-luna.js"></script>
    
    <script>
        function openConversation(id) {
            showToast(`Opening conversation ${id}`, 'info');
            // Remove unread indicators
            document.querySelectorAll('.conversation-item').forEach(item => {
                item.classList.remove('unread');
            });
        }

        function sendMessage() {
            const input = document.getElementById('messageInput');
            const message = input.value.trim();
            
            if (message) {
                const messagesContainer = document.getElementById('chatMessages');
                const messageDiv = document.createElement('div');
                messageDiv.className = 'message message-sent';
                messageDiv.innerHTML = `
                    <div class="message-content">${message}</div>
                    <div class="message-time">${new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</div>
                `;
                messagesContainer.appendChild(messageDiv);
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
                input.value = '';
            }
        }

        document.getElementById('messageInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });
    </script>

    <style>
        .conversations-list {
            max-height: 500px;
            overflow-y: auto;
        }

        .conversation-item {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 0.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .conversation-item:hover {
            background: var(--luna-light);
        }

        .conversation-item.unread {
            background: rgba(6, 95, 70, 0.05);
            border-left: 3px solid var(--luna-primary);
        }

        .unread-indicator {
            width: 8px;
            height: 8px;
            background: var(--luna-primary);
            border-radius: 50%;
        }

        .chat-container {
            height: 600px;
            display: flex;
            flex-direction: column;
        }

        .chat-header {
            padding: 1rem;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            justify-content: between;
            align-items: center;
        }

        .chat-messages {
            flex: 1;
            padding: 1rem;
            overflow-y: auto;
            background: #f8f9fa;
        }

        .message {
            margin-bottom: 1rem;
            display: flex;
            flex-direction: column;
        }

        .message-sent {
            align-items: flex-end;
        }

        .message-received {
            align-items: flex-start;
        }

        .message-content {
            max-width: 70%;
            padding: 0.75rem 1rem;
            border-radius: 18px;
            word-wrap: break-word;
        }

        .message-sent .message-content {
            background: var(--luna-primary);
            color: white;
        }

        .message-received .message-content {
            background: white;
            border: 1px solid #e9ecef;
        }

        .message-time {
            font-size: 0.75rem;
            color: #6c757d;
            margin-top: 0.25rem;
        }

        .chat-input {
            padding: 1rem;
            border-top: 1px solid #e9ecef;
        }
    </style>
</body>
</html>
