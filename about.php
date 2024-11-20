<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About</title>
    <link rel="stylesheet" href="styles/about.css">
    <link rel="stylesheet" href="layout/layout.css">
    <link rel="stylesheet" href="styles/fonts.css">
</head>
<body>
<?php
    require("layout/header.php");
    ?>

    <section class="about-us">
      <div class="container">
          <h1>About Us</h1>
          <p>Welcome to <strong>Uthaoo</strong>, your go-to platform for reliable vehicle rentals. Founded by two passionate individuals, we believe in making your travel experience smooth and hassle-free. Whether you're looking for a car for a weekend getaway or a long-term rental, we’ve got you covered.</p>
          <div class="team">
              <div class="member">
                  <img src="https://codemasalabytes.com/wp-content/uploads/2024/04/a-photorealistic-image-of-a-programmer-managing-hi-mUW7fXLcTim5Bp5IduKzoA-ZKfEhJ8wSR6zpHxRbnI59w.jpeg" alt="Person 1">
                  <h3>Rabin Dhakal</h3>
                  <p>Co-Founder & CEO</p>
                  <p>Rabin brings over 10 years of experience in the automotive industry and a vision to revolutionize the car rental market with a customer-first approach.</p>
              </div>
              <div class="member">
                  <img src="https://pathao.com/np/wp-content/uploads/sites/7/2018/12/Earn-with-your-Bike_Image.jpg" alt="Person 2">
                  <h3>Kushal Bhattarai</h3>
                  <p>Co-Founder & Operations Manager</p>
                  <p>Kushal is the operational brain behind DriveEase, ensuring that every customer has access to the best vehicles and seamless service.</p>
              </div>
          </div>
      </div>
  </section>

  <section class="our-mission">
      <div class="container">
          <h2>Our Mission</h2>
          <p>
              At <strong>Uthaoo</strong>, our mission is to provide an affordable, convenient, and eco-friendly two-wheeler rental service that empowers locals and tourists alike to explore the beautiful landscapes and vibrant culture of Kathmandu and beyond. As the owner of this business, we understand the unique challenges and demands of navigating through the narrow streets and bustling traffic of this historic city. Whether you're a daily commuter, an adventure enthusiast, or a traveler seeking to experience the raw beauty of Nepal, our mission is to make sure you have the right ride for the journey.
          </p>
          <p>
              We are deeply committed to fostering a sustainable mode of transport that not only reduces traffic congestion but also minimizes the environmental impact. Our fleet of well-maintained two-wheelers is designed to cater to a diverse range of needs, from fuel-efficient scooters perfect for city rides to sturdy motorcycles ideal for exploring Nepal’s rugged terrains and mountainous trails. By offering a range of options, we ensure that our customers always have access to vehicles that are reliable, safe, and suited for all types of road conditions.
          </p>
          <p>
              Kathmandu is a city rich in history, culture, and adventure. However, public transportation can be limited, and hiring four-wheelers can be expensive and impractical, especially when trying to access the narrower, off-the-beaten-path destinations. We are here to bridge that gap, offering two-wheelers as the perfect alternative. Our mission extends beyond just renting out vehicles; we aim to create a seamless, customer-first experience where you feel empowered to discover Nepal on your terms. From flexible rental plans to round-the-clock customer support, we go the extra mile to ensure your safety and comfort at every turn.
          </p>
          <p>
              As a locally-owned business, we are proud to contribute to Kathmandu’s growth by promoting tourism and providing job opportunities within the community. We believe that travel and exploration should be within reach for everyone, and that's why we strive to keep our rates affordable without compromising on quality. Your safety is our top priority, and every two-wheeler in our fleet undergoes regular maintenance and safety checks to guarantee a smooth and secure ride.
          </p>
          <p>
              At the heart of Uthaoo is a passion for adventure and a deep love for Nepal. Our mission is to make mobility in and around Kathmandu hassle-free and enjoyable. We hope to inspire you to embrace the freedom of the open road, explore new horizons, and experience the rich beauty that Nepal has to offer. Whether it’s your daily commute or a weekend getaway to the hills, we are here to support your journey, one ride at a time.
          </p>
          
          <h3>Key Points</h3>
          <ul class="key-points">
              <li>Provide affordable, eco-friendly two-wheeler rentals for locals and tourists.</li>
              <li>Promote sustainable transport to reduce traffic congestion and environmental impact.</li>
              <li>Offer a diverse fleet of two-wheelers for city rides and adventurous terrains.</li>
              <li>Ensure a customer-first experience with flexible rental plans and 24/7 support.</li>
              <li>Contribute to local tourism and community development in Kathmandu.</li>
              <li>Prioritize safety with regular maintenance and quality checks on all vehicles.</li>
              <li>Inspire exploration and adventure, offering a hassle-free travel experience.</li>
          </ul>
      </div>
  </section>
</div>
</section>

    <div id="loginPopup" class="popup-container">
      <div class="form-container">
        <span class="close-btn" id="closeBtn">&times;</span>
        <h2>Login</h2>
        <form action="">
          <input type="text" name="username" id="username" placeholder="Username" required>
          <input type="password" name="password" id="password" placeholder="Enter Your Password." required>
          <input type="checkbox" name="remember" id="remember" value="remember-me">Remember me
          <a href="#" id="forgot">Forgot Password?</a> <br>
          <button type="submit">Login</button>
          <h4 class="center-text sign">Don't have an account? <a href="#" id="sign">Sign Up</a></h4>
          <div class="center-text">
            <span class="connect-with">or connect with</span>
            <hr class="line">
          </div>
          <div class="con-icons">
            <a href="#" class="icons"><img src="media/fb-color.png" alt="fb" title="Connect with Facebook"></a>
            <a href="#" class="icons"><img src="media/gmail.webp" alt="gmail" title="Connect with Google"></a>
          </div>
        </form>
      </div>
    </div>

<?php
    require("layout/footer.php");
    ?>

    
      <!-- <script>
        window.onload = function() {
    setTimeout(showPopup, 2000);

    const closeBtn = document.getElementById("closeBtn");
    const popup = document.getElementById("loginPopup");

    closeBtn.addEventListener("click", function() {
        popup.style.display = "none";
    });
}

function showPopup() {
    document.getElementById("loginPopup").style.display = "flex";
}
      </script>  -->

</body>
</html>