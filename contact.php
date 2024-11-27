<?php
session_start(); 


if (isset($_SESSION['success_message'])) {
    echo "<script>showPopup('" . $_SESSION['success_message'] . "');</script>";
    unset($_SESSION['success_message']); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link rel="stylesheet" href="styles/contact.css">
    <link rel="stylesheet" href="./layout/layout.css">
    <link rel="stylesheet" href="styles/fonts.css">
</head>
<body>
<?php
require("layout/header.php");
?>


    <div class="contact-container">
    <div class="contact-image">
      <img src="media/contact.jpg" alt="contact-img">
    </div>
    
    <div class="contact-form">
        <h1>CONTACT US</h1>
        <form action="submit_contact.php" method="post">
              <label for="name">Name:</label>
              <input type="text" id="name" name="name" required>

              <label for="phone">Phone:</label>
              <input type="number" id="phone" name="phone" required>

              <label for="email">Email:</label>
              <input type="email" id="email" name="email" placeholder="abc@xyz.com" required>

              <label for="message">Message:</label>
              <textarea id="message" name="message" rows="5" maxlength="200" required></textarea>

              <center><button type="submit">Submit</button></center>
          </form>
      </div>
    </div>


  <?php
require("layout/footer.php");
?>    
</body>
</html>