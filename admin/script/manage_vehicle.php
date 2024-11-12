<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Vehicles</title>
    <link rel="stylesheet" href="../styles/manage_vehicles.css">
</head>
<body>

    <section id="manage-vehicles">
        <h2>Manage Vehicles</h2>
        
        <!-- Buttons -->
        <button id="addVehicleBtn">Add Vehicle</button>
        <a href="view_vehicles.php"><button id="viewVehiclesBtn">View Vehicles</button></a>

        <!-- Add Vehicle Popup Form -->
        <div class="popup-container" id="addVehiclePopup">
            <div class="form-container">
                <!-- Cross Button to Close Popup -->
                <button id="closePopupBtn" class="close-btn">&times;</button>

                <h2>Add New Vehicle</h2>
                <form action="add_vehicle.php" method="POST" enctype="multipart/form-data">
                    <label for="vehicle_name">Vehicle Name:</label>
                    <input type="text" name="vehicle_name" id="vehicle_name" required>

                    <label for="description">Description:</label>
                    <textarea name="description" id="description" required></textarea>

                    <label for="price">Price per Hour:</label>
                    <input type="number" name="price" id="price" required>

                    <label for="category">Category:</label>
                    <select name="category" id="category">
                        <option value="bike">Bike</option>
                        <option value="scooter">Scooter</option>
                    </select><br><br>

                    <label for="vehicle_image">Vehicle Image:</label>
                    <input type="file" name="vehicle_image" id="vehicle_image" required>

                    <button type="submit" name="add_vehicle">Add Vehicle</button>
                </form>
            </div>
        </div>
    </section>

    <script>
        const popup = document.getElementById('addVehiclePopup');
        const closeBtn = document.getElementById('closePopupBtn');

        function showPopup() {
            popup.style.display = 'flex';
        }

        closeBtn.addEventListener('click', function() {
            popup.style.display = 'none';
        });

        const addVehicleBtn = document.getElementById('addVehicleBtn'); 
        if (addVehicleBtn) {
            addVehicleBtn.addEventListener('click', function() {
                showPopup();
            });
        }
    </script>
</body>
</html>
