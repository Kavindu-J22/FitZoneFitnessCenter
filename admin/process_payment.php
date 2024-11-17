<?php
include 'db.php'; // Database connection
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Handle payment processing
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get payment details
    $user_id = $_SESSION['user_id']; // Logged-in user ID
    $membership_plan = $_POST['membership_plan'];
    $price = 0;

    switch ($membership_plan) {
        case 'basic':
            $price = 20;
            break;
        case 'standard':
            $price = 40;
            break;
        case 'premium':
            $price = 60;
            break;
        default:
            echo "Invalid membership plan.";
            exit();
    }

    // Handle payment slip upload
    if (isset($_FILES['payment_slip']) && $_FILES['payment_slip']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['payment_slip'];
        $cloudName = 'dgecq2e6l';
        $uploadPreset = 'jmrpithq';

        // Upload the image to Cloudinary
        $uploadUrl = 'https://api.cloudinary.com/v1_1/' . $cloudName . '/image/upload';
        $formData = [
            'file' => new CURLFile($file['tmp_name']),
            'upload_preset' => $uploadPreset,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $uploadUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $formData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        $responseData = json_decode($response, true);
        if (isset($responseData['secure_url'])) {
            $payment_slip_url = $responseData['secure_url'];
        } else {
            echo "Error uploading payment slip.";
            exit();
        }
    } else {
        echo "Please upload a valid payment slip.";
        exit();
    }

    // Insert payment record into the database
    $stmt = $conn->prepare("INSERT INTO payments (user_id, payment_type, subscription, price, status, payment_slip_url) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $user_id, $payment_type, $membership_plan, $price, $status, $payment_slip_url);

    $payment_type = 'Apply Membership';
    $status = 'pending';

    if ($stmt->execute()) {
        echo "Payment record created successfully!";
        header("Location: confirmation_page.php"); // Redirect to a confirmation page
    } else {
        echo "Error processing payment.";
    }

    $stmt->close();
    $conn->close();
}
?>
