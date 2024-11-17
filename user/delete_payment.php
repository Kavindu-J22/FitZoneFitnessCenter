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

// Check if payment ID is provided and delete the payment record
if (isset($_GET['payment_id'])) {
    $paymentId = $_GET['payment_id'];

    // Prepare and execute the delete query
    $stmt = $conn->prepare("DELETE FROM payments WHERE id = ? AND userId = ?");
    $stmt->bind_param("is", $paymentId, $loggedUserId);
    $stmt->execute();
    $stmt->close();

    // Redirect back to the payments page after deletion
    header("Location: view_payments.php");
    exit();
} else {
    // If no payment ID is provided, redirect to the payments page
    header("Location: view_payments.php");
    exit();
}
?>
