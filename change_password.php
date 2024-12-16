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

    if ($new_password !== $confirm_password) {
        $error_message = "New password and confirmation do not match.";
    } else {
        $query = "SELECT password FROM users WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if (password_verify($current_password, $user['password'])) {
            if (preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $new_password)) {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $update_query = "UPDATE users SET password = ? WHERE id = ?";
                $update_stmt = $conn->prepare($update_query);
                $update_stmt->bind_param("si", $hashed_password, $user_id);

                if ($update_stmt->execute()) {
                    session_destroy();
                    header("Location: login.php?message=Password changed successfully.");
                    exit();
                } else {
                    $error_message = "Error updating password.";
                }
            } else {
                $error_message = "Password must be at least 8 characters, with one uppercase letter, number, and special character.";
            }
        } else {
            $error_message = "Current password is incorrect.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="styles/change_password.css">
</head>
<body>
    <div class="change-password-container">
        <div class="change-password-card">
            <h2>Change Password</h2>
            <form action="change_password.php" method="POST">
                <label for="current_password">Current Password:</label>
                <div class="input-container">
                    <input type="password" id="current_password" name="current_password" required>
                    <span class="toggle-btn" onclick="togglePassword('current_password', this)">Show</span>
                </div>

                <label for="new_password">New Password:</label>
                <div class="input-container">
                    <input type="password" id="new_password" name="new_password" required>
                    <span class="toggle-btn" onclick="togglePassword('new_password', this)">Show</span>
                </div>

                <label for="confirm_password">Confirm New Password:</label>
                <div class="input-container">
                    <input type="password" id="confirm_password" name="confirm_password" required>
                    <span class="toggle-btn" onclick="togglePassword('confirm_password', this)">Show</span>
                </div>

                <div id="error-messages">
                    <?php if (!empty($error_message)): ?>
                        <p class="error"><?php echo $error_message; ?></p>
                    <?php endif; ?>
                </div>

                <button type="submit">Change Password</button>
            </form>
        </div>
    </div>

    <script>
        function togglePassword(fieldId, toggleElement) {
            const inputField = document.getElementById(fieldId);
            if (inputField.type === "password") {
                inputField.type = "text";
                toggleElement.textContent = "Hide";
            } else {
                inputField.type = "password";
                toggleElement.textContent = "Show";
            }
        }
    </script>
</body>
</html>
