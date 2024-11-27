<?php
session_start(); 

include('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_vehicle'])) {
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
                $stmt = mysqli_prepare($conn, "INSERT INTO vehicles (vehicle_name, vehicle_number, description, price_per_day, category, image) 
                                               VALUES (?, ?, ?, ?, ?, ?)");
                if ($stmt) {
                    mysqli_stmt_bind_param($stmt, "sssdss", $vehicle_name, $vehicle_number, $description, $price_per_day, $category, $new_image_name);

                    if (mysqli_stmt_execute($stmt)) {
                        $_SESSION['success_message'] = "Vehicle has been added successfully!";
                        header("Location: add_vehicle.php");
                        exit();
                    } else {
                        echo "Error inserting data: " . mysqli_error($conn);
                    }

                    mysqli_stmt_close($stmt);
                } else {
                    echo "Error preparing statement: " . mysqli_error($conn);
                }
            } else {
                echo "Error uploading image.";
            }
        } else {
            echo "Invalid image file type. Allowed types: JPG, JPEG, PNG, GIF.";
        }
    } else {
        echo "Error: No image selected or file error.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Vehicle</title>
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
        <h2>Add New Vehicle</h2>
        <form action="add_vehicle.php" method="POST" enctype="multipart/form-data">
            <label for="vehicle_name">Vehicle Name:</label>
            <input type="text" name="vehicle_name" id="vehicle_name" required>

            <label for="vehicle_no">Vehicle Number:</label>
            <input type="text" name="vehicle_no" id="vehicle_no" required>

            <label for="description">Description:</label>
            <textarea name="description" id="description" required></textarea>
            
            <label for="price">Price per Day:</label>
            <input type="number" step="0.01" name="price" id="price" required>

            <label for="category">Category:</label>
            <select name="category" id="category" required>
                <option value="bike">Bike</option>
                <option value="scooter">Scooter</option>
            </select>

            <label for="vehicle_image">Vehicle Image:</label>
            <input type="file" name="vehicle_image" id="vehicle_image" required>

            <button type="submit" name="add_vehicle">Add Vehicle</button>
        </form>
    </div>
</div>

<?php
if (isset($_SESSION['success_message'])) {
    echo "<script>showPopup('" . $_SESSION['success_message'] . "');</script>";
    unset($_SESSION['success_message']); 
}
?>
</body>
</html>
