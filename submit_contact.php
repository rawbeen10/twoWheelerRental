<?php
session_start(); // Start the session to check login status

// Check if the user is logged in, if not, redirect them to the login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");  // Redirect to login page
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "twowheelerrental"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from the contact form
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Insert contact data into the database
    $sql = "INSERT INTO contacts (name, phone, email, message) 
            VALUES ('$name', '$phone', '$email', '$message')";

    if ($conn->query($sql) === TRUE) {
        // If the message is successfully sent, display a success message
        echo "Your message has been sent. Our team will get back to you soon!";
    } else {
        // If there is an error, display the error message
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>
