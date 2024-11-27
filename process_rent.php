<?php
include('admin/script/db_connect.php'); 

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

$grand_total = $duration * $price_per_day;

$sql_rent = "INSERT INTO rent (full_name, phone_number, email, rent_from, rent_to, document_type, id_image) 
             VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt_rent = $conn->prepare($sql_rent);
$stmt_rent->bind_param("sssssss", $full_name, $phone_number, $email, $rent_from, $rent_to, $document_type, $id_image);

if ($stmt_rent->execute()) {

    header("Location: billing.php?full_name=" . urlencode($full_name) . 
           "&phone_number=" . urlencode($phone_number) . 
           "&email=" . urlencode($email) . 
           "&vehicle_name=" . urlencode($vehicle_name) . 
           "&vehicle_number=" . urlencode($vehicle_number) . 
           "&category=" . urlencode($category) . 
           "&price_per_day=" . urlencode($price_per_day) . 
           "&rent_from=" . urlencode($rent_from) . 
           "&rent_to=" . urlencode($rent_to) . 
           "&id_image=" . urlencode($id_image) . 
           "&grand_total=" . $grand_total . 
           "&vehicle_image=" . urlencode($vehicle_image));  
    exit;
} else {
    echo "Error: " . $stmt_rent->error;
}

$stmt_rent->close();
$conn->close();
?>
