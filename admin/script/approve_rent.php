<?php
include('db_connect.php');

// Get the rent ID from the query string
if (isset($_GET['id'])) {
    $rent_id = $_GET['id'];

    // Start a transaction to ensure both operations are completed
    mysqli_begin_transaction($conn);
    try {
        // Step 1: Insert the approved rental into the approved_rentals table
        $query = "INSERT INTO approved_rentals (id, vehicle_name, rent_date, status)
                  SELECT id, vehicle_name, rent_date, 'approved' FROM rent WHERE id = $rent_id";
        mysqli_query($conn, $query);

        // Step 2: Delete the rental from the 'rent' table (pending rentals)
        $query = "DELETE FROM rent WHERE id = $rent_id";
        mysqli_query($conn, $query);

        // Step 3: Commit the transaction
        mysqli_commit($conn);

        // Redirect to the manage rentals page or show a success message
        header('Location: manage_rentals.php');
        exit;
    } catch (Exception $e) {
        // In case of an error, rollback the transaction
        mysqli_rollback($conn);
        echo "Error approving rental: " . $e->getMessage();
    }
} else {
    echo "Invalid rent ID.";
}
?>
