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

    
   
</header>



<script>

    let notificationCount = 0; 

    
    function updateNotificationCount() {
        
        notificationCount++;
        document.getElementById('notification-count').textContent = notificationCount;
    }

    
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
