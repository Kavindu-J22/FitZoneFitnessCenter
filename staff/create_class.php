<?php
include '../includes/db.php'; // Database connection
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

// Handle class submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $class_type = trim($_POST['class_type']);
    $class_name = trim($_POST['class_name']);
    $class_time = trim($_POST['class_time']);
    $date = trim($_POST['date']);
    $conductor = trim($_POST['conductor']);

    // Insert the new class into the database
    $stmt = $conn->prepare("INSERT INTO classes (class_type, class_name, class_time, date, conductor) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $class_type, $class_name, $class_time, $date, $conductor);
    $stmt->execute();
    $stmt->close();
}

// Fetch all classes from the database
$classes = $conn->query("SELECT * FROM classes");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Class</title>
    <link rel="stylesheet" href="../css/style.css">
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
            padding: 40px;
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

        form {
            margin-bottom: 30px;
        }

        form label {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 8px;
            display: block;
        }

        form input[type="text"],
        form input[type="time"],
        form input[type="date"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            color: #333;
            box-sizing: border-box;
        }

        /* Button styles */
        .btn {
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
            display: inline-block;
            text-align: center;
            margin-top: 10px;
            text-decoration: none;
        }

        .btn-add {
            background-color: #28a745;
        }

        .btn-add:hover {
            background-color: #218838;
        }

        .btn-edit {
            background-color: #ffc107;
        }

        .btn-edit:hover {
            background-color: #e0a800;
        }

        .btn-delete {
            background-color: #dc3545;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }

        .btn-view {
            background-color: #17a2b8;
        }

        .btn-view:hover {
            background-color: #138496;
        }

        form button {
            background-color: #007bff;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
        }

        form button:hover {
            background-color: #0056b3;
        }

        .class-list {
            margin-top: 40px;
        }

        .class-item {
            background-color: #fafafa;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .class-item p {
            margin: 5px 0;
            color: #333;
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

        /* Responsive design */
        @media (max-width: 768px) {
            main {
                padding: 20px;
            }

            form button {
                width: auto;
            }

            .class-item {
                padding: 15px;
            }

            .class-item a {
                font-size: 12px;
                padding: 6px 12px;
            }
        }
    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <main>
        <h2>Add New Class</h2>

        <!-- Back to Dashboard Link -->
        <div class="back-to-db-container">
            <a href="#" id="back-to-dashboard" class="back-to-db">Back to Dashboard</a>
        </div>

        <!-- Form for adding new class -->
        <form method="post" action="create_class.php">
            <label for="class_type">Class Type:</label>
            <input type="text" id="class_type" name="class_type" required>

            <label for="class_name">Class Name:</label>
            <input type="text" id="class_name" name="class_name" required>

            <label for="class_time">Class Time:</label>
            <input type="time" id="class_time" name="class_time" required>

            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required>

            <label for="conductor">Conductor:</label>
            <input type="text" id="conductor" name="conductor" required>

            <button type="submit">Add Class</button>
        </form>

        <h3>Existing Classes</h3>
        <div class="class-list">
            <?php while ($class = $classes->fetch_assoc()): ?>
                <div class="class-item">
                    <p><strong>Class Type:</strong> <?php echo htmlspecialchars($class['class_type']); ?></p>
                    <p><strong>Class Name:</strong> <?php echo htmlspecialchars($class['class_name']); ?></p>
                    <p><strong>Class Time:</strong> <?php echo htmlspecialchars($class['class_time']); ?></p>
                    <p><strong>Date:</strong> <?php echo htmlspecialchars($class['date']); ?></p>
                    <p><strong>Conductor:</strong> <?php echo htmlspecialchars($class['conductor']); ?></p>
                    <a href="edit_class.php?id=<?php echo $class['id']; ?>" class="btn btn-edit">Edit</a>
                    <a href="delete_class.php?id=<?php echo $class['id']; ?>" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this class?');">Delete</a>
                    <a href="classAttend.php?id=<?php echo $class['id']; ?>" class="btn btn-view">View Appointments and Attenders</a>
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
            dashboardBtn.href = "../customer/dashboard.php";
        } else if (userRole === 'admin') {
            dashboardBtn.href = "../admin/dashboard.php";
        } else if (userRole === 'staff') {
            dashboardBtn.href = "../staff/dashboard.php";
        }
    </script>
</body>
</html>
