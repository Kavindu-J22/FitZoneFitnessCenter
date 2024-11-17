<?php
include '../includes/db.php'; // Database connection

// Get the blog post ID from the query string
$blogId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch the blog post details from the database
$stmt = $conn->prepare("SELECT * FROM blogs WHERE id = ?");
$stmt->bind_param("i", $blogId);
$stmt->execute();
$result = $stmt->get_result();
$blog = $result->fetch_assoc();
$stmt->close();

if (!$blog) {
    echo "Blog post not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($blog['name']); ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <main>
        <h2><?php echo htmlspecialchars($blog['name']); ?></h2>
        <p><strong>Category:</strong> <?php echo htmlspecialchars($blog['category']); ?></p>
        <p><?php echo nl2br(htmlspecialchars($blog['description'])); ?></p>
        <img src="<?php echo htmlspecialchars($blog['image_url']); ?>" alt="Blog Image" width="600">
    </main>
    <?php include '../includes/footer.php'; ?>
</body>
</html>
