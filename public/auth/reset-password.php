<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Luna - Reset Password</title>
    <link rel="shortcut icon" href="images/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-color: #4a6fa5;
            --primary-hover: #3a5a8f;
            --secondary-color: #6c757d;
            --light-bg: #f8fafc;
            --dark-text: #2d3748;
            --light-text: #718096;
            --border-radius: 12px;
            --box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }
        
        body {
            background-color: var(--light-bg);
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-image: radial-gradient(circle at 10% 20%, rgba(234, 249, 251, 0.8) 0%, rgba(239, 246, 253, 0.8) 90%);
        }
        
        .reset-container {
            background: #fff;
            padding: 2.5rem;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            width: 100%;
            max-width: 420px;
            transition: var(--transition);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .reset-container:hover {
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
        }
        
        .reset-header {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        
        .reset-header img {
            max-width: 150px;
            height: auto;
            margin-bottom: 1rem;
        }
        
        .reset-header h3 {
            font-weight: 600;
            color: var(--dark-text);
            margin-bottom: 0.5rem;
            font-size: 1.5rem;
        }
        
        .form-floating {
            position: relative;
            margin-bottom: 1.5rem;
        }
        
        .form-control {
            border-radius: var(--border-radius);
            padding: 1rem;
            border: 1px solid #e2e8f0;
            transition: var(--transition);
            font-size: 0.95rem;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(74, 111, 165, 0.15);
        }
        
        .password-toggle {
            position: absolute;
            top: 50%;
            right: 1rem;
            transform: translateY(-50%);
            cursor: pointer;
            color: var(--light-text);
            z-index: 5;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 0.85rem;
            font-weight: 500;
            border-radius: var(--border-radius);
            transition: var(--transition);
            box-shadow: 0 4px 6px rgba(74, 111, 165, 0.2);
            width: 100%;
        }
        
        .btn-primary:hover {
            background-color: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 10px rgba(74, 111, 165, 0.3);
        }
        
        .alert {
            border-radius: var(--border-radius);
            margin-bottom: 1.5rem;
            border: none;
            font-size: 0.9rem;
        }
        
        .password-strength {
            height: 3px;
            background: #e9ecef;
            margin-top: 0.25rem;
            border-radius: 2px;
            overflow: hidden;
        }
        
        .password-strength-bar {
            height: 100%;
            width: 0;
            transition: width 0.3s ease;
        }
        
        .password-match-feedback {
            display: none;
            font-size: 0.8rem;
            color: #dc3545;
            margin-top: 0.25rem;
        }
        
        @media (max-width: 576px) {
            .reset-container {
                padding: 1.75rem;
                margin: 0 1rem;
            }
            
            .reset-header img {
                max-width: 120px;
            }
        }
    </style>
</head>
<body>

<div class="reset-container">
    <div class="reset-header">
        <img src="images/logo.png" alt="Luna Logo">
        <h3>Reset Your Password</h3>
    </div>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php elseif (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <form action="php/auth.inc.php" method="POST" id="resetForm">
        <input type="hidden" name="token" value="<?= htmlspecialchars($_GET['token'] ?? '') ?>">
        
        <div class="form-floating mb-3 position-relative">
            <input type="password" class="form-control" id="password" name="password" placeholder="New Password" required>
            <label for="password">New Password</label>
            <i class="fas fa-eye password-toggle"></i>
            <div class="password-strength">
                <div class="password-strength-bar" id="passwordStrengthBar"></div>
            </div>
        </div>

        <div class="form-floating mb-3 position-relative">
            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required>
            <label for="confirmPassword">Confirm Password</label>
            <i class="fas fa-eye password-toggle"></i>
            <div class="password-match-feedback" id="passwordMatchFeedback">
                <i class="fas fa-exclamation-circle me-1"></i>Passwords do not match
            </div>
        </div>

        <button type="submit" class="btn btn-primary mb-3" name="reset_pwd">Reset Password</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Password visibility toggle
    document.querySelectorAll('.password-toggle').forEach(icon => {
        icon.addEventListener('click', function() {
            const input = this.closest('.form-floating').querySelector('input');
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    });

    // Password strength indicator
    document.getElementById('password').addEventListener('input', function() {
        const password = this.value;
        const strengthBar = document.getElementById('passwordStrengthBar');
        let strength = 0;
        
        if (password.length > 0) strength += 20;
        if (password.length >= 8) strength += 20;
        if (/\d/.test(password)) strength += 20;
        if (/[A-Z]/.test(password)) strength += 20;
        if (/[^A-Za-z0-9]/.test(password)) strength += 20;
        
        strengthBar.style.width = strength + '%';
        
        if (strength < 40) {
            strengthBar.style.backgroundColor = '#dc3545';
        } else if (strength < 70) {
            strengthBar.style.backgroundColor = '#ffc107';
        } else {
            strengthBar.style.backgroundColor = '#28a745';
        }
    });

    // Password match validation
    document.getElementById('confirmPassword').addEventListener('input', function() {
        const password = document.getElementById('password').value;
        const confirmPassword = this.value;
        const feedback = document.getElementById('passwordMatchFeedback');
        
        if (confirmPassword.length > 0 && password !== confirmPassword) {
            feedback.style.display = 'block';
        } else {
            feedback.style.display = 'none';
        }
    });

    // Form validation
    document.getElementById('resetForm').addEventListener('submit', function(e) {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirmPassword').value;
        
        if (password !== confirmPassword) {
            e.preventDefault();
            document.getElementById('passwordMatchFeedback').style.display = 'block';
            document.getElementById('confirmPassword').focus();
        }
    });
</script>
</body>
</html>