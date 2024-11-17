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
</head>
<body>
    <?php include '../includes/header.php'; ?> <!-- Include the header -->
    <main>
        <h2>Add Staff Member</h2>

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
                            <a href="edit_staff.php?id=<?php echo $staff['id']; ?>" class="btn">Edit</a>
                            <a href="delete_staff.php?id=<?php echo $staff['id']; ?>" class="btn">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>
    <?php include '../includes/footer.php'; ?> <!-- Include the footer -->
</body>
</html>
