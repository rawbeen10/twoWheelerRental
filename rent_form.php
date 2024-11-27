<?php
include('admin/script/db_connect.php');


$vehicle_id = isset($_GET['id']) ? $_GET['id'] : '';

if (empty($vehicle_id)) {
    die("Vehicle ID is missing.");
}

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
    <link rel="stylesheet" href="layout/layout.css">
    <link rel="stylesheet" href="styles/fonts.css">
</head>
<body>
<?php
    require("layout/header.php");
    ?>

<div class="container">
    <h2>Rental Form</h2>

    <form action="process_rent.php" method="POST" enctype="multipart/form-data" onsubmit="validateForm(event)">
    <input type="hidden" name="id" value="<?php echo $vehicle_id; ?>">

        <label for="vehicle_name">Vehicle Name</label>
        <input type="text" id="vehicle_name" name="vehicle_name" value="<?php echo htmlspecialchars($vehicle_name); ?>" readonly />

        <label for="category">Category</label>
        <input type="text" id="category" name="category" value="<?php echo htmlspecialchars($category); ?>" readonly />

        </select>

        <label for="price_per_day">Price per Day</label>
        <input type="text" id="price_per_day" name="price_per_day" value="<?php echo htmlspecialchars($price_per_day); ?>" readonly />

        <label for="vehicle_number">Vehicle Number</label>
        <input type="text" id="vehicle_number" name="vehicle_number" value="<?php echo htmlspecialchars($vehicle_number); ?>" readonly />

        <label for="full_name">Full Name</label>
        <input type="text" id="full_name" name="full_name" required />

        <label for="phone_number">Phone Number</label>
        <input type="text" id="phone_number" name="phone_number" required />
        <div id="phone-message" style="color: red; display: none;">Please enter exactly 10 digits.</div>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" required />
        <div id="email-message" style="color: red; display: none;">Please enter a valid email address.</div>

        <label for="rent_from">Rent From</label>
        <input type="date" id="rent_from" name="rent_from" required />
        <div id="rent-from-message" style="color: red; display: none;">Rent start date cannot be in the past.</div>

        <label for="rent_to">Rent To</label>
        <input type="date" id="rent_to" name="rent_to" required />

        <label for="document_type">Document Type</label>
        <select name="document_type" id="document_type" required>
                <option value="citizenship">Citizenship</option>
                <option value="driving licence">Driving Licence</option>
            <option value="national id">National ID</option>
            <option value="voterid">Voter ID</option>
            <option value="other">Other</option>
        </select>

        <label for="id_image">Upload ID Image</label>
        <input type="file" id="id_image" name="id_image" required />

        <button type="submit">Submit Rental</button>
    </form>
</div>

<script>
        function validateForm(event) {
            let isValid = true;

            const email = document.getElementById("email");
            const emailMessage = document.getElementById("email-message");
            const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (!emailPattern.test(email.value)) {
                emailMessage.style.display = "block";
                isValid = false;
            } else {
                emailMessage.style.display = "none";
            }

            const phone = document.getElementById("phone_number");
            const phoneMessage = document.getElementById("phone-message");
            const phonePattern = /^\d{10}$/;
            if (!phonePattern.test(phone.value)) {
                phoneMessage.style.display = "block";
                isValid = false;
            } else {
                phoneMessage.style.display = "none";
            }

            const rentFrom = document.getElementById("rent_from");
            const rentFromMessage = document.getElementById("rent-from-message");
            const today = new Date().toISOString().split('T')[0]; 
            if (rentFrom.value < today) {
                rentFromMessage.style.display = "block";
                isValid = false;
            } else {
                rentFromMessage.style.display = "none";
            }

            if (!isValid) {
                event.preventDefault(); 
            }
        }
    </script>

</body>
</html>
