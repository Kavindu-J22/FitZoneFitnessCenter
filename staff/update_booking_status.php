<?php
include '../includes/db.php'; // Database connection
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../user/login.php"); // Redirect to login if not admin
    exit();
}

// Check if the booking ID, action (Accept/Reject), and class ID are provided
if (isset($_GET['booking_id']) && isset($_GET['action']) && isset($_GET['class_id'])) {
    $booking_id = intval($_GET['booking_id']);
    $class_id = intval($_GET['class_id']);
    $action = $_GET['action'] === 'Accept' ? 'Accepted' : 'Rejected';

    // Update the booking status
    $stmt = $conn->prepare("UPDATE bookings SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $action, $booking_id);

    if ($stmt->execute()) {
        // Redirect back to the class attendance page with the class ID
        header("Location: classAttend.php?id=" . $class_id);
    } else {
        // In case of an error, show an error message
        header("Location: classAttend.php?id=" . $class_id . "&error=Failed+to+update+booking+status");
    }
    $stmt->close();
} else {
    // Redirect if no booking ID, action, or class ID was provided
    header("Location: classes.php?error=Invalid+booking+ID+or+action");
}
?>
