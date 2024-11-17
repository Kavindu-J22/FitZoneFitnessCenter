<?php
include '../includes/db.php';
session_start();

$error_messages = []; // Array to hold error messages

// Handle registration logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = password_hash(trim($_POST['password']), PASSWORD_BCRYPT); // Hash the password
    $contact_number = trim($_POST['contact_number']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);
    $role = 'customer'; // Default role for new registrations

    // Validation checks
    if (empty($username)) {
        $error_messages[] = "Username is required.";
    }
    if (empty($password)) {
        $error_messages[] = "Password is required.";
    }
    if (empty($contact_number)) {
        $error_messages[] = "Contact number is required.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_messages[] = "Valid email is required.";
    }
    if (empty($address)) {
        $error_messages[] = "Address is required.";
    }

    // If no validation errors, proceed with registration
    if (empty($error_messages)) {
        // Check if the username already exists in the database
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        if ($stmt) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $error_messages[] = "Error: Username already taken. Please choose a different one.";
            } else {
                // Insert user data into the database if username is unique
                $stmt->close(); // Close the previous statement before creating a new one

                $stmt = $conn->prepare("INSERT INTO users (username, password, contact_number, email, address, role) VALUES (?, ?, ?, ?, ?, ?)");
                if ($stmt) {
                    $stmt->bind_param("ssssss", $username, $password, $contact_number, $email, $address, $role);

                    if ($stmt->execute()) {
                        // Registration successful, show alert
                        echo "<script>alert('Registration successful! You can now log in.'); window.location.href = 'login.php';</script>";
                        exit();
                    } else {
                        $error_messages[] = "Error: " . $stmt->error;
                    }
                } else {
                    $error_messages[] = "Error preparing statement.";
                }
            }

            $stmt->close(); // Close the statement after use
        } else {
            $error_messages[] = "Error preparing statement.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        header, footer {
            text-align: center;
            background-color: #2c3e50;
            color: white;
            padding: 10px 0;
        }

        main {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 20px;
        }

        .register-container {
            background-color: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            text-align: center;
            animation: fadeIn 0.5s ease-in-out;
        }

        h2 {
            color: #333;
            margin-bottom: 30px;
            font-size: 28px;
        }

        .logo {
            width: 100px;
            margin-bottom: 20px;
        }

        .input-field {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 16px;
            color: #333;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }

        .input-field:focus {
            outline: none;
            border-color: #3498db;
        }

        button {
            width: 100%;
            padding: 15px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        button:hover {
            background-color: #2980b9;
            transform: scale(1.05);
        }

        .error-message {
            color: #e74c3c;
            text-align: center;
            margin-top: 15px;
            font-weight: bold;
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
            .register-container {
                padding: 20px;
                width: 90%;
            }
        }
    </style>
</head>
<body>

<?php include '../includes/header.php'; ?>

<main>
    <div class="register-container">
        <!-- Add the logo here -->
        <img src="../images/logo.png" alt="Logo" class="logo">

        <h2>Register for an Account</h2>

        <?php
        // Display error messages if any
        if (!empty($error_messages)) {
            echo '<div class="error-message">';
            foreach ($error_messages as $message) {
                echo "<p>$message</p>";
            }
            echo '</div>';
        }
        ?>

        <form method="post" action="register.php">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" class="input-field" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" class="input-field" required>

            <label for="contact_number">Contact Number:</label>
            <input type="text" id="contact_number" name="contact_number" class="input-field" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" class="input-field" required>

            <label for="address">Address:</label>
            <textarea id="address" name="address" class="input-field" required></textarea>

            <button type="submit">Register</button>
        </form>
    </div>
</main>

<?php include '../includes/footer.php'; ?>

</body>
</html>
