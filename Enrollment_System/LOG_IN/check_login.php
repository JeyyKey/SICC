<?php
session_start();

// Database connection details
$servername = "localhost"; 
$username = "root";        
$password = "";            
$dbname = "sicc";          

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve email and password from POST request
$email = $_POST['email'];
$password = $_POST['password']; // User-provided password (plain text)

// Check login for students
$query = "SELECT * FROM students WHERE guardian_email = ?";
$stmt = $conn->prepare($query);

if ($stmt === false) {
    die("Error preparing the query: " . $conn->error);
}

$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

if ($student) {
    // Verify password (use plain text comparison if passwords are not hashed yet)
    if ($password == $student['password']) { // Consider switching to `password_verify` if hashed passwords are used
        $_SESSION['student_id'] = $student['id']; // Assuming the column is 'id'
        $_SESSION['user_name'] = $student['first_name'] . ' ' . $student['last_name']; // Store name for personalized greeting
        header("Location: /ENROLLMENT_SYSTEM/Dashboard/student_dashboard.php"); // Redirect to student dashboard
        exit();
    } else {
        $_SESSION['login_error'] = "Incorrect password. Please try again.";
        header("Location: loginpage.php"); // Redirect back to login with error
        exit();
    }
}

// Check if the email exists in the admin table
$query = "SELECT * FROM admin WHERE email = ?";
$stmt = $conn->prepare($query);

if ($stmt === false) {
    die("Error preparing the query: " . $conn->error);
}

$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();

// If email found in admin table
if ($admin) {
    // Direct password comparison (plain text)
    if ($password == $admin['password']) {
        $_SESSION['admin_id'] = $admin['admin_id'];
        $_SESSION['user_name'] = $admin['name']; // Store name for personalized greeting
        header("Location: /ENROLLMENT_SYSTEM/admin/admin_dashboard.php"); // Redirect to admin dashboard
        exit();
    } else {
        $_SESSION['login_error'] = "Incorrect password. Please try again.";
        header("Location: loginpage.php"); // Redirect back to login with error
        exit();
    }
}

// If the email does not exist in both tables
$_SESSION['login_error'] = "Account does not exist. Please check your email or register.";
header("Location: loginpage.php"); // Redirect back to login with error
exit();
?>
