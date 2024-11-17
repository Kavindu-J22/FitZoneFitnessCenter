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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitZone Membership Plans</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        header {
            background-color: #3498db;
            color: white;
            padding: 20px 0;
            text-align: center;
            font-size: 24px;
        }

        .centered-heading {
            text-align: center;
            color: #2c3e50;
            margin-top: 30px;
            font-size: 28px;
            font-weight: 600;
        }

        .membership-plans-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
            margin: 40px 20px;
        }

        .membership-plan {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            padding: 20px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .membership-plan:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .membership-plan h2 {
            font-size: 22px;
            color: #2c3e50;
            margin-bottom: 15px;
        }

        .membership-plan p {
            font-size: 16px;
            color: #7f8c8d;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .membership-plan p.price {
            font-size: 20px;
            font-weight: bold;
            color: #3498db;
            margin-bottom: 25px;
        }

        .membership-plan button {
            background-color: #3498db;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .back-to-db {
        display: inline-block;
        padding: 10px;
        background-color: #7f8c8d;
        text-decoration: none;
        color: white;
        border-radius: 5px;
        font-size: 16px;
        margin-top: 20px;
        transition: background-color 0.3s ease;
    }

        .back-to-db:hover {
            background-color: #34495e;
        }

        .back-to-db-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .membership-plan button:hover {
            background-color: #2980b9;
            transform: scale(1.05);
        }

        @media (max-width: 768px) {
            .membership-plans-container {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>

<?php include '../includes/header.php'; ?>

    <div class="back-to-db-container">
        <a class="back-to-db" href="dashboard.php">Back to Dashboard</a>
    </div>

<h1 class="centered-heading">Choose Your Membership Plan</h1>

<div class="membership-plans-container">
    <!-- Basic Plan -->
    <div class="membership-plan">
        <h2>Basic Membership Plan</h2>
        <p>Description: A budget-friendly option for those looking to stay active.</p>
        <p>Access: Unlimited access to cardio and strength training equipment.</p>
        <p>Perks: One free personal training session, locker room access.</p>
        <p class="price">3000 LKR per month</p>
        <button onclick="proceedToPayment('Basic', 3000)">Proceed to Payment</button>
    </div>

    <!-- Standard Plan -->
    <div class="membership-plan">
        <h2>Standard Membership Plan</h2>
        <p>Description: Ideal for fitness enthusiasts.</p>
        <p>Access: Unlimited equipment, group classes, and more.</p>
        <p>Perks: Nutrition counseling, wellness workshops.</p>
        <p class="price">5000 LKR per month</p>
        <button onclick="proceedToPayment('Standard', 5000)">Proceed to Payment</button>
    </div>

    <!-- Premium Plan -->
    <div class="membership-plan">
        <h2>Premium Membership Plan</h2>
        <p>Description: Comprehensive fitness experience.</p>
        <p>Access: All benefits from Standard, plus personal training.</p>
        <p>Perks: VIP lounge, free guest passes.</p>
        <p class="price">7500 LKR per month</p>
        <button onclick="proceedToPayment('Premium', 7500)">Proceed to Payment</button>
    </div>

    <!-- Family Plan -->
    <div class="membership-plan">
        <h2>Family Membership Plan</h2>
        <p>Description: Perfect for families.</p>
        <p>Access: Premium benefits for 4 members.</p>
        <p>Perks: Family wellness workshops, free babysitting.</p>
        <p class="price">10,000 LKR per month</p>
        <button onclick="proceedToPayment('Family', 10000)">Proceed to Payment</button>
    </div>

    <!-- Student Plan -->
    <div class="membership-plan">
        <h2>Student Membership Plan</h2>
        <p>Description: Discounted plan for students.</p>
        <p>Access: Unlimited equipment, group fitness classes.</p>
        <p>Perks: Student-only wellness programs.</p>
        <p class="price">1500 LKR per month</p>
        <button onclick="proceedToPayment('Student', 1500)">Proceed to Payment</button>
    </div>
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
