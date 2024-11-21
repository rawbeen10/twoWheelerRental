<?php
// Start the session if it isn't already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;

if (isset($_SESSION['new_notification'])) {
    // Determine the message based on notification type
    if ($_SESSION['new_notification'] == 'approved') {
        $message = 'Your rent has been approved! Visit the office for further processing.';
    } elseif ($_SESSION['new_notification'] == 'canceled') {
        $message = 'Your rent has been canceled. Please contact the office for more details.';
    }

    // Display the popup message using JavaScript
    echo "<script>showPopup('$message');</script>";

    // Clear the session variable to avoid showing the same message again
    unset($_SESSION['new_notification']);
}
?>

<header>
    <div class="logo">
        <h1>Uthaoo</h1>
    </div>
    <nav>
        <ul class="nav-menu">
            <li><a href="index.php">Home</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="rent.php">Rent</a></li>
            <li><a href="contact.php">Contact</a></li>
            <?php if ($isLoggedIn): ?>
                <li class="dropdown">
                    <div class="profile-box">
                            <a href="#" class="dropdown-toggle">
                        <svg class="profile"  width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M16 7C16 9.20914 14.2091 11 12 11C9.79086 11 8 9.20914 8 7C8 4.79086 9.79086 3 12 3C14.2091 3 16 4.79086 16 7Z" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M12 14C8.13401 14 5 17.134 5 21H19C19 17.134 15.866 14 12 14Z" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                        <!-- <svg class="arrow" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg> -->
                    </a>
                        </div>

                    <ul class="dropdown-menu">
                        <li><a href="profile.php">Profile</a></li>
                        <li><a href="history.php">History</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
                </li>
            <?php else: ?>
                <li><a href="login.php">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<script>
    // Dropdown toggle logic
    document.addEventListener('DOMContentLoaded', () => {
        const dropdownToggle = document.querySelector('.dropdown-toggle');
        const dropdownMenu = document.querySelector('.dropdown-menu');

        if (dropdownToggle && dropdownMenu) {
            dropdownToggle.addEventListener('click', (e) => {
                e.preventDefault();
                dropdownMenu.classList.toggle('show');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', (event) => {
                if (!dropdownMenu.contains(event.target) && !dropdownToggle.contains(event.target)) {
                    dropdownMenu.classList.remove('show');
                }
            });
        }
    });
</script>

<style>
    .dropdown {
        position: relative;
    }

    .dropdown-menu {
        display: none;
        position: absolute;
        top: 100%;
        right: 0;
        background-color: rgb(0, 61, 122); /* Updated background color */
        border: none;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        list-style: none;
        padding: 10px;
        margin: 0;
        border-radius: 5px;
        z-index: 1000;
    }

    .dropdown-menu.show {
        display: block;
    }

    .dropdown-menu li {
        padding: 5px 10px;
    }

    .dropdown-menu li a {
        text-decoration: none;
        color: #fff; /* Updated text color */
    }

    .dropdown-menu li:hover {
        background-color: rgba(255, 255, 255, 0.1); /* Subtle hover effect */
    }

    .dropdown-toggle {
        cursor: pointer;
    }

    .arrow {
        margin-left: 5px;
        transition: transform 0.3s ease;
    }

    .dropdown-menu.show ~ .arrow {
        transform: rotate(180deg);
    }
</style>
