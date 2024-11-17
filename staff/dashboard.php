<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard</title>
</head>
<body>
    <h1>
        <?php
        echo "Hello, Staff!";
        ?>
    </h1>
    <div>
        <a href="../user/view_profile.php" class="btn">Profile</a>
        <a href="user/login.php" class="btn">All members</a>
        <a href="user/register.php" class="btn">Create Blog Post</a>
        <a href="user/register.php" class="btn">Create Classes</a>
        <a href="view_queries.php" class="btn">Reply Queries</a>
        <a href="../user/logout.php" class="btn">Logout</a> <!-- Logout Button -->
    </div>
</body>
</html>
