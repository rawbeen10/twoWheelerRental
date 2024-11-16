<?php
include('db_connect.php');

// Check if the 'id' is passed through the URL
if (isset($_GET['id'])) {
    $contact_id = $_GET['id'];

    // Delete the contact from the database
    $query = "DELETE FROM contacts WHERE id = $contact_id";
    $result = mysqli_query($conn, $query);

    // Check if the deletion was successful
    if ($result) {
        // Redirect to the manage contacts page after successful deletion
        header("Location: manage_contacts.php?message=Contact deleted successfully");
        exit();
    } else {
        // If there's an error, display an error message
        echo "Error: Could not delete contact.";
    }
} else {
    // If no 'id' is passed, redirect back to the contacts page with an error
    header("Location: manage_contacts.php?error=No contact ID provided");
    exit();
}
?>
