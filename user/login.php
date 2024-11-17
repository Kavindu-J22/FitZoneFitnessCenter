<?php
include '../includes/db.php';
session_start();

// Handle login logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Check if the user exists in the database
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        // Set session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // Redirect based on role
        if ($user['role'] === 'admin') {
            header("Location: ../admin/dashboard.php");
        } elseif ($user['role'] === 'staff') {
            header("Location: ../staff/dashboard.php");
        } else {
            header("Location: ../user/dashboard.php");
        }
        exit();
    } else {
        echo "Invalid username or password.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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

        .login-container {
            background-color: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
            text-align: center;
            animation: fadeIn 0.5s ease-in-out;
        }

        h2 {
            color: #333;
            margin-bottom: 30px;
            font-size: 28px;
        }

        .logo {
            width: 300px;
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
            .login-container {
                padding: 20px;
                width: 90%;
            }
        }
    </style>
</head>
<body>

<?php include '../includes/header.php'; ?>

<main>
    <div class="login-container">
        <!-- Add the logo here -->
        <img src="../images/logo.png" alt="Logo" class="logo">

        <h2>Login to Your Account</h2>
        
        <form method="post" action="login.php">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" class="input-field" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" class="input-field" required>

            <button type="submit">Login</button>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && !($user && password_verify($password, $user['password']))) {
            echo '<p class="error-message">Invalid username or password.</p>';
        }
        ?>
    </div>
</main>

<?php include '../includes/footer.php'; ?>

</body>
</html>
