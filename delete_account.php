<?php
session_start();
include('admin/script/db_connect.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Check if the delete account form is submitted
if (isset($_POST['delete_account'])) {
    // Start a transaction to ensure both user and related data (if any) are deleted
    $conn->begin_transaction();

    try {
        // Delete user from the 'users' table
        $delete_user_query = "DELETE FROM users WHERE id = ?";
        $stmt = $conn->prepare($delete_user_query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // Optionally, delete any related data (profile image, posts, comments, etc.)
            // Example: Deleting user's profile image if it exists
            $user_query = "SELECT profile_image FROM users WHERE id = ?";
            $stmt = $conn->prepare($user_query);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $stmt->bind_result($profile_image);
            $stmt->fetch();

            if ($profile_image && file_exists($profile_image)) {
                unlink($profile_image); // Delete the profile image from the server
            }

            // Commit the transaction
            $conn->commit();

            // Destroy the session to log out the user
            session_destroy();

            // Redirect to the login page with a success message
            header("Location: login.php?message=Account Deleted Successfully");
            exit();
        } else {
            // If the user could not be deleted
            throw new Exception("Error deleting user account.");
        }
    } catch (Exception $e) {
        // Rollback the transaction in case of error
        $conn->rollback();
        echo "Error deleting account: " . $e->getMessage();
    }

    $stmt->close();
}

$conn->close();
?>
