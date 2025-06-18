<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Luna Health - Notes</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="#">
                <strong style="color: #A8C3A4;">Luna Health</strong>
            </a>
            
            <div class="d-flex align-items-center">
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                        <div class="profile-img me-2">
                            <img src="https://images.unsplash.com/photo-1559839734-2b71ea197ec2?w=40&h=40&fit=crop&crop=face" alt="Dr. Sarah Johnson" class="rounded-circle" width="40" height="40">
                        </div>
                        <div class="text-start">
                            <div class="fw-semibold text-dark">Dr. Sarah Johnson</div>
                            <small class="text-muted">Licensed Therapist</small>
                        </div>
                    </a>
                    <!--ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profile</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                    </ul-->
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid" style="margin-top: 76px;">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        
                        <li class="nav-item">
                            <a class="nav-link active" href="#">
                                <i class="fas fa-file-medical-alt me-2"></i>
                                Notes
                            </a>
                        </li>
                        
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Session Notes</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <button type="button" class="btn btn-primary me-2" onclick="saveNote()" style="background-color: #A8C3A4; border-color: #A8C3A4;">
                            <i class="fas fa-save me-1"></i>Save Note
                        </button>
                        <button type="button" class="btn btn-outline-secondary" onclick="newNote()">
                            <i class="fas fa-plus me-1"></i>New Note
                        </button>
                    </div>
                </div>

                <!-- Notes List and Editor -->
                <div class="row">
                    <!-- Notes List -->
                    <div class="col-lg-4 mb-4">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header bg-white py-3">
                                <h6 class="m-0 font-weight-bold" style="color: #A8C3A4;">Recent Notes</h6>
                            </div>
                            <div class="card-body p-0">
                                <div class="notes-list" id="notesList">
                                    <!-- Notes will be populated here -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Note Editor -->
                    <div class="col-lg-8 mb-4">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                                <div>
                                    <input type="text" class="form-control border-0 p-0 h5 mb-0 font-weight-bold" 
                                           id="noteTitle" placeholder="Note Title" style="background: transparent;">
                                </div>
                                <small class="text-muted" id="lastSaved">Never saved</small>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="clientName" class="form-label text-muted small">Client</label>
                                    <input type="text" class="form-control" id="clientName" placeholder="Client name">
                                </div>
                                <div class="mb-3">
                                    <label for="sessionDate" class="form-label text-muted small">Session Date</label>
                                    <input type="date" class="form-control" id="sessionDate">
                                </div>
                                <div class="mb-3">
                                    <label for="noteContent" class="form-label text-muted small">Notes</label>
                                    <textarea class="form-control" id="noteContent" rows="15" 
                                              placeholder="Start writing your session notes here..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Notes data storage
        let notes = [
            {
                id: 1,
                title: "Sarah M. - Anxiety Session",
                client: "Sarah M.",
                date: "2025-06-17",
                content: "Client showed significant improvement in managing anxiety symptoms. Discussed coping strategies and breathing techniques. Homework assigned: daily mindfulness practice.",
                lastModified: new Date('2025-06-17T10:30:00')
            },
            {
                id: 2,
                title: "John & Mary K. - Couples Session",
                client: "John & Mary K.",
                date: "2025-06-16",
                content: "Worked on communication patterns. Both partners engaged well in active listening exercises. Need to address conflict resolution strategies in next session.",
                lastModified: new Date('2025-06-16T14:30:00')
            },
            {
                id: 3,
                title: "Alex R. - Teen Session",
                client: "Alex R.",
                date: "2025-06-15",
                content: "Discussed academic pressure and time management. Client is receptive to organizational strategies. Parents to be involved in next session for support planning.",
                lastModified: new Date('2025-06-15T16:00:00')
            }
        ];

        let currentNoteId = null;
        let nextId = 4;

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            renderNotesList();
            setTodayDate();
        });

        function renderNotesList() {
            const notesList = document.getElementById('notesList');
            notesList.innerHTML = '';

            notes.sort((a, b) => new Date(b.lastModified) - new Date(a.lastModified));

            notes.forEach(note => {
                const noteItem = document.createElement('div');
                noteItem.className = `note-item p-3 border-bottom cursor-pointer ${currentNoteId === note.id ? 'active' : ''}`;
                noteItem.onclick = () => loadNote(note.id);
                
                noteItem.innerHTML = `
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h6 class="mb-1 text-truncate">${note.title}</h6>
                        <small class="text-muted">${formatDate(note.date)}</small>
                    </div>
                    <p class="mb-1 text-muted small text-truncate">${note.client}</p>
                    <p class="mb-0 text-muted small text-truncate">${note.content}</p>
                `;
                
                notesList.appendChild(noteItem);
            });
        }

        function loadNote(noteId) {
            const note = notes.find(n => n.id === noteId);
            if (!note) return;

            currentNoteId = noteId;
            
            document.getElementById('noteTitle').value = note.title;
            document.getElementById('clientName').value = note.client;
            document.getElementById('sessionDate').value = note.date;
            document.getElementById('noteContent').value = note.content;
            document.getElementById('lastSaved').textContent = `Last saved: ${formatDateTime(note.lastModified)}`;

            renderNotesList();
        }

        function saveNote() {
            const title = document.getElementById('noteTitle').value.trim();
            const client = document.getElementById('clientName').value.trim();
            const date = document.getElementById('sessionDate').value;
            const content = document.getElementById('noteContent').value.trim();

            if (!title || !content) {
                alert('Please enter a title and note content.');
                return;
            }

            const now = new Date();

            if (currentNoteId) {
                // Update existing note
                const noteIndex = notes.findIndex(n => n.id === currentNoteId);
                if (noteIndex !== -1) {
                    notes[noteIndex] = {
                        ...notes[noteIndex],
                        title,
                        client,
                        date,
                        content,
                        lastModified: now
                    };
                }
            } else {
                // Create new note
                const newNote = {
                    id: nextId++,
                    title,
                    client,
                    date,
                    content,
                    lastModified: now
                };
                notes.unshift(newNote);
                currentNoteId = newNote.id;
            }

            document.getElementById('lastSaved').textContent = `Last saved: ${formatDateTime(now)}`;
            renderNotesList();
            
            // Show save confirmation
            showSaveConfirmation();
        }

        function newNote() {
            currentNoteId = null;
            document.getElementById('noteTitle').value = '';
            document.getElementById('clientName').value = '';
            document.getElementById('sessionDate').value = new Date().toISOString().split('T')[0];
            document.getElementById('noteContent').value = '';
            document.getElementById('lastSaved').textContent = 'Never saved';
            
            renderNotesList();
            document.getElementById('noteTitle').focus();
        }

        function setTodayDate() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('sessionDate').value = today;
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
        }

        function formatDateTime(date) {
            return date.toLocaleString('en-US', { 
                month: 'short', 
                day: 'numeric', 
                hour: 'numeric', 
                minute: '2-digit',
                hour12: true 
            });
        }

        function showSaveConfirmation() {
            const button = document.querySelector('.btn-primary');
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-check me-1"></i>Saved';
            button.style.backgroundColor = '#28a745';
            button.style.borderColor = '#28a745';
            
            setTimeout(() => {
                button.innerHTML = originalText;
                button.style.backgroundColor = '#A8C3A4';
                button.style.borderColor = '#A8C3A4';
            }, 1500);
        }
    </script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F8F9FA;
        }

        .sidebar {
            min-height: calc(100vh - 76px);
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
        }

        .sidebar .nav-link {
            color: #6C757D;
            padding: 12px 16px;
            margin-bottom: 4px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .sidebar .nav-link:hover {
            color: #A8C3A4;
            background-color: rgba(168, 195, 164, 0.1);
        }

        .sidebar .nav-link.active {
            color: #A8C3A4;
            background-color: rgba(168, 195, 164, 0.15);
            font-weight: 600;
        }

        .card {
            border-radius: 12px;
        }

        .note-item {
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .note-item:hover {
            background-color: #F8F9FA;
        }

        .note-item.active {
            background-color: rgba(168, 195, 164, 0.1);
            border-left: 3px solid #A8C3A4 !important;
        }

        .note-item:last-child {
            border-bottom: none !important;
        }

        .notes-list {
            max-height: 600px;
            overflow-y: auto;
        }

        .form-control:focus {
            border-color: #A8C3A4;
            box-shadow: 0 0 0 0.2rem rgba(168, 195, 164, 0.25);
        }

        .btn-primary {
            background-color: #A8C3A4;
            border-color: #A8C3A4;
        }

        .btn-primary:hover {
            background-color: #96B391;
            border-color: #96B391;
        }

        .btn-outline-secondary {
            color: #6C757D;
            border-color: #6C757D;
        }

        .btn-outline-secondary:hover {
            background-color: #6C757D;
            border-color: #6C757D;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .text-truncate {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .font-weight-bold {
            font-weight: 700 !important;
        }

        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }
            
            main {
                margin-left: 0 !important;
            }
        }
    </style>
</body>
</html>