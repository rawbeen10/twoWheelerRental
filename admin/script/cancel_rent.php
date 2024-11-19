<?php
include('db_connect.php');

// Get the rent ID from the query string
if (isset($_GET['id'])) {
    $rent_id = $_GET['id'];

    // Delete the rental from the 'rent' table (pending rentals)
    $query = "DELETE FROM rent WHERE id = $rent_id";
    if (mysqli_query($conn, $query)) {
        // Redirect to the manage rentals page after cancellation
        header('Location: manage_rentals.php');
        exit;
    } else {
        echo "Error canceling rental: " . mysqli_error($conn);
    }
} else {
    echo "Invalid rent ID.";
}
?>
