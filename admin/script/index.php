<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="styles/index.css"> 
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <h2>Admin Login</h2>
            <form id="loginForm" method="POST" action="process_login.php" onsubmit="return validateLogin()">
                <div class="input-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                    <span class="toggle-password" onclick="togglePassword()">👁️</span>
                </div>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>

    <script>
  
        function togglePassword() {
            const passwordInput = document.getElementById("password");
            passwordInput.type = passwordInput.type === "password" ? "text" : "password";
        }

        
        function validateLogin() {
            const username = document.getElementById("username").value;
            const password = document.getElementById("password").value;

            if (username === "admin" && password === "admin") {
               
                window.location.href = "http://localhost/twowheelerrental/admin/script/admin_dashboard.php"; 
                return false;
            } 
          
            return true; 
        }
    </script>
</body>
</html>
