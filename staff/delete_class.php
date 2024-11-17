<?php
include '../includes/db.php'; // Database connection
session_start();

// Check if the user is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../user/login.php");
    exit();
}

// Get the class ID from the query string
$classId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Ensure the class ID is valid
if ($classId > 0) {
    // Delete the class from the database
    $stmt = $conn->prepare("DELETE FROM classes WHERE id = ?");
    $stmt->bind_param("i", $classId);
    $stmt->execute();
    $stmt->close();
}

// Redirect back to the add class page
header("Location: create_class.php");
exit();
