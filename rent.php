<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent</title>
    <link rel="stylesheet" href="styles/rent.css">
    <link rel="stylesheet" href="./layout/layout.css">

</head>
<body>
<?php
require("layout/header.php");
?>
    <section id="rent">
      <h1>Rent Your Ride</h1>
      <div class="bike-container">
          <div class="bike-item">
              <img src="media/bike.jpg" alt="Bike 1" class="bike-img">
              <h3>Bike Name 1</h3>
              <p>Description for Bike 1</p>
              <button class="btn rent-btn">Rent</button>
              <button class="btn view-more-btn">View More</button>
          </div>
          <div class="bike-item">
              <img src="media/bike.jpg" alt="Bike 2" class="bike-img">
              <h3>Bike Name 2</h3>
              <p>Description for Bike 2</p>
              <button class="btn rent-btn">Rent</button>
              <button class="btn view-more-btn">View More</button>
          </div>
          <div class="bike-item">
              <img src="media/bike.jpg" alt="Bike 3" class="bike-img">
              <h3>Bike Name 3</h3>
              <p>Description for Bike 3</p>
              <button class="btn rent-btn">Rent</button>
              <button class="btn view-more-btn">View More</button>
          </div>
          <div class="bike-item">
              <img src="media/bike.jpg" alt="Bike 4" class="bike-img">
              <h3>Bike Name 4</h3>
              <p>Description for Bike 4</p>
              <button class="btn rent-btn">Rent</button>
              <button class="btn view-more-btn">View More</button>
          </div>
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

      <script>




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
      </script>
    
</body>
</html>