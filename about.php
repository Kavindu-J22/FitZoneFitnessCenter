<?php
include 'header.php'; // Include your header file
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="style.css"> <!-- Your CSS file -->
    <style>
        /* General Styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 0;
            color: #2c3e50;
        }

        /* Header Styles */
        .about-section {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            color: white;
            padding: 60px 20px;
            text-align: center;
            border-bottom: 5px solid #1abc9c;
        }

        /* Content Container */
        .about-content {
            max-width: 1000px;
            margin: 40px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        /* Section Headings */
        h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        h2 {
            font-size: 1.8rem;
            color: #34495e;
            margin-bottom: 10px;
        }

        /* Text Styles */
        p {
            font-size: 1rem;
            line-height: 1.7;
            margin-bottom: 20px;
            color: #777;
        }

        /* Hover Effect */
        .about-content:hover {
            transform: translateY(-10px);
        }

        /* Button Styles */
        .learn-more-btn {
            display: inline-block;
            padding: 10px 25px;
            background-color: #1abc9c;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s, transform 0.3s;
        }

        .learn-more-btn:hover {
            background-color: #16a085;
            transform: scale(1.05);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .about-content {
                padding: 20px;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            }

            h1 {
                font-size: 2rem;
            }

            h2 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- About Section -->
    <div class="about-section">
        <h1>About FitZone Fitness Center</h1>
        <p>Your ultimate destination for fitness, health, and wellness.</p>
    </div>

    <!-- About Content -->
    <div class="about-content">
        <h2>Our Mission</h2>
        <p>At FitZone Fitness Center, we are dedicated to creating a dynamic and supportive environment where individuals of all fitness levels can come together to achieve their health and wellness goals. Our mission is not only to provide top-notch fitness services but also to foster a community of like-minded individuals who inspire and encourage one another. Whether you're just starting your fitness journey, looking to take your training to the next level, or seeking guidance in your overall well-being, FitZone is here to help you every step of the way.

        Our state-of-the-art facility is equipped with the latest fitness technology, spacious workout areas, and a variety of equipment tailored to support a wide range of exercise routines. From strength training and cardio to group classes, personal training, and wellness workshops, we offer something for everyone. We believe in a holistic approach to health, addressing not just physical fitness but also mental wellness, nutrition, and overall lifestyle.

        FitZone Fitness Center is built on the values of respect, empowerment, and dedication. Our certified trainers and nutritionists work closely with members to develop personalized plans that align with their specific goals, whether it's weight loss, muscle gain, flexibility, or stress relief. We take pride in our supportive atmosphere, where every member is encouraged to push their limits, achieve new milestones, and celebrate their successes, no matter how big or small.

        Join us at FitZone, where fitness meets community, and every step towards your goal is a step towards a healthier, happier you.</p>
        
        <h2>Our Facilities</h2>
        <p>At FitZone Fitness Center, we pride ourselves on offering a comprehensive range of fitness solutions designed to meet the diverse needs of our community. Our facility is equipped with the latest and most advanced fitness equipment, providing members with everything they need to work towards their fitness goals, whether it’s strength training, cardiovascular health, or overall well-being.

        We understand that each individual has unique fitness goals, which is why we offer a wide variety of group classes to cater to different interests and fitness levels. From high-energy HIIT sessions to calming yoga and pilates, our group classes are led by certified instructors who are passionate about guiding members through effective and engaging workouts. These classes not only help improve physical fitness but also foster a sense of camaraderie and community among participants, creating an encouraging and supportive environment for everyone.

        For those who prefer a more personalized approach, we offer one-on-one personal training sessions with our team of experienced and certified trainers. Our personal trainers work closely with members to design custom workout plans tailored to individual needs, whether the goal is weight loss, muscle building, increasing flexibility, or improving athletic performance. With personalized attention and expert guidance, we ensure that every member receives the motivation and support they need to achieve their fitness aspirations.

        In addition to physical fitness, wellness programs are at the heart of what we offer. At FitZone, we believe that wellness extends beyond the gym, which is why we provide programs focused on mental health, nutrition, and overall lifestyle. Our nutrition counseling and wellness workshops are designed to help members make informed decisions about their diet, mental health, and lifestyle, empowering them to lead healthier and more balanced lives.

        Whether you are new to fitness, aiming to push your limits, or seeking a holistic approach to health, FitZone Fitness Center is here to support you every step of the way. Our extensive range of equipment, classes, personal training options, and wellness programs ensures that every member has access to the tools and resources they need to thrive.</p>
        
        <h2>Our Trainers</h2>
        <p>At FitZone Fitness Center, we believe that the foundation of any successful fitness journey is expert guidance and personalized support. That's why we are proud to have a team of experienced, certified trainers who specialize in a wide range of fitness disciplines, ensuring that every member receives the best possible coaching tailored to their unique needs.

        Our trainers come from diverse backgrounds, each bringing a wealth of knowledge and passion to their area of expertise. Whether you are looking to enhance your strength, improve your cardiovascular fitness, develop flexibility, or pursue a specific athletic goal, our trainers have the skills and experience to guide you through every step of your journey. From strength training, HIIT (High-Intensity Interval Training), and functional fitness, to yoga, pilates, and sports conditioning, our trainers are well-versed in various techniques and methods designed to push you to reach your full potential.

        What sets our trainers apart is their commitment to personalization. They understand that no two individuals are alike, which is why they take the time to assess your current fitness level, listen to your goals, and craft a tailored workout plan that aligns with your aspirations. Whether you’re training for a specific event, recovering from an injury, or simply seeking to improve your overall health, our trainers provide the knowledge and expertise to help you succeed.

        In addition to technical skills, our trainers are compassionate and motivated, fostering an environment where you feel encouraged and empowered. They serve as not only fitness experts but also as motivational coaches, providing continuous support and accountability throughout your journey. Their goal is not just to help you achieve physical results, but also to inspire confidence, build mental resilience, and cultivate a sense of accomplishment in every session.

        Our trainers also stay ahead of the latest fitness trends and certifications, ensuring that their methods are always informed by the latest research and techniques. They participate in ongoing education, ensuring that the training programs at FitZone Fitness Center remain fresh, effective, and innovative. Whether you are a beginner, an advanced athlete, or somewhere in between, our trainers are committed to helping you reach your goals safely and efficiently, providing the expert guidance and motivation you need to thrive.

        With the help of our professional trainers, you can rest assured that your fitness journey will be a rewarding one, marked by progress, growth, and continuous improvement.</p>

        <!-- Learn More Button -->
        <a href="services.php" class="learn-more-btn">Learn More About Our Services</a>
    </div>
</body>
</html>
