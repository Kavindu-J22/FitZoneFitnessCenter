<?php
include '../includes/db.php'; // Include your database connection

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $status = $_POST['status'];

    // Update the status of the payment
    $stmt = $conn->prepare("UPDATE payments SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);

    if ($stmt->execute()) {
        echo json_encode(['message' => 'Status updated successfully!']);
    } else {
        echo json_encode(['message' => 'Failed to update status.']);
    }

    $stmt->close();
}
?>
