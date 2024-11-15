<?php
include('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_vehicle'])) {
    // Get POST data
    $vehicle_name = $_POST['vehicle_name'];
    $description = $_POST['description'];
    $price_per_day = $_POST['price']; 
    $category = $_POST['category']; 

  
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
               
                $stmt = mysqli_prepare($conn, "INSERT INTO vehicles (vehicle_name, description, price_per_day, category, image) 
                                               VALUES (?, ?, ?, ?, ?)");

                mysqli_stmt_bind_param($stmt, "ssdsd", $vehicle_name, $description, $price_per_day, $category, $new_image_name);

              
                if (mysqli_stmt_execute($stmt)) {
                    echo "New vehicle added successfully!";
                    header("Location: manage_vehicles.php"); 
                    exit(); 
                } else {
                    echo "Error: " . mysqli_error($conn);
                }

                mysqli_stmt_close($stmt);
            } else {
                echo "Error uploading image.";
            }
        } else {
            echo "Invalid image file type.";
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
</head>
<body>

<div class="main-container">
<div class="container-one">
    <?php 
    include '../Layout/sidebar.html';
    ?>
    <script src="../Layout/sidebar.js"></script>
    </div>
 

    <div class="container-two">
    <h2>Add New Vehicle</h2>
    <form action="add_vehicle.php" method="POST" enctype="multipart/form-data">
        <label for="vehicle_name">Vehicle Name:</label>
        <input type="text" name="vehicle_name" id="vehicle_name" required>

        <label for="description">Description:</label>
        <textarea name="description" id="description" required></textarea>

        <label for="price">Price per Hour:</label>
        <input type="number" name="price" id="price" required>

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





</body>
</html>
