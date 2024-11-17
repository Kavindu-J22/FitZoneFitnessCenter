<?php
include '../includes/db.php'; // Include your database connection
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../user/login.php");
    exit();
}

// Get the logged-in user's ID
$loggedUserId = $_SESSION['user_id'];

// Fetch user data from the database
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $loggedUserId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit();
}

// Handle the reply submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['query_id'])) {
    $query_id = $_POST['query_id'];
    $reply = trim($_POST['reply']);

    if (!empty($reply)) {
        // Update the query with the reply and change the status to "Replied"
        $stmt = $conn->prepare("UPDATE queries SET reply = ?, status = 'Replied' WHERE id = ?");
        $stmt->bind_param("si", $reply, $query_id);
        $stmt->execute();
        $stmt->close();
        $success_message = "Reply submitted successfully!";
    } else {
        $error_message = "Reply cannot be empty.";
    }
}

// Fetch all queries from the database
$queries = $conn->query("SELECT * FROM queries");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View All Queries</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Link to your CSS file -->
    <style>
        /* General page layout */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        main {
            max-width: 900px;
            margin: 30px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .back-to-db-container {
            text-align: right;
            margin-bottom: 15px;
        }

        .back-to-db {
            color: #007bff;
            text-decoration: none;
            font-size: 16px;
        }

        .back-to-db:hover {
            text-decoration: underline;
        }

        .queries {
            margin-top: 20px;
        }

        .query-item {
            background-color: #fafafa;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .query-item p {
            margin: 5px 0;
            color: #333;
        }

        .query-item strong {
            color: #007bff;
        }

        form {
            margin-top: 20px;
            padding: 10px;
            border-top: 1px solid #ddd;
        }

        textarea {
            width: 100%;
            height: 100px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            color: #333;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        .error, .success {
            text-align: center;
            font-size: 16px;
            padding: 10px;
            margin: 20px 0;
            border-radius: 4px;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
        }
    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?> <!-- Include the header -->

    <main>
        <h2>All User Queries</h2>
        
        <!-- Back to Dashboard Link -->
        <div class="back-to-db-container">
            <a href="#" id="back-to-dashboard" class="back-to-db">Back to Dashboard</a>
        </div>

        <?php if (isset($error_message)): ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <?php if (isset($success_message)): ?>
            <p class="success"><?php echo $success_message; ?></p>
        <?php endif; ?>

        <div class="queries">
            <?php while ($query = $queries->fetch_assoc()): ?>
                <div class="query-item">
                    <p><strong>User ID:</strong> <?php echo htmlspecialchars($query['user_id']); ?></p>
                    <p><strong>Title:</strong> <?php echo htmlspecialchars($query['query_title']); ?></p>
                    <p><strong>Description:</strong> <?php echo htmlspecialchars($query['description']); ?></p>
                    <p><strong>Status:</strong> <?php echo htmlspecialchars($query['status']); ?></p>
                    <p><strong>Reply:</strong> <?php echo htmlspecialchars($query['reply']); ?></p>

                    <!-- Form to submit a reply -->
                    <form method="post" action="view_queries.php">
                        <input type="hidden" name="query_id" value="<?php echo $query['id']; ?>">
                        <label for="reply-<?php echo $query['id']; ?>">Reply:</label>
                        <textarea id="reply-<?php echo $query['id']; ?>" name="reply"></textarea>
                        <button type="submit">Submit Reply</button>
                    </form>
                </div>
            <?php endwhile; ?>
        </div>
    </main>

    <script>
    // JavaScript to dynamically navigate based on user role
    const userRole = <?php echo json_encode($user['role']); ?>; // Get the user role from PHP
    const dashboardBtn = document.getElementById('back-to-dashboard');
    
    // Set the appropriate link based on the user's role
    if (userRole === 'customer') {
        dashboardBtn.href = 'dashboard.php';
    } else if (userRole === 'admin') {
        dashboardBtn.href = '../admin/dashboard.php';
    } else if (userRole === 'staff') {
        dashboardBtn.href = '../staff/dashboard.php';
    }
</script>

</body>
</html>
