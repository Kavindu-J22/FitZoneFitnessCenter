<?php
include '../includes/db.php'; // Database connection

// Fetch all blog posts from the database
$blogs = $conn->query("SELECT * FROM blogs");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Posts</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <main>
        <h2>Our Blog</h2>
        
        <div class="blog-posts">
            <?php while ($blog = $blogs->fetch_assoc()): ?>
                <div class="blog-post">
                    <h3><?php echo htmlspecialchars($blog['name']); ?></h3>
                    <p><strong>Category:</strong> <?php echo htmlspecialchars($blog['category']); ?></p>
                    <p><?php echo nl2br(htmlspecialchars($blog['description'])); ?></p>
                    <img src="<?php echo htmlspecialchars($blog['image_url']); ?>" alt="Blog Image" width="400">
                    <a href="view_blog_detail.php?id=<?php echo $blog['id']; ?>" class="btn">View More</a>
                </div>
            <?php endwhile; ?>
        </div>
    </main>
    <?php include '../includes/footer.php'; ?>
</body>
</html>
