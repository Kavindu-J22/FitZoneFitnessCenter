<?php
include '../includes/db.php'; // Database connection
session_start();

// Fetch all classes from the database
$classes = $conn->query("SELECT * FROM classes");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Classes</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Link to your CSS file -->
</head>
<body>
    <?php include '../includes/header.php'; ?> <!-- Include the header -->

    <main>
        <h2>Available Classes</h2>
        <div class="class-list">
            <?php if ($classes->num_rows > 0): ?>
                <?php while ($class = $classes->fetch_assoc()): ?>
                    <div class="class-item">
                        <h3><?php echo htmlspecialchars($class['class_name']); ?></h3>
                        <p><strong>Type:</strong> <?php echo htmlspecialchars($class['class_type']); ?></p>
                        <p><strong>Time:</strong> <?php echo htmlspecialchars($class['class_time']); ?></p>
                        <p><strong>Date:</strong> <?php echo htmlspecialchars($class['date']); ?></p>
                        <p><strong>Conductor:</strong> <?php echo htmlspecialchars($class['conductor']); ?></p>

                        <a href="classBooking.php?class_id=<?php echo $class['id']; ?>" class="btn">Book an Appointment</a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No classes available at the moment.</p>
            <?php endif; ?>
        </div>
    </main>

    <?php include '../includes/footer.php'; ?> <!-- Include the footer -->
</body>
</html>
