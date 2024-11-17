<?php
session_start();
// Make sure the user ID is set in the session
if (!isset($_SESSION['user_id'])) {
    die("User ID is not set in the session.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FitZone Membership Plans</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>
    <h1 class="centered-heading">FitZone Membership Plans</h1>

    <!-- Membership plans -->
    <div class="membership-plan">
        <h2>Basic Membership Plan</h2>
        <p>Description: A budget-friendly option for those looking to stay active.</p>
        <p>Access: Unlimited access to cardio and strength training equipment.</p>
        <p>Perks: One free personal training session, locker room access.</p>
        <p>Price: $20 per month</p>
        <button onclick="proceedToPayment('Basic', 20)">Proceed to Payment</button>
    </div>

    <div class="membership-plan">
        <h2>Standard Membership Plan</h2>
        <p>Description: Ideal for fitness enthusiasts.</p>
        <p>Access: Unlimited equipment, group classes, and more.</p>
        <p>Perks: Nutrition counseling, wellness workshops.</p>
        <p>Price: $40 per month</p>
        <button onclick="proceedToPayment('Standard', 40)">Proceed to Payment</button>
    </div>

    <div class="membership-plan">
        <h2>Premium Membership Plan</h2>
        <p>Description: Comprehensive fitness experience.</p>
        <p>Access: All benefits from Standard, plus personal training.</p>
        <p>Perks: VIP lounge, free guest passes.</p>
        <p>Price: $60 per month</p>
        <button onclick="proceedToPayment('Premium', 60)">Proceed to Payment</button>
    </div>

    <div class="membership-plan">
        <h2>Family Membership Plan</h2>
        <p>Description: Perfect for families.</p>
        <p>Access: Premium benefits for 4 members.</p>
        <p>Perks: Family wellness workshops, free babysitting.</p>
        <p>Price: $100 per month</p>
        <button onclick="proceedToPayment('Family', 100)">Proceed to Payment</button>
    </div>

    <div class="membership-plan">
        <h2>Student Membership Plan</h2>
        <p>Description: Discounted plan for students.</p>
        <p>Access: Unlimited equipment, group fitness classes.</p>
        <p>Perks: Student-only wellness programs.</p>
        <p>Price: $15 per month</p>
        <button onclick="proceedToPayment('Student', 15)">Proceed to Payment</button>
    </div>

    <script>
        // JavaScript function to handle the payment process
        const userId = <?php echo json_encode($_SESSION['user_id'] ?? null); ?>;

        function proceedToPayment(subscription, price) {
            if (!userId) {
                alert("User is not logged in.");
                return;
            }

            const paymentType = 'Apply Membership';
            const status = 'pending';

            // Redirect to the payment page with details
            window.location.href = `payment.php?userId=${userId}&paymentType=${paymentType}&subscription=${subscription}&price=${price}&status=${status}`;
        }
    </script>
</body>
</html>
