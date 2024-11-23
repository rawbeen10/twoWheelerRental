<?php
include('db_connect.php');


$limit = isset($_GET['limit']) ? $_GET['limit'] : 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;


$total_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM vehicles");
$total_row = mysqli_fetch_assoc($total_result);
$total_pages = ceil($total_row['total'] / $limit);


$query = "SELECT * FROM vehicles LIMIT $start, $limit";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Vehicles</title>
    <link rel="stylesheet" href="../Layout/sidebar.css">
    <link rel="stylesheet" href="styles/view_vehicle.css">
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
        <h2>View Vehicles</h2>

        <div class="show-entries">
            Show 
            <form action="view_vehicle.php" method="GET" style="display:inline;">
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
                    <th>Vehicle Name</th>
                    <th>Vehicle Number</th> 
                    <th>Description</th>
                    <th>Price per Day</th>
                    <th>Category</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sn = $start + 1; 
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $sn++ . "</td>";
                    echo "<td>" . htmlspecialchars($row['vehicle_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['vehicle_number']) . "</td>"; 
                    echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['price_per_day']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['category']) . "</td>";
                    echo "<td><img src='../uploads/" . htmlspecialchars($row['image']) . "' alt='" . htmlspecialchars($row['vehicle_name']) . "' class='bike-img' width='50'></td>";
                    echo "<td class='action-buttons'>
                              <a href='edit_vehicle.php?id=" . $row['id'] . "' class='edit-btn'>Edit</a> 
                              <a href='delete_vehicle.php?id=" . $row['id'] . "' class='delete-btn'>Delete</a>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <div class="pagination">
            <?php
    
            for ($i = 1; $i <= $total_pages; $i++) {
                $is_active = ($page == $i) ? 'class="active"' : '';
                echo "<a href='view_vehicle.php?page=$i&limit=$limit' $is_active>$i</a>";
            }
            ?>
        </div>
    </div>
</div>

</body>
</html>
