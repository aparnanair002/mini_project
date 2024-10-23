<?php

include('connection.php');
// Get the user ID from the session or query string
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
$password = $_POST['p3'];
$homeaddress = $_POST['p4'];
$phone_no = $_POST['p5'];
$location_society = $_POST['p6'];
$gender = $_POST['ctype'];

// Validate the form data
if (empty($name) || empty($username) || empty($password) || empty($homeaddress) || empty($phone_no) || empty($location_society) || empty($gender)) {
    header("Location: ../fedit.php?error=1");
    exit;
}

// Update the user profile in the database
$sql = "UPDATE tbl_dairyf SET f_name = '$name', f_username = '$username', f_password = '$password', f_homeaddress = '$homeaddress', phone_no = '$phone_no', location_society= '$location_society', gender= '$gender' WHERE f_Id = '$f_Id'";

if (mysqli_query($con, $sql)) {
    header("Location: ../fhome.php?eprir=1");
} else {
    header("Location: ../fedit.php?error=1");
}

// Close the database conection
mysqli_close($con);
?>