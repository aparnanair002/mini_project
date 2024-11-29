
<?php
session_start();
if (!isset($_SESSION['s_Id'])) {
    header('Location: authentication-login.php');
    exit;
}

include('connection.php'); // Include your database connection

// Check if 'id' is set in the URL
if (isset($_GET['id'])) {
    $m_id = intval($_GET['id']); // Convert to integer for safety

    // Prepare the delete statement
    $stmt = $con->prepare("Update tbl_milk_records set val_status=0 WHERE m_id = ?");
    $stmt->bind_param("i", $m_id);

    // Execute the statement
    if ($stmt->execute()) {
        // Record deleted successfully
        echo "<script>alert('Milk details on reset!'); window.location.href='../html/milk_edit.php';</script>";
    } else {
        // Error occurred
        echo "<script>alert('Error adding milk details: " . $stmt->error . "'); window.location.href='../html/milk_edit.php';</script>";
    }

    // Close the statement
    $stmt->close();
} else {
    echo "<script>alert('No ID provided.'); window.history.back();</script>";
}
?>