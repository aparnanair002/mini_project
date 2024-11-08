<?php
session_start();
include 'connection.php'; // Include your database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $fid = $_POST['fid'];
    $milk_type = $_POST['milk_type'];
    $quantity = $_POST['quantity'];
    $unit = $_POST['unit'];
    
    if ($unit=='millilitre'){
        $quantity = $quantity / 1000;
    }
    // Prepare the insert statement
    $sql = "INSERT INTO tbl_milk_records (f_id, milk_type, t_date, c_ltr) VALUES (?, ?, CURDATE(), ?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("isi", $fid, $milk_type, $quantity); // Assuming fid is an integer, milk_type is a string, and quantity is an integer
    
    // Execute the statement and check for success
    if ($stmt->execute()) {
        echo "<script> alert('Successfully entered data');window.location.href='../html/v_collection.php';</script>";
    } else {
        echo "<script>window.location.href='../html/add_milk.php'; alert('.$stmt->error.');</script>";
    }

    // Close the statement and connection
    $stmt->close();
    $con->close();
}
?>