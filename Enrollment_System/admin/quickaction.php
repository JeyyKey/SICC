<?php
include 'db_connection.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate input
    $teacherName = mysqli_real_escape_string($conn, $_POST['teacherName']);
    $teacherEmail = mysqli_real_escape_string($conn, $_POST['teacherEmail']);
    $teacherGrade = mysqli_real_escape_string($conn, $_POST['teacherGrade']);
    
    // Check if all fields are filled
    if (empty($teacherName) || empty($teacherEmail) || empty($teacherGrade)) {
        die("Error: Please fill all the fields.");
    }
    
    // Prepare and execute the SQL query to insert the new teacher
    $sql = "INSERT INTO teachers (name, email, grade) VALUES ('$teacherName', '$teacherEmail', '$teacherGrade')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Teacher added successfully!');</script>";
        echo "<script>window.location.href = 'admin_dashboard.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
    
  
}
?>
