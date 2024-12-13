<?php
include('admin/script/db_connect.php'); 

// Ensure user is logged in and user_id is available in session
session_start();
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to rent a vehicle.");
}

$user_id = $_SESSION['user_id'];  // Get user_id from the session

$vehicle_id = $_POST['id']; 
$full_name = $_POST['full_name'];
$phone_number = $_POST['phone_number'];
$email = $_POST['email'];
$rent_from = $_POST['rent_from'];
$rent_to = $_POST['rent_to'];
$document_type = $_POST['document_type'];

$id_image = $_FILES['id_image']['name'];
$id_image_tmp = $_FILES['id_image']['tmp_name'];
$id_image_path = "admin/uploads/" . $id_image; 
move_uploaded_file($id_image_tmp, $id_image_path);

$rent_from_date = new DateTime($rent_from);
$rent_to_date = new DateTime($rent_to);
$duration = $rent_from_date->diff($rent_to_date)->days;

$sql_vehicle = "SELECT vehicle_name, vehicle_number, category, price_per_day, image FROM vehicles WHERE id = ?";
$stmt_vehicle = $conn->prepare($sql_vehicle);
$stmt_vehicle->bind_param("i", $vehicle_id); 
$stmt_vehicle->execute();
$stmt_vehicle->bind_result($vehicle_name, $vehicle_number, $category, $price_per_day, $vehicle_image);
$stmt_vehicle->fetch();
$stmt_vehicle->close();

if (!$vehicle_name) {
    die("No vehicle found with the given ID.");
}

$grand_total = $duration * $price_per_day; // Calculate the grand total

// Set the initial status to 'pending' for the new rental
$status = 'pending';

// Insert rent data into the rent table, including the user_id and the initial status
$sql_rent = "INSERT INTO rent (user_id, vehicle_id, full_name, phone_number, email, rent_from, rent_to, document_type, id_image, status) 
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt_rent = $conn->prepare($sql_rent);

// Bind parameters with the correct types (i - integer, s - string)
$stmt_rent->bind_param("iissssssss", $user_id, $vehicle_id, $full_name, $phone_number, $email, $rent_from, $rent_to, $document_type, $id_image, $status);

if ($stmt_rent->execute()) {
    $rent_id = $stmt_rent->insert_id; // Get the last inserted rent ID

    // Redirect to billing.php with rent_id, grand_total, and other relevant details
    header("Location: billing.php?id=" . $rent_id . 
           "&full_name=" . urlencode($full_name) . 
           "&phone_number=" . urlencode($phone_number) . 
           "&email=" . urlencode($email) . 
           "&vehicle_name=" . urlencode($vehicle_name) . 
           "&vehicle_number=" . urlencode($vehicle_number) . 
           "&category=" . urlencode($category) . 
           "&price_per_day=" . urlencode($price_per_day) . 
           "&rent_from=" . urlencode($rent_from) . 
           "&rent_to=" . urlencode($rent_to) . 
           "&id_image=" . urlencode($id_image) . 
           "&vehicle_image=" . urlencode($vehicle_image) . 
           "&grand_total=" . urlencode($grand_total));  // Include grand_total in the URL
    exit;
} else {
    echo "Error: " . $stmt_rent->error;
}

$stmt_rent->close();
$conn->close();
?>
