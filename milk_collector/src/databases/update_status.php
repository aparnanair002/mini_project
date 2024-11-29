<?php
// Assuming you have already established a database connection in $con
include('connection.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $f_id = $_POST['f_id'];
    $checked = $_POST['checked'];

    // Update t_status in the database
    $status = ($checked == 1) ? 1 : 0; // Set t_status to 1 if checked, otherwise 0
    
    // Prepare the statement to update the status
    $stmt = $con->prepare("UPDATE tbl_todaysel SET t_status = ? WHERE t_id = ? AND t_date = CURDATE()");
    $stmt->bind_param("ii", $status, $f_id);
    if($stmt->execute()){
        echo "<script> alert('Status updated successfully!'); window.location.href='../html/add_milk.php'; </script>";
    }
    
    // Increment $today_house if the checkbox is checked
   

    // Close the statement
    $stmt->close();
    echo "Status updated successfully.";
}
?>