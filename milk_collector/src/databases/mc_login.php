<?php
include "connection.php";
session_start();

if (isset($_POST["sub"])) {
    $usr = $_POST["p1"];
    $pas = $_POST["p2"];

    // Prepare the SQL statement to prevent SQL injection
    $sqse = "SELECT  c_Id,c_username, c_password, c_status FROM tbl_collector WHERE c_username=? AND c_password=?";
    $stmt = $con->prepare($sqse);
    $stmt->bind_param("ss", $usr, $pas);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if any rows were returned
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc(); // Fetch the result as an associative array
        if ($row['c_status'] == 1) {
             $_SESSION['c_Id'] = $row['c_Id'];
            header("Location: ../index.php");
            exit();
        } else {
            header("Location: ../authentication-login.php?yes=1");
            exit();
        }
    } else {
        // No matching user found
        header("Location: ../authentication-login.php?error=1");
        exit();
    }

    // Close the prepared statement
    $stmt->close();
}

// Close the database connection
$con->close();
?>