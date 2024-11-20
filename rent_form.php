<?php
include('db_connect.php');

// Fetch the vehicle data for a specific rent entry
$vehicle_id = isset($_GET['vehicle_id']) ? $_GET['vehicle_id'] : null;

$vehicle_name = 'N/A';
$vehicle_number = 'N/A';

if ($vehicle_id) {
    $query_vehicle = "SELECT vehicle_name, vehicle_number FROM vehicles WHERE id = '$vehicle_id'";
    $result_vehicle = mysqli_query($conn, $query_vehicle);

    if ($row_vehicle = mysqli_fetch_assoc($result_vehicle)) {
        $vehicle_name = $row_vehicle['vehicle_name'];
        $vehicle_number = $row_vehicle['vehicle_number'];
    }
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

    <form action="submit_rental.php" method="POST">
        <!-- Vehicle Name -->
        <label for="vehicle_name">Vehicle Name</label>
        <input type="text" id="vehicle_name" name="vehicle_name" value="<?php echo htmlspecialchars($vehicle_name); ?>" readonly />

        <!-- Vehicle Number (Read-only) -->
        <label for="vehicle_number">Vehicle Number</label>
        <input type="text" id="vehicle_number" name="vehicle_number" value="<?php echo htmlspecialchars($vehicle_number); ?>" readonly />

        <!-- Full Name -->
        <label for="full_name">Full Name</label>
        <input type="text" id="full_name" name="full_name" required />

        <!-- Phone Number -->
        <label for="phone_number">Phone Number</label>
        <input type="text" id="phone_number" name="phone_number" required />

        <!-- Email -->
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required />

        <!-- Rent From Date -->
        <label for="rent_from">Rent From</label>
        <input type="date" id="rent_from" name="rent_from" required />

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
            <option value="others">Others</option>
        </select>

        <!-- ID Image Upload -->
        <label for="id_image">Upload ID Image</label>
        <input type="file" id="id_image" name="id_image" required />

        <button type="submit">Submit Rental</button>
    </form>
</div>

</body>
</html>
