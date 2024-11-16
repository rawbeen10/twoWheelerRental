<?php

session_start();


include('admin/script/db_connect.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
        
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];

            header("Location: index.php");
            exit();
        } else {
            echo "Incorrect password!";
        }
    } else {
        echo "No user found with that email!";
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
    <title>Login Page</title>
    <link rel="stylesheet" href="styles/login.css">
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <form action="login.php" method="POST">
            <input type="email" name="email" id="email" placeholder="Enter Your Email" required>
            <input type="password" name="password" id="password" placeholder="Enter Your Password" required>

            <button type="submit">Login</button>
            <h4>Don't have an account? <a href="signup.php">Sign Up</a></h4>
        </form>
    </div>
</body>
</html>
