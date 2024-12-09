<?php
session_start(); 

include_once("db_connection.php"); 


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAINT ISIDORE CHILDREN SCHOOL - Login</title>
    <link rel="icon" type="image/x-icon" href="/images/LOGO.png">
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="container">
        <div class="login-section">
            <h1>Log In to Your Account</h1>
            <form action="check_login.php" method="POST">
                <!-- Login Information Section -->
                <label for="email" class="email">Email:</label><br>
                <input type="email" id="email" name="email" required><br><br>

                <label for="password" class="pass">Password:</label><br>
                <input type="password" id="password" name="password" required>
                <p><a href="/ENROLLMENT_SYSTEM/LOG_IN/email_auth.php" id="forgot-password-link" class="forgot-password">Forgot Password?</a></p>

                <!-- Submit Button for Login -->
                <input type="submit" value="Login">
            </form>

            <!-- Link to Enrollment Page -->
            <p><a href="/ENROLLMENT_SYSTEM/Form/Form.html" id="enroll-link" class="enroll">Enroll now</a></p>

            <!-- Display login feedback message (if any) -->
            <?php
            // Check if there is a session variable set for login errors
            if (isset($_SESSION['login_error'])) {
                // Display the error message
                echo '<p class="error-message" style="color:red;">' . $_SESSION['login_error'] . '</p>';
                // Clear the error message after displaying it
                unset($_SESSION['login_error']);
            }
            ?>
        </div>
    </div>
</body>
</html>
