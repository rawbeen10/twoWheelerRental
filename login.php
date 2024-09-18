<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="styles/login.css">

</head>
<body>
    <header>
        <div class="logo">
            <h1>Two Wheeler System</h1>
        </div>
        <nav>
            <ul class="nav-menu">
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="rent.php">Rent</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="login.php">Login</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
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




    <footer>
        <div class="footer-container">
          <!-- About Us Section -->
          <div class="footer-section">
            <h3>About Us</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque auctor nec nulla eu malesuada.</p>
          </div>
          
          <!-- Contact Information -->
          <div class="footer-section">
            <h3>Contact Us</h3>
            <ul>
              <li>Email: info@example.com</li>
              <li>Phone: +977 1234567</li>
              <li>Address: Chabahil, 06 Kathmandu, Nepal</li>
            </ul>
          </div>
      
          <!-- Useful Links -->
          <div class="footer-section">
            <h3>Useful Links</h3>
            <ul>
              <li><a href="#">Privacy Policy</a></li>
              <li><a href="#">Terms of Service</a></li>
              <li><a href="#">Help Center</a></li>
            </ul>
          </div>
      
          <!-- Social Media -->
          <div class="footer-section">
            <h3>Follow Us</h3>
            <div class="social-icons">
              <a href="#" class="social-icon"><img src="media/fb.png" alt="fb-logo"></a>
              <a href="#" class="social-icon"><img src="media/x.png" alt="x-logo"></a>
              <a href="#" class="social-icon"><img src="media/insta.png" alt="insta-logo"></a>
            </div>
          </div>
        </div>
        <hr>
        <div class="footer-bottom">
          <p>&copy; 2024 Your Company. All Rights Reserved.</p>
          <p>Designed and Developed by Rabin and Kushal.</p>
        </div>
      </footer>

    
</body>
</html>