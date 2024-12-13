<?php
include('../script/db_connect.php');

// Fetch cancelled rentals with vehicle details
$query_rent = "
    SELECT rent.*, vehicles.vehicle_name, vehicles.vehicle_number 
    FROM rent 
    JOIN vehicles ON rent.vehicle_id = vehicles.id
    WHERE rent.status = 'cancelled'
";
$result_rent = mysqli_query($conn, $query_rent);

// Handle delete action
if (isset($_GET['delete_id'])) {
    $rent_id = $_GET['delete_id'];
    $delete_query = "DELETE FROM rent WHERE id = ?";
    $stmt_delete = $conn->prepare($delete_query);
    $stmt_delete->bind_param("i", $rent_id);
    if ($stmt_delete->execute()) {
        header("Location: cancelled.php"); // Refresh the page after deletion
        exit;
    } else {
        echo "Error deleting record: " . $stmt_delete->error;
    }
    $stmt_delete->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancelled Rentals</title>
    <link rel="stylesheet" href="../Layout/sidebar.css">
    <link rel="stylesheet" href="styles/manage_rental.css">
    <style>
        .status-btn {
            background-color: red;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            font-weight: bold;
            cursor: default;
        }
        .delete-btn {
            background-color: #f44336;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="container-one">
            <?php include '../Layout/sidebar.html'; ?>
            <script src="../Layout/sidebar.js"></script>
        </div>
        <div class="container container-two">
            <h1>Cancelled Rentals</h1>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Full Name</th>
                        <th>Vehicle Name</th>
                        <th>Vehicle Number</th>
                        <th>Phone Number</th>
                        <th>Email</th>
                        <th>Rent From</th>
                        <th>Rent To</th>
                        <th>Document Type</th>
                        <th>ID Image</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sn = 1; // Serial number
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
                        echo "<td><img src='../uploads/" . htmlspecialchars($row['id_image']) . "' alt='ID Image' class='id-img' width='50'></td>";
                        echo "<td><button class='status-btn'>Cancelled</button></td>";
                        echo "<td><a href='?delete_id=" . $row['id'] . "' onclick='return confirm(\"Are you sure you want to delete this rental?\")'>
                                    <button class='delete-btn'>Delete</button>
                                </a></td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
