<?php
include("./connection.php"); 

if (isset($_POST['sub'])) {
    // Retrieve and sanitize form inputs
    $m_id = htmlspecialchars($_GET['id']); // Get m_id from the URL
    $fat = htmlspecialchars($_POST['fat']);
    $snf = htmlspecialchars($_POST['snf']);
    $reading = htmlspecialchars($_POST['reading']);
    $c_ltr = htmlspecialchars($_POST['c_ltr']);
    $a_ltr = htmlspecialchars($_POST['a_ltr']);
    $amount = htmlspecialchars($_POST['amount']);
    $feedback = isset($_POST['feedback']) ? htmlspecialchars($_POST['feedback']) : '';

    // Prepare an SQL statement to prevent SQL injection
    $stmt = $con->prepare("UPDATE tbl_milk_records SET fat=?, snf=?, reading=?, c_ltr=?, a_ltr=?, amount=?,message=?, val_status=1 WHERE m_id=?");
    $stmt->bind_param("ddddddsi", $fat, $snf, $reading, $c_ltr, $a_ltr, $amount,$feedback, $m_id);

    // Execute the statement for updating milk records
    if ($stmt->execute()) {
        // If feedback is provided, insert it into the feedback table
        echo "<script>alert('Milk details added successfully!'); window.location.href='../html/milk_edit.php';</script>";
    } else {
        echo "<script>alert('Error adding milk details: " . $stmt->error . "'); window.location.href='../html/add_milk_rec.php?id=$m_id';</script>";
    }

    // Close the main statement
    $stmt->close();
}

// Close the database connection
$con->close();
?>