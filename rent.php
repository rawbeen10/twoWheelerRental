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
    <link rel="stylesheet" href="./layout/layout.css">
    <link rel="stylesheet" href="styles/fonts.css">

</head>
<body>
<?php
require("layout/header.php");
?>
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
