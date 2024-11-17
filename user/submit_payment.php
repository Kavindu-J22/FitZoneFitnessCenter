<?php
include '../includes/db.php'; // Database connection
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['userId'];
    $paymentType = $_POST['paymentType'];
    $subscription = $_POST['subscription'];
    $price = $_POST['price'];
    $status = 'pending';
    $paymentSlipUrl = $_POST['paymentSlipUrl']; // Get the uploaded image URL

    // Insert payment details into the database
    $stmt = $conn->prepare("INSERT INTO payments (userid, paymenttype, subscription, price, status, paymentslip) 
                            VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $userId, $paymentType, $subscription, $price, $status, $paymentSlipUrl);
    
    if ($stmt->execute()) {
        // Payment details saved successfully
        header("Location: membership.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
