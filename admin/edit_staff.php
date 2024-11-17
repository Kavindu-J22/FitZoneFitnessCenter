<?php
include '../includes/db.php'; // Database connection
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../user/login.php"); // Redirect to login if not admin
    exit();
}

// Get the staff member ID from the query string
if (isset($_GET['id'])) {
    $staff_id = $_GET['id'];
} else {
    header("Location: add_staff.php"); // Redirect if no ID is provided
    exit();
}

// Fetch the current staff details
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ? AND role = 'staff'");
$stmt->bind_param("i", $staff_id);
$stmt->execute();
$result = $stmt->get_result();
$staff = $result->fetch_assoc();

if (!$staff) {
    header("Location: add_staff.php"); // Redirect if staff member not found
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $contact_number = trim($_POST['contact_number']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);

    // Validate form inputs
    if (empty($username) || empty($contact_number) || empty($email) || empty($address)) {
        $error_message = "All fields are required.";
    } else {
        // Update the staff member details
        $stmt = $conn->prepare("UPDATE users SET username = ?, contact_number = ?, email = ?, address = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $username, $contact_number, $email, $address, $staff_id);

        if ($stmt->execute()) {
            $success_message = "Staff member updated successfully!";
        } else {
            $error_message = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Staff Member</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Link to your CSS file -->
</head>
<body>
    <?php include '../includes/header.php'; ?> <!-- Include the header -->
    <main>
        <h2>Edit Staff Member</h2>

        <?php if (isset($error_message)): ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <?php if (isset($success_message)): ?>
            <p class="success"><?php echo $success_message; ?></p>
        <?php endif; ?>

        <form method="post" action="edit_staff.php?id=<?php echo $staff['id']; ?>">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($staff['username']); ?>" required>

            <label for="contact_number">Contact Number:</label>
            <input type="text" id="contact_number" name="contact_number" value="<?php echo htmlspecialchars($staff['contact_number']); ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($staff['email']); ?>" required>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($staff['address']); ?>" required>

            <button type="submit">Update Staff Member</button>
        </form>
    </main>
    <?php include '../includes/footer.php'; ?> <!-- Include the footer -->
</body>
</html>
