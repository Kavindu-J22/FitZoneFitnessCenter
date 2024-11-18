<?php
include '../includes/db.php'; // Database connection
session_start();


// Get the class ID from the URL
if (!isset($_GET['id'])) {
    header("Location: classes.php"); // Redirect to the classes page if no ID is provided
    exit();
}
$class_id = intval($_GET['id']);

// Fetch all bookings for the specified class
$stmt = $conn->prepare("SELECT * FROM bookings WHERE class_id = ?");
$stmt->bind_param("i", $class_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Appointments and Attendees</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Link to your CSS file -->
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f7f9fc;
            margin: 0;
            padding: 0;
            color: #333;
        }
        header, footer {
            background-color: #34495E;
            color: #fff;
            padding: 20px 0;
            text-align: center;
        }
        .btn {
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 6px;
            color: white;
            font-weight: bold;
            margin: 10px;
            transition: all 0.3s ease;
        }
        .accept-btn {
            background-color: #27ae60;
        }
        .reject-btn {
            background-color: #e74c3c;
        }
        .accept-btn:hover, .reject-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        .booking-item {
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease-in-out;
        }
        .booking-item:hover {
            transform: scale(1.02);
        }
        .booking-list h3 {
            color: #34495E;
            font-size: 1.2em;
            margin-bottom: 15px;
        }
        .back-btn {
            background-color: #3498db;
            display: inline-block;
            margin: 20px 0;
            padding: 12px 24px;
            border-radius: 6px;
            color: white;
            font-size: 16px;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .back-btn:hover {
            background-color: #2980b9;
        }
        main {
            padding: 30px;
            max-width: 1200px;
            margin: auto;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }
        .container {
            margin: 0 auto;
            padding: 20px;
        }
        h2 {
            color: #34495E;
            font-size: 2em;
            margin-bottom: 20px;
            text-align: center;
        }
        .booking-item p {
            font-size: 1.1em;
            margin: 8px 0;
        }
    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?> <!-- Include the header -->

    <main>
        <div class="container">
            <a href="create_class.php" class="back-btn">Back to Classes</a> <!-- Back button -->

            <h2>Bookings for Class ID: <?php echo htmlspecialchars($class_id); ?></h2>

            <div class="booking-list">
                <h3>Pending Bookings</h3>
                <?php
                $hasPending = false;
                while ($booking = $result->fetch_assoc()) {
                    if ($booking['status'] === 'Pending') {
                        $hasPending = true;
                        ?>
                        <div class="booking-item">
                            <p><strong>User ID:</strong> <?php echo htmlspecialchars($booking['user_id']); ?></p>
                            <p><strong>Booking Title:</strong> <?php echo htmlspecialchars($booking['booking_title']); ?></p>
                            <p><strong>Booking Name:</strong> <?php echo htmlspecialchars($booking['booking_name']); ?></p>
                            <p><strong>Status:</strong> <?php echo htmlspecialchars($booking['status']); ?></p>

                            <a href="update_booking_status.php?booking_id=<?php echo $booking['id']; ?>&class_id=<?php echo $class_id; ?>&action=Accept" class="btn accept-btn">Accept</a>
                            <a href="update_booking_status.php?booking_id=<?php echo $booking['id']; ?>&class_id=<?php echo $class_id; ?>&action=Reject" class="btn reject-btn">Reject</a>
                        </div>
                        <?php
                    }
                }
                if (!$hasPending) {
                    echo "<p>No pending bookings.</p>";
                }
                ?>

                <h3>Accepted Bookings</h3>
                <?php
                $result->data_seek(0); // Reset result pointer
                $hasAccepted = false;
                while ($booking = $result->fetch_assoc()) {
                    if ($booking['status'] === 'Accepted') {
                        $hasAccepted = true;
                        ?>
                        <div class="booking-item">
                            <p><strong>User ID:</strong> <?php echo htmlspecialchars($booking['user_id']); ?></p>
                            <p><strong>Booking Title:</strong> <?php echo htmlspecialchars($booking['booking_title']); ?></p>
                            <p><strong>Booking Name:</strong> <?php echo htmlspecialchars($booking['booking_name']); ?></p>
                            <p><strong>Status:</strong> <?php echo htmlspecialchars($booking['status']); ?></p>
                        </div>
                        <?php
                    }
                }
                if (!$hasAccepted) {
                    echo "<p>No accepted bookings.</p>";
                }
                ?>

                <h3>Rejected Bookings</h3>
                <?php
                $result->data_seek(0); // Reset result pointer
                $hasRejected = false;
                while ($booking = $result->fetch_assoc()) {
                    if ($booking['status'] === 'Rejected') {
                        $hasRejected = true;
                        ?>
                        <div class="booking-item">
                            <p><strong>User ID:</strong> <?php echo htmlspecialchars($booking['user_id']); ?></p>
                            <p><strong>Booking Title:</strong> <?php echo htmlspecialchars($booking['booking_title']); ?></p>
                            <p><strong>Booking Name:</strong> <?php echo htmlspecialchars($booking['booking_name']); ?></p>
                            <p><strong>Status:</strong> <?php echo htmlspecialchars($booking['status']); ?></p>
                        </div>
                        <?php
                    }
                }
                if (!$hasRejected) {
                    echo "<p>No rejected bookings.</p>";
                }
                ?>
            </div>
        </div>
    </main>

    <?php include '../includes/footer.php'; ?> <!-- Include the footer -->
</body>
</html>
