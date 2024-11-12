<?php
// Step 1: Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "twowheelerrental";  // Replace with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Step 2: Fetch vehicle data from the database
$sql = "SELECT * FROM vehicles";  // Replace 'vehicles' with your table name
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent</title>
    <link rel="stylesheet" href="styles/rent.css">
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

    <section id="rent">
      <h1>Rent Your Ride</h1>
      <div class="bike-container">
          <?php
          // Step 3: Display the vehicle data
          if ($result->num_rows > 0) {
              // Output each vehicle data as a bike item
              while($row = $result->fetch_assoc()) {
                  echo "<div class='bike-item'>";
                  echo "<img src='admin/uploads/" . htmlspecialchars($row['image']) . "' alt='" . htmlspecialchars($row['vehicle_name']) . "' class='bike-img'>";

                  echo "<h3>" . $row['vehicle_name'] . "</h3>";
                  echo "<p>Description: " . $row['category'] . "</p>"; 
                  echo "<button class='btn rent-btn'>Rent</button>";
                  echo "<button class='btn view-more-btn'>View More</button>";
                  echo "</div>";
              }
          } else {
              echo "<p>No vehicles available for rent at the moment.</p>";
          }
          $conn->close();
          ?>
      </div>
  </section>

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
