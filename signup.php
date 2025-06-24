<?php session_start(); 
$config = include './php/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Create Account - Luna</title>
  <link rel="shortcut icon" href="images/favicon.ico" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href='https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700' rel='stylesheet'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
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

    .login-container {
      background: #fff;
      padding: 2.5rem;
      border-radius: var(--border-radius);
      box-shadow: var(--box-shadow);
      width: 100%;
      max-width: 420px;
      transition: var(--transition);
      border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .login-container:hover {
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
    }

    .login-header {
      text-align: center;
      margin-bottom: 1.5rem;
    }

    .login-header img {
      max-width: 150px;
      margin-bottom: 1rem;
    }

    .login-header h3 {
      font-weight: 600;
      color: var(--dark-text);
      margin-bottom: 0.25rem;
      font-size: 1.5rem;
    }

    .login-header p {
      color: var(--light-text);
      font-size: 0.9rem;
    }

    .form-floating {
      margin-bottom: 1rem;
    }

    .form-control {
      border-radius: var(--border-radius);
      padding: 1rem;
      font-size: 0.95rem;
      border: 1px solid #e2e8f0;
      transition: var(--transition);
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
    }

    .btn-primary:hover {
      background-color: var(--primary-hover);
      transform: translateY(-2px);
      box-shadow: 0 6px 10px rgba(74, 111, 165, 0.3);
    }

    .divider {
      display: flex;
      align-items: center;
      margin: 1.5rem 0;
      color: var(--light-text);
      font-size: 0.8rem;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .divider::before,
    .divider::after {
      content: "";
      flex: 1;
      border-bottom: 1px solid #e2e8f0;
    }

    .divider::before {
      margin-right: 0.75rem;
    }

    .divider::after {
      margin-left: 0.75rem;
    }

    .login-footer {
      text-align: center;
      margin-top: 1.5rem;
      font-size: 0.9rem;
    }

    .login-footer a {
      color: var(--primary-color);
      font-weight: 500;
      text-decoration: none;
      transition: var(--transition);
    }

    .login-footer a:hover {
      text-decoration: underline;
    }

    /* Google Sign-In Button */
    .google-auth-container {
      display: flex;
      justify-content: center;
      margin-bottom: 1rem;
    }

    .g_id_signin {
      width: 100% !important;
      max-width: 300px;
      margin: 0 auto;
      border-radius: var(--border-radius) !important;
    }

    /* Password validation */
    .password-feedback {
      font-size: 0.8rem;
      color: var(--light-text);
      margin-top: 0.25rem;
      display: flex;
      align-items: center;
    }

    .password-feedback i {
      margin-right: 0.5rem;
      font-size: 0.7rem;
    }

    .password-feedback.valid {
      color: #28a745;
    }

    .password-feedback.invalid {
      color: #dc3545;
    }

    /* Alert styling */
    .alert {
      border-radius: var(--border-radius);
      margin-bottom: 1.5rem;
      border: none;
      font-size: 0.9rem;
      padding: 0.75rem 1.25rem;
    }

    @media (max-width: 576px) {
      .login-container {
        padding: 1.75rem;
        margin: 0 1rem;
      }
      
      .login-header img {
        max-width: 120px;
      }
    }
  </style>
</head>
<body>

<div class="login-container">
  <div class="login-header">
    <img src="images/logo.png" alt="Luna Logo">
    <h3>Create Account</h3>
    <p>Join our community today</p>
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

  <form action="php/auth.inc.php" method="POST" id="signupForm">
    <div class="form-floating mb-3">
      <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
      <label for="email">Email Address</label>
    </div>

    <div class="form-floating mb-3 position-relative">
      <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
      <label for="password">Password</label>
      <i class="fas fa-eye password-toggle" id="togglePassword"></i>
      <div class="password-feedback" id="lengthFeedback">
        <i class="fas fa-circle"></i> At least 8 characters
      </div>
    </div>

    <div class="form-floating mb-3 position-relative">
      <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required>
      <label for="confirmPassword">Confirm Password</label>
      <i class="fas fa-eye password-toggle"></i>
      <div class="password-feedback invalid" id="matchFeedback" style="display: none;">
        <i class="fas fa-exclamation-circle"></i> Passwords do not match
      </div>
    </div>

    <button type="submit" class="btn btn-primary w-100 mb-3" name="create_account">Sign Up</button>

    <div class="divider">or continue with</div>

    <div class="google-auth-container">
      <div id="g_id_onload"
          data-client_id="<?php echo htmlspecialchars($config['google_client_id']); ?>"
          data-context="signup"
          data-ux_mode="popup"
          data-callback="handleCredentialResponse"
          data-auto_prompt="false">
      </div>
      <div class="g_id_signin"
          data-type="standard"
          data-shape="rectangular"
          data-theme="filled_blue"
          data-text="signup_with"
          data-size="large"
          data-width="300">
      </div>
    </div>

    <div class="login-footer">
      Already have an account? <a href="login.php">Sign In</a>
    </div>
  </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://accounts.google.com/gsi/client" async defer></script>
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

  // Password validation
  const passwordInput = document.getElementById('password');
  const confirmPasswordInput = document.getElementById('confirmPassword');
  const lengthFeedback = document.getElementById('lengthFeedback');
  const matchFeedback = document.getElementById('matchFeedback');

  passwordInput.addEventListener('input', function() {
    if (this.value.length >= 8) {
      lengthFeedback.classList.add('valid');
      lengthFeedback.innerHTML = '<i class="fas fa-check-circle"></i> At least 8 characters';
    } else {
      lengthFeedback.classList.remove('valid');
      lengthFeedback.innerHTML = '<i class="fas fa-circle"></i> At least 8 characters';
    }
    
    checkPasswordMatch();
  });

  confirmPasswordInput.addEventListener('input', checkPasswordMatch);

  function checkPasswordMatch() {
    if (confirmPasswordInput.value.length > 0 && passwordInput.value !== confirmPasswordInput.value) {
      matchFeedback.style.display = 'block';
    } else {
      matchFeedback.style.display = 'none';
    }
  }

  // Form validation
  document.getElementById('signupForm').addEventListener('submit', function(e) {
    if (passwordInput.value !== confirmPasswordInput.value) {
      e.preventDefault();
      matchFeedback.style.display = 'block';
      confirmPasswordInput.focus();
    }
  });

  function handleCredentialResponse(response) {
    const idToken = response.credential;
    
    fetch('php/google_auth_handler.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: 'credential=' + encodeURIComponent(idToken)
    })
    .then(response => {
      if (response.redirected) {
        window.location.href = response.url;
      } else {
        return response.text();
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert('Sign up failed. Please try again.');
    });
  }
</script>
</body>
</html>