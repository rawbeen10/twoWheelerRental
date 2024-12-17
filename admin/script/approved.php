<?php
include('../script/db_connect.php');

// Entries per page (default to 10 if not set)
$entries_per_page = isset($_GET['entries']) ? intval($_GET['entries']) : 10;

// Current page number (default to 1 if not set)
$current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;

// Calculate OFFSET
$offset = ($current_page - 1) * $entries_per_page;

// Total records count query
$total_query = "SELECT COUNT(*) AS total FROM rent WHERE status = 'approved'";
$total_result = mysqli_query($conn, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_entries = $total_row['total'];
$total_pages = ceil($total_entries / $entries_per_page);

// Fetch approved rentals with vehicle details
$query_rent = "
    SELECT rent.*, vehicles.vehicle_name, vehicles.vehicle_number 
    FROM rent 
    JOIN vehicles ON rent.vehicle_id = vehicles.id
    WHERE rent.status = 'approved'
    LIMIT $entries_per_page OFFSET $offset
";
$result_rent = mysqli_query($conn, $query_rent);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approved Rentals</title>
    <link rel="stylesheet" href="styles/manage_rental.css">
    <link rel="stylesheet" href="../Layout/sidebar.css"> <!-- Sidebar CSS -->
</head>
<body>

<div class="main-container">
    <div class="container-one">
        <?php include '../Layout/sidebar.html'; ?>
        <script src="../Layout/sidebar.js"></script>
    </div>


    <div class=" container container-two">
        <h2>Approved Rentals</h2>
    <div class="show-entries">
     <form method="GET" action="approved.php" id="entries">
        <label for="entries">Show Entries:</label>
        <select name="entries" id="entries" onchange="this.form.submit()">
            <option value="5" <?php if ($entries_per_page == 5) echo "selected"; ?>>5</option>
            <option value="10" <?php if ($entries_per_page == 10) echo "selected"; ?>>10</option>
            <option value="20" <?php if ($entries_per_page == 20) echo "selected"; ?>>20</option>
        </select>
    </form>
     </div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Full Name</th>
                <th>Vehicle Name</th>
                <th>Vehicle Number</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Rent From</th>
                <th>Rent To</th>
                <th>Document</th>
                <th>ID Image</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sn = $offset + 1; // Serial Number starts with OFFSET
            while ($row = mysqli_fetch_assoc($result_rent)) {
                echo "<tr>";
                echo "<td>" . $sn++ . "</td>";
                echo "<td>" . htmlspecialchars($row['full_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['vehicle_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['vehicle_number']) . "</td>";
                echo "<td>" . htmlspecialchars($row['phone_number']) . "</td>";
                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                echo "<td>" . htmlspecialchars($row['rent_from']) . "</td>";
                echo "<td>" . htmlspecialchars($row['rent_to']) . "</td>";
                echo "<td>" . htmlspecialchars($row['document_type']) . "</td>";
                echo "<td><img src='../uploads/" . htmlspecialchars($row['id_image']) . "' width='50' height='50'></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    <!-- Pagination -->
    <div class="pagination">
        <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
            <a href="?page=<?= $i ?>&entries=<?= $entries_per_page ?>" 
                class="<?= $i == $current_page ? 'active' : '' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>
    </div>
    </div>



</div>

</body>
</html>
