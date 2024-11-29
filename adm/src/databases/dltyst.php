<?php
session_start(); // Start the session if not already started
include("connection.php");


if (isset($_POST['sub'])) {
    $loca = $_SESSION['locat'];

    // Prepare the SQL statement
    $stmt = $con->prepare("DELETE FROM tbl_todaysel WHERE f_Id IN (
        SELECT f_id
        FROM tbl_dairyf
        WHERE location_society = ? ) AND t_date != CURDATE();");

    // Bind the parameter
    $stmt->bind_param("s", $loca); // Assuming location_society is a string. Change "s" to "i" if it's an integer.

    // Execute the statement
    if ($stmt->execute()) {
        echo "<script>
                alert('Milk logs until yesterday deleted successfully.'); 
                window.location.href = '../html/report.php'; 
              </script>";
        exit;
    } else {
        echo "Error deleting user: " . $stmt->error; // Use $stmt->error for query errors
    }

    // Close the statement and connection
    $stmt->close();
    $con->close();
}
?>