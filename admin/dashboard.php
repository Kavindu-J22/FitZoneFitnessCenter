<?php
session_start();
include '../includes/db.php'; // Ensure the database connection file is included

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
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Link to your main stylesheet -->
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        /* Modern Styles for Dashboard */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .dashboard-container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            font-size: 36px;
            margin-bottom: 10px;
        }

        .subtitle {
            font-size: 16px;
            color: #777;
            margin-bottom: 30px;
        }

        /* Button Grid */
        .button-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); /* Ensure buttons are same size and responsive */
            gap: 20px;
            justify-items: center;
        }

        .btn {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 15px;
            background-color: #2c3e50;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            transition: background-color 0.3s;
            font-size: 14px;
            height: 100px; /* Ensure all buttons have the same height */
            justify-content: space-around; /* Ensures icons and text are spaced properly */
        }

        .btn i {
            font-size: 24px;
        }

        .btn:hover {
            background-color: #1abc9c;
        }

        .logout-btn {
            background-color: #e74c3c;
        }

        .logout-btn:hover {
            background-color: #c0392b;
        }

        /* Add descriptions below each button */
        .btn-description {
            font-size: 12px;
            color: #555;
            margin-top: 5px;
        }

        /* Responsive layout for smaller screens */
        @media (max-width: 768px) {
            .btn {
                font-size: 12px;
                height: auto; /* Adjust button height for smaller screens */
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?>
    
    <div class="dashboard-container">
        <h1>Hello, Admin!</h1>
        <p class="subtitle">Welcome back to your Admin Dashboard.</p>

        <div class="button-grid">
            <div>
                <a href="../user/view_profile.php" class="btn"><i class="fas fa-user"></i> Profile</a>
                <p class="btn-description">View and update your admin profile.</p>
            </div>
            <div>
                <a href="add_staff.php" class="btn"><i class="fas fa-users-cog"></i> Manage Staff Members</a>
                <p class="btn-description">Add or manage staff members in the system.</p>
            </div>
            <div>
                <a href="view_payments.php" class="btn"><i class="fas fa-credit-card"></i> Manage Members & Payments</a>
                <p class="btn-description">View and manage membership payments.</p>
            </div>
            <div>
                <a href="create_blog.php" class="btn"><i class="fas fa-blog"></i> Manage Blog Posts</a>
                <p class="btn-description">Create, edit, and manage blog posts.</p>
            </div>
            <div>
                <a href="../staff/view_queries.php" class="btn"><i class="fas fa-question-circle"></i> Manage Queries</a>
                <p class="btn-description">View and respond to members' queries.</p>
            </div>
            <div>
                <a href="../staff/create_class.php" class="btn"><i class="fas fa-dumbbell"></i> Manage Classes</a>
                <p class="btn-description">Create and manage fitness classes.</p>
            </div>
            <div>
                <a href="view_users.php" class="btn"><i class="fas fa-users"></i> Manage Users</a>
                <p class="btn-description">View and manage all users in the system.</p>
            </div>
            <div>
                <a href="../user/logout.php" class="btn logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
                <p class="btn-description">Log out of the admin dashboard securely.</p>
            </div>
        </div>
    </div>
</body>
</html>
