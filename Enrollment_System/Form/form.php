<?php
session_start();
require 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $lastName = $_POST['lastName'];
    $firstName = $_POST['firstName'];
    $middleName = $_POST['middleName'];
    $grade = $_POST['grade'];
    $dob = $_POST['dob'];
    $age = $_POST['age'];
    $birthPlace = $_POST['birthPlace'];
    $gender = $_POST['gender'];
    $completeAddress = $_POST['complete_add'];
    $fatherName = $_POST['fatherName'];
    $motherName = $_POST['motherName'];
    $guardianName = $_POST['guardianName'];
    $contactNumber = $_POST['contactNumber'];
    $facebookMessenger = $_POST['facebookMessenger'];
    $relationship = $_POST['relationship'];
    $guardianContact = $_POST['guardianContact'];
    $guardianEmail = $_POST['guardianEmail'];

    // File to store the counter
    $filename = 'counter.txt';

    // Check if the file exists and initialize if necessary
    if (!file_exists($filename)) {
        file_put_contents($filename, 0); // Start with 0 if the file doesn't exist
    }

    // Read the current counter value
    $counter = (int)file_get_contents($filename);

    // Increment the counter
    $counter++;

    // Save the new counter value back to the file
    file_put_contents($filename, $counter);

    // Generate a unique custom_id in the format 2024-XX
    $customId = '2024-' . str_pad($counter, 2, '0', STR_PAD_LEFT);

    // Insert data into students table
    $stmt = $conn->prepare("INSERT INTO students (last_name, first_name, middle_name, grade, date_of_birth, age, birth_place, gender, complete_address, father_name, mother_name, guardian_name, contact_number, facebook_messenger, relationship, guardian_contact, guardian_email, custom_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssssssssss", $lastName, $firstName, $middleName, $grade, $dob, $age, $birthPlace, $gender, $completeAddress, $fatherName, $motherName, $guardianName, $contactNumber, $facebookMessenger, $relationship, $guardianContact, $guardianEmail, $customId);

    if ($stmt->execute()) {
        $_SESSION['custom_id'] = $customId; // Save the custom ID in the session
        header('Location: /ENROLLMENT_SYSTEM/Form/documentsforms.html'); // Redirect to the document upload page
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
