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
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
        }

        main {
            width: 90%;
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            font-size: 36px;
            color: #2d3436;
            text-align: center;
            margin-bottom: 30px;
        }

        .blog-posts {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
        }

        .blog-post {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .blog-post:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }

        .blog-post h3 {
            font-size: 24px;
            color: #2d3436;
            margin-bottom: 10px;
        }

        .blog-post p {
            font-size: 16px;
            color: #636e72;
            margin-bottom: 15px;
        }

        .blog-post img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 15px;
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

        .btn {
            display: inline-block;
            padding: 12px 20px;
            background-color: #00b894;
            color: white;
            font-size: 16px;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 10px;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #098e67;
        }

        @media (max-width: 768px) {
            main {
                padding: 15px;
            }

            h2 {
                font-size: 28px;
            }

            .btn {
                font-size: 14px;
                padding: 10px 16px;
            }
        }
    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <main>
        <h2>Our Blogs</h2>

        <div class="back-to-db-container">
        <a class="back-to-db" href="dashboard.php">Back to Dashboard</a>
    </div>

        <div class="blog-posts">
            <?php while ($blog = $blogs->fetch_assoc()): ?>
                <div class="blog-post">
                    <h3><?php echo htmlspecialchars($blog['name']); ?></h3>
                    <p><strong>Category:</strong> <?php echo htmlspecialchars($blog['category']); ?></p>
                    <p><?php echo nl2br(htmlspecialchars($blog['description'])); ?></p>
                    <img src="<?php echo htmlspecialchars($blog['image_url']); ?>" alt="Blog Image">
                    <a href="view_blog_detail.php?id=<?php echo $blog['id']; ?>" class="btn">View More</a>
                </div>
            <?php endwhile; ?>
        </div>
    </main>

</body>
</html>
