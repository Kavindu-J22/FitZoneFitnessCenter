<?php
include 'header.php'; // Include your header file
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Services</title>
    <link rel="stylesheet" href="style.css"> <!-- Your CSS file -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .service-section {
            text-align: center;
            padding: 60px 20px;
            background-color: #2c3e50;
            color: white;
            border-bottom: 5px solid #2980b9;
        }
        .service-section h1 {
            font-size: 3rem;
            font-weight: bold;
            margin: 0;
            letter-spacing: 2px;
        }
        .services {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding: 40px 20px;
            gap: 30px;
            margin-top: -30px;
        }
        .service-card {
            background-color: #fff;
            border-radius: 15px;
            padding: 25px;
            width: 280px;
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            position: relative;
        }
        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }
        .service-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            z-index: -1;
        }
        .service-card h3 {
            font-size: 1.6rem;
            color: #2c3e50;
            margin-bottom: 15px;
            font-weight: 600;
        }
        .service-card p {
            font-size: 1rem;
            color: #555;
            line-height: 1.6;
            text-align: center;
        }
        .service-card img {
            width: 100%;
            height: auto;
            border-radius: 15px;
            margin-bottom: 15px;
        }
        .btn-more {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 24px;
            background-color: #2980b9;
            color: white;
            font-weight: bold;
            border-radius: 30px;
            text-decoration: none;
            text-transform: uppercase;
            transition: background-color 0.3s;
        }
        .btn-more:hover {
            background-color: #3498db;
        }
        @media (max-width: 768px) {
            .service-section h1 {
                font-size: 2.5rem;
            }
            .services {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>
    <div class="service-section">
        <h1>Our Premium Services</h1>
        <p style="font-size: 1.2rem; color: #ecf0f1;">Helping you achieve your fitness and wellness goals</p>
    </div>
    <div class="services">
        <div class="service-card">
            <img src="images/icon-4.svg" alt="Personal Training">
            <h3>Personal Training</h3>
            <p>Our trainers offer one-on-one sessions tailored to your fitness goals.</p>
            <a href="#" class="btn-more">Learn More</a>
        </div>
        <div class="service-card">
            <img src="images/icon-1.svg" alt="Group Classes">
            <h3>Group Classes</h3>
            <p>Join our dynamic group classes for yoga, HIIT, dance, and more.</p>
            <a href="#" class="btn-more">Learn More</a>
        </div>
        <div class="service-card">
            <img src="images/icon-2.svg" alt="Nutrition Counseling">
            <h3>Nutrition Counseling</h3>
            <p>Receive personalized meal plans from our certified nutritionists.</p>
            <a href="#" class="btn-more">Learn More</a>
        </div>
        <div class="service-card">
            <img src="images/icon-3.svg" alt="Wellness Workshops">
            <h3>Wellness Workshops</h3>
            <p>Learn about mindfulness, healthy living, and self-care in our workshops.</p>
            <a href="#" class="btn-more">Learn More</a>
        </div>
    </div>
</body>
</html>

<?php
?>
