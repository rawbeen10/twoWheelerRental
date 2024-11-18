<?php
session_start();

// Include the database connection file
include('admin/script/db_connect.php');

// Check if user is logged in, if not redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Initialize variables
$user_id = $_SESSION['user_id'];
$username = $email = $dob = $gender = $bio = $profile_image = "";

// Fetch the user's current profile details from the database
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $username = $user['username'];
    $email = $user['email']; // Email cannot be changed
    $dob = $user['dob'];
    $gender = $user['gender']; // Gender is editable anytime
    $bio = $user['bio'];
    $profile_image = $user['profile_image']; // Profile image path
} else {
    echo "User profile not found.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the updated values from the form
    $updated_username = $_POST['username'];
    $updated_dob = $_POST['dob'];
    $updated_bio = $_POST['bio'];
    $updated_gender = $_POST['gender'];
    $updated_profile_image = $profile_image; // Default to current profile image

    // Handle profile image upload
    if (isset($_FILES['profile_image']['name']) && $_FILES['profile_image']['name'] != "") {
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        $image_extension = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
        $upload_dir = __DIR__ . '/admin/uploads/'; // Directory for uploads

        // Ensure the upload directory exists
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true); // Create the directory if it doesn't exist
        }

        if (in_array(strtolower($image_extension), $allowed_extensions)) {
            $new_file_name = time() . "_" . basename($_FILES['profile_image']['name']);
            $target_file = $upload_dir . $new_file_name;

            // Move uploaded file to the server
            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file)) {
                $updated_profile_image = 'admin/uploads/' . $new_file_name; // Save relative path to database
            } else {
                echo "Error uploading file.";
                exit();
            }
        } else {
            echo "Invalid file type. Allowed types: " . implode(', ', $allowed_extensions);
            exit();
        }
    }

    // Update the profile details in the database
    $update_query = "UPDATE users SET username = ?, dob = ?, bio = ?, gender = ?, profile_image = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("sssssi", $updated_username, $updated_dob, $updated_bio, $updated_gender, $updated_profile_image, $user_id);

    if ($update_stmt->execute()) {
        // Successfully updated profile
        header("Location: profile.php"); // Redirect to the profile page after update
        exit();
    } else {
        echo "Error updating profile: " . $conn->error;
    }

    $update_stmt->close();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="styles/edit_profile.css"> <!-- External CSS file -->
</head>
<body>
    <div class="profile-container">
        <h2>Edit Profile</h2>
        <form action="edit_profile.php" method="POST" enctype="multipart/form-data">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>

            <label for="dob">Date of Birth:</label>
            <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($dob); ?>" required>

            <label for="bio">Bio:</label>
            <textarea id="bio" name="bio"><?php echo htmlspecialchars($bio); ?></textarea>

            <label for="profile_image">Profile Image:</label>
            <input type="file" id="profile_image" name="profile_image">

            <label for="gender">Gender:</label>
            <select id="gender" name="gender">
                <option value="Male" <?php echo $gender == "Male" ? 'selected' : ''; ?>>Male</option>
                <option value="Female" <?php echo $gender == "Female" ? 'selected' : ''; ?>>Female</option>
                <option value="Other" <?php echo $gender == "Other" ? 'selected' : ''; ?>>Other</option>
            </select>

            <button type="submit">Save Changes</button>
        </form>

        <div class="profile-info">
            <h3>Current Profile Picture:</h3>
            <?php if ($profile_image): ?>
                <img src="<?php echo $profile_image; ?>" alt="Profile Image" class="profile-image" width="100">
            <?php else: ?>
                <p>No profile picture set.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
