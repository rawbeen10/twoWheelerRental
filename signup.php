<?php

include('admin/script/db_connect.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

   
    $check_email_query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($check_email_query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "This email is already registered!";
    } else {
     
        $insert_query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("sss", $username, $email, $hashed_password);

        if ($stmt->execute()) {
            echo "Account created successfully!";
           
            header("Location: index.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Page</title>
    <link rel="stylesheet" href="styles/login.css">
    <link rel="stylesheet" href="styles/fonts.css">
    <link rel="stylesheet" href="layout/layout.css">

</head>
<body>

<?php
    require("layout/header.php");
    ?>

    <div class="container">
        <h1>Signup</h1>
        <form action="signup.php" method="POST">
            <input type="text" name="username" id="username" placeholder="Username" required>
            <input type="email" name="email" id="email" placeholder="Enter Your Email" required>
            <input type="password" name="password" id="password" placeholder="Enter Your Password" required>
            <input type="password" name="confirm_password" id="confirm_password" placeholder="Re-enter Your Password" required>

            <input type="checkbox" name="terms" id="terms" required>
            I agree to the <a href="#">Terms and Conditions</a> <br>

            <button type="submit">Sign Up</button>
            <h4>Already have an account? <a href="login.php">Log in</a></h4>
        </form>
    </div>

    <?php
    require("layout/footer.php");
    ?>
</body>
</html>
