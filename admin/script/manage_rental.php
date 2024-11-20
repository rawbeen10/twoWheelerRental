<?php
include('db_connect.php');

// Pagination variables
$limit = isset($_GET['limit']) ? $_GET['limit'] : 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Count total rows in the rent table
$total_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM rent");
$total_row = mysqli_fetch_assoc($total_result);
$total_pages = ceil($total_row['total'] / $limit);

// Fetch rental data from the rent table
$query_rent = "SELECT * FROM rent LIMIT $start, $limit";
$result_rent = mysqli_query($conn, $query_rent);

// Fetch vehicle data (this will be done for each rent entry)
$vehicle_data = [];
$query_vehicle = "SELECT id, vehicle_name, vehicle_number FROM vehicles";
$result_vehicle = mysqli_query($conn, $query_vehicle);

// Store vehicle data in an array, indexed by the vehicle_id
while ($row_vehicle = mysqli_fetch_assoc($result_vehicle)) {
    $vehicle_data[$row_vehicle['id']] = $row_vehicle;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Rentals</title>
    <link rel="stylesheet" href="styles/manage_rental.css">
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
        <h2>Manage Rentals</h2>

        <div class="show-entries">
            Show 
            <form action="manage_rentals.php" method="GET" style="display:inline;">
                <select name="limit" onchange="this.form.submit()">
                    <option value="10" <?php echo $limit == 10 ? 'selected' : ''; ?>>10</option>
                    <option value="20" <?php echo $limit == 20 ? 'selected' : ''; ?>>20</option>
                    <option value="30" <?php echo $limit == 30 ? 'selected' : ''; ?>>30</option>
                    <option value="40" <?php echo $limit == 40 ? 'selected' : ''; ?>>40</option>
                    <option value="50" <?php echo $limit == 50 ? 'selected' : ''; ?>>50</option>
                </select> entries
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>SN</th>
                    <th>Full Name</th>
                    <th>Vehicle Name</th>
                    <th>Vehicle Number</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                    <th>Rent From</th>
                    <th>Rent To</th>
                    <th>Document Type</th>
                    <th>Image</th>
                    <th>Actions</th>
                    <th>Status</th> 
                </tr>
            </thead>
            <tbody>
                <?php
                $sn = $start + 1; 
                while ($row_rent = mysqli_fetch_assoc($result_rent)) {
                    // Check if vehicle_id exists in the current rent row
                    $vehicle_id = isset($row_rent['vehicle_id']) ? $row_rent['vehicle_id'] : null;

                    // Debugging: Print the vehicle_id for each rent entry
                    echo "<!-- Debugging: Vehicle ID: " . $vehicle_id . " -->";

                    // Fetch vehicle name and number, or set as 'N/A' if not found
                    $vehicle_name = 'N/A';
                    $vehicle_number = 'N/A';
                    if ($vehicle_id && isset($vehicle_data[$vehicle_id])) {
                        $vehicle_name = $vehicle_data[$vehicle_id]['vehicle_name'];
                        $vehicle_number = $vehicle_data[$vehicle_id]['vehicle_number'];
                    }

                    $status = isset($row_rent['status']) ? htmlspecialchars($row_rent['status']) : 'pending';
                    $status_label = ($status == 'approved') ? 'Approved' : 'Pending';
                    echo "<tr>";
                    echo "<td>" . $sn++ . "</td>";
                    echo "<td>" . htmlspecialchars($row_rent['full_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($vehicle_name) . "</td>"; 
                    echo "<td>" . htmlspecialchars($vehicle_number) . "</td>";  
                    echo "<td>" . htmlspecialchars($row_rent['phone_number']) . "</td>";
                    echo "<td>" . htmlspecialchars($row_rent['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row_rent['rent_time_from']) . "</td>";
                    echo "<td>" . htmlspecialchars($row_rent['rent_time_to']) . "</td>";
                    echo "<td>" . htmlspecialchars($row_rent['document_type']) . "</td>";
                    echo "<td><img src='../uploads/" . htmlspecialchars($row_rent['id_image']) . "' alt='ID Image' class='id-img' width='50'></td>";
                    echo "<td class='action-buttons'>
                             <a href='approve_rent.php?id=" . $row_rent['id'] . "' class='approve-btn'>Approve</a> | 
                             <a href='cancel_rent.php?id=" . $row_rent['id'] . "' class='cancel-btn'>Cancel</a>
                         </td>";
                    echo "<td><button class='status-btn $status'>$status_label</button></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <div class="pagination">
            <?php
            // Display pagination links
            for ($i = 1; $i <= $total_pages; $i++) {
                echo "<a href='manage_rentals.php?page=$i&limit=$limit' class='pagination-link'>$i</a>";
            }
            ?>
        </div>
    </div>
</div>

</body>
</html>
