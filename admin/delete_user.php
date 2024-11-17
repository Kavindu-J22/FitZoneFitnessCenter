<?php
include '../includes/db.php'; // Database connection
session_start();

// Check if the user is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../user/login.php");
    exit();
}

// Get the user ID from the query string
$userId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Ensure the user ID is valid
if ($userId > 0) {
    // Delete the user from the database
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->close();
}

// Redirect back to the user list page
header("Location: view_users.php");
exit();
