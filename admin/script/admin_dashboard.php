<?php
// Connect to the database
include('db_connect.php');

// Fetch required data
$result_vehicles = mysqli_query($conn, "SELECT COUNT(*) AS total_vehicles FROM vehicles");
$data_vehicles = mysqli_fetch_assoc($result_vehicles);
$total_vehicles = $data_vehicles['total_vehicles'];

$result_users = mysqli_query($conn, "SELECT COUNT(*) AS total_users FROM users");
$data_users = mysqli_fetch_assoc($result_users);
$total_users = $data_users['total_users'];

$result_pending = mysqli_query($conn, "SELECT COUNT(*) AS pending_requests FROM rent WHERE status = 'pending'");
$data_pending = mysqli_fetch_assoc($result_pending);
$pending_requests = $data_pending['pending_requests'];

$result_approved = mysqli_query($conn, "SELECT COUNT(*) AS approved_requests FROM rent WHERE status = 'approved'");
$data_approved = mysqli_fetch_assoc($result_approved);
$approved_requests = $data_approved['approved_requests'];

$result_cancelled = mysqli_query($conn, "SELECT COUNT(*) AS cancelled_requests FROM rent WHERE status = 'cancelled'");
$data_cancelled = mysqli_fetch_assoc($result_cancelled);
$cancelled_requests = $data_cancelled['cancelled_requests'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles/admin_dashboard.css">
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
    <div class="container">
        <div class="main-content">
            <div class="navbar">
                <div class="left">
                    <h1>Dashboard</h1>
                </div>
                <div class="right">
                    <button id="notification-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell">
                            <path d="M18 8a6 6 0 0 0-12 0v4a6 6 0 0 0-2 4v1h16v-1a6 6 0 0 0-2-4V8z"></path>
                            <path d="M13 17h-2v2h2v-2z"></path>
                            <path d="M10 21h4v2H10z"></path>
                        </svg>
                    </button>
                    <button id="logout-btn" onclick="window.location.href='index.php'">Logout</button>
                </div>
            </div>
    </div>

    </div>

    <h1 id="info-head">Rides</h1>
    <div class="info-dashboard vehicle-info">
        <a href="view_vehicle.php">
        <div class="info-box no-vehicles">
            <h3><?php echo $total_vehicles; ?></h3>
            <p>Total Vehicles</p>
        </div>
        </a>

        <a href="add_vehicle.php">
        <div class="info-box link">
            <h3><svg width="25px" height="25px" viewBox="0 0 24.00 24.00" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title></title> <g id="Complete"> <g data-name="add" id="add-2"> <g> <line fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.4" x1="12" x2="12" y1="19" y2="5"></line> <line fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.4" x1="5" x2="19" y1="12" y2="12"></line> </g> </g> </g> </g></svg></h3>
            <p>Add New Vehicle</p>
        </div>
        </a>
</div>

    <h1 id="info-head">Rents</h1>
    <div class="info-dashboard rent-info">
        <a href="manage_rental.php">
        <div class="info-box pending">
            <h3><?php echo $pending_requests; ?></h3>
            <p>Pending Requests</p>
        </div>
        </a>

        <a href="approved.php">
        <div class="info-box approved">
            <h3><?php echo $approved_requests; ?></h3>
            <p>Approved</p>
        </div>
        </a>
        <a href="cancelled.php">
        <div class="info-box cancelled">
            <h3><?php echo $cancelled_requests; ?></h3>
            <p>Cancelled</p>
        </div>
        </a>
</div>

<h1 id="info-head">Users</h1>
    <div class="info-dashboard users">
        <a href="#">
        <div class="info-box no-users">
            <h3><?php echo $total_users; ?></h3>
            <p>Total Users</p>
        </div>
        </a>

        <a href="view_users.php">
        <div class="info-box users-link">
            <h3><svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M9 4.45962C9.91153 4.16968 10.9104 4 12 4C16.1819 4 19.028 6.49956 20.7251 8.70433C21.575 9.80853 22 10.3606 22 12C22 13.6394 21.575 14.1915 20.7251 15.2957C19.028 17.5004 16.1819 20 12 20C7.81811 20 4.97196 17.5004 3.27489 15.2957C2.42496 14.1915 2 13.6394 2 12C2 10.3606 2.42496 9.80853 3.27489 8.70433C3.75612 8.07914 4.32973 7.43025 5 6.82137" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"/>
<path d="M15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12Z" stroke="#ffffff" stroke-width="1.5"/>
</svg></h3>
            <p>View Users</p>
        </div>
        </a>
</div>
</div>
</body>
</html>
