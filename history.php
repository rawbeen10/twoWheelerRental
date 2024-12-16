<?php
include('admin/script/db_connect.php');

// Start session if not already started
session_start();

// Ensure user is logged in, otherwise redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Pagination logic
$records_per_page = 10;

// Get total records for the logged-in user
$total_query = "SELECT COUNT(*) AS total_records FROM rent WHERE user_id = ?";
$total_stmt = $conn->prepare($total_query);
$total_stmt->bind_param("i", $_SESSION['user_id']); // Filter by logged-in user
$total_stmt->execute();
$total_result = $total_stmt->get_result();
$total_row = $total_result->fetch_assoc();
$total_records = $total_row['total_records'];

$total_pages = ceil($total_records / $records_per_page);

// Get the current page or default to page 1
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start_from = ($current_page - 1) * $records_per_page;

// Query for rental history of the logged-in user
$query = "SELECT rent.id AS rent_id, rent.full_name, rent.phone_number, rent.email, rent.rent_from, rent.rent_to, rent.document_type, rent.id_image, rent.status, 
                 vehicles.vehicle_name, vehicles.vehicle_number, vehicles.category, vehicles.price_per_day, vehicles.image AS vehicle_image
          FROM rent
          INNER JOIN vehicles ON rent.vehicle_id = vehicles.id
          WHERE rent.user_id = ? 
          ORDER BY rent.id DESC
          LIMIT ?, ?";  // Use placeholders for pagination parameters

$stmt = $conn->prepare($query);
$stmt->bind_param("iii", $_SESSION['user_id'], $start_from, $records_per_page); // Bind parameters
$stmt->execute();
$result = $stmt->get_result();

// Check if there are any results
if ($result->num_rows === 0) {
    $no_history_message = "No History Found";
} else {
    $no_history_message = "";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental History</title>
    <link rel="stylesheet" href="styles/history.css">
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/fonts.css">
    <link rel="stylesheet" href="layout/layout.css">
</head>
<body>
<?php require("layout/header.php");?>
    <h1 id="rental-history">Rental History</h1>
    
    <div class="history-container">
        <?php if ($no_history_message) { ?>
            <p><?php echo $no_history_message; ?></p>
        <?php } else { ?>
            <?php while ($row = $result->fetch_assoc()) { 
                // Format rent dates
                $rent_from = new DateTime($row['rent_from']);
                $rent_to = new DateTime($row['rent_to']);
                $formatted_rent_from = $rent_from->format('d M Y');
                $formatted_rent_to = $rent_to->format('d M Y');
            ?>
                <!-- History Bar -->
                <div class="history-item">
                    <a href="billing.php?id=<?php echo $row['rent_id']; ?>&full_name=<?php echo urlencode($row['full_name']); ?>&phone_number=<?php echo urlencode($row['phone_number']); ?>&email=<?php echo urlencode($row['email']); ?>&vehicle_name=<?php echo urlencode($row['vehicle_name']); ?>&vehicle_number=<?php echo urlencode($row['vehicle_number']); ?>&category=<?php echo urlencode($row['category']); ?>&price_per_day=<?php echo urlencode($row['price_per_day']); ?>&vehicle_image=<?php echo urlencode($row['vehicle_image']); ?>&rent_from=<?php echo urlencode($formatted_rent_from); ?>&rent_to=<?php echo urlencode($formatted_rent_to); ?>&grand_total=<?php echo urlencode($row['price_per_day'] * $rent_from->diff($rent_to)->days); ?>" class="history-link">
                        <div class="history-thumbnail">
                            <?php if ($row['vehicle_image']) { ?>
                                <img src="admin/uploads/<?php echo htmlspecialchars($row['vehicle_image']); ?>" alt="Vehicle Image" class="vehicle-img-thumbnail">
                            <?php } else { ?>
                                <p>No image available</p>
                            <?php } ?>
                        </div>
                        <div class="history-details">
                            <p><strong><?php echo htmlspecialchars($row['vehicle_name']); ?></strong></p>
                            <p class="submission-date">Submitted on: <?php echo $formatted_rent_from; ?></p>
                        </div>
                    </a>
                </div>
            <?php } ?>
        <?php } ?>
    </div>

    <!-- Pagination -->
    <div class="pagination">
        <?php for ($page = 1; $page <= $total_pages; $page++) { ?>
            <a href="history.php?page=<?php echo $page; ?>" class="pagination-link <?php echo $page == $current_page ? 'active' : ''; ?>"><?php echo $page; ?></a>
        <?php } ?>
    </div>

    <?php require("layout/footer.php"); ?>
    
    <script src="styles/script/index.js"></script>
</body>
</html>
