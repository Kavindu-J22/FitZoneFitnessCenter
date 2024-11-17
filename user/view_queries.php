<?php
include '../includes/db.php'; // Database connection
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../user/login.php"); // Redirect to login if not logged in
    exit();
}

$user_id = $_SESSION['user_id']; // Get the logged-in user ID

// Fetch queries for the logged-in user
$stmt = $conn->prepare("SELECT * FROM queries WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Queries</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Link to your CSS file -->
</head>
<body>
    <?php include '../includes/header.php'; ?> <!-- Include the header -->
    <main>
        <h2>My Queries</h2>

        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Query Title</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Reply</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($query = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($query['query_title']); ?></td>
                            <td><?php echo htmlspecialchars($query['description']); ?></td>
                            <td><?php echo htmlspecialchars($query['status']); ?></td>
                            <td><?php echo htmlspecialchars($query['reply']); ?></td>
                            <td>
                                <a href="edit_query.php?id=<?php echo $query['id']; ?>" class="btn">Edit</a>
                                <a href="delete_query.php?id=<?php echo $query['id']; ?>" class="btn" onclick="return confirm('Are you sure you want to delete this query?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>You have no queries yet.</p>
        <?php endif; ?>
    </main>
    <?php include '../includes/footer.php'; ?> <!-- Include the footer -->
</body>
</html>

