<?php
// Include the database connection file
require_once('admin/script/db_connect.php');

// Get data from the form submission
$full_name = $_POST['full_name'];
$phone_number = $_POST['phone_number'];
$email = $_POST['email'];
$document_type = $_POST['document_type'];

// Handle file upload for document image (id_image)
$id_image = $_FILES['id_image']['name'];
$id_image_tmp = $_FILES['id_image']['tmp_name'];
$id_image_path = "admin/uploads/" . $id_image; // specify the directory for storing the file

// Move the uploaded document image to the desired location
move_uploaded_file($id_image_tmp, $id_image_path);

// Get the rent start and end time (from the form input)
$rent_time_from = $_POST['rent_time_from'];
$rent_time_to = $_POST['rent_time_to'];

// Prepare the SQL query to insert the data into the rent table
$sql = "INSERT INTO rent (full_name, phone_number, email, rent_time_from, rent_time_to, document_type, id_image) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";

// Prepare the statement
$stmt = $conn->prepare($sql);

// Bind the parameters to the statement
$stmt->bind_param("sssssss", $full_name, $phone_number, $email, $rent_time_from, $rent_time_to, $document_type, $id_image);

// Execute the statement
if ($stmt->execute()) {
    echo "Rent record added successfully!";
} else {
    echo "Error: " . $stmt->error;
}

// Close the prepared statement and the database connection
$stmt->close();
$conn->close();
?>
