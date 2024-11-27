<?php
include('../script/db_connect.php');

$rental_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($rental_id > 0) {
    $query_approve = "UPDATE rent SET status = 'approved' WHERE id = ?";
    
    $stmt = $conn->prepare($query_approve);
    $stmt->bind_param("i", $rental_id);
    
    if ($stmt->execute()) {
        header('Location: manage_rental.php');
        exit();
    } else {
        echo "Error updating rental status: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Invalid rental ID.";
}

$conn->close();
?>
