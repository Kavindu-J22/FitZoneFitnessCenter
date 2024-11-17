<?php
include '../includes/db.php'; // Include your database connection
session_start();


// Handle the reply submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['query_id'])) {
    $query_id = $_POST['query_id'];
    $reply = trim($_POST['reply']);

    if (!empty($reply)) {
        // Update the query with the reply and change the status to "Replied"
        $stmt = $conn->prepare("UPDATE queries SET reply = ?, status = 'Replied' WHERE id = ?");
        $stmt->bind_param("si", $reply, $query_id);
        $stmt->execute();
        $stmt->close();
        $success_message = "Reply submitted successfully!";
    } else {
        $error_message = "Reply cannot be empty.";
    }
}

// Fetch all queries from the database
$queries = $conn->query("SELECT * FROM queries");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View All Queries - Admin</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Link to your CSS file -->
</head>
<body>
    <?php include '../includes/header.php'; ?> <!-- Include the header -->

    <main>
        <h2>All User Queries</h2>

        <?php if (isset($error_message)): ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <?php if (isset($success_message)): ?>
            <p class="success"><?php echo $success_message; ?></p>
        <?php endif; ?>

        <div class="queries">
            <?php while ($query = $queries->fetch_assoc()): ?>
                <div class="query-item">
                    <p><strong>User ID:</strong> <?php echo htmlspecialchars($query['user_id']); ?></p>
                    <p><strong>Title:</strong> <?php echo htmlspecialchars($query['query_title']); ?></p>
                    <p><strong>Description:</strong> <?php echo htmlspecialchars($query['description']); ?></p>
                    <p><strong>Status:</strong> <?php echo htmlspecialchars($query['status']); ?></p>
                    <p><strong>Reply:</strong> <?php echo htmlspecialchars($query['reply']); ?></p>

                    <!-- Form to submit a reply -->
                    <form method="post" action="view_queries.php">
                        <input type="hidden" name="query_id" value="<?php echo $query['id']; ?>">
                        <label for="reply-<?php echo $query['id']; ?>">Reply:</label>
                        <textarea id="reply-<?php echo $query['id']; ?>" name="reply"></textarea>
                        <button type="submit">Submit Reply</button>
                    </form>
                </div>
                <hr>
            <?php endwhile; ?>
        </div>
    </main>

    <?php include '../includes/footer.php'; ?> <!-- Include the footer -->
</body>
</html>
