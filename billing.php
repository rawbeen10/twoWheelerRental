<?php
// Include database connection
include('admin/script/db_connect.php');

// Retrieve the rent ID from query parameters
$rent_id = isset($_GET['id']) ? $_GET['id'] : '';

// Default status (for when no status is found)
$status = 'pending';

// Fetch status from the rent table based on the rent ID
if ($rent_id) {
    $query_status = "SELECT status FROM rent WHERE id = ?";
    $stmt = $conn->prepare($query_status);
    $stmt->bind_param("i", $rent_id);
    $stmt->execute();
    $stmt->bind_result($status);
    $stmt->fetch();
    $stmt->close();
}

// Set the label for the status
$status_label = ucfirst($status); // Capitalize first letter

// Now, retrieve the remaining query parameters (for displaying other data)
$full_name = isset($_GET['full_name']) ? $_GET['full_name'] : '';
$phone_number = isset($_GET['phone_number']) ? $_GET['phone_number'] : '';
$email = isset($_GET['email']) ? $_GET['email'] : '';
$vehicle_name = isset($_GET['vehicle_name']) ? $_GET['vehicle_name'] : '';
$vehicle_number = isset($_GET['vehicle_number']) ? $_GET['vehicle_number'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';
$price_per_day = isset($_GET['price_per_day']) ? $_GET['price_per_day'] : '';
$vehicle_image = isset($_GET['vehicle_image']) ? $_GET['vehicle_image'] : '';
$rent_from = isset($_GET['rent_from']) ? $_GET['rent_from'] : '';
$rent_to = isset($_GET['rent_to']) ? $_GET['rent_to'] : '';
$grand_total = isset($_GET['grand_total']) ? $_GET['grand_total'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing Details</title>
    <link rel="stylesheet" href="styles/billing.css">
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/fonts.css">
    <link rel="stylesheet" href="layout/layout.css">
</head>
<body>
<?php require("layout/header.php");?>

<div class="billing-details">
        <h1>Billing Details</h1>
        <div class="flex-container">
            <!-- Table Section for Billing Details -->
            <div class="billing-table">
                <h2>Rental Information</h2>
                <table>
                    <tr>
                        <th>Full Name</th>
                        <td><?php echo htmlspecialchars($full_name); ?></td>
                    </tr>
                    <tr>
                        <th>Phone Number</th>
                        <td><?php echo htmlspecialchars($phone_number); ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?php echo htmlspecialchars($email); ?></td>
                    </tr>
                    <tr>
                        <th>Vehicle Name</th>
                        <td><?php echo htmlspecialchars($vehicle_name); ?></td>
                    </tr>
                    <tr>
                        <th>Vehicle Number</th>
                        <td><?php echo htmlspecialchars($vehicle_number); ?></td>
                    </tr>
                    <tr>
                        <th>Category</th>
                        <td><?php echo htmlspecialchars($category); ?></td>
                    </tr>
                    <tr>
                        <th>Price per Day</th>
                        <td>Rs. <?php echo htmlspecialchars($price_per_day); ?></td>
                    </tr>
                    <tr>
                        <th>Rent From</th>
                        <td><?php echo htmlspecialchars($rent_from); ?></td>
                    </tr>
                    <tr>
                        <th>Rent To</th>
                        <td><?php echo htmlspecialchars($rent_to); ?></td>
                    </tr>
                    <!-- Make Grand Total Row Bold -->
                    <tr class="grand-total">
                        <th>Grand Total</th>
                        <td>Rs. <?php echo htmlspecialchars($grand_total); ?></td>
                    </tr>
                </table>
            </div>

            <!-- Vehicle Image Section -->
            <div class="vehicle-img">
                <h2>Vehicle Image</h2>
                <?php if ($vehicle_image): ?>
                    <img src="admin/uploads/<?php echo htmlspecialchars($vehicle_image); ?>" alt="Vehicle Image" width="400">
                <?php else: ?>
                    <p>No image available.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Status Section below the table -->
        <div class="status">
            <p><strong>Status:</strong> 
                <button class="status-btn <?php echo $status; ?>">
                    <?php echo $status_label; ?>
                </button>
            </p>
        </div>
        <div class="print-section">
    <button onclick="window.print()" class="print-btn">Print</button>
</div><br>

    <?php require("layout/footer.php"); ?>
    <script src="styles/script/index.js"></script>
</body>
</html>
