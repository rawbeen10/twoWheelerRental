<?php
// Include database connection
include('../script/db_connect.php');

// Check if rent ID is provided and valid
if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    $rent_id = (int)$_GET['id'];

    // Update the status to "approved" instead of deleting the record
    $query_approve = "UPDATE rent SET status = 'approved' WHERE id = ?";
    $stmt = $conn->prepare($query_approve);

    if ($stmt) {
        $stmt->bind_param("i", $rent_id);

        // Execute the query
        if ($stmt->execute()) {
            // Redirect back to manage_rental.php
            header('Location: manage_rental.php');
            exit();
        } else {
            echo "Error approving rental: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
} else {
    echo "Invalid rent ID.";
}

// Close the database connection
$conn->close();
?>
