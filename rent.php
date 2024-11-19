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
                echo "<a href='rent_form.php?vehicle_name=" . urlencode($row['vehicle_name']) . "&category=" . urlencode($row['category']) . "&price_per_day=" . urlencode($pricePerDay) . "&image=" . urlencode($row['image']) . "' class='btn rent-btn'>Rent</a>";  
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

<!-- View More Popup -->
<div id="viewMorePopup" class="popup-container">
    <div class="popup-content">
        <img id="popupImage" class="popup-image" src="" alt="Vehicle Image">
        <h2>Vehicle Details</h2>
        <p><strong>Vehicle Name:</strong> <span id="popupVehicleName"></span></p>
        <p><strong>Category:</strong> <span id="popupCategory"></span></p>
        <p><strong>Price per Day:</strong> Rs. <span id="popupPricePerDay"></span></p>
        <p><strong>Description:</strong> <span id="popupDescription"></span></p>
        <button class="btn cancel-btn" onclick="closePopup()">Close</button>
    </div>
</div>

<?php
    require("layout/footer.php");
?>

<script>
    // Open the "View More" popup
    function openPopup(vehicleName, category, pricePerDay, description, imageUrl) {
        document.getElementById('popupVehicleName').textContent = vehicleName;
        document.getElementById('popupCategory').textContent = category;
        document.getElementById('popupPricePerDay').textContent = pricePerDay;
        document.getElementById('popupDescription').textContent = description;
        document.getElementById('popupImage').src = 'admin/uploads/' + imageUrl;
        document.getElementById('viewMorePopup').classList.add('show');
    }

    // Close the "View More" popup
    function closePopup() {
        document.getElementById('viewMorePopup').classList.remove('show');
    }
</script>

</body>
</html>
