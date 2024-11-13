<?php

include('db_connect.php');


if (isset($_GET['id'])) {
    $vehicle_id = $_GET['id'];

    
    $query = "SELECT image FROM vehicles WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $vehicle_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    
    $row = mysqli_fetch_assoc($result);
    $image_name = $row['image'];
    
    
    $query = "DELETE FROM vehicles WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $vehicle_id);
    if (mysqli_stmt_execute($stmt)) {
        
        $image_path = __DIR__ . "/uploads/" . $image_name;
        if (file_exists($image_path)) {
            unlink($image_path); 
        }

        
        header("Location: view_vehicle.php");
        exit(); 
    } else {
        echo "Error deleting vehicle.";
    }

    
    mysqli_stmt_close($stmt);
} else {
    echo "Invalid vehicle ID.";
}
?>
