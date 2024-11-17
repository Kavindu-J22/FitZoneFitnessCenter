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
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        main {
            width: 90%;
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        h2 {
            font-size: 32px;
            color: #2d3436;
            margin-bottom: 20px;
            text-align: center;
        }

        .booking-list {
            width: 100%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #00b894;
            color: white;
            font-size: 18px;
        }

        td {
            font-size: 16px;
            color: #636e72;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .btn {
            display: inline-block;
            padding: 10px 15px;
            text-decoration: none;
            font-size: 16px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .delete-btn {
            background-color: #d63031;
            color: white;
            text-align: center;
        }

        .delete-btn:hover {
            background-color: #c0392b;
        }

        .back-to-db {
        display: inline-block;
        padding: 10px;
        background-color: #7f8c8d;
        text-decoration: none;
        color: white;
        border-radius: 5px;
        font-size: 16px;
        margin-top: 20px;
        transition: background-color 0.3s ease;
    }

        .back-to-db:hover {
            background-color: #34495e;
        }

        .back-to-db-container {
            text-align: center;
            margin-bottom: 20px;
        }


        .no-bookings {
            font-size: 18px;
            color: #636e72;
            text-align: center;
            margin-top: 20px;
        }

        @media (max-width: 768px) {
            table {
                font-size: 14px;
            }

            th, td {
                padding: 8px;
            }

            .btn {
                font-size: 14px;
                padding: 8px 12px;
            }

            h2 {
                font-size: 28px;
            }
        }
    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?> <!-- Include the header -->

    <main>
        <h2>My Bookings</h2>

        <div class="back-to-db-container">
        <a class="back-to-db" href="dashboard.php">Back to Dashboard</a>
    </div>

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
                <p class="no-bookings">No bookings found.</p>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
