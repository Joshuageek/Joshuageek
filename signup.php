<?php session_start(); 
$config = include './php/config.php';
?>
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
      color: var(--link-color);
      text-decoration: none;
    }

    .btn-login:hover {
       text-decoration: underline;
       color: var(--link-hover);
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

     <div style="display: flex; justify-content: center; margin-bottom: 1rem;">
        <div id="g_id_onload"
            data-client_id="<?php echo htmlspecialchars($config['google_client_id']);?>"
            data-context="signup"
            data-ux_mode="popup"
            data-callback="handleCredentialResponse"
            data-auto_prompt="false">
        </div>

        <div class="g_id_signin"
            data-type="standard"
            data-shape="rectangular"
            data-theme="outline"
            data-text="signup_with"
            data-size="large"
            data-logo_alignment="right">
        </div>
    </div>

    <div class="text-center d-flex alighn-items-center justify-content-center mt-3 gap-2">
      <span style="font-weight: 600; color: grey">With account?</span>
      <span><a href="login.php" class="d-block btn-login"><i class="fas fa-user me-1"></i>Login</a></span>
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

  function handleCredentialResponse(response) {
    const idToken = response.credential;

    // Send the ID token to your server via POST
    fetch('php/google_auth_handler.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'credential=' + encodeURIComponent(idToken)
    })
    .then(res => {
        if (res.redirected) {
            window.location.href = res.url; // Redirect to question or index page
        } else {
            return res.text(); // For debugging or error display
        }
    })
    .catch(err => {
        console.error('Login error:', err);
        alert('Login failed. Please try again.');
    });
}
</script>

</body>
</html>
