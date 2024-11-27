<?php
include('db_connect.php');


if (isset($_GET['id'])) {
    $rent_id = $_GET['id'];

    $query = "DELETE FROM rent WHERE id = $rent_id";
    if (mysqli_query($conn, $query)) {
        header('Location: manage_rentals.php');
        exit;
    } else {
        echo "Error canceling rental: " . mysqli_error($conn);
    }
} else {
    echo "Invalid rent ID.";
}
?>
