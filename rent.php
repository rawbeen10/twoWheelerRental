<?php
session_start(); 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "twowheelerrental";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$filter = isset($_GET['category']) ? $_GET['category'] : '';

$sql = "SELECT * FROM vehicles";
if ($filter && in_array($filter, ['bike', 'scooter'])) {
    $sql .= " WHERE category = '" . $conn->real_escape_string($filter) . "'";
}

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
    <title>Rent Your Ride</title>
    <link rel="stylesheet" href="styles/rent.css">
    <link rel="stylesheet" href="layout/layout.css">
    <link rel="stylesheet" href="styles/fonts.css">
    <link rel="stylesheet" href="styles/rentForm.css">
</head>
<body>
    <?php
    require("layout/header.php");
    ?>

<section id="rent" class="container">
    <h1>Rent Your Ride</h1>

    <div class="filter-container">
        <form action="rent.php" method="GET" id="filter-form">
            <label for="category" class="filter-label">Filter by Category:</label>
            <select name="category" id="category" class="filter-select" onchange="document.getElementById('filter-form').submit();">
                <option value="">All</option>
                <option value="bike" <?= $filter === 'bike' ? 'selected' : '' ?>>Bike</option>
                <option value="scooter" <?= $filter === 'scooter' ? 'selected' : '' ?>>Scooter</option>
            </select>
        </form>
    </div>

    <div class="bike-container">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $pricePerDay = isset($row['price_per_day']) && !empty($row['price_per_day']) ? htmlspecialchars($row['price_per_day']) : 'N/A';

                echo "<div class='bike-item'>";
                echo "<img src='admin/uploads/" . htmlspecialchars($row['image']) . "' alt='" . htmlspecialchars($row['vehicle_name']) . "' class='bike-img'>";
                echo "<h3 class='bike-title'>" . htmlspecialchars($row['vehicle_name']) . "</h3>";

                if (isset($_SESSION['user_id'])) {
                    echo "<a href='rent_form.php?id=" . urlencode($row['id']) . "' class='btn rent-btn'>Rent Now</a>";
                } else {
                    echo "<a href='login.php' class='btn rent-btn'>Login to Rent</a>";
                }

                echo "<a href='#' 
    class='btn view-more-btn' 
    data-name='" . htmlspecialchars($row['vehicle_name']) . "' 
    data-category='" . htmlspecialchars($row['category']) . "' 
    data-price='" . $pricePerDay . "' 
    data-description='" . htmlspecialchars($row['description']) . "' 
    data-number='" . htmlspecialchars($row['vehicle_number']) . "' 
    data-image='" . htmlspecialchars($row['image']) . "'>
    View More
</a>";

                echo "</div>";
            }
        } else {
            echo "<p>No vehicles available for rent at the moment.</p>";
        }
        $conn->close();
        ?>
    </div>
</section>

<div id="viewMorePopup" class="popup-container">
    <div class="popup-content">
        <img id="popupImage" class="popup-image" src="" alt="Vehicle Image">
        <h2>Vehicle Details</h2>
        <p><strong>Vehicle Name:</strong> <span id="popupVehicleName"></span></p>
        <p><strong>Category:</strong> <span id="popupCategory"></span></p>
        <p><strong>Price per Day:</strong> Rs. <span id="popupPricePerDay"></span></p>
        <p><strong>Vehicle Number:</strong> <span id="popupVehicleNumber"></span></p>
        <p><strong>Description:</strong> <span id="popupDescription"></span></p>
        <button class="btn cancel-btn" onclick="closePopup()">X</button>
    </div>
</div>


<?php
    require("layout/footer.php");
?>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    const viewMoreButtons = document.querySelectorAll(".view-more-btn");

    viewMoreButtons.forEach((button) => {
        button.addEventListener("click", function (e) {
            e.preventDefault(); 

            const vehicleName = this.dataset.name;
            const category = this.dataset.category;
            const pricePerDay = this.dataset.price;
            const description = this.dataset.description;
            const vehicleNumber = this.dataset.number;
            const imageUrl = this.dataset.image;

            console.log("Button clicked with data:", {
                vehicleName,
                category,
                pricePerDay,
                description,
                vehicleNumber,
                imageUrl,
            });

            openPopup(vehicleName, category, pricePerDay, description, vehicleNumber, imageUrl);
        });
    });

    document.addEventListener("click", function (e) {
        const popupContainer = document.getElementById("viewMorePopup");
        const popupContent = popupContainer.querySelector(".popup-content");

        if (
            popupContainer.classList.contains("show") && 
            !popupContent.contains(e.target) && 
            !e.target.classList.contains("view-more-btn") 
        ) {
            closePopup();
        }
    });
});

function openPopup(vehicleName, category, pricePerDay, description, vehicleNumber, imageUrl) {
    document.getElementById("popupVehicleName").textContent = vehicleName;
    document.getElementById("popupCategory").textContent = category;
    document.getElementById("popupPricePerDay").textContent = pricePerDay;
    document.getElementById("popupVehicleNumber").textContent = vehicleNumber;
    document.getElementById("popupDescription").textContent = description;
    document.getElementById("popupImage").src = "admin/uploads/" + imageUrl;
    document.getElementById("viewMorePopup").classList.add("show");
}

function closePopup() {
    document.getElementById("viewMorePopup").classList.remove("show");
}


</script>
</body>
</html>
