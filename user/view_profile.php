<?php
include '../includes/db.php'; // Include your database connection
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../user/login.php");
    exit();
}

// Get the logged-in user's ID
$loggedUserId = $_SESSION['user_id'];

// Fetch user data from the database
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $loggedUserId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Assuming you have a general style.css file -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        header {
            text-align: center;
            background-color: #2c3e50;
            color: white;
            padding: 20px;
        }

        main {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .profile-container {
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            text-align: center;
            animation: fadeIn 0.5s ease-in-out;
        }

        .profile-container h1 {
            color: #333;
            margin-bottom: 20px;
            font-size: 24px;
        }

        .profile-container table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        .profile-container th,
        .profile-container td {
            padding: 15px;
            text-align: left;
            font-size: 16px;
        }

        .profile-container th {
            background-color: #3498db;
            color: white;
            border-radius: 6px;
        }

        .profile-container td {
            background-color: #ecf0f1;
            border-radius: 6px;
        }

        .profile-container a {
            display: inline-block;
            padding: 12px 20px;
            margin-top: 20px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 16px;
            transition: background-color 0.3s, transform 0.2s;
        }

        .profile-container a:hover {
            background-color: #2980b9;
            transform: scale(1.05);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .profile-container {
                padding: 20px;
                width: 90%;
            }
        }
    </style>
</head>
<body>


<?php include '../includes/header.php'; ?>


<main>
    <div class="profile-container">
        <h1><?php echo htmlspecialchars($user['username']); ?>'s Profile</h1>

        <table>
            <tr>
                <th>Username</th>
                <td><?php echo htmlspecialchars($user['username']); ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
            </tr>
            <tr>
                <th>Contact Number</th>
                <td><?php echo htmlspecialchars($user['contact_number']); ?></td>
            </tr>
            <tr>
                <th>Address</th>
                <td><?php echo htmlspecialchars($user['address']); ?></td>
            </tr>
        </table>

        <a href="edit_profile.php">Edit Profile</a>
        <br><br>
        <a href="#" id="back-to-dashboard" class="back-to-db">Back to Dashboard</a>
    </div>
</main>

<script>
    // JavaScript to dynamically navigate based on user role
    const userRole = <?php echo json_encode($user['role']); ?>; // Get the user role from PHP
    const dashboardBtn = document.getElementById('back-to-dashboard');
    
    // Set the appropriate link based on the user's role
    if (userRole === 'customer') {
        dashboardBtn.href = 'dashboard.php';
    } else if (userRole === 'admin') {
        dashboardBtn.href = '../admin/dashboard.php';
    } else if (userRole === 'staff') {
        dashboardBtn.href = '../staff/dashboard.php';
    }
</script>

</body>
</html>
