<?php
include "connection.php";

// Check if the connection was successful
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST["Submit"])) {
   
    $aid = $_POST["p2"];
    $lname = $_POST["p3"];

    // Check if the location name already exists
    $sqse = "SELECT loc_name FROM tbl_location WHERE loc_name='$lname'";
    $sel = mysqli_query($con, $sqse);

    if ($sel && $sel->num_rows == 0) {
        // Prepare the insert statement
        $sq = "INSERT INTO tbl_location (adm_id, loc_name) VALUES ('$aid', '$lname')";
        
        $result = mysqli_query($con, $sq);

        if ($result) {
            $message = "Admin added Successfully !!";
            header('Location: ../html/location_add.php?error=' . urlencode($message));
            exit();
        } else {
            $error_message = "Failed: " . $con->error;
            header('Location: ../html/location_add.php?error=' . urlencode($error_message));
            exit();
        }
    } else {
        $error_message = "Location name already exists.";
        header('Location: ../html/location_add.php?error=' . urlencode($error_message));
        exit();
    }

    // Close the connection
    mysqli_close($con);
}
?>