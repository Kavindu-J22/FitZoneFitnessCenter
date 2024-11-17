<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Custommer Dashboard</title>
</head>
<body>
<?php include '../includes/header.php'; ?>
    <h1>
        <?php
        echo "Hello, Customer!";
        ?>
    </h1>
    <div>
        <a href="view_profile.php" class="btn">Profile</a>
        <a href="membership.php" class="btn">Apply Membership</a>
        <a href="submit_query.php" class="btn">Submit Query</a>
        <a href="joinClasses.php" class="btn">Book a Classes</a>
        <a href="blogs.php" class="btn">View Blog Posts</a>
        <a href="myBookings.php" class="btn">My Bookings</a>
        <a href="my_payments.php" class="btn">My Payments and Appointments</a>
        <a href="logout.php" class="btn">Logout</a>
    </div>
</body>
</html>
