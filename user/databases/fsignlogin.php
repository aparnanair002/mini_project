<?php
include "connection.php";
session_start();

if (isset($_POST["sub"])) {
    $usr = $_POST["p1"];
    $pas = $_POST["p2"];

    // Prepare the SQL statement to prevent SQL injection
    $sqse = "SELECT f_Id, f_username, f_password, f_status FROM tbl_dairyf WHERE f_username=? AND f_password=?";
    $stmt = $con->prepare($sqse);
    $stmt->bind_param("ss", $usr, $pas);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if any rows were returned
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc(); // Fetch the result as an associative array
        if ($row['f_status'] == 1) {
            $_SESSION['f_Id'] = $row['f_Id'];
            header("Location: ../fhome.php");
            exit();
        } else {
            header("Location: ../fsignlogin.php?yes=1");
            exit();
        }
    } else {
        // No matching user found
        header("Location: ../fsignlogin.php?error=1");
        exit();
    }

    // Close the prepared statement
    $stmt->close();
}

// Close the database connection
$con->close();
?>