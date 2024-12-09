<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Collect data from the form
    $email = filter_var($_POST["Email"], FILTER_VALIDATE_EMAIL);
    $newPassword = $_POST["new-password"];
    $confirmPassword = $_POST["confirm-password"];
    $token = $_POST["token"];

    if ($email && $newPassword && $confirmPassword && $token) {
        // Check if passwords match
        if ($newPassword !== $confirmPassword) {
            die("Passwords do not match.");
        }

        // Validate password strength
        if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $newPassword)) {
            die("Password must be at least 8 characters long, contain at least one number and one special character.");
        }

        // Hash the new password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Connect to the database
        $conn = new mysqli("localhost", "root", "", "sicc");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Validate the token and email
        $stmt = $conn->prepare("SELECT * FROM students WHERE reset_token = ? AND guardian_email = ? AND reset_expiry > NOW()");
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("ss", $token, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Token and email are valid; update the password
            $stmt = $conn->prepare("UPDATE students SET password = ?, reset_token = NULL, reset_expiry = NULL WHERE guardian_email = ?");
            if (!$stmt) {
                die("Prepare failed: " . $conn->error);
            }
            $stmt->bind_param("ss", $hashedPassword, $email);
            if ($stmt->execute()) {
                echo "Password reset successful. You can now log in with your new password.";
            } else {
                echo "Failed to update the password. Please try again.";
            }
        } else {
            echo "Invalid or expired token.";
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    } else {
        echo "All fields are required. Please fill out the form correctly.";
    }
} else {
    die("Invalid request method.");
}
?>
