<?php
include('admin/script/db_connect.php');

// Assuming you are fetching vehicle data from the database to display the available vehicles
// Fetch the vehicle details based on the vehicle ID passed in the URL
$vehicle_id = isset($_GET['id']) ? $_GET['id'] : '';

if (empty($vehicle_id)) {
    die("Vehicle ID is missing.");
}

// Query to get vehicle details
$sql = "SELECT id, vehicle_name, vehicle_number, category, price_per_day FROM vehicles WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $vehicle_id);
$stmt->execute();
$stmt->bind_result($id, $vehicle_name, $vehicle_number, $category, $price_per_day);
$stmt->fetch();
$stmt->close();

if (!$vehicle_name) {
    die("No vehicle found with the given ID.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental Form</title>
    <link rel="stylesheet" href="styles/rent_form.css">
</head>
<body>

<div class="container">
    <h2>Rental Form</h2>

    <form action="process_rent.php" method="POST" enctype="multipart/form-data" onsubmit="validateForm(event)">
    <input type="hidden" name="id" value="<?php echo $vehicle_id; ?>">

        <label for="vehicle_name">Vehicle Name</label>
        <input type="text" id="vehicle_name" name="vehicle_name" value="<?php echo htmlspecialchars($vehicle_name); ?>" readonly />

        <!-- Vehicle Category (Read-only dropdown) -->
        <label for="category">Category</label>
        <select id="category" name="category" disabled>
            <option value="bike" <?php echo ($category == 'bike') ? 'selected' : ''; ?>>Bike</option>
            <option value="scooter" <?php echo ($category == 'scooter') ? 'selected' : ''; ?>>Scooter</option>
        </select>

        <!-- Price per Day (Read-only) -->
        <label for="price_per_day">Price per Day</label>
        <input type="text" id="price_per_day" name="price_per_day" value="<?php echo htmlspecialchars($price_per_day); ?>" readonly />

        <!-- Vehicle Number (Read-only) -->
        <label for="vehicle_number">Vehicle Number</label>
        <input type="text" id="vehicle_number" name="vehicle_number" value="<?php echo htmlspecialchars($vehicle_number); ?>" readonly />

        <!-- Full Name -->
        <label for="full_name">Full Name</label>
        <input type="text" id="full_name" name="full_name" required />

        <!-- Phone Number -->
        <label for="phone_number">Phone Number</label>
        <input type="text" id="phone_number" name="phone_number" required />
        <div id="phone-message" style="color: red; display: none;">Please enter exactly 10 digits.</div>

        <!-- Email -->
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required />
        <div id="email-message" style="color: red; display: none;">Please enter a valid email address.</div>

        <!-- Rent From Date -->
        <label for="rent_from">Rent From</label>
        <input type="date" id="rent_from" name="rent_from" required />
        <div id="rent-from-message" style="color: red; display: none;">Rent start date cannot be in the past.</div>

        <!-- Rent To Date -->
        <label for="rent_to">Rent To</label>
        <input type="date" id="rent_to" name="rent_to" required />

        <!-- Document Type -->
        <label for="document_type">Document Type</label>
        <select id="document_type" name="document_type">
            <option value="citizenship">Citizenship</option>
            <option value="driving_license">Driving License</option>
            <option value="national_id">National ID</option>
            <option value="voter_id">Voter ID</option>
            <option value="other">Other</option>
        </select>

        <!-- ID Image Upload -->
        <label for="id_image">Upload ID Image</label>
        <input type="file" id="id_image" name="id_image" required />

        <button type="submit">Submit Rental</button>
    </form>
</div>

<script>
        // Validate the form before submission
        function validateForm(event) {
            let isValid = true;

            // Email validation
            const email = document.getElementById("email");
            const emailMessage = document.getElementById("email-message");
            const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (!emailPattern.test(email.value)) {
                emailMessage.style.display = "block";
                isValid = false;
            } else {
                emailMessage.style.display = "none";
            }

            // Phone number validation (exactly 10 digits)
            const phone = document.getElementById("phone_number");
            const phoneMessage = document.getElementById("phone-message");
            const phonePattern = /^\d{10}$/;
            if (!phonePattern.test(phone.value)) {
                phoneMessage.style.display = "block";
                isValid = false;
            } else {
                phoneMessage.style.display = "none";
            }

            // Date validation (rent_from should not be in the past)
            const rentFrom = document.getElementById("rent_from");
            const rentFromMessage = document.getElementById("rent-from-message");
            const today = new Date().toISOString().split('T')[0]; // Get current date in YYYY-MM-DD format
            if (rentFrom.value < today) {
                rentFromMessage.style.display = "block";
                isValid = false;
            } else {
                rentFromMessage.style.display = "none";
            }

            if (!isValid) {
                event.preventDefault(); // Prevent form submission if validation fails
            }
        }
    </script>

</body>
</html>
