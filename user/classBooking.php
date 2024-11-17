<?php
include '../includes/db.php'; // Database connection
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../user/login.php"); // Redirect to login if not logged in
    exit();
}

// Retrieve the user ID from the session
$user_id = $_SESSION['user_id'];

// Check if a class ID is provided in the URL
if (isset($_GET['class_id'])) {
    $class_id = intval($_GET['class_id']);

    // Check if the user has already booked this class
    $stmt = $conn->prepare("SELECT * FROM bookings WHERE user_id = ? AND class_id = ?");
    $stmt->bind_param("ii", $user_id, $class_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User has already booked this class
        $notification_message = "You already have a booking for this class. Please check your bookings to know the status.";
    } else {
        // Proceed with booking if not already booked
        $booking_title = 'Class Booking';
        $status = 'Pending';

        // Fetch class details for the booking name
        $stmt = $conn->prepare("SELECT class_name FROM classes WHERE id = ?");
        $stmt->bind_param("i", $class_id);
        $stmt->execute();
        $stmt->bind_result($class_name);
        $stmt->fetch();
        $stmt->close();

        // Insert the booking into the database
        $stmt = $conn->prepare("INSERT INTO bookings (user_id, class_id, booking_title, booking_name, status) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iisss", $user_id, $class_id, $booking_title, $class_name, $status);

        if ($stmt->execute()) {
            $success_message = "Booking successful! Your status is currently 'Pending'.";
        } else {
            $error_message = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking Confirmation</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Link to your CSS file -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
        }

        main {
            width: 80%;
            max-width: 800px;
            margin: 40px auto;
            padding: 30px;
            background-color: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }

        h2 {
            font-size: 30px;
            color: #2d3436;
            margin-bottom: 30px;
        }

        .notification,
        .success,
        .error {
            font-size: 18px;
            color: #2d3436;
            margin-bottom: 20px;
            padding: 20px;
            border-radius: 8px;
            background-color: #dfe6e9;
        }

        .success {
            background-color: #00b894;
            color: white;
        }

        .error {
            background-color: #e74c3c;
            color: white;
        }

        .btn {
            display: inline-block;
            padding: 12px 20px;
            background-color: #00b894;
            color: white;
            font-size: 16px;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 15px;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #098e67;
        }

        @media (max-width: 768px) {
            main {
                padding: 20px;
            }

            h2 {
                font-size: 26px;
            }

            .btn {
                font-size: 14px;
                padding: 10px 16px;
            }
        }
    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?> <!-- Include the header -->

    <main>
        <h2>Booking Confirmation</h2>

        <?php if (isset($notification_message)): ?>
            <p class="notification"><?php echo $notification_message; ?></p>
            <a href="joinClasses.php" class="btn">Back to Classes</a>
        <?php elseif (isset($success_message)): ?>
            <p class="success"><?php echo $success_message; ?></p>
            <a href="joinClasses.php" class="btn">Back to Classes</a>
        <?php elseif (isset($error_message)): ?>
            <p class="error"><?php echo $error_message; ?></p>
            <a href="view_classes.php" class="btn">Back to Classes</a>
        <?php endif; ?>
    </main>

</body>
</html>
