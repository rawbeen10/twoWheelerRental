<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uthaoo</title>
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/fonts.css">
    <link rel="stylesheet" href="layout/layout.css">
</head>
<body>
    
    <?php require("layout/header.php");?>

<section id="home">
    <img src="media/bg123.jpg" alt="Hero Image">
    <div class="home-txt">
        <h1>Welcome to UTHAOO</h1>
        <p>Explore Kathmandu on our modern bikes and scooters. The best rates, the best bikes!</p>
        <a href="rent.php"><button class="btn-primary" id="btn" type="button">Explore</button></a>
    </div>
</section>

<section id="why-choose">
    <h2>Why Choose UTHAOO ?</h2>
    <div class="content-wrapper">
        <div class="image-container">
            <img src="media/redvespa.jpg" alt="Why Choose UTHAOO Image">
        </div>
        <div class="content">
            <p>At UTHAOO, we believe that exploring Kathmandu should be an unforgettable experience. Our fleet of modern bikes and scooters provides a perfect blend of style, comfort, and reliability. Whether you're a local or a visitor, we offer an affordable and eco-friendly way to discover the city's vibrant culture and beautiful landscapes.</p>
            <p>We take great pride in maintaining our vehicles to the highest standards, ensuring that every ride is smooth, safe, and enjoyable. From the moment you rent a bike or scooter, you can count on exceptional customer service and full support throughout your journey.</p>
            <p>Our mission is to make your experience with us as easy and enjoyable as possible. With flexible rental options, competitive pricing, and a commitment to customer satisfaction, UTHAOO is the ideal choice for anyone looking to explore Kathmandu in style and comfort.</p>
        </div>
    </div>
</section>

<section class="carousel">
    <h2>Top Ride Destination near Kathmandu</h2>
    <div class="carousel-container">
        <div class="carousel-slider">
            <div class="carousel-item">
                <img src="https://media-cdn.tripadvisor.com/media/photo-c/1280x250/08/40/02/28/nagarkot.jpg" alt="Nagarkot">
                <div class="carousel-text">Nagarkot</div>
            </div>
            <div class="carousel-item">
                <img src="https://www.poonhillguide.com/wp-content/uploads/2018/09/kakani-hiking.jpg" alt="Kakani">
                <div class="carousel-text">Kakani</div>
            </div>
            <div class="carousel-item">
                <img src="https://upload.wikimedia.org/wikipedia/commons/d/d9/Nyatpola_%26_Bhairav_Temple.jpg" alt="Bhaktapur">
                <div class="carousel-text">Bhaktapur</div>
            </div>
            <div class="carousel-item">
                <img src="https://i0.wp.com/imfreee.com/wp-content/uploads/2019/09/Bheda-Farm-Markhu-Chitlang.jpg?ssl=1" alt="Chitlang">
                <div class="carousel-text">Chitlang</div>
            </div>
            <div class="carousel-item">
                <img src="https://tourshala.com/wp-content/uploads/2024/04/dhap-daman-2-1024x683.jpg" alt="Dhap Dam">
                <div class="carousel-text">Dhap Dam</div>
            </div>
        </div>
    </div>
    <button class="carousel-btn prev">&lt;</button>
    <button class="carousel-btn next">&gt;</button>
</section>


    <?php require("layout/footer.php"); ?>
    <script src="styles/script/index.js"></script>
</body>
</html>
