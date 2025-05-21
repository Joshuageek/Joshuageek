<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Create Account</title>
  <link rel="shortcut icon" href="images/favicon.ico" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Montserrat', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      padding: 1rem;
    }

    .login-container {
      background: #fff;
      padding: 2rem;
      border-radius: 8px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 420px;
    }

    .form-floating {
      position: relative;
    }

    .form-control:focus {
      border-color: #c5e5c2 !important;
      box-shadow: 0 0 0 0.25rem rgba(157, 194, 151, 0.25);
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

    .btn-signup {
      background-color: #9dc297;
      color: white;
      font-weight: bold;
      border: none;
    }

    .btn-signup:hover {
        background-color: #A8C3A4;
    }

    .btn-login {
      border: none;
      color:#A8C3A4;
      text-decoration: none;
    }

    .btn-login:hover {
       text-decoration: underline;
    }

    .google-btn {
      margin-top: 10px;
      background: white;
      border: 1px solid #ccc;
      border-radius: 5px;
      padding: 8px;
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 8px;
      font-weight: 600;
    }

    .google-btn:hover {
      background: #f0f0f0;
    }
  </style>
</head>
<body>

<div class="login-container">
  <div class="text-center mb-4">
    <img src="images/logo.png" alt="Luna Logo" class="img-fluid" style="max-width: 150px;">
    <h5 class="mt-3">Sign Up</h5>
  </div>

  <?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger text-center" aria-label="Close"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
  <?php elseif (isset($_SESSION['success'])): ?>
    <div class="alert alert-success text-center" aria-label="Close"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
  <?php endif; ?>

  <form action="php/auth.inc.php" method="POST">
    <div class="form-floating mb-3">
      <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
      <label for="email">Email Address</label>
    </div>

    <div class="form-floating mb-3 position-relative">
      <input type="password" class="form-control password-input" id="password" name="password" placeholder="Password" required>
      <label for="password">Password</label>
      <i class="fa fa-eye toggle-password"></i>
    </div>

    <div class="form-floating mb-3 position-relative">
      <input type="password" class="form-control password-input" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required>
      <label for="confirmPassword">Confirm Password</label>
      <i class="fa fa-eye toggle-password"></i>
    </div>

    <button type="submit" class="btn btn-signup w-100" name="create_account">Sign Up</button>

    <div class="text-center my-3">or</div>

    <!-- Google Auth Button -->
    <div id="g_id_onload"
         data-client_id="YOUR_GOOGLE_CLIENT_ID"
         data-context="signup"
         data-ux_mode="redirect"
         data-login_uri="php/google_auth_handler.php"
         data-auto_prompt="false">
    </div>

    <div class="g_id_signin"
         data-type="standard"
         data-shape="rectangular"
         data-theme="outline"
         data-text="signup_with"
         data-size="large"
         data-logo_alignment="left">
    </div>

    <div class="text-center mt-3">
      <span style="font-weight: 600; color: grey">Already have an account?</span>
      <a href="login.php" class="d-block mt-2 btn-login"><i class="fas fa-user me-1"></i>Login</a>
    </div>
  </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://accounts.google.com/gsi/client" async defer></script>
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
