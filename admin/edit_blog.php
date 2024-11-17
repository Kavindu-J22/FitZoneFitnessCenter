<?php
include '../includes/db.php'; // Database connection
session_start();

// Check if the user is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../user/login.php");
    exit();
}

// Get the blog ID from the query string
$blogId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch the blog post details
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

// Handle blog post update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category = trim($_POST['category']);
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $image_url = trim($_POST['image_url']); // Cloudinary image URL

    // Update the blog post in the database
    $stmt = $conn->prepare("UPDATE blogs SET category = ?, name = ?, description = ?, image_url = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $category, $name, $description, $image_url, $blogId);
    $stmt->execute();
    $stmt->close();

    // Redirect to the create_blog.php page after updating
    header("Location: create_blog.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Blog Post</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://widget.cloudinary.com/v2.0/global/all.js" type="text/javascript"></script>
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <main>
        <h2>Edit Blog Post</h2>
        <form method="post" action="edit_blog.php?id=<?php echo $blogId; ?>">
            <label for="category">Category:</label>
            <input type="text" id="category" name="category" value="<?php echo htmlspecialchars($blog['category']); ?>" required>

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($blog['name']); ?>" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required><?php echo htmlspecialchars($blog['description']); ?></textarea>

            <label for="image">Image:</label>
            <input type="file" id="image" accept="image/*">
            <input type="hidden" name="image_url" id="image_url" value="<?php echo htmlspecialchars($blog['image_url']); ?>" required>
            <button type="button" onclick="uploadImage()">Upload New Image</button>

            <button type="submit">Update Blog Post</button>
        </form>
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
