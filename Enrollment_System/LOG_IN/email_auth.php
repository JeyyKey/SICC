<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize and validate the email address
    $email = filter_var($_POST["reset-email"], FILTER_VALIDATE_EMAIL);

    if ($email) {
        // Connect to the database
        $conn = new mysqli("localhost", "root", "", "sicc");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare the SQL statement to find the student by guardian_email
        $stmt = $conn->prepare("SELECT * FROM students WHERE guardian_email = ?");
        if (!$stmt) {
            die("Prepare failed: " . $conn->error); // Debugging error
        }

        // Bind the email parameter and execute the query
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Generate a reset token and expiry time
            $token = bin2hex(random_bytes(16));
            $expiry = date("Y-m-d H:i:s", strtotime("+1 hour"));

            // Update the student's record with the reset token and expiry
            $stmt = $conn->prepare("UPDATE students SET reset_token = ?, reset_expiry = ? WHERE guardian_email = ?");
            if (!$stmt) {
                die("Prepare failed: " . $conn->error); // Debugging error
            }
            $stmt->bind_param("sss", $token, $expiry, $email);
            $stmt->execute();

            // Send the reset email to the guardian
            $resetLink = "http://localhost/resetpass.html?token=$token";
            $subject = "Password Reset Request";
            $message = "Click the link to reset your password: $resetLink";
            $headers = "From: no-reply@saintisidore.edu";

            if (mail($email, $subject, $message, $headers)) {
                echo "Reset email sent. Please check your inbox.";
                // Redirect to the reset password page (or show a message)
                header("Location: resetpass.html");
                exit();
            } else {
                echo "Failed to send email. Please try again.";
            }
        } else {
            echo "Email not found in the students table.";
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    } else {
        echo "Invalid email address. Please enter a valid one.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Authentication - SAINT ISIDORE CHILDREN SCHOOL</title>
    <link rel="icon" type="image/x-icon" href="/images/LOGO.png">
    <!-- <link rel="stylesheet" href="login.css"> -->
    <link rel="stylesheet" href="email_auth.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="reset_password.js" defer></script>
</head>
<body>
    <div class="container">
    <div class="forgot-section">  
    <h1>Forgot Password</h1>
        <p>Enter your email to receive a password reset link.</p>
        <form id="request-reset-form" action="email_auth.php" method="POST">
            <label for="reset-email"><strong>Email Address</strong></label>
            <input type="email" id="reset-email" name="reset-email" required>
            <input type="submit" value="Send Reset Email">
        </form>
        </div>
    </div>
</body>
</html>
