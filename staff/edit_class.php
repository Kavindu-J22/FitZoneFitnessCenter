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
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <main>
        <h2>Edit Class</h2>
        
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
    <?php include '../includes/footer.php'; ?>
</body>
</html>
