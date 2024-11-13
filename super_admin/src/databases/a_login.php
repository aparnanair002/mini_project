<?php
include "connection.php";
session_start();

if (isset($_POST["sub"])) {
    $usr = $_POST["p1"];
    $pas = $_POST["p2"];

    // Prepare the SQL statement to prevent SQL injection
    $sqse = "SELECT a_id, a_username, a_password FROM tbl_admin_super WHERE a_username=?  AND a_password=?";
    $stmt = $con->prepare($sqse);
    $stmt->bind_param("ss", $usr, $pas);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if any rows were returned
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc(); // Fetch the result as an associative array
        
        // Verify the password
       
           
                $_SESSION['a_Id'] = $row['a_Id'];
                
                header("Location: ../html/index.php");
                exit();
           
    } else {
        // No matching user found
        header("Location: ../html/authentication-login.php?error=user_not_found");
        exit();
    }

    // Close the prepared statement
    $stmt->close();
}

// Close the database connection
$con->close();
?>