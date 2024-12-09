<?php
session_start(); 

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    die("Error: Admin not logged in. Please log in first.");
}

include 'db_connection.php'; 
include 'sync_admin.php';
include 'quickaction.php';   
$adminId = $_SESSION['admin_id']; // Fetch admin ID from session

// Call the function to fetch admin details
$adminDetails = syncAdminDetails($conn, $adminId); //return value is stored here

function getDashboardCounts($conn) {
    $counts = [];

    // Get total students
    $result = $conn->query("SELECT COUNT(*) as total_students FROM students");
    $counts['total_students'] = $result->fetch_assoc()['total_students'] ?? 0;

    //Get total teachers 
    $result = $conn->query("SELECT COUNT(*) as total_teachers FROM teachers");
    $counts['total_teachers'] = $result->fetch_assoc()['total_teachers'] ?? 0;

    /* Get active classes (Assuming you have a classes table)
    $result = $conn->query("SELECT COUNT(*) as active_classes FROM classes WHERE status = 'active'");
    $counts['active_classes'] = $result->fetch_assoc()['active_classes'] ?? 0;

    // Get pending payments (Assuming you have a payments table)
    $result = $conn->query("SELECT COUNT(*) as pending_payments FROM payments WHERE status = 'pending'");
    $counts['pending_payments'] = $result->fetch_assoc()['pending_payments'] ?? 0; */

    return $counts;
}

// Call the function and store the result in $dashboardCounts
$dashboardCounts = getDashboardCounts($conn);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - SAINT ISIDORE CHILDREN SCHOOL</title>
    <link rel="icon" type="image/x-icon" href="/ENROLLMENT_SYSTEM/images/logooo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="admin_dashboard.css">

</head>

<body>
    <div class="container">
        <header>
        <h1>Welcome, <?php echo htmlspecialchars($adminDetails['name']); ?></h1>
            <p>Admin Dashboard for SAINT ISIDORE CHILDREN SCHOOL</p>
        </header>
        
        <main>
        <section class="admin-info">
        <h2>Admin Details</h2>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($adminDetails['name']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($adminDetails['email']); ?></p>
                <p><strong>Username:</strong> <?php echo htmlspecialchars($adminDetails['username']); ?></p>
    </section>

            <section class="resources">
                <h2>Dashboard Overview</h2>
                <ul>
                    <li><i class="fas fa-user-graduate"></i> Total Students: <strong><?php echo $dashboardCounts['total_students']; ?></strong></li>
                    <li><i class="fas fa-chalkboard-teacher"></i> Total Teachers: <strong><?php echo $dashboardCounts['total_teachers']; ?></strong></li>
                    <li><i class="fas fa-book"></i> Active Classes: <strong>24</strong></li>
                    <li><i class="fas fa-dollar-sign"></i> Pending Payments: <strong>15</strong></li>
                </ul>
            </section>

            <section class="quick-actions">
    <div class="quick-action-card">
        <h3><i class="fas fa-plus"></i> Add Teacher</h3>
        <button class="btn" id="toggleStudentForm">Add New Teacher</button>
        <form id="studentForm" class="quick-action-form" method="POST" action="quickaction.php" style="display: none;">
            <input type="text" name="teacherName" id="teacherName" placeholder="Teacher Name" required>
            <input type="email" name="teacherEmail" id="teacherEmail" placeholder="Email" required>
            <select name="teacherGrade" id="teacherGrade" required>
                <option value="">Select Grade</option>
                <option value="Nursery">Nursery</option>
                <option value="Kinder">Kinder</option>
                <option value="Grade 1">Grade 1</option>
                <option value="Grade 2">Grade 2</option>
                <option value="Grade 3">Grade 3</option>
                <option value="Grade 4">Grade 4</option>
                <option value="Grade 5">Grade 5</option>
                <option value="Grade 6">Grade 6</option>
            </select>
            <button type="submit" class="btn">Submit</button>
        </form>
    </div>

    <div class="quick-action-card">
        <h3><i class="fas fa-user-plus"></i> Manage Grade Level</h3>
        <button class="btn btn-blue" id="toggleTeacherForm">Manage</button>
        <form id="teacherForm" class="quick-action-form" style="display: none;">
            <input type="text" placeholder="Adviser Name" required>
            <input type="email" placeholder="Email" required>
            <select required>
                <option value="">Select Grade Level</option>
                <option value="1">Nursery</option>
                <option value="2">Kinder</option>
                <option value="3">Grade 1</option>
                <option value="4">Grade 2</option>
                <option value="5">Grade 3</option>
                <option value="6">Grade 4</option>
                <option value="7">Grade 5</option>
                <option value="8">Grade 6</option>
            </select>
            <button type="submit" class="btn btn-blue">Submit</button>
        </form>
    </div>

    <div class="quick-action-card">
        <h3><i class="fas fa-bell"></i> Send Announcement</h3>
        <button class="btn btn-red" id="toggleAnnouncementForm">Create Announcement</button>
        <form id="announcementForm" class="quick-action-form" style="display: none;">
            <input type="text" placeholder="Announcement Title" required>
            <textarea placeholder="Announcement Content" required style="width: 100%; height: 100px; margin: 8px 0; padding: 8px;"></textarea>
            <label for="imageAttachment">Send Image:</label>
            <input type="file" id="imageAttachment" name="imageAttachment" accept="image/*">
            <select required>
                <option value="">Select Recipients</option>
                <option value="all">All</option>
                <option value="teachers">Teachers Only</option>
                <option value="students">Students Only</option>
            </select>
            <button type="submit" class="btn btn-red">Send Announcement</button>
        </form>
    </div>
</section>


            <section class="recent-enrollments">
                <h2>Manage Enrollments</h2>
                <input type="text" class="search-bar" placeholder="Search students...">
                <table>
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Grade</th>
                            <th>Enrollment Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                            <tr data-student-id="STD001">
            <td>STD001</td>
            <td class="student-name">John Smith</td>
            <td class="student-grade">Grade 5</td>
            <td>2024-01-15</td>
            <td>Active</td>
            <td>
                <button class="btn" style="padding: 5px; width: auto; display: inline-block;" onclick="editStudent('STD001')">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn btn-red" style="padding: 5px; width: auto; display: inline-block;" onclick="deleteStudent('STD001')">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        </tr>
        <tr data-student-id="STD002">
            <td>STD002</td>
            <td class="student-name">Sarah Johnson</td>
            <td class="student-grade">Grade 3</td>
            <td>2024-01-18</td>
            <td>Active</td>
            <td>
                <button class="btn" style="padding: 5px; width: auto; display: inline-block;" onclick="editStudent('STD002')">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn btn-red" style="padding: 5px; width: auto; display: inline-block;" onclick="deleteStudent('STD002')">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        </tr>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Table content will be populated by JavaScript -->
                    </tbody>
                </table>
            </section>
        </main>

        <section class="logout">
            <a href="/ENROLLMENT_SYSTEM/LOG_IN/loginpage.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Log Out</a>
        </section>

        <footer>
            <p>© 2024 SAINT ISIDORE CHILDREN SCHOOL - Admin Portal</p>
        </footer>
    </div>

    <!-- Success Message Container -->
    <div id="successMessage" class="success-message"></div>

    <script src="admin_dashboard.js"></script>
</body>
</html>
<?php
$conn->close(); // Close the database connection
?>