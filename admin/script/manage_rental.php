<?php
include('../script/db_connect.php');


$limit = 10;  
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;  
$start = ($page - 1) * $limit;  


$query_rent = "SELECT * FROM rent LIMIT $start, $limit";
$result_rent = mysqli_query($conn, $query_rent);


$vehicle_data = [];
$query_vehicle = "SELECT id, vehicle_name, vehicle_number FROM vehicles";
$result_vehicle = mysqli_query($conn, $query_vehicle);


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

<div class="container">
    <h1>Manage Rentals</h1>
    
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Full Name</th>
                <th>Vehicle Name</th>
                <th>Vehicle Number</th>
                <th>Phone Number</th>
                <th>Email</th>
                <th>Rent From</th> <!-- Updated -->
                <th>Rent To</th> <!-- Updated -->
                <th>Document Type</th>
                <th>ID Image</th>
                <th>Actions</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sn = $start + 1; 
            while ($row_rent = mysqli_fetch_assoc($result_rent)) {
                // Fetch vehicle name, number, and category using rent.id
                $vehicle_id = $row_rent['id']; // Use the rent id to fetch vehicle data
                $vehicle_name = 'N/A';
                $vehicle_number = 'N/A';
                $category = 'N/A';
                
                // Fetch the vehicle details using the rent id
                if (isset($vehicle_data[$vehicle_id])) {
                    $vehicle_name = $vehicle_data[$vehicle_id]['vehicle_name'];
                    $vehicle_number = $vehicle_data[$vehicle_id]['vehicle_number'];
                    $category = $vehicle_data[$vehicle_id];
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
                echo "<td>" . htmlspecialchars($row_rent['rent_from']) . "</td>"; 
                echo "<td>" . htmlspecialchars($row_rent['rent_to']) . "</td>";  
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

    <!-- Pagination -->
    <div class="pagination">
        <?php
        // Get total number of rentals
        $query_total_rent = "SELECT COUNT(*) as total FROM rent";
        $result_total_rent = mysqli_query($conn, $query_total_rent);
        $row_total_rent = mysqli_fetch_assoc($result_total_rent);
        $total_records = $row_total_rent['total'];
        $total_pages = ceil($total_records / $limit);

        // Display pagination links
        for ($i = 1; $i <= $total_pages; $i++) {
            echo "<a href='manage_rental.php?page=$i'>$i</a> ";
        }
        ?>
    </div>
</div>

</body>
</html>
