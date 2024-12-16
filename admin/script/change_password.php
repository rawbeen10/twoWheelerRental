<?php
session_start();
include('../script/db_connect.php');

// Initialize error message variables
$old_password_error = $new_password_error = $retype_password_error = "";
$password_changed_message = "";

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the current admin's ID from session
    $admin_id = $_SESSION['admin_id'];
    
    // Get form data
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $retype_password = $_POST['retype_password'];

    // Validate old password, new password, and retype password
    if (empty($old_password)) {
        $old_password_error = "Old password is required.";
    } else {
        // Check if the old password is correct
        $query = "SELECT password FROM admins WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $admin_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $admin = $result->fetch_assoc();

        // Verify old password
        if (MD5($old_password) !== $admin['password']) {
            $old_password_error = "Old password is incorrect.";
        }
    }

    // Validate new password
    if (empty($new_password)) {
        $new_password_error = "New password is required.";
    } elseif (strlen($new_password) < 6) {
        $new_password_error = "Password must be at least 6 characters long.";
    }

    // Validate retype password
    if (empty($retype_password)) {
        $retype_password_error = "Please retype the new password.";
    } elseif ($new_password !== $retype_password) {
        $retype_password_error = "Passwords do not match.";
    }

    // If no errors, update the password
    if (empty($old_password_error) && empty($new_password_error) && empty($retype_password_error)) {
        // Hash the new password and update in the database
        $hashed_new_password = MD5($new_password);
        $update_query = "UPDATE admins SET password = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("si", $hashed_new_password, $admin_id);
        $update_stmt->execute();

        // Display success message
        $password_changed_message = "Password successfully changed.";

        header("Location: index.php");
        exit(); // Make sure no further code is executed
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
    <link rel="stylesheet" href="../Layout/sidebar.css">
</head>
<body>
    <div class="main-container">
        <div class="container-one">
            <?php include '../Layout/sidebar.html'; ?>
            <script src="../Layout/sidebar.js"></script>
        </div>
        <div class="container-two">
            <div class="change-password-container">
                <div class="change-password-card">
                    <h2>Change Password</h2>

                    <!-- Display success message if password is changed -->
                    <?php if ($password_changed_message) { ?>
                        <p style="color: green;"><?php echo $password_changed_message; ?></p>
                    <?php } ?>

                    <form method="POST" action="change_password.php">
                        <table>
                            <!-- Old Password Field -->
                            <tr>
                                <td><label for="old_password">Old Password</label></td>
                                <td>
                                    <div class="input-wrapper">
                                        <input type="password" id="old_password" name="old_password" required>
                                        <button type="button" class="toggle-btn" onclick="togglePassword('old_password')">Show</button>
                                    </div>
                                    <span class="error"><?php echo $old_password_error; ?></span>
                                </td>
                            </tr>

                            <!-- New Password Field -->
                            <tr>
                                <td><label for="new_password">New Password</label></td>
                                <td>
                                    <div class="input-wrapper">
                                        <input type="password" id="new_password" name="new_password" required>
                                        <button type="button" class="toggle-btn" onclick="togglePassword('new_password')">Show</button>
                                    </div>
                                    <span class="error"><?php echo $new_password_error; ?></span>
                                </td>
                            </tr>

                            <!-- Retype New Password Field -->
                            <tr>
                                <td><label for="retype_password">Retype New Password</label></td>
                                <td>
                                    <div class="input-wrapper">
                                        <input type="password" id="retype_password" name="retype_password" required>
                                        <button type="button" class="toggle-btn" onclick="togglePassword('retype_password')">Show</button>
                                    </div>
                                    <span class="error"><?php echo $retype_password_error; ?></span>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2" style="text-align: center;">
                                    <button type="submit" id="submit-btn">Change Password</button>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            var passwordField = document.getElementById(fieldId);
            var toggleButton = passwordField.nextElementSibling; // the toggle button
            if (passwordField.type === "password") {
                passwordField.type = "text";
                toggleButton.textContent = "Hide"; // Change text to "Hide"
            } else {
                passwordField.type = "password";
                toggleButton.textContent = "Show"; // Change text to "Show"
            }
        }
    </script>
</body>
</html>
