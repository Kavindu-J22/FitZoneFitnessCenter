<?php
include '../includes/db.php'; // Include your database connection
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../user/login.php");
    exit();
}

// Get the logged-in user's ID
$loggedUserId = $_SESSION['user_id'];

// Fetch user data from the database
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $loggedUserId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit();
}

// Update profile if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $contact_number = $_POST['contact_number'];
    $address = $_POST['address'];
    $password = $_POST['password'];

    if (!empty($password)) {
        // Hash the password if it's updated
        $password = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE users SET username = ?, email = ?, contact_number = ?, address = ?, password = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssssi", $username, $email, $contact_number, $address, $password, $loggedUserId);
    } else {
        // If password is not updated, skip updating password
        $query = "UPDATE users SET username = ?, email = ?, contact_number = ?, address = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssi", $username, $email, $contact_number, $address, $loggedUserId);
    }

    if ($stmt->execute()) {
        // Redirect to the view profile page after successful update
        header("Location: view_profile.php");
        exit();
    } else {
        echo "Error updating profile.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
</head>
<body>
    <h1>Edit Profile</h1>
    <form method="POST" action="edit_profile.php">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br><br>

        <label for="contact_number">Contact Number:</label>
        <input type="text" id="contact_number" name="contact_number" value="<?php echo htmlspecialchars($user['contact_number']); ?>"><br><br>

        <label for="address">Address:</label>
        <textarea id="address" name="address"><?php echo htmlspecialchars($user['address']); ?></textarea><br><br>

        <label for="password">New Password (leave blank if not changing):</label>
        <input type="password" id="password" name="password"><br><br>

        <button type="submit">Save Changes</button>
    </form>
</body>
</html>
