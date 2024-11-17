<?php
include '../includes/db.php'; // Database connection
session_start();

// Check if the user is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../user/login.php");
    exit();
}

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
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <main>
        <h2>Create Blog Post</h2>
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
                    <img src="<?php echo htmlspecialchars($blog['image_url']); ?>" alt="Blog Image" width="200">
                    <a href="edit_blog.php?id=<?php echo $blog['id']; ?>" class="btn">Edit</a>
                    <a href="delete_blog.php?id=<?php echo $blog['id']; ?>" class="btn" onclick="return confirm('Are you sure you want to delete this post?');">Delete</a>
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
