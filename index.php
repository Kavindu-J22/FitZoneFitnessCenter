<?php
session_start();
include 'includes/db.php'; // Ensure the database connection file is included

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['user_id']);
$userRole = '';
$username = '';

if ($isLoggedIn) {
    // Fetch user details from the database
    $userId = $_SESSION['user_id'];
    
    // Check if the database connection ($conn) is successful
    if ($conn) {
        $query = "SELECT username, role FROM users WHERE id = ?";
        $stmt = $conn->prepare($query);

        if ($stmt) {
            $stmt->bind_param('i', $userId);
            $stmt->execute();
            $stmt->bind_result($username, $userRole);
            $stmt->fetch();
            $stmt->close();
        } else {
            // Handle the error if $stmt is not properly initialized
            echo "Error: Unable to prepare the statement.";
        }
    } else {
        // Handle the error if $db is not connected properly
        echo "Error: Unable to connect to the database.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitZone Fitness Center</title>
    <link rel="stylesheet" href="css/style.css">
    <!-- Add Google Fonts for better typography -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Header Section -->
    <?php include 'header.php'; ?>

    <!-- Main Content -->
    <main>
        <div class="hero-section">
            <div class="hero-content">
                <h1>Welcome <?= htmlspecialchars($username) ?>! to FitZone Fitness Center</h1>
                <p>Transform your body and mind with our cutting-edge fitness solutions, expert guidance, and a supportive community dedicated to your success!</p>
                <div class="button-container">
                    <?php if ($isLoggedIn): ?>
                        <?php if ($userRole === 'admin'): ?>
                            <a href="admin/dashboard.php" class="btn primary-btn">Go to Dashboard (Admin)</a>
                        <?php elseif ($userRole === 'staff'): ?>
                            <a href="staff/dashboard.php" class="btn secondary-btn">Go to Dashboard (Staff)</a>
                        <?php elseif ($userRole === 'customer'): ?>
                            <a href="user/dashboard.php" class="btn tertiary-btn">Go to Dashboard (Customer)</a>
                        <?php endif; ?>
                    <?php else: ?>
                        <a href="user/login.php" class="btn primary-btn">Login</a>
                        <a href="user/register.php" class="btn secondary-btn">Register</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <section class="features">
            <div class="container">
                <h2>Our Fitness Features</h2>
                <div class="feature-list">
                    <div class="feature-item">
                        <img src="images/icon-1.svg" alt="State-of-the-art Equipment" class="feature-icon">
                        <h3>State of the art Equipment</h3>
                        <p>We provide the latest and most advanced fitness equipment to ensure you get the best workout experience.</p>
                    </div>
                    <div class="feature-item">
                        <img src="images/icon-2.svg" alt="Personalized Training" class="feature-icon">
                        <h3>Personalized Training</h3>
                        <p>Our expert trainers will customize a fitness plan just for you, based on your goals and fitness level.</p>
                    </div>
                    <div class="feature-item">
                        <img src="images/icon-3.svg" alt="Group Classes" class="feature-icon">
                        <h3>Group Classes</h3>
                        <p>Join our high-energy group classes to stay motivated while achieving your fitness goals together.</p>
                    </div>
                    <div class="feature-item">
                        <img src="images/icon-4.svg" alt="Nutrition Support" class="feature-icon">
                        <h3>Nutrition Support</h3>
                        <p>Our nutrition experts will guide you on the best diet plans to complement your workout regimen.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer Section -->
    <?php include 'includes/footer.php'; ?>
</body>
</html>
