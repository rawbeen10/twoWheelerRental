<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "twowheelerrental";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT * FROM vehicles";  
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent</title>
    <link rel="stylesheet" href="styles/rent.css">
    <link rel="stylesheet" href="layout/layout.css">
    <link rel="stylesheet" href="styles/fonts.css">
    <link rel="stylesheet" href="styles/rentForm.css">
</head>
<body>
    <?php
    require("layout/header.php");
    ?>

<section id="rent">
    <h1>Rent Your Ride</h1>
    <div class="bike-container">
        <?php
      
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                
                $pricePerDay = isset($row['price_per_day']) && !empty($row['price_per_day']) ? htmlspecialchars($row['price_per_day']) : 'N/A';

                echo "<div class='bike-item'>";
                echo "<img src='admin/uploads/" . htmlspecialchars($row['image']) . "' alt='" . htmlspecialchars($row['vehicle_name']) . "' class='bike-img'>";
                echo "<h3>" . htmlspecialchars($row['vehicle_name']) . "</h3>";
                echo "<a href='#' class='btn rent-btn' onclick=openRentForm(\"" . htmlspecialchars($row['vehicle_name'])."\")'>Rent</a>";  
                
                echo "<a href='#' class='btn view-more-btn' onclick='openPopup(\"" . htmlspecialchars($row['vehicle_name']) . "\", \"" . htmlspecialchars($row['category']) . "\", \"$pricePerDay\", \"" . htmlspecialchars($row['description']) . "\", \"" . htmlspecialchars($row['image']) . "\")'>View More</a>";
                echo "</div>";
            }
        } else {
            echo "<p>No vehicles available for rent at the moment.</p>";
        }
        $conn->close();
        ?>
    </div>
</section>

<!-- Popup -->
<div id="viewMorePopup" class="popup-container">
    <div class="popup-content">
        <img id="popupImage" class="popup-image" src="" alt="Vehicle Image">
        <h2>Vehicle Details</h2>
        <p><strong>Vehicle Name: </strong> <span id="popupVehicleName"></span></p>
        <p><strong>Vehicle Number: </strong> <span id="popupVehicleNo"></span></p>
        <p><strong>Category: </strong> <span id="popupCategory"></span></p>
        <p><strong>Price per Day: </strong> Rs. <span id="popupPricePerDay"></span></p>
        <p><strong>Description: </strong> <span id="popupDescription"></span></p>
        <button class="btn cancel-btn" onclick="closePopup()">Cancel</button>
    </div>
</div>

    <!-- Rent Form Popup -->
    <div id="rentFormPopup" class="popup-container">
        <div class="popup-content">
            <button class="cancel-btn" onclick="closeRentForm()">Close</button>
            <h2>Rental Form</h2>
            <form action="submit_rental.php" method="POST" enctype="multipart/form-data" class="rent-form">
                <label for="vehicle">Vehicle Name:</label>
                <input type="text" id="vehicleName" name="vehicle_name" readonly>

                <label for="fullname">Full Name:</label>
                <input type="text" name="fullname" placeholder="Full Name" required>

                <label for="email">Email:</label>
                <input type="email" name="email" placeholder="example@gmail.com" required>

                <label for="phone">Phone Number:</label>
                <input type="text" name="phone" placeholder="Your Phone Number" required>

                <label for="id_type">Type of ID:</label>
                <select name="id_type" required>
                    <option value="citizenship">Citizenship</option>
                    <option value="license">Driving License</option>
                    <option value="nid">National ID</option>
                    <option value="voter">Voter Card</option>
                    <option value="others">Others</option>
                </select>

                <label for="id_upload">Upload ID:</label>
                <input type="file" name="id_upload" required>

                <input type="submit" value="Submit">
            </form>
        </div>
    </div>



<?php
    require("layout/footer.php");
    ?>

<script>
   
    function openPopup(vehicleName, vehicleNo, category, pricePerDay, description, imageUrl) {
        document.getElementById('popupVehicleName').textContent = vehicleName;
        document.getElementById('popupVehicleNo').textContent = vehicleNo;
        document.getElementById('popupCategory').textContent = category;
        document.getElementById('popupPricePerDay').textContent = pricePerDay;
        document.getElementById('popupDescription').textContent = description;
        document.getElementById('viewMorePopup').classList.add('show');
        document.getElementById('popupImage').src = 'admin/uploads/' + imageUrl; 
    }

    
    function closePopup() {
        document.getElementById('viewMorePopup').classList.remove('show');
    }

        // Open the rent form popup
        function openRentForm(vehicleName) {
            document.getElementById('vehicleName').value = vehicleName; // Set vehicle name
            document.getElementById('rentFormPopup').classList.add('show');
        }

        // Close the rent form popup
        function closeRentForm() {
            document.getElementById('rentFormPopup').classList.remove('show');
        }
    </script>


</body>
</html>
