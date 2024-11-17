<?php
include '../includes/db.php'; // Database connection
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../user/login.php"); // Redirect to login if not admin
    exit();
}

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
    <title>View Appointments and Attendees</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Link to your CSS file -->
</head>
<body>
    <?php include '../includes/header.php'; ?> <!-- Include the header -->

    <main>
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
    </main>

    <?php include '../includes/footer.php'; ?> <!-- Include the footer -->
</body>
</html>
