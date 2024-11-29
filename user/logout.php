<?php
session_start(); // Start the session

// Unset specific session variables
unset($_SESSION['loc']);
unset($_SESSION['f_Id']);

// Optionally, if you want to destroy the entire session
// session_destroy();

// Redirect to index.php
header("Location: ../../../user/index.php");
exit(); 
?>