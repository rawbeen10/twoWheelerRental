
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Two Wheeler Rental</title>
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="layout/layout.css">
    <link rel="stylesheet" href="styles/fonts.css">

</head>
<body>
<?php
require("layout/header.php");
?>

    <section id="home">
        <div class="home-txt">
            <h1>Welcome to UTHAOO</h1>
            <p>Explore Kathmandu on our modern bikes and scooters. The best rates, the best bikes!</p>
            <a href="rent.php"><button id="btn" type="button">Explore</button></a>
        </div>
    </section>

    <section class="booking-section">
        <div class="booking-form">
            <h3>Book Your Ride</h3>
            <form id="vehicleBookingForm" class="form-inline">
                <div class="form-group">
                    <label for="startDate">Start Date</label>
                    <input type="date" id="startDate" name="startDate" required>
                </div>
    
                <div class="form-group">
                    <label for="endDate">End Date</label>
                    <input type="date" id="endDate" name="endDate" required>
                </div>
    
                <button type="submit">Search</button>
            </form>
    
            <p id="error-message" class="error"></p>
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
        document.getElementById('vehicleBookingForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent form submission
    
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;
    
    const errorMessage = document.getElementById('error-message');

    const startDateTime = new Date(startDate);
    const endDateTime = new Date(endDate);

    if (startDateTime >= endDateTime) {
        errorMessage.textContent = 'End date must be after the start date.';
        return;
    }

    errorMessage.textContent = ''; // Clear any previous error messages
    alert('Booking is valid! Proceeding to search.');
});

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
