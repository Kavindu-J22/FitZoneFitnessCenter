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
    <script src="https://widget.cloudinary.com/v2.0/global/all.js" type="text/javascript"></script>
    <style>
        /* Edit Blog Post Styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .edit-blog-main {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 40px;
        }

        .edit-blog-main h2 {
            text-align: center;
            color: #333;
        }

        .back-to-db-container {
            margin-bottom: 20px;
            text-align: center;
        }

        .back-to-db {
            color: #007bff;
            text-decoration: none;
            font-size: 16px;
        }

        .back-to-db:hover {
            text-decoration: underline;
        }

        .edit-blog-form label {
            font-size: 16px;
            margin-bottom: 5px;
            color: #555;
        }

        .input-field, .textarea-field {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            color: #333;
        }

        .textarea-field {
            height: 150px;
        }

        .upload-button, .submit-button {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-bottom: 5px;
        }

        .upload-button:hover, .submit-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <main class="edit-blog-main">
        <h2>Edit Blog Post</h2>
        
        <!-- Back Button -->
        <div class="back-to-db-container">
            <a class="back-to-db" href="create_blog.php">&larr; Back to Blog List</a>
        </div>

        <form method="post" action="edit_blog.php?id=<?php echo $blogId; ?>" class="edit-blog-form">
            <label for="category">Category:</label>
            <input type="text" id="category" name="category" value="<?php echo htmlspecialchars($blog['category']); ?>" required class="input-field">

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($blog['name']); ?>" required class="input-field">

            <label for="description">Description:</label>
            <textarea id="description" name="description" required class="textarea-field"><?php echo htmlspecialchars($blog['description']); ?></textarea>

            <label for="image">Image:</label>
            <input type="file" id="image" accept="image/*" class="input-field">
            <input type="hidden" name="image_url" id="image_url" value="<?php echo htmlspecialchars($blog['image_url']); ?>" required>
            <button type="button" class="upload-button" onclick="uploadImage()">Upload New Image</button>

            <button type="submit" class="submit-button">Update Blog Post</button>
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
