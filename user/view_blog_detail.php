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
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
        }

        main {
            width: 90%;
            max-width: 1000px;
            margin: 40px auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            font-size: 36px;
            color: #2d3436;
            margin-bottom: 20px;
        }

        p {
            font-size: 18px;
            color: #636e72;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .blog-category {
            font-weight: bold;
            color: #00b894;
            margin-bottom: 15px;
        }

        img {
            width: 50%;
            height: auto;
            border-radius: 8px;
            margin-top: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
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
            margin-top: 20px;
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

            p {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <main>
        <h2><?php echo htmlspecialchars($blog['name']); ?></h2>
        <p class="blog-category"><strong>Category:</strong> <?php echo htmlspecialchars($blog['category']); ?></p>
        <img src="<?php echo htmlspecialchars($blog['image_url']); ?>" alt="Blog Image">
        <p><?php echo nl2br(htmlspecialchars($blog['description'])); ?></p>
        <a href="blogs.php" class="btn">Back to Blog List</a>
    </main>
</body>
</html>
