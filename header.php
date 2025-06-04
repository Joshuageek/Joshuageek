<?php 
session_start();
require 'config/db.php';

$user_id = $_SESSION['user_id'] ?? null;
$user_role = $_SESSION['user_role'] ?? null;

$current_page = basename($_SERVER['PHP_SELF']);
function isActive($page) {
  global $current_page;
  return $current_page === $page ? 'active' : '';
}

$menu_items = [
  ['label' => 'Home', 'url' => 'index.php'],
  ['label' => 'About Us', 'url' => 'about.php'],
  ['label' => 'For Therapists', 'url' => 'clinic.php'],
  ['label' => 'Dashboard', 'url' => 'admin/dashboard.php'],
  ['label' => 'Bookings', 'url' => 'booking.php']
];

// if ($user_role === 'therapist') {
//   $menu_items[] = ['label' => 'For Therapists', 'url' => 'clinic.php'];
// } elseif ($user_role === 'admin' || $user_role === 'patient') {
//   $menu_items[] = ['label' => 'Dashboard', 'url' => 'admin/dashboard.php'];
//   $menu_items[] = ['label' => 'Bookings', 'url' => 'booking.php'];
// } 
// else {
// }

if ($user_id) {
  $menu_items[] = ['label' => 'Sign Out', 'url' => 'logout.php', 'class' => 'logout'];
} else {
  $menu_items[] = ['label' => 'Sign In', 'url' => 'login.php'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="keywords" content="">
  <meta name="description" content="">
  <title>Luna</title>

  <!-- Loading Bootstrap -->
  <link href="bootstrap/css/bootstrap.css" rel="stylesheet">

  <!-- Loading Template CSS -->
  <link href="css/style.css" rel="stylesheet">
  <link href="css/animate.css" rel="stylesheet">
  <link href="css/style-magnific-popup.css" rel="stylesheet">

  <!-- Fonts -->
  <link href="css/font-awesome.min.css" rel="stylesheet">
  <link href="css/icons-main.css" rel="stylesheet">
  <link href="css/icons-helper.css" rel="stylesheet">

  <!-- RS5.0 Main Stylesheet -->
  <link rel="stylesheet" type="text/css" href="revolution/css/settings.css">
  <!-- RS5.0 Layers and Navigation Styles -->
  <link rel="stylesheet" type="text/css" href="revolution/css/layers.css">
  <link rel="stylesheet" type="text/css" href="revolution/css/navigation.css">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
  <!-- Font Favicon -->
  <link rel="shortcut icon" href="images/favicon.ico">

  <!-- sweet alerts -->
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">


  <style>
    .home-hero {
      text-align: center;
      padding: 50px 0;
    }

    .home-hero h1 {
      font-size: 2.5em;
      margin-bottom: 20px;
    }

    .hero-services {
      display: flex;
      justify-content: space-around;
      flex-wrap: wrap;
      margin-top: 20px;
    }

    .hero-services a {
      flex: 1 1 calc(25% - 20px);
      margin: 10px;
      text-align: center;
      padding: 20px;
      border-radius: 10px;
      transition: background-color 0.3s;
      position: relative;
    }

    .hero-services .individual {
      background-color: #A8C3A4;
    }

    .hero-services .teens {
      background-color: #AFCBFF;
    }

    .hero-services .couples {
      background-color: #D8C4E7;
    }

    .hero-services .medication {
      background-color: #F5EBDD;
    }

    .hero-services a:hover {
      background-color: #9e8741;
    }

    .hero__service-img-wrap {
      height: 350px;
      overflow: hidden;
      border-radius: 10px;
    }

    .hero__service-img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .hero-services h2 {
      margin-top: 15px;
      font-size: 1.5em;
    }

    .hero-services p {
      margin-top: 10px;
      font-size: 1em;
    }

    .hero-services .text-link {
      margin-top: 15px;
      font-size: 1.2em;
      color: #333;
      text-decoration: underline;
    }

    body {
      font-family: 'Montserrat', sans-serif;
    }

    /* Services Section Styles */
    .services-section {
      padding: 50px 0;
      background-color: #f9f9f9;
    }

    .service-item {
      margin-bottom: 30px;
      padding: 20px;
      background-color: white;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      transition: all 0.3s ease;
    }

    .service-item:hover {
      transform: translateY(-5px);
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      background-color: #f0f8ff;
    }

    .service-item h3 {
      color: #A8C3A4;
      margin-bottom: 10px;
      transition: color 0.3s ease;
    }

    .service-item:hover h3 {
      color: #8bc34a;
    }

    /* Compare Section Styles */
    .compare-section {
      padding: 50px 0;
      background-color: #D8C4E7; /* Teal background color */
      color: white;
    }

    .compare-section h2 {
      text-align: center;
      margin-bottom: 40px;
      font-size: 28px;
    }

    .compare-table {
      width: 100%;
      border-collapse: collapse;
      margin: 0 auto;
      max-width: 800px;
    }

    .compare-table th {
      text-align: center;
      padding: 15px;
      font-size: 18px;
    }

    .compare-table td {
      padding: 15px;
      text-align: center;
      border-bottom: 1px solid rgba(255, 255, 255, 0.3);
    }

    .compare-table tr:last-child td {
      border-bottom: none;
    }

    .feature-name {
      text-align: center;
      padding: 15px;
      font-weight: bold;
    }

    .check-circle {
      display: inline-block;
      width: 30px;
      height: 30px;
      border-radius: 50%;
      border: 2px solid white;
      text-align: center;
      line-height: 26px;
      margin: 0 auto;
    }

    .check {
      color: white;
      font-weight: bold;
    }

    .x-mark {
      color: white;
      font-weight: bold;
    }

    /* Footer Styles */
    .footer {
      background-color: #333;
      color: white;
      padding: 50px 0 20px;
    }

    .footer-bottom {
      margin-top: 20px;
      padding-top: 20px;
      border-top: 1px solid #444;
    }

    .footer_social {
      list-style: none;
      padding: 0;
    }

    .footer_social li {
      display: inline-block;
      margin-right: 15px;
    }

    .footer_social a {
      color: white;
      font-size: 18px;
    }
  </style>
</head>
<body>
  <!-- Loader -->
  <div id="loader">
    <div class="sk-three-bounce">
      <div class="sk-child sk-bounce1"></div>
      <div class="sk-child sk-bounce2"></div>
      <div class="sk-child sk-bounce3"></div>
    </div>
  </div>

  <!-- Header -->
  <style>
    /* Global Styles */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body {
      font-family: 'Montserrat', sans-serif;
      line-height: 1.6;
      color: #333;
    }
    
    .container {
      width: 100%;
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 15px;
    }
    
    /* Navbar */
    .navbar {
      background-color: #fff;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      padding: 15px 0;
      position: fixed;
      width: 100%;
      top: 0;
      z-index: 1000;
    }
    
    .navbar .container {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    
    .navbar-brand {
      font-size: 24px;
      font-weight: 700;
      color: #A8C3A4;
      text-decoration: none;
    }
    
    .navbar-nav {
      display: flex;
      list-style: none;
    }
    
    .navbar-nav li {
      margin-left: 20px;
    }
    
    .navbar-nav a {
      text-decoration: none;
      color: #333;
      font-weight: 500;
      transition: color 0.3s;
    }
    
    .navbar-nav a:hover {
      color: #A8C3A4;
    }
    
    .navbar-nav .active a {
      /* color: #A8C3A4; */
      background: #7aca9e;
      padding: .4em;
      border-radius: .4em;
      color: #fff;
    }
    
    /* Responsive Adjustments */
    @media (max-width: 768px) {
      .navbar .container {
        flex-direction: column;
      }
      
      .navbar-nav {
        margin-top: 15px;
        flex-direction: column;
        align-items: center;
      }
      
      .navbar-nav li {
        margin: 5px 0;
      }
    }
    .logout a{
     color: red !important;
    }

    .logout a:hover{
     color: #d64540 !important;
    }
  </style>
</head>
<body>
  <!-- Fixed Navbar -->
  <header class="header">
  <nav class="navbar">
    <div class="container">
      <a href="index.php" class="navbar-brand">LUNA</a>
      <ul class="navbar-nav">
        <?php foreach($menu_items as $item): ?>
          <li class="<?= isActive($item['url'])?> <?= $item['class'] ?? ''?>">
            <a href="<?= $item['url']?>" <?= $item['url'] === $current_page ? 'aria-current="page"' : ''?>>
              <?= htmlspecialchars($item['label'])?>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </nav>
</header>