<?php
include '../includes/db.php'; // Database connection
session_start();

// Check if the user is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../user/login.php");
    exit();
}

// Get the class ID from the query string
$classId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch the class data from the database
if ($classId > 0) {
    $stmt = $conn->prepare("SELECT * FROM classes WHERE id = ?");
    $stmt->bind_param("i", $classId);
    $stmt->execute();
    $result = $stmt->get_result();
    $class = $result->fetch_assoc();
    $stmt->close();
}

// Handle class update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $class_type = trim($_POST['class_type']);
    $class_name = trim($_POST['class_name']);
    $class_time = trim($_POST['class_time']);
    $date = trim($_POST['date']);
    $conductor = trim($_POST['conductor']);

    // Update the class data in the database
    $stmt = $conn->prepare("UPDATE classes SET class_type = ?, class_name = ?, class_time = ?, date = ?, conductor = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $class_type, $class_name, $class_time, $date, $conductor, $classId);
    $stmt->execute();
    $stmt->close();

    // Redirect to the add class page after update
    header("Location: create_class.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Class</title>
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

        /* Back button */
        .back-btn {
            color: #007bff;
            text-decoration: none;
            font-size: 16px;
            display: inline-block;
            margin-bottom: 20px;
            text-align: center;
        }

        .back-btn:hover {
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
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            color: #333;
            box-sizing: border-box;
        }

        button {
            background-color: #28a745;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
        }

        button:hover {
            background-color: #218838;
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
        }
    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <main>
        <!-- Back Button -->
        <a href="create_class.php" class="back-btn">← Back to Classes</a>

        <h2>Edit Class</h2>

        <!-- Display class data -->
        <?php if ($class): ?>
            <form method="post" action="edit_class.php?id=<?php echo $class['id']; ?>">
                <label for="class_type">Class Type:</label>
                <input type="text" id="class_type" name="class_type" value="<?php echo htmlspecialchars($class['class_type']); ?>" required>
                
                <label for="class_name">Class Name:</label>
                <input type="text" id="class_name" name="class_name" value="<?php echo htmlspecialchars($class['class_name']); ?>" required>
                
                <label for="class_time">Class Time:</label>
                <input type="time" id="class_time" name="class_time" value="<?php echo htmlspecialchars($class['class_time']); ?>" required>
                
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($class['date']); ?>" required>
                
                <label for="conductor">Conductor:</label>
                <input type="text" id="conductor" name="conductor" value="<?php echo htmlspecialchars($class['conductor']); ?>" required>
                
                <button type="submit">Update Class</button>
            </form>
        <?php else: ?>
            <p>Class not found!</p>
        <?php endif; ?>
    </main>
</body>
</html>
