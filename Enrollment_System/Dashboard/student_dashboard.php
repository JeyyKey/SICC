<?php
session_start();

// Check if student is logged in
if (!isset($_SESSION['student_id'])) {
    die("Error: Student not logged in. Please log in first.");
}

include 'db_connection.php';
include 'sync_students.php';

$studentId = $_SESSION['student_id'];
$studentDetails = syncStudentDetails($conn, $studentId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - SAINT ISIDORE CHILDREN SCHOOL</title>
    <link rel="icon" type="image/x-icon" href="/ENROLLMENT_SYSTEM/images/logooo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="student_dashboard.css">
    
</head>
<body>
    <div class="container">
        <header>
        <h1>Welcome, 
                <span id="firstName"><?php echo $studentDetails ? $studentDetails['first_name'] : 'N/A'; ?></span> 
                <span id="lastName"><?php echo $studentDetails ? $studentDetails['last_name'] : 'N/A'; ?></span> 
            </h1>
        <span class="status-badge">Enrolled</span>
        </header>

        <div class="dashboard-grid">
            <section class="student-info">
                <h2>Your Details</h2>
                <p><strong>First Name:</strong> <span id="firstName"><?php echo $studentDetails ? $studentDetails['first_name'] : 'N/A'; ?></span></p>
                <p><strong>Last Name:</strong> <span id="lastName"><?php echo $studentDetails ? $studentDetails['last_name'] : 'N/A'; ?></span></p>
                <p><strong>Email:</strong> <span id="email"><?php echo $studentDetails ? $studentDetails['guardian_email'] : 'N/A'; ?></span></p>
                <p><strong>Grade Level:</strong> <span id="gradeLevel"><?php echo $studentDetails ? $studentDetails['grade'] : 'N/A'; ?></span></p>
                <p><strong>Birth Date:</strong> <span id="enrollmentDate"><?php echo $studentDetails ? $studentDetails['date_of_birth'] : 'N/A'; ?></span></p>
                <section class="logout">
            <a href="/ENROLLMENT_SYSTEM/LOG_IN/loginpage.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Log Out</a>
        </section>

            </section>
            

            <section class="resources">
                <h2>Resources</h2>
    
                <ul>
                    <li>
                        <a href="status.html">
                            <i class="fa-solid fa-square-poll-vertical"></i>
                            <h1 class="status">Enrollment Status</h1>
                        </a>
                    </li>
                    <li>
                        <a href="financial.html">
                            <i class="fa-solid fa-stamp"></i>
                            <h2 class="financial">Financial Information</h2>
                        </a>
                    </li>
                    <li>
                        <a href="dnf.html">
                            <i class="fas fa-book"></i>
                            <h2>Documents and Forms</h2>
                        </a>
                    </li>
                    <li>
                        <a href="anounce.html">
                            <i class="fas fa-bullhorn"></i>
                            <h2>Announcements</h2>
                        </a>
                    </li>
                </ul>
            </section>
        </div>

        <footer>
            <p>© 2024 SAINT ISIDORE CHILDREN SCHOOL - All Rights Reserved</p>
        </footer>
    </div>
    

 
</body>
</html>
<?php
// Close the connection after use
$conn->close();
?>