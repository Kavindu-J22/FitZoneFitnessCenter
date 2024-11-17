<?php
include '../includes/db.php'; // Database connection
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../user/login.php"); // Redirect to login if not logged in
    exit();
}

$user_id = $_SESSION['user_id']; // Get the logged-in user ID

// Fetch queries for the logged-in user
$stmt = $conn->prepare("SELECT * FROM queries WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Queries</title>
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
            font-size: 28px;
            color: #2d3436;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #00b894;
            color: white;
            font-size: 16px;
        }

        td {
            font-size: 14px;
            color: #2d3436;
        }

        td a.btn {
            display: inline-block;
            padding: 8px 15px;
            margin-right: 10px;
            text-decoration: none;
            font-size: 14px;
            border-radius: 5px;
            color: white;
            background-color: #3498db;
            transition: background-color 0.3s;
        }

        td a.btn:hover {
            background-color: #2980b9;
        }

        .btn-delete {
            background-color: #e74c3c;
        }

        .btn-delete:hover {
            background-color: #c0392b;
        }

        td a.btn, td a.btn-delete {
            transition: background-color 0.3s ease;
        }

        .no-queries {
            text-align: center;
            font-size: 18px;
            color: #7f8c8d;
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

        /* Responsive Design */
        @media (max-width: 768px) {
            main {
                padding: 20px;
            }

            h2 {
                font-size: 24px;
            }

            table th, table td {
                font-size: 14px;
                padding: 10px;
            }

            td a.btn {
                padding: 6px 12px;
                font-size: 12px;
            }
        }
    </style>
</head>
<body>

<?php include '../includes/header.php'; ?> <!-- Include the header -->

<main>
    <h2>My Queries</h2>

    <div class="back-to-db-container">
        <a class="back-to-db" href="dashboard.php">Back to Dashboard</a>
    </div>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Query Title</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Reply</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($query = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($query['query_title']); ?></td>
                        <td><?php echo htmlspecialchars($query['description']); ?></td>
                        <td><?php echo htmlspecialchars($query['status']); ?></td>
                        <td><?php echo htmlspecialchars($query['reply']); ?></td>
                        <td>
                            <a href="edit_query.php?id=<?php echo $query['id']; ?>" class="btn">Edit</a>
                            <a href="delete_query.php?id=<?php echo $query['id']; ?>" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this query?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="no-queries">You have no queries yet.</p>
    <?php endif; ?>
</main>


</body>
</html>
