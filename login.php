<?php

session_start(); // Start the session

include('admin/script/db_connect.php'); // Database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collecting the input from the form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query to fetch user based on email
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // If a user is found, verify the password
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password'])) {
            // If password matches, set session variables
            $_SESSION['user_id'] = $user['id'];  // Store the user ID in session
            $_SESSION['username'] = $user['username'];  // Store the username in session
            $_SESSION['email'] = $user['email'];  // Store the email in session

            // Redirect to profile page or any other page
            header("Location: profile.php"); // Redirect to the profile page
            exit();
        } else {
            // Incorrect password message
            echo "Incorrect password!";
        }
    } else {
        // No user found with the provided email
        echo "No user found with that email!";
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="styles/login.css">
    <link rel="stylesheet" href="styles/fonts.css">
    <link rel="stylesheet" href="layout/layout.css">
</head>
<body>

<?php
    require("layout/header.php");
    ?>

   <span id="admin-login"><a href="admin/script/index.php">Admin Login</a></span> 

    <div class="container">
        <h1>Login</h1>
        <form action="login.php" method="POST">
            <input type="email" name="email" id="email" placeholder="Enter Your Email" required>
            <input type="password" name="password" id="password" placeholder="Enter Your Password" required>

            <button type="submit">Login</button>
            <h4>Don't have an account? <a href="signup.php">Sign Up</a></h4>
        </form>
    </div>

    <?php
    require("layout/footer.php");
    ?>
</body>
</html>
