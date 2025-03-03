<?php
session_start();
include('admin/script/db_connect.php');

if (isset($_GET['message'])) {
    $message = $_GET['message'];
    echo "<script>alert('$message');</script>"; // Show an alert with the message
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $error_message = '';

    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];

            header("Location: index.php");
            exit();
        } else {
            $error_message = "Incorrect password!";
        }
    } else {
        $error_message = "No user found with that email!";
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
    <link rel="stylesheet" href="styles/fonts.css">
    <link rel="stylesheet" href="layout/layout.css">
</head>
<body>

<?php
    require("layout/header.php");
?>


<div class="container">
    <h1>Login</h1>
    <form action="login.php" method="POST">
        <input type="email" name="email" id="email" placeholder="Enter Your Email" required>
        <div class="password-field">
            <input type="password" name="password" id="password" placeholder="Enter Your Password" required>
            <span id="toggle-password" onclick="togglePasswordVisibility()">Show</span>
        </div>
        
        <?php if (!empty($error_message)): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <button type="submit">Login</button>
        <h4>Don't have an account? <a href="signup.php">Sign Up</a></h4>
    </form>
</div>

<?php
    require("layout/footer.php");
?>

<script>
    function togglePasswordVisibility() {
        let passwordField = document.getElementById('password');
        let toggleButton = document.getElementById('toggle-password');
        let type = passwordField.type === 'password' ? 'text' : 'password';
        passwordField.type = type;
        toggleButton.textContent = type === 'password' ? 'Show' : 'Hide';
    }
</script>

</body>
</html>
