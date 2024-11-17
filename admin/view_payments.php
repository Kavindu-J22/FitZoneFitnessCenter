<?php
include '../includes/db.php'; // Include your database connection
session_start();

// Check if the user is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../user/login.php");
    exit();
}

// Update status based on action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['payment_id'])) {
    $action = $_POST['action'];
    $paymentId = $_POST['payment_id'];

    if ($action === 'accept') {
        $status = 'accepted';
    } elseif ($action === 'reject') {
        $status = 'rejected';
    }

    $stmt = $conn->prepare("UPDATE payments SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $paymentId);
    $stmt->execute();
    $stmt->close();

    // Refresh the page to see the updates
    header("Location: view_payments.php");
    exit();
}

// Fetch all payment records from the database
$query = "SELECT * FROM payments ORDER BY created_at DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Payments</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        /* General Styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
        }
        
        main {
            max-width: 1200px;
            margin: 30px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        .back-to-db-container {
            text-align: right;
            margin-bottom: 20px;
        }

        .back-to-db {
            font-size: 14px;
            color: #007bff;
            text-decoration: none;
            border: 1px solid #007bff;
            padding: 8px 16px;
            border-radius: 5px;
            background-color: #f1f9ff;
            transition: all 0.3s ease;
        }

        .back-to-db:hover {
            background-color: #007bff;
            color: white;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f1f9ff;
            color: #333;
        }

        td a {
            color: #007bff;
            text-decoration: none;
        }

        td a:hover {
            text-decoration: underline;
        }

        td button {
            padding: 6px 12px;
            margin: 5px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        td button:hover {
            opacity: 0.8;
        }

        .accept-button {
            background-color: #28a745;
            color: white;
        }

        .reject-button {
            background-color: #dc3545;
            color: white;
        }

        .accept-button:hover {
            background-color: #218838;
        }

        .reject-button:hover {
            background-color: #c82333;
        }

        .error, .success {
            color: white;
            padding: 10px;
            margin-bottom: 20px;
            text-align: center;
            border-radius: 5px;
        }

        .error {
            background-color: #dc3545;
        }

        .success {
            background-color: #28a745;
        }
    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <main>
        <h2>All Payments</h2>
        <div class="back-to-db-container">
            <a class="back-to-db" href="dashboard.php">Back to Dashboard</a>
        </div>

        <?php if (isset($error_message)): ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <?php if (isset($success_message)): ?>
            <p class="success"><?php echo $success_message; ?></p>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>User ID</th>
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
                            <td><?php echo htmlspecialchars($row['userId']); ?></td>
                            <td><?php echo htmlspecialchars($row['paymentType']); ?></td>
                            <td><?php echo htmlspecialchars($row['subscription']); ?></td>
                            <td><?php echo htmlspecialchars($row['price']); ?></td>
                            <td><?php echo htmlspecialchars($row['status']); ?></td>
                            <td>
                                <a href="<?php echo htmlspecialchars($row['paymentSlip']); ?>" target="_blank">
                                    View Slip
                                </a>
                            </td>
                            <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                            <td>
                                <?php if ($row['status'] === 'pending'): ?>
                                    <form method="post" style="display: inline;">
                                        <input type="hidden" name="payment_id" value="<?php echo $row['id']; ?>">
                                        <input type="hidden" name="action" value="accept">
                                        <button type="submit" class="accept-button">Accept</button>
                                    </form>
                                    <form method="post" style="display: inline;">
                                        <input type="hidden" name="payment_id" value="<?php echo $row['id']; ?>">
                                        <input type="hidden" name="action" value="reject">
                                        <button type="submit" class="reject-button">Reject</button>
                                    </form>
                                <?php elseif ($row['status'] === 'accepted'): ?>
                                    <form method="post" style="display: inline;">
                                        <input type="hidden" name="payment_id" value="<?php echo $row['id']; ?>">
                                        <input type="hidden" name="action" value="reject">
                                        <button type="submit" class="reject-button">Reject</button>
                                    </form>
                                <?php elseif ($row['status'] === 'rejected'): ?>
                                    <form method="post" style="display: inline;">
                                        <input type="hidden" name="payment_id" value="<?php echo $row['id']; ?>">
                                        <input type="hidden" name="action" value="accept">
                                        <button type="submit" class="accept-button">Accept</button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">No payment records found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
</body>
</html>
