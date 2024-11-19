<?php
// Start the session if it isn't already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

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
            <li><a href="login.php">Login</a></li>
        </ul>
    </nav>

    <!-- Notification Icon with SVG -->
    <div class="notification-icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
            <path d="M12 22c1.104 0 2-.896 2-2H10c0 1.104.896 2 2 2zm6-6V9c0-3.314-2.686-6-6-6-1.184 0-2.285.386-3.214 1.032C8.474 3.532 8 4.853 8 6h8v10h2zM5 15V6c0-1.147.474-2.468 1.214-3.032C6.285 2.386 7.184 2 8 2c-3.314 0-6 2.686-6 6v9h2z"/>
        </svg>
        <span class="notification-count" id="notification-count">0</span>
    </div>
</header>

<!-- Popup Modal -->
<div class="popup" id="popup" style="display: none;">
    <div class="popup-content">
        <span class="close-btn" onclick="closePopup()">×</span>
        <h2 id="popup-message">Your rent has been approved! Visit the office for further processing.</h2>
    </div>
</div>

<script>
    // Example logic to check for rent approval or cancellation
    let notificationCount = 0; // Start with 0 notifications

    // Update notification count dynamically (this would be based on actual data)
    function updateNotificationCount() {
        // For example, if there's a new rent approval or cancellation:
        notificationCount++;
        document.getElementById('notification-count').textContent = notificationCount;
    }

    // Show the popup message when the notification is clicked
    document.querySelector('.notification-icon').addEventListener('click', function() {
        if (notificationCount > 0) {
            showPopup('Your rent has been approved! Visit the office for further processing.');
        }
    });

    // Function to display the popup
    function showPopup(message) {
        document.getElementById('popup-message').textContent = message;
        document.getElementById('popup').style.display = 'block';
    }

    // Function to close the popup
    function closePopup() {
        document.getElementById('popup').style.display = 'none';
    }

    // You can call `updateNotificationCount()` based on actions like approval or cancellation.
    // Example: Call this function when a rent is approved or canceled.
    // updateNotificationCount(); // Uncomment when an approval/cancellation happens.
</script>

<!-- Popup Modal CSS -->
<style>
    .popup {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: none;
        justify-content: center;
        align-items: center;
    }

    .popup-content {
        background-color: white;
        padding: 20px;
        border-radius: 5px;
        text-align: center;
        max-width: 400px;
        width: 90%;
    }

    .close-btn {
        font-size: 20px;
        color: black;
        background-color: transparent;
        border: none;
        cursor: pointer;
        position: absolute;
        top: 10px;
        right: 10px;
    }

    .notification-icon {
        position: relative;
        cursor: pointer;
    }

    .notification-count {
        position: absolute;
        top: -5px;
        right: -5px;
        background-color: red;
        color: white;
        border-radius: 50%;
        padding: 5px;
        font-size: 12px;
    }
</style>
