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
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
        }

        main {
            width: 90%;
            max-width: 600px;
            margin: 40px auto;
            padding: 30px;
            background-color: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            text-align: center;
            font-size: 28px;
            color: #2d3436;
            margin-bottom: 30px;
        }

        label {
            font-size: 16px;
            color: #2d3436;
            margin-bottom: 10px;
            display: block;
        }

        input, textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            color: #2d3436;
            box-sizing: border-box;
        }

        textarea {
            resize: vertical;
        }

        button {
            padding: 12px 20px;
            background-color: #00b894;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
        }

        button:hover {
            background-color: #098e67;
        }

        .error {
            color: #e74c3c;
            font-size: 16px;
            text-align: center;
            margin-bottom: 20px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            main {
                padding: 20px;
            }

            h2 {
                font-size: 24px;
            }

            input, textarea, button {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

<?php include '../includes/header.php'; ?> <!-- Include the header -->

<main>
    <h2>Edit Your Query</h2>

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



</body>
</html>
