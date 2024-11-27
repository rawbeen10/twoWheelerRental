<?php
session_start();
include('db_connect.php');

if (isset($_GET['id'])) {
    $vehicle_id = $_GET['id'];

    $query = "SELECT * FROM vehicles WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $vehicle_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $vehicle_name = $row['vehicle_name'];
        $vehicle_number = $row['vehicle_number'];
        $description = $row['description'];
        $price_per_day = $row['price_per_day'];
        $category = $row['category'];
        $image = $row['image'];
    } else {
        $_SESSION['error_message'] = "Vehicle not found.";
        header("Location: view_vehicle.php");
        exit();
    }
    mysqli_stmt_close($stmt);
} else {
    $_SESSION['error_message'] = "Invalid vehicle ID.";
    header("Location: view_vehicle.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_vehicle'])) {
    $vehicle_name = $_POST['vehicle_name'];
    $vehicle_number = $_POST['vehicle_no'];
    $description = $_POST['description'];
    $price_per_day = $_POST['price'];
    $category = $_POST['category'];

    if (isset($_FILES['vehicle_image']) && $_FILES['vehicle_image']['error'] === 0) {
        $image_name = $_FILES['vehicle_image']['name'];
        $image_tmp_name = $_FILES['vehicle_image']['tmp_name'];
        $image_extension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($image_extension, $allowed_extensions)) {
            $upload_dir = __DIR__ . '/../uploads/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $new_image_name = time() . '_' . uniqid() . '.' . $image_extension;
            $upload_path = $upload_dir . $new_image_name;

            if (move_uploaded_file($image_tmp_name, $upload_path)) {
                $old_image_path = $upload_dir . $image;
                if (file_exists($old_image_path)) {
                    unlink($old_image_path); 
                }
                $image = $new_image_name;
            } else {
                $_SESSION['error_message'] = "Error uploading image.";
                header("Location: edit_vehicle.php?id=$vehicle_id");
                exit();
            }
        } else {
            $_SESSION['error_message'] = "Invalid image file type. Allowed: JPG, JPEG, PNG, GIF.";
            header("Location: edit_vehicle.php?id=$vehicle_id");
            exit();
        }
    }

    $query = "UPDATE vehicles SET vehicle_name = ?, vehicle_number = ?, description = ?, price_per_day = ?, category = ?, image = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sssdssi", $vehicle_name, $vehicle_number, $description, $price_per_day, $category, $image, $vehicle_id);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success_message'] = "Vehicle updated successfully!";
        header("Location: view_vehicle.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Error updating vehicle: " . mysqli_error($conn);
        header("Location: edit_vehicle.php?id=$vehicle_id");
        exit();
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
    <script>
        function showPopup(message) {
            const popup = document.getElementById("popup");
            const popupMessage = document.getElementById("popupMessage");
            popupMessage.textContent = message;
            popup.style.display = "block";

            setTimeout(() => {
                popup.style.display = "none";
            }, 3000);
        }
    </script>
</head>
<body>
<div id="popup" style="display: none; position: fixed; top: 20%; left: 50%; transform: translate(-50%, -50%); background: #4CAF50; color: white; padding: 20px; border-radius: 5px; z-index: 1000;">
    <span id="popupMessage"></span>
</div>

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

            <label for="vehicle_no">Vehicle Number:</label>
            <input type="text" name="vehicle_no" id="vehicle_no" value="<?php echo htmlspecialchars($vehicle_number); ?>" required>

            <label for="description">Description:</label>
            <textarea name="description" id="description" required><?php echo htmlspecialchars($description); ?></textarea>
            
            <label for="price">Price per Day:</label>
            <input type="number" step="0.01" name="price" id="price" value="<?php echo htmlspecialchars($price_per_day); ?>" required>

            <label for="category">Category:</label>
            <select name="category" id="category" required>
                <option value="bike" <?php echo ($category === 'bike') ? 'selected' : ''; ?>>Bike</option>
                <option value="scooter" <?php echo ($category === 'scooter') ? 'selected' : ''; ?>>Scooter</option>
            </select>

            <label for="vehicle_image">Vehicle Image (optional):</label>
            <input type="file" name="vehicle_image" id="vehicle_image">

            <button type="submit" name="update_vehicle">Update Vehicle</button>
        </form>
    </div>
</div>

<?php
if (isset($_SESSION['success_message'])) {
    echo "<script>showPopup('" . $_SESSION['success_message'] . "');</script>";
    unset($_SESSION['success_message']);
}
if (isset($_SESSION['error_message'])) {
    echo "<script>showPopup('" . $_SESSION['error_message'] . "');</script>";
    unset($_SESSION['error_message']);
}
?>
</body>
</html>
