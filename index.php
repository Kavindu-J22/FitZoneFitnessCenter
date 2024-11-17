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
    <title>FitZone Fitness Center</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Link to your stylesheet -->
</head>
<body>
    <!-- Header Section -->
    <?php include 'header.php'; ?>

    <!-- Main Content -->
    <main>
        <div class="hero-section">
            <h1>Welcome, <?= htmlspecialchars($username) ?>.! to FitZone Fitness Center</h1>
            <p>Discover our wide range of fitness programs, state-of-the-art equipment, personalized training, and more!</p>
            <div class="button-container">
                <?php if ($isLoggedIn): ?>
                    <?php if ($userRole === 'admin'): ?>
                        <a href="admin/dashboard.php" class="btn">Go to Dashboard (Admin)</a>
                    <?php elseif ($userRole === 'staff'): ?>
                        <a href="staff/dashboard.php" class="btn">Go to Dashboard (Staff)</a>
                    <?php elseif ($userRole === 'customer'): ?>
                        <a href="user/dashboard.php" class="btn">Go to Dashboard (Customer)</a>
                    <?php endif; ?>
                <?php else: ?>
                    <a href="user/login.php" class="btn">Login</a>
                    <a href="user/register.php" class="btn">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <!-- Footer Section -->
    <?php include 'includes/footer.php'; ?>
</body>
</html>
