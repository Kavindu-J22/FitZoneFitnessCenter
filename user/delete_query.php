<?php
include '../includes/db.php'; // Database connection
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../user/login.php");
    exit();
}

$query_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Delete the query
$stmt = $conn->prepare("DELETE FROM queries WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $query_id, $user_id);

if ($stmt->execute()) {
    header("Location: view_queries.php"); // Redirect to view queries page
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
?>
