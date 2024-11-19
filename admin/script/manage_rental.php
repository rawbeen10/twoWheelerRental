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

// Fetch rental data from the database
$query = "SELECT * FROM rent LIMIT $start, $limit";
$result = mysqli_query($conn, $query);
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
                while ($row = mysqli_fetch_assoc($result)) {
                   
                    $status = isset($row['status']) ? htmlspecialchars($row['status']) : 'pending';
                    $status_label = ($status == 'approved') ? 'Approved' : 'Pending';
                    echo "<tr>";
                    echo "<td>" . $sn++ . "</td>";
                    echo "<td>" . htmlspecialchars($row['full_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['phone_number']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['rent_time_from']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['rent_time_to']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['document_type']) . "</td>";
                    echo "<td><img src='../uploads/" . htmlspecialchars($row['id_image']) . "' alt='ID Image' class='id-img' width='50'></td>"; // Fetch and display id_image
                    echo "<td class='action-buttons'>
                              <a href='approve_rent.php?id=" . $row['id'] . "' class='approve-btn'>Approve</a> | 
                              <a href='cancel_rent.php?id=" . $row['id'] . "' class='cancel-btn'>Cancel</a>
                          </td>";
                    echo "<td><button class='status-btn $status'>$status_label</button></td>"; // Status column with dynamic label
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
