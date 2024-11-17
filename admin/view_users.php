<?php
include '../includes/db.php'; // Database connection
session_start();

// Check if the user is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../user/login.php");
    exit();
}

// Fetch all users from the database
$users = $conn->query("SELECT * FROM users");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <main>
        <h2>All Users</h2>
        
        <div class="user-list">
            <?php while ($user = $users->fetch_assoc()): ?>
                <div class="user-item">
                    <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                    <p><strong>Contact Number:</strong> <?php echo htmlspecialchars($user['contact_number']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                    <p><strong>Address:</strong> <?php echo htmlspecialchars($user['address']); ?></p>
                    <p><strong>Role:</strong> <?php echo htmlspecialchars($user['role']); ?></p>
                    <a href="delete_user.php?id=<?php echo $user['id']; ?>" class="btn" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                </div>
            <?php endwhile; ?>
        </div>
    </main>
    <?php include '../includes/footer.php'; ?>
</body>
</html>
