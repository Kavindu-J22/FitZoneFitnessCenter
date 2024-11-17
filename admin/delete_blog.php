<?php
include '../includes/db.php'; // Database connection
session_start();

// Check if the user is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../user/login.php");
    exit();
}

// Get the blog ID from the query string
$blogId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Delete the blog post from the database
$stmt = $conn->prepare("DELETE FROM blogs WHERE id = ?");
$stmt->bind_param("i", $blogId);
$stmt->execute();
$stmt->close();

// Redirect to the create_blog.php page after deletion
header("Location: create_blog.php");
exit();
