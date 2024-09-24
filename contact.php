<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link rel="stylesheet" href="styles/contact.css">
    <link rel="stylesheet" href="./layout/layout.css">
    <link rel="stylesheet" href="styles/fonts.css">
</head>
<body>
<?php
require("layout/header.php");
?>


    <div class="contact-container">
    <div class="contact-image">
      <img src="media/contact.jpg" alt="contact-img">
    </div>
    
    <div class="contact-form">
        <h1>CONTACT US</h1>
          <form action="#" method="post">
              <label for="name">Name:</label>
              <input type="text" id="name" name="name" required>

              <label for="phone">Phone:</label>
              <input type="number" id="phone" name="phone" required>

              <label for="email">Email:</label>
              <input type="email" id="email" name="email" placeholder="abc@xyz.com" required>

              <label for="message">Message:</label>
              <textarea id="message" name="message" rows="5" required></textarea>

              <center><button type="submit">Submit</button></center>
          </form>
      </div>
    </div>


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
          <a href="#" class="  icons"><img src="media/gmail.webp" alt="gmail" title="Connect with Google"></a>
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
      </script> -->

    
</body>
</html>