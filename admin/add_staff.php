<?php
include '../includes/db.php'; // Database connection
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../user/login.php"); // Redirect to login if not admin
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $contact_number = trim($_POST['contact_number']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);

    // Validate form inputs
    if (empty($username) || empty($password) || empty($contact_number) || empty($email) || empty($address)) {
        $error_message = "All fields are required.";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Insert the staff member into the database
        $stmt = $conn->prepare("INSERT INTO users (username, password, contact_number, email, address, role) VALUES (?, ?, ?, ?, ?, 'staff')");
        $stmt->bind_param("sssss", $username, $hashed_password, $contact_number, $email, $address);

        if ($stmt->execute()) {
            $success_message = "Staff member added successfully!";
        } else {
            $error_message = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Fetch all staff members
$staff_query = "SELECT id, username, contact_number, email, address, role FROM users WHERE role = 'staff'";
$staff_result = $conn->query($staff_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Staff Member</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Link to your CSS file -->
    <style>
        /* Global styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #2c3e50;
            color: white;
            padding: 20px 0;
            text-align: center;
        }

        main {
            padding: 30px;
            max-width: 1200px;
            margin: 0 auto;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
            font-size: 28px;
            text-align: center;
        }

        .error, .success {
            text-align: center;
            font-size: 16px;
            margin-bottom: 20px;
        }

        .error {
            color: #e74c3c;
        }

        .success {
            color: #27ae60;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            max-width: 600px;
            margin: 0 auto;
        }

        form input, form button {
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
        }

        form button {
            background-color: #3498db;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        form button:hover {
            background-color: #2980b9;
        }

        table {
            width: 100%;
            margin-top: 30px;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #3498db;
            color: white;
            text-transform: uppercase;
        }

        table td {
            background-color: #f9f9f9;
        }

        table a {
            display: inline-block;
            padding: 8px 15px;
            text-decoration: none;
            color: white;
            border-radius: 4px;
            margin-right: 5px;
            margin-bottom: 5px;
            transition: background-color 0.3s;
        }

        .edit-btn {
            background-color: #2ecc71; /* Green */
        }

        .edit-btn:hover {
            background-color: #27ae60;
        }

        .delete-btn {
            background-color: #e74c3c; /* Red */
        }

        .delete-btn:hover {
            background-color: #c0392b;
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

        /* Responsive design */
        @media (max-width: 768px) {
            form {
                width: 100%;
            }

            table {
                font-size: 14px;
            }

            table th, table td {
                padding: 8px;
            }
        }
    </style>
</head>
<body>

<?php include '../includes/header.php'; ?>

<main>
    <h2>Add Staff Member</h2>
    <div class="back-to-db-container">
        <a class="back-to-db" href="dashboard.php">Back to Dashboard</a>
    </div>

    <?php if (isset($error_message)): ?>
        <p class="error"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <?php if (isset($success_message)): ?>
        <p class="success"><?php echo $success_message; ?></p>
    <?php endif; ?>

    <form method="post" action="add_staff.php">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <label for="contact_number">Contact Number:</label>
        <input type="text" id="contact_number" name="contact_number" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required>

        <button type="submit">Add Staff Member</button>
    </form>

    <h3>Staff Members</h3>
    <table>
        <thead>
            <tr>
                <th>Username</th>
                <th>Contact Number</th>
                <th>Email</th>
                <th>Address</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($staff = $staff_result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($staff['username']); ?></td>
                    <td><?php echo htmlspecialchars($staff['contact_number']); ?></td>
                    <td><?php echo htmlspecialchars($staff['email']); ?></td>
                    <td><?php echo htmlspecialchars($staff['address']); ?></td>
                    <td>
                        <a href="edit_staff.php?id=<?php echo $staff['id']; ?>" class="edit-btn">Edit</a>
                        <a href="delete_staff.php?id=<?php echo $staff['id']; ?>" class="delete-btn">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</main>

</body>
</html>
