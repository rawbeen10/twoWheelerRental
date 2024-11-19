<?php
// Check if all required parameters are set in the URL
if (isset($_GET['vehicle_name']) && isset($_GET['category']) && isset($_GET['price_per_day']) && isset($_GET['image'])) {
    // Assign parameters to variables
    $vehicleName = $_GET['vehicle_name'];
    $category = $_GET['category'];
    $pricePerDay = $_GET['price_per_day'];
    $image = $_GET['image'];
} else {
    // If parameters are not set, redirect back to rent page or show an error message
    echo "Vehicle not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent Form</title>
    <link rel="stylesheet" href="styles/rent_form.css">
    <link rel="stylesheet" href="layout/layout.css">
    <link rel="stylesheet" href="styles/fonts.css">
    <link rel="stylesheet" href="styles/rentForm.css">
</head>
<body>
    <?php require("layout/header.php"); ?>

    <section id="rent-form">
        <h1>Rent Your Ride: <?php echo htmlspecialchars($vehicleName); ?></h1>
        <form action="process_rent.php" method="POST" enctype="multipart/form-data">
            <!-- Vehicle details (readonly) -->
            <input type="text" name="vehicle_name" value="<?php echo htmlspecialchars($vehicleName); ?>" readonly>
            <input type="text" name="category" value="<?php echo htmlspecialchars($category); ?>" readonly>
            <input type="text" name="price_per_day" value="<?php echo htmlspecialchars($pricePerDay); ?>" readonly>
            <img src="admin/uploads/<?php echo htmlspecialchars($image); ?>" alt="Vehicle Image" class="vehicle-image">
            
            <!-- Rent information -->
            <label for="full_name">Full Name:</label>
            <input type="text" name="full_name" required>

            <label for="phone_number">Phone Number:</label>
            <input type="text" name="phone_number" required>

            <label for="email">Email:</label>
            <input type="email" name="email" required>

            <label for="rent_time_from">Rent From:</label>
            <input type="time" name="rent_time_from" required> <!-- format: mmddyyhhmmss -->

            <label for="rent_time_to">Rent To :</label>
            <input type="time" name="rent_time_to" required> <!-- format: mmddyyhhmmss -->

            <label for="document_type">Document Type:</label>
            <select name="document_type" required>
                <option value="citizenship">Citizenship</option>
                <option value="driving license">Driving Licence</option>
                <option value="national_id">National ID</option>
                <option value="voter id">Voter ID</option>
                <option value="other">Others</option>
            </select>

            <label for="id_image">Document Image:</label>
            <input type="file" name="id_image" accept="image/*" required>

            <button type="submit" class="btn rent-submit-btn">Submit Rent</button>
        </form>
    </section>

    <?php require("layout/footer.php"); ?>
</body>
</html>
