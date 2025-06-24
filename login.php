<?php
session_start();
$config = include './php/config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Luna - Login</title>
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
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
            color: var(--dark-text);
            line-height: 1.6;
            background-image: radial-gradient(circle at 10% 20%, rgba(234, 249, 251, 0.8) 0%, rgba(239, 246, 253, 0.8) 90%);
        }
        
        .login-container {
            background: #fff;
            padding: 3rem;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            width: 100%;
            max-width: 460px;
            transition: var(--transition);
            border: 1px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
        }
        
        .login-container:hover {
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
            transform: translateY(-2px);
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }
        
        .login-header img {
            max-width: 180px;
            height: auto;
            margin-bottom: 1.5rem;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
        }
        
        .login-header h3 {
            font-weight: 600;
            color: var(--dark-text);
            margin-bottom: 0.5rem;
            font-size: 1.75rem;
        }
        
        .login-header p {
            color: var(--light-text);
            font-size: 0.95rem;
        }
        
        .btn-login {
            background-color: var(--primary-color);
            color: #fff;
            border: none;
            padding: 0.85rem;
            font-weight: 500;
            letter-spacing: 0.5px;
            transition: var(--transition);
            border-radius: var(--border-radius);
            text-transform: uppercase;
            font-size: 0.9rem;
            box-shadow: 0 4px 6px rgba(74, 111, 165, 0.2);
        }
        
        .btn-login:hover {
            background-color: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 10px rgba(74, 111, 165, 0.3);
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
        
        .form-floating label {
            color: var(--light-text);
            padding: 1rem 0.75rem;
            font-size: 0.9rem;
        }
        
        .form-floating>.form-control:focus~label,
        .form-floating>.form-control:not(:placeholder-shown)~label {
            transform: scale(0.85) translateY(-1.5rem) translateX(0.15rem);
            color: var(--primary-color);
        }
        
        .input-group-text {
            background-color: transparent;
            border-right: none;
            color: var(--light-text);
        }
        
        .input-group .form-control {
            border-left: none;
        }
        
        .divider {
            display: flex;
            align-items: center;
            margin: 2rem 0;
            color: var(--light-text);
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 500;
        }
        
        .divider::before,
        .divider::after {
            content: "";
            flex: 1;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .divider::before {
            margin-right: 1rem;
        }
        
        .divider::after {
            margin-left: 1rem;
        }
        
        .login-footer {
            display: flex;
            justify-content: space-between;
            margin-top: 2rem;
            text-align: center;
        }
        
        .login-footer a {
            color: var(--secondary-color);
            text-decoration: none;
            transition: var(--transition);
            font-size: 0.9rem;
            font-weight: 500;
        }
        
        .login-footer a:hover {
            color: var(--primary-color);
            text-decoration: none;
        }
        
        .login-footer i {
            margin-right: 0.5rem;
            font-size: 0.8rem;
        }
        
        .alert {
            border-radius: var(--border-radius);
            margin-bottom: 1.5rem;
            border: none;
            font-size: 0.9rem;
        }

        .google-btn {
            width: 100%;
            background-color: #fff;
            color: #5f6368;
            padding: 0.75rem;
            border: 1px solid #e0e0e0;
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: var(--transition);
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .google-btn:hover {
            background-color: #f7f7f7;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.08);
        }
        
        .google-icon {
            width: 20px;
            height: 20px;
            margin-right: 12px;
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
        
        @media (max-width: 576px) {
            .login-container {
                padding: 2rem 1.5rem;
                margin: 0 1rem;
            }
            
            body {
                padding: 1rem;
            }
            
            .login-header img {
                max-width: 140px;
            }
            
            .login-header h3 {
                font-size: 1.5rem;
            }
            
            .login-footer {
                flex-direction: column;
                gap: 1rem;
            }
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="login-header">
        <img src="images/logo.png" alt="Luna Logo">
        <h3>Welcome Back</h3>
        <p>Sign in to access your account</p>
    </div>

    <!-- Show messages -->
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

    <form action="php/auth.inc.php" method="POST">
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="email" name="email" placeholder="Email" required>
            <label for="email">Email Address</label>
        </div>

        <div class="form-floating mb-3 position-relative">
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
            <label for="password">Password</label>
            <i class="fas fa-eye password-toggle" id="togglePassword"></i>
        </div>

        <div class="d-grid mb-3">
            <button type="submit" class="btn btn-login" name="login_btn">Sign In</button>
        </div>

        <div class="divider">or continue with</div>

        <div class="mb-3">
            <div id="g_id_onload"
                data-client_id="<?php echo htmlspecialchars($config['google_client_id']); ?>"
                data-context="signin"
                data-ux_mode="popup"
                data-callback="handleCredentialResponse"
                data-auto_prompt="false">
            </div>

            <div class="g_id_signin d-flex justify-content-center"
                data-type="standard"
                data-shape="rectangular"
                data-theme="filled_blue"
                data-text="signin_with"
                data-size="large"
                data-logo_alignment="left"
                data-width="300">
            </div>
        </div>

        <div class="login-footer">
            <a href="forgot-pwd.php"><i class="fas fa-key"></i> Forgot Password?</a>
            <a href="signup.php"><i class="fas fa-user-plus"></i> Create Account</a>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://accounts.google.com/gsi/client" async defer></script>
<script>
document.getElementById('togglePassword').addEventListener('click', function () {
    const passwordInput = document.getElementById('password');
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);
    
    // Toggle icon class between eye and eye-slash
    this.classList.toggle('fa-eye');
    this.classList.toggle('fa-eye-slash');
});

function handleCredentialResponse(response) {
    console.log("Google auth response received", response);
    
    if (!response.credential) {
        console.error("No credential received from Google");
        return;
    }

    const idToken = response.credential;
    
    fetch('php/google_auth_handler.php', {
        method: 'POST',
        headers: { 
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: 'credential=' + encodeURIComponent(idToken)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.redirect) {
            window.location.href = data.redirect;
        } else {
            console.log("Login successful", data);
            // Handle successful login without redirect
            window.location.reload();
        }
    })
    .catch(error => {
        console.error('Login error:', error);
        alert('Login failed. Please try again.');
    });
}
</script>
</body>
</html>