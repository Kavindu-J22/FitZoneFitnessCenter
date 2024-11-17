<?php
// Database connection
$servername = "localhost";
$username = "root"; // Default XAMPP username
$password = ""; // Default XAMPP password (empty)
$dbname = "fitness_center"; // The database you created

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Admin credentials
$username = 'admin';
$password = password_hash('admin', PASSWORD_BCRYPT); // Hash the password
$role = 'admin';

// Insert the admin user into the database
$stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $password, $role);

if ($stmt->execute()) {
    echo "Admin user created successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
