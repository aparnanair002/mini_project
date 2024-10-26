<?php

include('connection.php');
session_start();
$f_Id = $_SESSION['f_Id'];

// Check if the user ID is valid
if (empty($f_Id)) {
    header("Location:../fedit.php");
    exit;
}

// Get the form data
$name = $_POST['p1'];
$username = $_POST['p2'];
$homeaddress = $_POST['p4'];
$phone_no = $_POST['p5'];
$location_society = $_POST['p6'];
$gender = $_POST['ctype'];

// Validate the form data
if (empty($name) || empty($username) || empty($homeaddress) || empty($phone_no) || empty($location_society) || empty($gender)) {
    header("Location: ../fedit.php?error=1");
    exit;
}

// Prepare the SQL statement
$stmt = $con->prepare("UPDATE tbl_dairyf SET f_name = ?, f_username = ?, f_homeaddress = ?, phone_no = ?, location_society = ?, gender = ?, f_status = 0 WHERE f_Id = ?");

// Bind parameters
$stmt->bind_param("ssssssi", $name, $username, $homeaddress, $phone_no, $location_society, $gender, $f_Id);

// Execute the statement
if ($stmt->execute()) {
    header("Location: ../fsignlogin.php");
} else {
    // Redirect with the error message
    $error_message = urlencode($stmt->error);
    header("Location: ../fedit.php?error=$error_message");
}

// Close the statement and database connection
$stmt->close();
mysqli_close($con);
?>