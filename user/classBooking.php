<?php
include '../includes/db.php'; // Database connection
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../user/login.php"); // Redirect to login if not logged in
    exit();
}

// Retrieve the user ID from the session
$user_id = $_SESSION['user_id'];

// Check if a class ID is provided in the URL
if (isset($_GET['class_id'])) {
    $class_id = intval($_GET['class_id']);

    // Check if the user has already booked this class
    $stmt = $conn->prepare("SELECT * FROM bookings WHERE user_id = ? AND class_id = ?");
    $stmt->bind_param("ii", $user_id, $class_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User has already booked this class
        $notification_message = "You already have a booking for this class. Please check your bookings to know the status.";
    } else {
        // Proceed with booking if not already booked
        $booking_title = 'Class Booking';
        $status = 'Pending';

        // Fetch class details for the booking name
        $stmt = $conn->prepare("SELECT class_name FROM classes WHERE id = ?");
        $stmt->bind_param("i", $class_id);
        $stmt->execute();
        $stmt->bind_result($class_name);
        $stmt->fetch();
        $stmt->close();

        // Insert the booking into the database
        $stmt = $conn->prepare("INSERT INTO bookings (user_id, class_id, booking_title, booking_name, status) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iisss", $user_id, $class_id, $booking_title, $class_name, $status);

        if ($stmt->execute()) {
            $success_message = "Booking successful! Your status is currently 'Pending'.";
        } else {
            $error_message = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking Confirmation</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Link to your CSS file -->
</head>
<body>
    <?php include '../includes/header.php'; ?> <!-- Include the header -->

    <main>
        <h2>Booking Confirmation</h2>

        <?php if (isset($notification_message)): ?>
            <p class="notification"><?php echo $notification_message; ?></p>
            <a href="joinClasses.php" class="btn">Back to Classes</a>
        <?php elseif (isset($success_message)): ?>
            <p class="success"><?php echo $success_message; ?></p>
            <a href="joinClasses.php" class="btn">Back to Classes</a>
        <?php elseif (isset($error_message)): ?>
            <p class="error"><?php echo $error_message; ?></p>
            <a href="view_classes.php" class="btn">Back to Classes</a>
        <?php endif; ?>
    </main>

    <?php include '../includes/footer.php'; ?> <!-- Include the footer -->
</body>
</html>
