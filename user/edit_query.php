<?php
include '../includes/db.php'; // Database connection
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../user/login.php");
    exit();
}

$query_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Fetch the query details
$stmt = $conn->prepare("SELECT * FROM queries WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $query_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$query = $result->fetch_assoc();
$stmt->close();

// Handle form submission for editing
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $query_title = trim($_POST['query_title']);
    $description = trim($_POST['description']);

    if (empty($query_title) || empty($description)) {
        $error_message = "All fields are required.";
    } else {
        $stmt = $conn->prepare("UPDATE queries SET query_title = ?, description = ? WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ssii", $query_title, $description, $query_id, $user_id);

        if ($stmt->execute()) {
            header("Location: view_queries.php"); // Redirect to view queries page
            exit();
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
    <title>Edit Query</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Link to your CSS file -->
</head>
<body>
    <?php include '../includes/header.php'; ?> <!-- Include the header -->
    <main>
        <h2>Edit Query</h2>

        <?php if (isset($error_message)): ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <form method="post" action="">
            <label for="query_title">Query Title:</label>
            <input type="text" id="query_title" name="query_title" value="<?php echo htmlspecialchars($query['query_title']); ?>" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4" required><?php echo htmlspecialchars($query['description']); ?></textarea>

            <button type="submit">Update Query</button>
        </form>
    </main>
    <?php include '../includes/footer.php'; ?> <!-- Include the footer -->
</body>
</html>
