<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="styles/login.css">
    <link rel="stylesheet" href="./layout/layout.css">


</head>
<body>
<?php
require("layout/header.php");
?>

    <div class="container">
      <h1>Login</h1>
      <form action="">
        <input type="text" name="username" id="username" placeholder="Username/Email" required>
        <input type="password" name="password" id="password" placeholder="Enter Your Password." required>
        <input type="checkbox" name="remember" id="remember" value="remember-me">Remember me
        <a href="#" id="forgot">Forgot Password?</a> <br>
        <button type="submit">Login</button>
        <h4 class="center-text sign log-in">Don't have an account? <a href="signup.php" id="sign">Sign Up</a></h4>
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




    <?php
require("layout/footer.php");
?>

    
</body>
</html>