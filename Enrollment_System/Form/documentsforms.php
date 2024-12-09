<?php
session_start();
require 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['custom_id'])) {
        die("Student ID is missing. Please start the process again.");
    }

    $customId = $_SESSION['custom_id']; // Retrieve custom ID

    $photo = $_FILES['photo'];
    $form137 = $_FILES['form137'];
    $reportCard = $_FILES['reportCard'];

    $photoPath = 'uploads/' . basename($photo['name']);
    $form137Path = 'uploads/' . basename($form137['name']);
    $reportCardPath = 'uploads/' . basename($reportCard['name']);

    move_uploaded_file($photo['tmp_name'], $photoPath);
    move_uploaded_file($form137['tmp_name'], $form137Path);
    move_uploaded_file($reportCard['tmp_name'], $reportCardPath);

    // Update students table with file paths
    $stmt = $conn->prepare("UPDATE students SET photo = ?, form137 = ?, report_card = ? WHERE custom_id = ?");
    $stmt->bind_param("ssss", $photoPath, $form137Path, $reportCardPath, $customId);

    if ($stmt->execute()) {
        header('Location: /ENROLLMENT_SYSTEM/Form/receipt.html'); // Redirect to the payment receipt page
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
