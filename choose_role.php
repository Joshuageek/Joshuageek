<?php
session_start();
$config = include './php/config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Luna - Choose Role</title>
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
        }

        .login-container h5 {
            font-weight: 700;
            color: var(--text-color);
            margin-bottom: 1.5rem;
            text-align: center;
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

        .form-select {
            border-radius: var(--border-radius);
            padding: 0.75rem;
            border: 1px solid #dee2e6;
            margin-bottom: 1.5rem;
        }

        .alert {
            border-radius: var(--border-radius);
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="text-center mb-4">
        <img src="images/logo.png" alt="Luna Logo" class="img-fluid" style="max-width: 150px;">
        <h5 class="mt-3">Choose Your Role</h5>
    </div>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger text-center"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php elseif (isset($_SESSION['success'])): ?>
        <div class="alert alert-success text-center"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <form action="php/auth.inc.php" method="POST">
        <label for="role" class="form-label">Select your role</label>
        <select name="role" id="role" class="form-select" required>
            <option value="">-- Choose your role --</option>
            <option value="patient">Patient</option>
            <option value="therapist">Therapist</option>
        </select>

        <button type="submit" name="choose_role_btn" class="btn btn-login w-100">Continue</button>
    </form>
</div>

</body>
</html>
