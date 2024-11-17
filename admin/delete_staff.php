<?php
include '../includes/db.php'; // Database connection
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../user/login.php"); // Redirect to login if not admin
    exit();
}

// Get the staff member ID from the query string
if (isset($_GET['id'])) {
    $staff_id = $_GET['id'];
} else {
    header("Location: add_staff.php"); // Redirect if no ID is provided
    exit();
}

// Delete the staff member
$stmt = $conn->prepare("DELETE FROM users WHERE id = ? AND role = 'staff'");
$stmt->bind_param("i", $staff_id);

if ($stmt->execute()) {
    $success_message = "Staff member deleted successfully!";
} else {
    $error_message = "Error: " . $stmt->error;
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Staff Member</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Link to your CSS file -->
    <style>
        /* Custom styles for decoration */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }
        header, footer {
            background-color: #34495E;
            color: white;
            padding: 20px;
            text-align: center;
        }
        main {
            max-width: 900px;
            margin: 50px auto;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            font-size: 2rem;
            margin-bottom: 20px;
            color: #2c3e50;
        }
        p {
            font-size: 1.1rem;
            color: #7f8c8d;
        }
        .btn {
            display: inline-block;
            padding: 12px 20px;
            margin-top: 20px;
            font-size: 1rem;
            background-color: #e74c3c;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #c0392b;
        }
        .success {
            color: #27ae60;
            font-size: 1.2rem;
        }
        .error {
            color: #e74c3c;
            font-size: 1.2rem;
        }
    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?> <!-- Include the header -->
    <main>
        <h2>Delete Staff Member</h2>

        <?php if (isset($error_message)): ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <?php if (isset($success_message)): ?>
            <p class="success"><?php echo $success_message; ?></p>
            <a href="add_staff.php" class="btn">Go Back</a>
        <?php else: ?>
            <p>Are you sure you want to delete this staff member?</p>
            <a href="delete_staff.php?id=<?php echo $staff_id; ?>" class="btn">Yes, Delete</a>
            <a href="add_staff.php" class="btn">Cancel</a>
        <?php endif; ?>
    </main>

</body>
</html>
