 

<?php
function syncStudentDetails($conn, $studentId) {
    $query = "SELECT * FROM students WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $studentId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null; // No student found
    }
}


?>
