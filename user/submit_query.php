<?php
include '../includes/db.php'; // Database connection
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../user/login.php"); // Redirect to login if not logged in
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $query_title = trim($_POST['query_title']);
    $description = trim($_POST['description']);
    $status = 'Pending'; // Default status

    // Validate form inputs
    if (empty($query_title) || empty($description)) {
        $error_message = "All fields are required.";
    } else {
        $user_id = $_SESSION['user_id']; // Get the logged-in user ID

        // Insert the query into the database
        $stmt = $conn->prepare("INSERT INTO queries (user_id, query_title, description, status) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $user_id, $query_title, $description, $status);

        if ($stmt->execute()) {
            $success_message = "Your query has been submitted successfully!";
        } else {
            $error_message = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Query</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Link to your CSS file -->
</head>
<body>
    <?php include '../includes/header.php'; ?> <!-- Include the header -->
    <main>
        <h2>Create a New Query</h2>

        <?php if (isset($error_message)): ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <?php if (isset($success_message)): ?>
            <p class="success"><?php echo $success_message; ?></p>
        <?php endif; ?>

        <form method="post" action="submit_query.php">
            <label for="query_title">Query Title:</label>
            <input type="text" id="query_title" name="query_title" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4" required></textarea>

            <button type="submit">Submit Query</button>
        </form>

        <a href="view_queries.php" class="btn">View My Queries</a>
    </main>
    <?php include '../includes/footer.php'; ?> <!-- Include the footer -->
</body>
</html>
