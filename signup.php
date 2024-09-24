<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="styles/login.css">
    <link rel="stylesheet" href="./layout/layout.css">
<style>
  #email{
    display: flex;
  width: 100%;
  height: 40px;
  margin: 15px 0;
  padding-left: 10px;
  font-size: 14px;
  border-radius: 12px;
  outline: none;
  background-color: #e2e2e2;
  border: 1px solid azure;
  }
</style>

</head>
<body>
<?php
require("layout/header.php");
?>

    <div class="container">
      <h1>Signup</h1>
      <form action="">
        <input type="text" name="username" id="username" placeholder="Username" required>
        <input type="email" name="email" id="email" placeholder="Enter Your Email" required>
        <input type="password" name="password" id="password" placeholder="Enter Your Password." required>
        <input type="password" name="password" id="password" placeholder="Re-enter Your Password." required>

        <input type="checkbox" name="terms" id="terms" value="" required>I agree to the
        <a href="#" id="terms">Terms and Conditions.</a> <br>

        <button type="submit">Sign Up</button>
        <h4 class="center-text sign log-in">Already have an account? <a href="login.php" id="log-in">Log in</a></h4>
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