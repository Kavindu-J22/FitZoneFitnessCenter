<?php
include '../includes/db.php'; // Database connection
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../user/login.php"); // Redirect to login if not logged in
    exit();
}

// Check if a booking ID is provided in the URL
if (isset($_GET['booking_id'])) {
    $booking_id = intval($_GET['booking_id']);
    $user_id = $_SESSION['user_id'];

    // Delete the booking only if it belongs to the logged-in user
    $stmt = $conn->prepare("DELETE FROM bookings WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $booking_id, $user_id);

    if ($stmt->execute()) {
        header("Location: myBookings.php?message=Booking+deleted+successfully");
    } else {
        header("Location: myBookings.php?error=Failed+to+delete+booking");
    }
    $stmt->close();
} else {
    header("Location: myBookings.php?error=Invalid+booking+ID");
}
?>
