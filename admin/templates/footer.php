<!-- Professional Footer -->

<footer class="bg-white border-top py-4 mt-5">
    <div class="container-fluid px-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="d-flex align-items-center">
                    <div class="bg-luna-primary rounded-2 p-2 me-3">
                        <i class="fas fa-moon text-white"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 text-luna-primary fw-bold">Luna Mental Wellness</h6>
                        <small class="text-muted">&copy; <?php echo date('Y'); ?> All rights reserved. Professional therapy platform.</small>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-md-end align-items-center gap-4">
                    <div class="d-flex align-items-center gap-2">
                        <div class="bg-success rounded-circle" style="width: 8px; height: 8px;"></div>
                        <small class="text-muted">System Status: <span class="text-success fw-semibold">Online</span></small>
                    </div>
                    <small class="text-muted">Version 2.1.0</small>
                    <div class="d-flex gap-2">
                        <a href="help.php" class="text-decoration-none text-muted small">Help</a>
                        <span class="text-muted">•</span>
                        <a href="privacy.php" class="text-decoration-none text-muted small">Privacy</a>
                        <span class="text-muted">•</span>
                        <a href="terms.php" class="text-decoration-none text-muted small">Terms</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
</div>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- custome js -->
<script src="assets/js/admin-script.js"></script>
    <script>
        // Avatar upload preview
        document.getElementById('avatarUpload')?.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    showToast('Avatar uploaded successfully!', 'success');
                };
                reader.readAsDataURL(file);
            }
        });

        function showToast(message, type) {
            let toast = document.createElement('div');
            toast.className = `simple-toast ${type ? 'toast-' + type : ''} show`;
            toast.innerHTML = `
                <i class="fas fa-${type === 'error' ? 'times-circle' : type === 'success' ? 'check-circle' : 'info-circle'} me-2"></i>
                ${message}
                <button class="toast-close" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>
            `;
            document.body.appendChild(toast);
            setTimeout(() => toast.classList.add('show'), 100);
            setTimeout(() => toast.classList.remove('show'), 3000);
        }

        // Form submissions
        document.querySelector('#editProfileForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            showToast('Profile updated successfully!', 'success');
            bootstrap.Modal.getInstance(document.getElementById('editProfileModal')).hide();
        });
        document.querySelector('#changePasswordForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            showToast('Password changed successfully!', 'success');
            bootstrap.Modal.getInstance(document.getElementById('changePasswordModal')).hide();
        });
    </script>

</body>
</html>
