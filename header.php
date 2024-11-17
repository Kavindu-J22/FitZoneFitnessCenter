<?php
// Check if a session is not already started before starting one
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitZone Fitness Center</title>
    <!-- Corrected CSS path -->
    <link rel="stylesheet" href="http://localhost/FitZoneFitnessCenter/css/header.css">
</head>
<body>
<header>
    <div class="logo-container">
        <!-- Corrected image path -->
        <img src="http://localhost/FitZoneFitnessCenter/images/logo.png" alt="FitZone Logo" class="logo">
        <h1>FitZone Fitness Center</h1>
    </div>
    <nav>
        <ul class="nav-links">
            <li><a href="http://localhost/FitZoneFitnessCenter/index.php">Home</a></li>
            <li><a href="http://localhost/FitZoneFitnessCenter/about.php">About Us</a></li>
            <li><a href="http://localhost/FitZoneFitnessCenter/services.php">Services</a></li>
            <li><a href="http://localhost/FitZoneFitnessCenter/contact.php">Contact</a></li>

            <?php if ($isLoggedIn): ?>
                <!-- Display these buttons if the user is logged in -->
                <li><a href="http://localhost/FitZoneFitnessCenter/user/view_profile.php" class="cta-btn">Profile</a></li>
                <li><a href="http://localhost/FitZoneFitnessCenter/user/logout.php" class="cta-btn">Logout</a></li>
            <?php else: ?>
                <!-- Display these buttons if the user is not logged in -->
                <li><a href="http://localhost/FitZoneFitnessCenter/user/login.php" class="cta-btn">Login</a></li>
                <li><a href="http://localhost/FitZoneFitnessCenter/user/register.php" class="cta-btn">Register</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
</body>
</html>
