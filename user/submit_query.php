<?php
include '../includes/db.php'; // Database connection
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../user/login.php"); // Redirect to login if not logged in
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $query_title = trim($_POST['query_title']);
    $description = trim($_POST['description']);
    $status = 'Pending'; // Default status

    // Validate form inputs
    if (empty($query_title) || empty($description)) {
        $error_message = "All fields are required.";
    } else {
        $user_id = $_SESSION['user_id']; // Get the logged-in user ID

        // Insert the query into the database
        $stmt = $conn->prepare("INSERT INTO queries (user_id, query_title, description, status) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $user_id, $query_title, $description, $status);

        if ($stmt->execute()) {
            $success_message = "Your query has been submitted successfully!";
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
    <title>Create Query</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Link to your CSS file -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
        }

        main {
            width: 100%;
            max-width: 800px;
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
            margin-bottom: 20px;
        }

        .error, .success {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
        }

        .error {
            background-color: #e74c3c;
            color: white;
        }

        .success {
            background-color: #2ecc71;
            color: white;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        label {
            font-size: 16px;
            color: #2d3436;
        }

        input[type="text"], textarea {
            padding: 12px;
            font-size: 16px;
            border-radius: 6px;
            border: 1px solid #dfe6e9;
            background-color: #f1f2f6;
            resize: vertical;
        }

        input[type="text"]:focus, textarea:focus {
            outline-color: #00b894;
        }

        button {
            padding: 12px 20px;
            background-color: #00b894;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #098f6e;
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
            text-align: center;
            padding: 12px 20px;
            background-color: #3498db;
            color: white;
            border-radius: 6px;
            font-size: 16px;
            text-decoration: none;
            transition: background-color 0.3s;
            margin-top: 20px;
        }

        .btn:hover {
            background-color: #2980b9;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            main {
                padding: 20px;
            }

            h2 {
                font-size: 24px;
            }

            label, input, textarea {
                font-size: 14px;
            }

            button, .btn {
                padding: 10px 18px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

<?php include '../includes/header.php'; ?> <!-- Include the header -->

<main>

    <h2>Create a New Query</h2>

    <div class="back-to-db-container">
        <a class="back-to-db" href="dashboard.php">Back to Dashboard</a>
    </div>

    <?php if (isset($error_message)): ?>
        <p class="error"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <?php if (isset($success_message)): ?>
        <p class="success"><?php echo $success_message; ?></p>
    <?php endif; ?>

    <form method="post" action="submit_query.php">
        <label for="query_title">Query Title:</label>
        <input type="text" id="query_title" name="query_title" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description" rows="4" required></textarea>

        <button type="submit">Submit Query</button>
    </form>

    <a href="view_queries.php" class="btn">View My Queries</a>
</main>

</body>
</html>
