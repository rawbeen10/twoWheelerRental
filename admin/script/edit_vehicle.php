<?php

include('db_connect.php');

if (isset($_GET['id'])) {
    $vehicle_id = $_GET['id'];

    // Fetch existing vehicle data from the database
    $query = "SELECT * FROM vehicles WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $vehicle_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $vehicle_name = $row['vehicle_name'];
        $vehicle_number = $row['vehicle_number']; // Fetch vehicle_number
        $description = $row['description'];
        $price_per_day = $row['price_per_day'];
        $category = $row['category'];
        $image = $row['image'];
    } else {
        echo "Vehicle not found.";
        exit();
    }

    mysqli_stmt_close($stmt);
} else {
    echo "Invalid vehicle ID.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_vehicle'])) {
    $vehicle_name = $_POST['vehicle_name'];
    $vehicle_number = $_POST['vehicle_number']; // Add vehicle_number
    $description = $_POST['description'];
    $price_per_day = $_POST['price_per_day'];
    $category = $_POST['category']; // Ensure category is captured

    // Handle image upload if there's a new image
    if (isset($_FILES['vehicle_image']) && $_FILES['vehicle_image']['error'] === 0) {
        $image_name = $_FILES['vehicle_image']['name'];
        $image_tmp_name = $_FILES['vehicle_image']['tmp_name'];
        $image_size = $_FILES['vehicle_image']['size'];
        $image_type = $_FILES['vehicle_image']['type'];

        $allowed_extensions = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($image_type, $allowed_extensions)) {
            $upload_dir = __DIR__ . '/../uploads/';
            $new_image_name = time() . '_' . $image_name;
            $upload_path = $upload_dir . $new_image_name;

            if (move_uploaded_file($image_tmp_name, $upload_path)) {
                $old_image_path = __DIR__ . '/../uploads/' . $image;
                if (file_exists($old_image_path)) {
                    unlink($old_image_path);
                }
            } else {
                echo "Error uploading the new image.";
                exit();
            }
        } else {
            echo "Invalid image file type.";
            exit();
        }
    } else {
        $new_image_name = $image; // Use the existing image if no new one is uploaded
    }

    // Update vehicle details in the database
    $query = "UPDATE vehicles SET vehicle_name = ?, vehicle_number = ?, description = ?, price_per_day = ?, category = ?, image = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssssisi", $vehicle_name, $vehicle_number, $description, $price_per_day, $category, $new_image_name, $vehicle_id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: view_vehicle.php"); // Redirect to vehicle list after update
        exit();
    } else {
        echo "Error updating vehicle: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Vehicle</title>
    <link rel="stylesheet" href="styles/add_vehicle.css">
    <link rel="stylesheet" href="../Layout/sidebar.css">
</head>
<body>

<div class="main-container">
    <div class="container-one">
        <?php include '../Layout/sidebar.html'; ?>
        <script src="../Layout/sidebar.js"></script>
    </div>

    <div class="container-two">
        <h2>Edit Vehicle</h2>
        <form action="edit_vehicle.php?id=<?php echo $vehicle_id; ?>" method="POST" enctype="multipart/form-data">
            <label for="vehicle_name">Vehicle Name:</label>
            <input type="text" name="vehicle_name" id="vehicle_name" value="<?php echo htmlspecialchars($vehicle_name); ?>" required>

            <label for="vehicle_number">Vehicle Number:</label>
            <input type="text" name="vehicle_number" id="vehicle_number" value="<?php echo htmlspecialchars($vehicle_number); ?>" required>

            <label for="description">Description:</label>
            <textarea name="description" id="description" required><?php echo htmlspecialchars($description); ?></textarea>

            <label for="price_per_day">Price per Day:</label>
            <input type="number" name="price_per_day" id="price_per_day" value="<?php echo htmlspecialchars($price_per_day); ?>" required>

            <label for="category">Category:</label>
            <select name="category" id="category" required>
                <option value="bike" <?php echo ($category === 'bike') ? 'selected' : ''; ?>>Bike</option>
                <option value="scooter" <?php echo ($category === 'scooter') ? 'selected' : ''; ?>>Scooter</option>
            </select><br><br>

            <label for="vehicle_image">Vehicle Image (optional):</label>
            <input type="file" name="vehicle_image" id="vehicle_image">

            <button type="submit" name="update_vehicle">Update Vehicle</button>
        </form>
    </div>
</div>

</body>
</html>
