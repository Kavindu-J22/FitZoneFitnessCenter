<?php
include '../includes/db.php'; // Database connection
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../user/login.php"); // Redirect to login if not logged in
    exit();
}

// Retrieve the logged-in user's ID
$user_id = $_SESSION['user_id'];

// Fetch all bookings for the logged-in user
$stmt = $conn->prepare("SELECT * FROM bookings WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Bookings</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Link to your CSS file -->
</head>
<body>
    <?php include '../includes/header.php'; ?> <!-- Include the header -->

    <main>
        <h2>My Bookings</h2>
        <div class="booking-list">
            <?php if ($result->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Booking Title</th>
                            <th>Booking Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($booking = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($booking['booking_title']); ?></td>
                                <td><?php echo htmlspecialchars($booking['booking_name']); ?></td>
                                <td><?php echo htmlspecialchars($booking['status']); ?></td>
                                <td>
                                    <a href="delete_booking.php?booking_id=<?php echo $booking['id']; ?>" class="btn delete-btn" onclick="return confirm('Are you sure you want to Cancel this booking?');">Cancel Booking</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No bookings found.</p>
            <?php endif; ?>
        </div>
    </main>

    <?php include '../includes/footer.php'; ?> <!-- Include the footer -->
</body>
</html>
