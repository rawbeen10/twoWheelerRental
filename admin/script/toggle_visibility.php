<?php
include('db_connect.php');

if (isset($_GET['id']) && isset($_GET['visibility'])) {
    $id = intval($_GET['id']);
    $visibility = $_GET['visibility'] === 'show' ? 'show' : 'hide';

    $query = "UPDATE vehicles SET visibility = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $visibility, $id);

    if ($stmt->execute()) {
        header("Location: view_vehicle.php");
        exit();
    } else {
        echo "Error updating visibility.";
    }
} else {
    echo "Invalid request.";
}
?>
