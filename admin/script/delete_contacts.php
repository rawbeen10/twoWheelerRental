<?php
include('db_connect.php');

if (isset($_GET['id'])) {
    $contact_id = $_GET['id'];

    $query = "DELETE FROM contacts WHERE id = $contact_id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        header("Location: manage_contacts.php?message=Contact deleted successfully");
        exit();
    } else {
        echo "Error: Could not delete contact.";
    }
} else {
    header("Location: manage_contacts.php?error=No contact ID provided");
    exit();
}
?>
