<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "twowheelerrental"; 


$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $sql = "INSERT INTO contacts (name, phone, email, message) 
            VALUES ('$name', '$phone', '$email', '$message')";

    if ($conn->query($sql) === TRUE) {
       
        echo "Contact information has been saved!";
    } else {
        
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

  
    $conn->close();
}
?>
