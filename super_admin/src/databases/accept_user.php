<?php
include("../databases/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];

    // Prepare and bind the SQL statement to update the status
    $stmt = $con->prepare("UPDATE tbl_dairyf SET f_status = 1 WHERE f_Id = ?");
    $stmt->bind_param("i", $user_id);

    // Execute the statement
    if ($stmt->execute()) {
       
        echo "<script>
        window.location.href = '../html/validate.php'; // Redirect to validate.php
                alert('User  accepted successfully.'); // Optional: alert message
                
              </script>";
        exit;
    } else {
        echo "Error accepting user: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $con->close();

    // Redirect back to the previous page (optional)
   
}
?>