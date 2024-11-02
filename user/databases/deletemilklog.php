<?php
session_start();
include("connection.php");

if (isset($_GET['id'])) {
    $tid = intval($_GET['id']); // Convert to integer to prevent SQL injection

    // Prepare and bind the SQL statement
    $stmt = $con->prepare("DELETE FROM tbl_todaysel WHERE t_id = ?");
    $stmt->bind_param("i", $tid); // 'i' indicates the type is integer

    // Execute the statement
    if ($stmt->execute()) {
        echo "<script>window.location.href='../fhome.php'; alert('Done Deleting this record!!');</script>";
    } else {
    echo "<script>window.location.href='../fhome.php'; alert('. $stmt->error.')</script>";
    }

    // Close the statement
    $stmt->close();
} else {
    echo "<script>window.location.href='../fhome.php'; alert('No ID');</script>";

}

// Close the connection
$con->close();
?>