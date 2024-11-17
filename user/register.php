<?php
include '../includes/db.php';
session_start();

// Handle registration logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = password_hash(trim($_POST['password']), PASSWORD_BCRYPT); // Hash the password
    $contact_number = trim($_POST['contact_number']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);
    $role = 'customer'; // Default role for new registrations

    // Check if the username already exists in the database
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "Error: Username already taken. Please choose a different one.";
    } else {
        // Insert user data into the database if username is unique
        $stmt = $conn->prepare("INSERT INTO users (username, password, contact_number, email, address, role) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $username, $password, $contact_number, $email, $address, $role);

        if ($stmt->execute()) {
            echo "Registration successful! You can now log in.";
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <main>
        <h2>Register</h2>
        <form id="registerForm" method="post" action="register.php">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <label for="contact_number">Contact Number:</label>
            <input type="text" id="contact_number" name="contact_number" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="address">Address:</label>
            <textarea id="address" name="address" required></textarea>
            
            <button type="submit">Register</button>
        </form>
    </main>
    <?php include '../includes/footer.php'; ?>
    <script src="js/validation.js"></script> <!-- Include the validation script -->
</body>
</html>
