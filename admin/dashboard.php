<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>
        <?php
        echo "Hello, Admin!";
        ?>
    </h1>
    <div>
        <!-- Ensure all href paths are correct -->
        <a href="../user/view_profile.php" class="btn">profile</a>
        <a href="add_staff.php" class="btn">Manage Staff Members</a>
        <a href="view_payments.php" class="btn">Manage Members and payments</a>
        <a href="create_blog.php" class="btn">Manage Blog Post</a>
        <a href="../staff/view_queries.php" class="btn">Manage Queries</a>
        <a href="../staff/create_class.php" class="btn">Manage Classes</a>
        <a href="view_users.php" class="btn">Manage Users</a>
        <a href="../user/logout.php" class="btn">Logout</a>
        
    </div>
</body>
</html>
