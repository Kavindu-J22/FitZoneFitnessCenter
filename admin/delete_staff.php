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
    <title>Delete Staff Member</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Link to your CSS file -->
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
    <?php include '../includes/footer.php'; ?> <!-- Include the footer -->
</body>
</html>
