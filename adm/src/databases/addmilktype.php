<?php
session_start();
$loca = isset($_SESSION['loc']) ? $_SESSION['loc'] : null; // Check if session variable is set
include('connection.php');

if (isset($_POST["sub"])) {
    // Get the milk type from the form
    $milkType = $_POST['p2'];

    // Validate input
    if (!empty($milkType) && $loca !== null) { // Ensure loca is not null
        // Prepare the SQL statement
        $stmt = $con->prepare("INSERT INTO tbl_milk_type (type_name, loc_id) VALUES (?, ?)");

        // Check if the statement was prepared successfully
        if ($stmt) {
            // Bind parameters: "si" means string and integer
            $stmt->bind_param("si", $milkType, $loca); // Assuming loc_id is an integer

            // Execute the statement
            if ($stmt->execute()) {
                echo "<script>
                    alert('Milk type added successfully.'); // Alert message
                    window.location.href = '../html/index.php'; // Redirect to index.php
                </script>";
            } else {
                echo "<script>
                    alert('Error: " . $stmt->error . "'); // Alert message with error
                    window.location.href = '../html/Mcollector_validate.php'; // Redirect to validate.php
                </script>";
            }

            // Close the statement
            $stmt->close();
        } else {
            echo "<script>
                alert('Failed to prepare statement.'); // Alert message
                window.location.href = '../html/Mcollector_validate.php'; // Redirect to validate.php
            </script>";
        }
    } else {
        echo "<script>
            alert('Milk type cannot be null or location ID is invalid.'); // Alert message
            window.location.href = '../html/index.php'; // Redirect to index.php
        </script>";
    }
}

// Close the connection
$con->close();
?>