<?php
include('db_connect.php');

$query = "SELECT * FROM approved_rentals";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    echo "<h2>Approved Rentals</h2>";
    echo "<table>";
    echo "<tr><th>Vehicle Name</th><th>Rent Date</th><th>Status</th></tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['vehicle_name'] . "</td>";
        echo "<td>" . $row['rent_date'] . "</td>";
        echo "<td>" . $row['status'] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<p>No approved rentals found.</p>";
}
?>
