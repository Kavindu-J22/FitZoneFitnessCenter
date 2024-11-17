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
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <main>
        <h2>My Payments</h2>
        <table border="1" cellpadding="10" cellspacing="0">
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
                                <a href="<?php echo htmlspecialchars($row['paymentSlip']); ?>" target="_blank">
                                    View Slip
                                </a>
                            </td>
                            <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                            <td>
                                <form method="post" style="display: inline;">
                                    <input type="hidden" name="payment_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit">Cancel Membership</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No payment records found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
    <?php include '../includes/footer.php'; ?>
</body>
</html>
