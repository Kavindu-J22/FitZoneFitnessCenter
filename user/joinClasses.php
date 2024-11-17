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
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
        }

        main {
            width: 90%;
            max-width: 1000px;
            margin: 40px auto;
            padding: 30px;
            background-color: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            text-align: center;
            font-size: 32px;
            color: #2d3436;
            margin-bottom: 30px;
        }

        .class-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }

        .class-item {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .class-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        }

        .class-item h3 {
            font-size: 24px;
            color: #2d3436;
            margin-bottom: 15px;
        }

        .class-item p {
            font-size: 16px;
            color: #555;
            margin-bottom: 10px;
        }

        .class-item strong {
            font-weight: bold;
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
            padding: 12px 20px;
            background-color: #00b894;
            color: white;
            font-size: 16px;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 15px;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #098e67;
        }

        @media (max-width: 768px) {
            main {
                padding: 20px;
            }

            h2 {
                font-size: 28px;
            }

            .class-item {
                padding: 15px;
            }

            .btn {
                font-size: 14px;
                padding: 10px 16px;
            }
        }
    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?> <!-- Include the header -->

    <main>
        <h2>Available Classes</h2>

        <div class="back-to-db-container">
        <a class="back-to-db" href="dashboard.php">Back to Dashboard</a>
    </div>

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

</body>
</html>
