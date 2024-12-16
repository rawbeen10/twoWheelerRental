<?php
session_start();
include('admin/script/db_connect.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate new password and confirmation
    if ($new_password !== $confirm_password) {
        $error_message = "New password and confirmation do not match.";
    } else {
        // Check if current password is correct
        $query = "SELECT password FROM users WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if (password_verify($current_password, $user['password'])) {
            // Validate new password strength
            if (preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $new_password)) {
                // Hash new password and update it in the database
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $update_query = "UPDATE users SET password = ? WHERE id = ?";
                $update_stmt = $conn->prepare($update_query);
                $update_stmt->bind_param("si", $hashed_password, $user_id);

                if ($update_stmt->execute()) {
                    session_destroy(); // Logout the user
                    header("Location: login.php?message=Password changed successfully. Please log in again.");
                    exit();
                } else {
                    $error_message = "Error updating password.";
                }
            } else {
                $error_message = "Password must be at least 8 characters long, contain at least one uppercase letter, one number, and one special character.";
            }
        } else {
            $error_message = "Current password is incorrect.";
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
    <title>Change Password</title>
    <link rel="stylesheet" href="styles/change_password.css">
    <script>
        // Client-side validation for new password strength and matching passwords
        function validateForm() {
            let currentPassword = document.getElementById('current_password').value;
            let newPassword = document.getElementById('new_password').value;
            let confirmPassword = document.getElementById('confirm_password').value;
            let errorMessages = document.getElementById('error-messages');

            // Clear previous error messages
            errorMessages.innerHTML = "";

            // Validate current password
            if (currentPassword == "") {
                errorMessages.innerHTML += "<p class='error'>Current password is required.</p>";
                return false;
            }

            // Validate new password
            if (newPassword.length < 8) {
                errorMessages.innerHTML += "<p class='error'>New password must be at least 8 characters long.</p>";
                return false;
            }
            if (!/[A-Z]/.test(newPassword)) {
                errorMessages.innerHTML += "<p class='error'>New password must contain at least one uppercase letter.</p>";
                return false;
            }
            if (!/\d/.test(newPassword)) {
                errorMessages.innerHTML += "<p class='error'>New password must contain at least one number.</p>";
                return false;
            }
            if (!/[!@#$%^&*(),.?":{}|<>]/.test(newPassword)) {
                errorMessages.innerHTML += "<p class='error'>New password must contain at least one special character.</p>";
                return false;
            }

            // Validate confirm password matches
            if (newPassword !== confirmPassword) {
                errorMessages.innerHTML += "<p class='error'>New password and confirmation do not match.</p>";
                return false;
            }

            return true;
        }
    </script>
</head>
<body>
    <div class="change-password-container">
        <div class="change-password-card">
            <h2>Change Password</h2>
            <form action="change_password.php" method="POST" onsubmit="return validateForm()">
                <label for="current_password">Current Password:</label>
                <input type="password" id="current_password" name="current_password" required>

                <label for="new_password">New Password:</label>
                <input type="password" id="new_password" name="new_password" required>

                <label for="confirm_password">Confirm New Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>

                <div id="error-messages"></div>

                <button type="submit">Change Password</button>
            </form>
            <?php if (!empty($error_message)): ?>
                <div class="error-message"><?php echo $error_message; ?></div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
