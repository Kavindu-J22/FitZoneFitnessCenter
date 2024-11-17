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
    <link rel="stylesheet" href="../css/style.css"> <!-- Assuming you have a general style.css file -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        header {
            text-align: center;
            background-color: #2c3e50;
            color: white;
            padding: 20px;
        }

        main {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .form-container {
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            text-align: center;
            animation: fadeIn 0.5s ease-in-out;
        }

        .form-container h1 {
            color: #333;
            margin-bottom: 20px;
            font-size: 24px;
        }

        .form-container form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .form-container label {
            font-size: 16px;
            color: #555;
            margin-bottom: 8px;
            text-align: left;
            width: 100%;
            padding-left: 15px;
        }

        .form-container input,
        .form-container textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 16px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        .form-container button {
            padding: 12px 20px;
            background-color: #3498db;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        .form-container button:hover {
            background-color: #2980b9;
            transform: scale(1.05);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .form-container {
                width: 90%;
                padding: 20px;
            }
        }
    </style>
</head>
<body>

<header>
    <h2>FitZone Fitness Center</h2>
</header>

<main>
    <div class="form-container">
        <h1>Edit Profile</h1>

        <form method="POST" action="edit_profile.php">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

            <label for="contact_number">Contact Number:</label>
            <input type="text" id="contact_number" name="contact_number" value="<?php echo htmlspecialchars($user['contact_number']); ?>">

            <label for="address">Address:</label>
            <textarea id="address" name="address"><?php echo htmlspecialchars($user['address']); ?></textarea>

            <label for="password">New Password (leave blank if not changing):</label>
            <input type="password" id="password" name="password">

            <button type="submit">Save Changes</button>
        </form>
    </div>
</main>

</body>
</html>
