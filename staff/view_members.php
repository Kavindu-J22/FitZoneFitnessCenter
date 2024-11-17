<?php
include '../includes/db.php'; // Include your database connection
session_start();


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
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <main>
        <h2>All Members</h2>
        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Payment Type</th>
                    <th>Subscription</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Payment Slip</th>
                    <th>Date</th>
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
