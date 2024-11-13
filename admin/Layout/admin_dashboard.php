<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin_dashboard.css">
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <div class="logo">
                <h2>Admin Panel</h2>
            </div>
            <ul>
                <!-- Manage Vehicles with dropdown -->
                <li>
                    <a href="#" onclick="toggleDropdown('vehicleDropdown', this)">
                        Manage Vehicles
                        <svg class="arrow" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </a>
                    <ul id="vehicleDropdown" class="dropdown">
                        <li><a href="http://localhost/twoWheelerRental/admin/script/add_vehicle.php">Add Vehicle</a></li>
                        <li><a href="http://localhost/twoWheelerRental/admin/script/view_vehicle.php">View Vehicles</a></li>
                    </ul>
                </li>

                <li><a href="#">Manage Rentals</a></li>

                <li>
                    <a href="#" onclick="toggleDropdown('userDropdown', this)">
                        Manage Users
                        <svg class="arrow" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </a>
                    <ul id="userDropdown" class="dropdown">
                        <li><a href="#">Admins</a></li>
                        <li><a href="#">Users</a></li>
                    </ul>
                </li>

                <li>
                    <a href="#" onclick="toggleDropdown('settingsDropdown', this)">
                        Settings
                        <svg class="arrow" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </a>
                    <ul id="settingsDropdown" class="dropdown">
                        <li><a href="#">Profile Settings</a></li>
                        <li><a href="#">Security Settings</a></li>
                        <li><a href="#">Notification Settings</a></li>
                    </ul>
                </li>
            </ul>
        </div>

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
                    <button id="logout-btn" onclick="window.location.href='login.php'">Logout</button>
                </div>
            </div>
            <div class="content">
                <!-- Main content goes here -->
            </div>
        </div>
    </div>

    <script>
        function toggleDropdown(id, element) {
            // Toggle the display of the dropdown
            const dropdown = document.getElementById(id);
            dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
            
            // Toggle the rotation of the arrow
            const arrow = element.querySelector('.arrow');
            arrow.classList.toggle('rotate');
        }
    </script>
</body>
</html>
