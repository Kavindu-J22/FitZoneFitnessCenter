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
    <style>
        /* General page styling */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f6f8;
            color: #34495E;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }
        main {
            max-width: 1200px;
            margin: 30px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 20px;
        }
        .back-to-db-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .back-to-db {
            display: inline-block;
            background-color: #3498db;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        .back-to-db:hover {
            background-color: #2980b9;
        }
        .user-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .user-item {
            background-color: #ecf0f1;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            overflow: hidden; /* Prevents content from overflowing */
            word-wrap: break-word; /* Ensures long text wraps */
        }
        .user-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        }
        .user-item p {
            margin: 8px 0;
            color: #2c3e50;
            overflow: hidden; /* Ensures text doesn't overflow */
            text-overflow: ellipsis; /* Adds ellipsis (...) for overflowing text */
            white-space: nowrap; /* Keeps text on a single line */
        }
        .btn {
            display: inline-block;
            background-color: #e74c3c;
            color: white;
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #c0392b;
        }
        /* Responsive Design */
        @media (max-width: 768px) {
            .user-item {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <main>
        <h2>All Users</h2>

        <div class="back-to-db-container">
            <a class="back-to-db" href="dashboard.php">Back to Dashboard</a>
        </div>

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

