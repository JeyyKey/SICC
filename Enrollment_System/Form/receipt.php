<?php 
session_start();
require 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['custom_id'])) {
        die("Student ID is missing. Please start the process again.");
    }

    $customId = $_SESSION['custom_id']; // Retrieve custom ID
    $reservationAmount = $_POST['reservation_amount'];
    $miscFeeAmount = $_POST['misc_fee_amount'];
    $booksAmount = $_POST['books_amount'];
    $reservationOr = $_POST['reservation_or'];
    $miscFeeOr = $_POST['misc_fee_or'];
    $booksOr = $_POST['books_or'];
    $reservationDate = $_POST['reservation_date'];
    $miscFeeDate = $_POST['misc_fee_date'];
    $booksDate = $_POST['books_date'];
    $transactionNumber = $_POST['transactionNumber'];
    $amount = $_POST['amount'];
    $paymentType = $_POST['Payment'];

    $proofOfPayment = $_FILES['imageAttachment'];
    $proofOfPaymentPath = 'uploads/' . basename($proofOfPayment['name']);

    if (!move_uploaded_file($proofOfPayment['tmp_name'], $proofOfPaymentPath)) {
        die("File upload failed!");
    }

    // Insert payment data into payments table
    $stmt = $conn->prepare(
        "INSERT INTO payments 
        (reservation_amount, misc_fee_amount, books_amount, reservation_or, misc_fee_or, books_or, 
        reservation_date, misc_fee_date, books_date, transaction_number, amount, payment_type, proof_of_payment, custom_id) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );

    // Bind parameters
    $stmt->bind_param(
        "ddddssssssssss", 
        $reservationAmount, $miscFeeAmount, $booksAmount, // decimal values
        $reservationOr, $miscFeeOr, $booksOr, // string values
        $reservationDate, $miscFeeDate, $booksDate, // date values
        $transactionNumber, $amount, $paymentType, // string and decimal
        $proofOfPaymentPath, $customId // varchar and custom_id
    );

    // Execute statement
    if ($stmt->execute()) {
        echo "Payment recorded successfully!";
        session_destroy(); // Clear session data
        header("Location: /ENROLLMENT_SYSTEM/LOG_IN/loginpage.php"); // Redirect to login page
        exit(); // Ensure no further code is executed
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
