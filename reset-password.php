<!-- reset-password.php -->
<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Luna - Generate Password</title>
    <link rel="shortcut icon" href="images/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    :root {
        --primary-color: #9dc297;
        --primary-hover: #A8C3A4;
        --light-gray: #f8f9fa;
        --border-radius: 8px;
        --text-color: #333;
        --text-muted: #6c757d;
        --link-color: #5a6e5a;
        --link-hover: #4a5c4a;
    }
    
    body {
        background-color: var(--light-gray);
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        font-family: 'Montserrat', sans-serif;
        color: var(--text-color);
        line-height: 1.6;
    }
    
    .login-container {
        background: #fff;
        padding: 2.5rem;
        border-radius: var(--border-radius);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        width: 100%;
        max-width: 420px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .login-container:hover {
        box-shadow: 0 6px 20px rgba(0,0,0,0.12);
    }

    .toggle-password {
      position: absolute;
      top: 50%;
      right: 1rem;
      transform: translateY(-50%);
      cursor: pointer;
      color: grey;
      z-index: 10;
    }
    
    .login-container h5 {
        font-weight: 700;
        color: var(--text-color);
        margin-bottom: 1.5rem;
    }
    
    .btn-login {
        background-color: var(--primary-color);
        color: #fff;
        border: none;
        padding: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }
    
    .btn-login:hover {
        background-color: var(--primary-hover);
        transform: translateY(-2px);
    }
    
    .form-control {
        border-radius: var(--border-radius);
        padding: 1rem;
        border: 1px solid #dee2e6;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }
    
    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.25rem rgba(157, 194, 151, 0.25);
    }
    
    .form-floating label {
        color: var(--text-muted);
        padding: 1rem 0.75rem;
    }
    
    .divider {
        display: flex;
        align-items: center;
        margin: 1.5rem 0;
        color: var(--text-muted);
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .divider::before,
    .divider::after {
        content: "";
        flex: 1;
        border-bottom: 1px solid #dee2e6;
    }
    
    .divider::before {
        margin-right: 0.75rem;
    }
    
    .divider::after {
        margin-left: 0.75rem;
    }
    
    .login-extras {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        margin-top: 1.5rem;
        text-align: center;
    }
    
    .login-extras a {
        color: var(--link-color);
        text-decoration: none;
        transition: color 0.3s ease;
        font-size: 0.9rem;
    }
    
    .login-extras a:hover {
        color: var(--link-hover);
        text-decoration: underline;
    }
    
    .login-extras i {
        margin-right: 0.5rem;
    }
    
    .alert {
        border-radius: var(--border-radius);
        margin-bottom: 1.5rem;
    }
    
    @media (max-width: 576px) {
        .login-container {
            padding: 1.75rem;
            margin: 0 1rem;
        }
        
        body {
            padding: 1rem;
        }
    }
</style>
</head>
<body>

<div class="login-container">
    <div class="text-center mb-4">
        <img src="images/logo.png" alt="Luna Logo" class="img-fluid" style="max-width: 150px;">
        <h5 class="mt-3">Reset Password</h5>
    </div>

    <!-- Show messages -->
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger text-center"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php elseif (isset($_SESSION['success'])): ?>
        <div class="alert alert-success text-center"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <form action="php/auth.inc.php" method="POST">
        <div class="form-floating mb-3 position-relative">
            <input type="password" class="form-control password-input" id="password" name="password" placeholder="New Password" required>
            <label for="password">New Password</label>
            <i class="fa fa-eye toggle-password"></i>
        </div>

        <div class="form-floating mb-3 position-relative">
            <input type="password" class="form-control password-input" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required>
            <label for="confirmPassword">Confirm Password</label>
            <i class="fa fa-eye toggle-password"></i>
        </div>

        <button type="submit" class="btn btn-login w-100" name="reset_pwd">Reset Password</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.querySelectorAll('.toggle-password').forEach(icon => {
    icon.addEventListener('click', function () {
      const input = this.closest('.form-floating').querySelector('input');
      const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
      input.setAttribute('type', type);
      this.classList.toggle('fa-eye');
      this.classList.toggle('fa-eye-slash');
    });
  });
</script>
</body>
</html>
