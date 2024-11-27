<?php
session_start(); 

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include('admin/script/db_connect.php'); 

$user_id = $_SESSION['user_id']; 

$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "No profile found.";
    exit();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="styles/profile.css">
    <link rel="stylesheet" href="styles/fonts.css">
    <link rel="stylesheet" href="layout/layout.css">
</head>
<body>
<?php
    require("layout/header.php");
    ?>
    <div class="profile-container">
        <div class="profile-card">
            <div class="profile-header">
                <h1>Welcome, <?php echo htmlspecialchars($user['username']); ?>!</h1>
                <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
            </div>

            <div class="profile-details">
                <div class="profile-image">
                    <img src="<?php echo !empty($user['profile_image']) && file_exists($user['profile_image']) ? htmlspecialchars($user['profile_image']) : 'admin/uploads/default.png'; ?>" 
                         alt="Profile Image">
                </div>
                <div class="profile-info">
                    <p><strong>Gender:</strong> <?php echo !empty($user['gender']) ? htmlspecialchars($user['gender']) : "Not set"; ?></p>
                    <p><strong>Date of Birth:</strong> <?php echo !empty($user['dob']) ? htmlspecialchars($user['dob']) : "Not set"; ?></p>
                    <p><strong>Bio:</strong> <?php echo !empty($user['bio']) ? htmlspecialchars($user['bio']) : "Not set"; ?></p>
                </div>
            </div>

            <a href="edit_profile.php" class="edit-btn">Edit Profile</a>
        </div>
    </div>
    <?php
    require("layout/footer.php");
    ?>
</body>
</html>
