<?php
include 'header.php'; // Include your header file
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="style.css"> <!-- Your CSS file -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .contact-section {
            background-color: #1abc9c;
            color: white;
            text-align: center;
            padding: 80px 20px;
            border-bottom: 5px solid #16a085;
        }
        .contact-section h1 {
            font-size: 3rem;
            font-weight: bold;
            margin: 0;
        }
        .contact-section p {
            font-size: 1.2rem;
            margin-top: 10px;
        }
        .contact-content {
            max-width: 800px;
            margin: 50px auto;
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .contact-content h2 {
            text-align: center;
            color: #2c3e50;
            font-size: 2rem;
            margin-bottom: 30px;
        }
        .contact-info {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 30px;
        }
        .contact-card {
            background-color: #ecf0f1;
            padding: 20px;
            border-radius: 8px;
            width: 100%;
            max-width: 280px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .contact-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        .contact-card i {
            font-size: 2rem;
            color: #16a085;
            margin-bottom: 10px;
        }
        .contact-card h3 {
            font-size: 1.4rem;
            color: #2c3e50;
            margin-bottom: 5px;
        }
        .contact-card p {
            color: #7f8c8d;
            font-size: 1rem;
        }
        .contact-card a {
            color: #16a085;
            text-decoration: none;
            font-weight: bold;
        }
        .contact-card a:hover {
            color: #1abc9c;
        }
        @media (max-width: 768px) {
            .contact-info {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="contact-section">
        <h1>Contact Us</h1>
        <p>We are here to assist you with anything you need. Reach out to us today!</p>
    </div>
    <div class="contact-content">
        <h2>Get in Touch</h2>
        <div class="contact-info">
            <div class="contact-card">
                <i class="fas fa-map-marker-alt"></i>
                <h3>Our Address</h3>
                <p>123 Fitness Avenue, Colombo, Sri Lanka</p>
            </div>
            <div class="contact-card">
                <i class="fas fa-phone-alt"></i>
                <h3>Call Us</h3>
                <p>+94 123 456 789</p>
            </div>
            <div class="contact-card">
                <i class="fas fa-envelope"></i>
                <h3>Email Us</h3>
                <p><a href="mailto:info@fitzone.lk">info@fitzone.lk</a></p>
            </div>
        </div>
    </div>
</body>
</html>

<?php
?>
