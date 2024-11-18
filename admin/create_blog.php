<?php
include '../includes/db.php'; // Database connection
session_start();

// Handle blog post submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category = trim($_POST['category']);
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $image_url = trim($_POST['image_url']); // Cloudinary image URL

    // Insert the new blog post into the database
    $stmt = $conn->prepare("INSERT INTO blogs (category, name, description, image_url) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $category, $name, $description, $image_url);
    $stmt->execute();
    $stmt->close();

    // Redirect to refresh the page after submission
    header("Location: create_blog.php");
    exit();
}

// Fetch all blog posts from the database
$blogs = $conn->query("SELECT * FROM blogs");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Blog Post</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://widget.cloudinary.com/v2.0/global/all.js" type="text/javascript"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }
        main {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #34495E;
            margin-bottom: 20px;
        }
        .back-to-db-container {
            text-align: right;
            margin-bottom: 20px;
        }
        .back-to-db {
            font-size: 16px;
            color: #2980B9;
            text-decoration: none;
        }
        .back-to-db:hover {
            text-decoration: underline;
        }
        form {
            display: grid;
            gap: 15px;
        }
        label {
            font-size: 16px;
            color: #34495E;
        }
        input[type="text"], textarea {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 100%;
        }
        input[type="file"] {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            padding: 12px 18px;
            font-size: 16px;
            background-color: #2980B9;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #1A6D8C;
        }
        .blog-posts {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: space-between;
            margin-top: 40px;
        }
        .blog-post {
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 48%;
            transition: transform 0.3s ease;
        }
        .blog-post:hover {
            transform: translateY(-10px);
        }
        .blog-post img {
            max-width: 100%;
            border-radius: 4px;
            margin-bottom: 15px;
        }
        .blog-post h4 {
            color: #2980B9;
            margin-bottom: 10px;
        }
        .blog-post p {
            font-size: 14px;
            color: #7F8C8D;
            margin-bottom: 15px;
        }
        .btn {
            padding: 8px 12px;
            background-color: #34495E;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            margin-right: 10px;
        }
        .btn:hover {
            background-color: #2C3E50;
        }
    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <main>
        <h2>Create Blog Post</h2>
        <div class="back-to-db-container">
            <a class="back-to-db" href="dashboard.php">Back to Dashboard</a>
        </div>
        <form method="post" action="create_blog.php">
            <label for="category">Category:</label>
            <input type="text" id="category" name="category" required>
            
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            
            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>
            
            <label for="image">Image:</label>
            <input type="file" id="image" accept="image/*">
            <input type="hidden" name="image_url" id="image_url" required>
            <button type="button" onclick="uploadImage()">Upload Image</button>
            
            <button type="submit">Add Blog Post</button>
        </form>

        <h3>Added Blog Posts</h3>
        <div class="blog-posts">
            <?php while ($blog = $blogs->fetch_assoc()): ?>
                <div class="blog-post">
                    <h4><?php echo htmlspecialchars($blog['name']); ?></h4>
                    <p><strong>Category:</strong> <?php echo htmlspecialchars($blog['category']); ?></p>
                    <p><?php echo htmlspecialchars($blog['description']); ?></p>
                    <img src="<?php echo htmlspecialchars($blog['image_url']); ?>" alt="Blog Image">
                    <a href="edit_blog.php?id=<?php echo $blog['id']; ?>" class="btn">Edit</a>
                    <a href="delete_blog.php?id=<?php echo $blog['id']; ?>" class="btn" onclick="return confirm('Admin only can delete blogs. Are you sure you want to Continue this ?');">Delete</a>
                </div>
            <?php endwhile; ?>
        </div>
    </main>
    <?php include '../includes/footer.php'; ?>

    <script>
        function uploadImage() {
            const cloudName = 'dgecq2e6l';
            const uploadPreset = 'jmrpithq';

            const fileInput = document.getElementById('image');
            const imageUrlInput = document.getElementById('image_url');

            if (fileInput.files.length > 0) {
                const file = fileInput.files[0];
                const formData = new FormData();
                formData.append('file', file);
                formData.append('upload_preset', uploadPreset);

                fetch(`https://api.cloudinary.com/v1_1/${cloudName}/image/upload`, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    imageUrlInput.value = data.secure_url;
                    alert('Image uploaded successfully!');
                })
                .catch(error => {
                    console.error('Error uploading image:', error);
                    alert('Failed to upload image.');
                });
            } else {
                alert('Please select an image to upload.');
            }
        }
    </script>
</body>
</html>
