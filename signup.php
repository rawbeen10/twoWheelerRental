<?php
include('admin/script/db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    $errors = [];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format!";
    }

    if (strlen($password) < 8) {
        $errors['password'] = "Password must be at least 8 characters long!";
    } elseif (!preg_match('/[A-Z]/', $password)) {
        $errors['password'] = "Password must contain at least 1 uppercase letter!";
    } elseif (!preg_match('/[0-9]/', $password)) {
        $errors['password'] = "Password must contain at least 1 number!";
    } elseif (!preg_match('/[\W_]/', $password)) {
        $errors['password'] = "Password must contain at least 1 special character!";
    }

    if ($password !== $confirm_password) {
        $errors['confirm_password'] = "Passwords do not match!";
    }

    $check_email_query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($check_email_query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $errors['email'] = "This email is already registered!";
    }

    $terms = isset($_POST['terms']);
    if (!$terms) {
        $errors['terms'] = "You must agree to the terms and conditions!";
    }

    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $insert_query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("sss", $username, $email, $hashed_password);

        if ($stmt->execute()) {
            header("Location: login.php");
            exit();
        } else {
            $errors['general'] = "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
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
    <style>
        .container form > div {
            margin-bottom: 20px; 
        }

        .error-message {
            color: red;
            font-size: 0.9em;
            margin-top: 5px; 
        }

        .password-field {
            position: relative;
            display: flex;
            flex-direction: column;
            width: 100%;
        }

        .password-field input {
            width: 100%;
            padding-right: 40px; 
            box-sizing: border-box;
            height: 40px; 
        }

        .toggle-btn {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%); 
            cursor: pointer;
            color: #007bff;
            font-size: 1rem;
        }

        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<?php require("layout/header.php"); ?>

<div class="container">
    <h1>Signup</h1>
    <form action="signup.php" method="POST" id="signup-form">
        <div>
            <input type="text" name="username" id="username" placeholder="Full Name" required>
            <div class="error-message" id="username-error"></div>
        </div>
        <div>
            <input type="email" name="email" id="email" placeholder="Enter Your Email" required>
            <div class="error-message" id="email-error"><?php echo $errors['email'] ?? ''; ?></div>
        </div>
        <div class="password-field">
            <input type="password" name="password" id="password" placeholder="Enter Your Password" required>
            <span class="toggle-btn" id="toggle-password" onclick="togglePasswordVisibility()">Show</span>
            <div class="error-message" id="password-error"><?php echo $errors['password'] ?? ''; ?></div>
        </div>
        <div class="password-field">
            <input type="password" name="confirm_password" id="confirm_password" placeholder="Re-enter Your Password" required>
            <span class="toggle-btn" id="toggle-confirm-password" onclick="toggleConfirmPasswordVisibility()">Show</span>
            <div class="error-message" id="confirm-password-error"><?php echo $errors['confirm_password'] ?? ''; ?></div>
        </div>
        <div>
            <input type="checkbox" name="terms" id="terms" required>
            I agree to the <a href="#">Terms and Conditions</a>
            <div class="error-message" id="terms-error"><?php echo $errors['terms'] ?? ''; ?></div>
        </div>
        <button type="submit">Sign Up</button>
        <h4>Already have an account? <a href="login.php">Log in</a></h4>
    </form>
</div>

<?php require("layout/footer.php"); ?>

<script>
    document.getElementById('signup-form').addEventListener('submit', function (event) {
        let hasError = false;

        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm_password').value;
        const terms = document.getElementById('terms').checked;

        document.getElementById('email-error').textContent = '';
        document.getElementById('password-error').textContent = '';
        document.getElementById('confirm-password-error').textContent = '';
        document.getElementById('terms-error').textContent = '';

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            document.getElementById('email-error').textContent = "Please enter a valid email address.";
            hasError = true;
        }

        if (password.length < 8) {
            document.getElementById('password-error').textContent = "Password must be at least 8 characters long.";
            hasError = true;
        }
        if (!/[A-Z]/.test(password)) {
            document.getElementById('password-error').textContent = "Password must contain at least 1 uppercase letter.";
            hasError = true;
        }
        if (!/[0-9]/.test(password)) {
            document.getElementById('password-error').textContent = "Password must contain at least 1 number.";
            hasError = true;
        }
        if (!/[\W_]/.test(password)) {
            document.getElementById('password-error').textContent = "Password must contain at least 1 special character.";
            hasError = true;
        }

        if (password !== confirmPassword) {
            document.getElementById('confirm-password-error').textContent = "Passwords do not match.";
            hasError = true;
        }

        if (!terms) {
            document.getElementById('terms-error').textContent = "You must agree to the terms and conditions.";
            hasError = true;
        }

        if (hasError) {
            event.preventDefault();
        }
    });

    function togglePasswordVisibility() {
        var passwordField = document.getElementById('password');
        var toggleButton = document.getElementById('toggle-password');
        var type = passwordField.type === 'password' ? 'text' : 'password';
        passwordField.type = type;
        toggleButton.textContent = type === 'password' ? 'Show' : 'Hide';
    }

    function toggleConfirmPasswordVisibility() {
        var confirmPasswordField = document.getElementById('confirm_password');
        var toggleButton = document.getElementById('toggle-confirm-password');
        var type = confirmPasswordField.type === 'password' ? 'text' : 'password';
        confirmPasswordField.type = type;
        toggleButton.textContent = type === 'password' ? 'Show' : 'Hide';
    }
</script>
</body>
</html>
