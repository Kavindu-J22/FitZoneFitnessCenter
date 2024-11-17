<?php
include '../includes/db.php'; // Include your database connection
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../user/login.php");
    exit();
}

// Get the logged-in user's ID
$loggedUserId = $_SESSION['user_id'];

// Delete payment record based on action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['payment_id'])) {
    $paymentId = $_POST['payment_id'];

    // Prepare and execute the delete query
    $stmt = $conn->prepare("DELETE FROM payments WHERE id = ? AND userId = ?");
    $stmt->bind_param("is", $paymentId, $loggedUserId);
    $stmt->execute();
    $stmt->close();

    // Refresh the page to see the updates
    header("Location: my_payments.php");
    exit();
}

// Fetch payment records for the logged-in user
$query = "SELECT * FROM payments WHERE userId = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $loggedUserId);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Payments</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        main {
            width: 90%;
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        h2 {
            font-size: 32px;
            color: #2d3436;
            margin-bottom: 20px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
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

        tr:nth-child(even) {
            background-color: #f7f7f7;
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

        .cancel-btn {
            background-color: #e74c3c;
            color: white;
            text-align: center;
        }

        .cancel-btn:hover {
            background-color: #c0392b;
        }

        .view-slip {
            color: #00b894;
            text-decoration: none;
            font-weight: bold;
        }

        .view-slip:hover {
            text-decoration: underline;
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

        .no-payments {
            font-size: 18px;
            color: #636e72;
            text-align: center;
            margin-top: 20px;
        }

        @media (max-width: 768px) {
            th, td {
                padding: 8px;
                font-size: 14px;
            }

            h2 {
                font-size: 28px;
            }

            .btn {
                font-size: 14px;
                padding: 8px 12px;
            }
        }
    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <main>
        <h2>My Payments</h2>
        <div class="back-to-db-container">
        <a class="back-to-db" href="dashboard.php">Back to Dashboard</a>
    </div>
        <table>
            <thead>
                <tr>
                    <th>Payment Type</th>
                    <th>Subscription</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Payment Slip</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['paymentType']); ?></td>
                            <td><?php echo htmlspecialchars($row['subscription']); ?></td>
                            <td><?php echo htmlspecialchars($row['price']); ?></td>
                            <td><?php echo htmlspecialchars($row['status']); ?></td>
                            <td>
                                <a href="<?php echo htmlspecialchars($row['paymentSlip']); ?>" class="view-slip" target="_blank">
                                    View Slip
                                </a>
                            </td>
                            <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                            <td>
                                <form method="post" style="display: inline;">
                                    <input type="hidden" name="payment_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="btn cancel-btn" onclick="return confirm('Are you sure you want to cancel your membership?');">Cancel Membership</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="no-payments">No payment records found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>

</body>
</html>
