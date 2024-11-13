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
      <form onsubmit="return validateLogin()">
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
        <!-- Footer content here -->
    </footer>

    
    </script>
</body>
</html>
