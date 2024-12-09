<?php
function syncAdminDetails($conn, $adminId) {
    // Query to fetch admin details based on the logged-in admin's ID
    $query = "SELECT name, email, username FROM admin WHERE admin_id = ?";
    
    // Prepare the SQL statement to prevent SQL injection
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $adminId); // "i" specifies the type is integer
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        // Fetch the admin details
        $admin = $result->fetch_assoc();
        return [
            'name' => $admin['name'] ?? 'Not Set',
            'email' => $admin['email'] ?? 'Not Set',
            'username' => $admin['username'] ?? 'Not Set',
        ];
    } else {
        // Default response if no admin found
        return [
            'name' => 'No Admin Found',
            'email' => 'No Email Found',
            'username' => 'No Username Found',
        ];
    }
}

?>
