<?php
include "connection.php";

if (isset($_POST["Submit"])) {
    $nm = $_POST["p1"];
    $usr = $_POST["p2"];
    $pas = $_POST["p3"];
    $add = $_POST["p5"];
    $phn = $_POST["p6"];
    $location = $_POST["p7"];
   

    // Check if the username already exists
    $sqse = "SELECT c_username FROM tbl_collector WHERE c_username='$usr'";
    $sel = mysqli_query($con, $sqse);
    
    if ($sel && $sel->num_rows == 0) {
        // Prepare the insert statement
        $sq = "INSERT INTO tbl_collector (c_name, c_username, c_password, location_society, c_homeaddress, phone_no, status) 
                VALUES ('$nm', '$usr', '$pas', '$location','$add', '$phn', 0)";
        
        $result = mysqli_query($con, $sq);

        if ($result) {
            $message = "Milk Collector added Successfully !!";
            header('Location: ../html/authentication-register.php?error=' . urlencode($message));
            exit();
        } else {
            $error_message = "Failed: " . $con->error;
            header('Location: ../html/authentication-register.php?error=' . urlencode($error_message));
            exit();
        }
    } else {
        $error_message = "Username already exists.";
        header('Location: ../html/authentication-register.php?error=' . urlencode($error_message));
        exit();
    }

    mysqli_close($con);
}
?>