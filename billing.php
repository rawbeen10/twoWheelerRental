<?php
// Retrieve query parameters
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
</head>
<body>
    <h1>Billing Details</h1>
    <div class="billing-details">
        <h2>Rental Information</h2>
        <p><strong>Full Name:</strong> <?php echo htmlspecialchars($full_name); ?></p>
        <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($phone_number); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
        <p><strong>Vehicle Name:</strong> <?php echo htmlspecialchars($vehicle_name); ?></p>
        <p><strong>Vehicle Number:</strong> <?php echo htmlspecialchars($vehicle_number); ?></p>
        <p><strong>Category:</strong> <?php echo htmlspecialchars($category); ?></p>
        <p><strong>Price per Day:</strong> Rs. <?php echo htmlspecialchars($price_per_day); ?></p>
        <p><strong>Rent From:</strong> <?php echo htmlspecialchars($rent_from); ?></p>
        <p><strong>Rent To:</strong> <?php echo htmlspecialchars($rent_to); ?></p>
        
        <h2>Vehicle Image</h2>
        <?php if ($vehicle_image): ?>
            <img src="admin/uploads/<?php echo htmlspecialchars($vehicle_image); ?>" alt="Vehicle Image" width="200">
        <?php else: ?>
            <p>No image available.</p>
        <?php endif; ?>

        <p><strong>Grand Total:</strong> Rs. <?php echo htmlspecialchars($grand_total); ?></p>
    </div>
</body>
</html>
