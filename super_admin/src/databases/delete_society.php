<?php
include("../databases/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize user input to prevent SQL injection
    $user_id = intval($_POST['user_id']); // Assuming user_id is an integer

    // Prepare the SQL statement
    $stmt = $con->prepare("DELETE FROM tbl_society WHERE s_Id = ?;");
    
    // Bind the parameter
    $stmt->bind_param("i", $user_id);

    // Execute the statement
    if ($stmt->execute()) {
        echo "<script>
                alert('User  Deleted successfully.'); 
                window.location.href = '../html/view.php'; 
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