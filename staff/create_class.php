<?php
include '../includes/db.php'; // Database connection
session_start();


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
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <main>
        <h2>Add New Class</h2>
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
                    <a href="edit_class.php?id=<?php echo $class['id']; ?>" class="btn">Edit</a>
                    <a href="delete_class.php?id=<?php echo $class['id']; ?>" class="btn" onclick="return confirm('Are you sure you want to delete this class?');">Delete</a>
                    <a href="classAttend.php?id=<?php echo $class['id']; ?>" class="btn">view Appointments and Attenders</a>
                </div>
            <?php endwhile; ?>
        </div>
    </main>
    <?php include '../includes/footer.php'; ?>
</body>
</html>
