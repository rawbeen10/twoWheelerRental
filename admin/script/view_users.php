<?php
include('db_connect.php'); 

// Set the limit and page values
$limit = isset($_GET['limit']) ? $_GET['limit'] : 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Get total number of users for pagination
$total_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM users");
$total_row = mysqli_fetch_assoc($total_result);
$total_pages = ceil($total_row['total'] / $limit);

// Fetch users for current page with the limit
$query = "SELECT * FROM users LIMIT $start, $limit";
$result = mysqli_query($conn, $query);

// Handling delete action
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_query = "DELETE FROM users WHERE id = ?";
    $delete_stmt = $conn->prepare($delete_query);
    $delete_stmt->bind_param("i", $delete_id);
    if ($delete_stmt->execute()) {
        header("Location: view_users.php?limit=$limit&page=$page");
        exit();
    } else {
        echo "Error deleting user.";
    }
    $delete_stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="styles/view_users.css">
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
        <h2>Manage Users</h2>

        <div class="show-entries">
            Show 
            <form action="view_users.php" method="GET" style="display:inline;">
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
                    <th>Username</th>
                    <th>Date of Birth</th>
                    <th>Bio</th>
                    <th>Gender</th>
                    <th>Profile Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sn = $start + 1; 
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $sn++ . "</td>";
                    echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['dob']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['bio']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['gender']) . "</td>";

                   
                  

$profile_image = !empty($row['profile_image']) ? $row['profile_image'] : 'default.png';
echo "<td><img src='../uploads/" . htmlspecialchars($profile_image) . "' alt='Profile Image' class='user-img' width='50' height='50'></td>";



                    echo "<td class='action-buttons'>
                              <a href='view_users.php?delete_id=" . $row['id'] . "' class='delete-btn' onclick='return confirm(\"Are you sure you want to delete this user?\")'>Delete</a>
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
                echo "<a href='view_users.php?page=$i&limit=$limit' $is_active>$i</a>";
            }
            ?>
        </div>
    </div>
</div>

</body>
</html>
