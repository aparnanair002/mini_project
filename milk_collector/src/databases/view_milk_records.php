<?php
session_start();
$loca=$_SESSION['locat'];
include 'connection.php'; // Include your database connection

// Fetch records from the database
$sql = "SELECT m.f_id, m.milk_type, m.t_date, m.c_ltr,d.f_Id,d.f_homeaddress,d.f_name,d.location_society 
FROM tbl_milk_records m,tbl_dairyf d where d.f_Id=f.f_id and  d.location_society='$loca'";

$result = $con->query($sql);

if ($result->num_rows > 0) {
   echo" <div class='table-responsive'>";
   echo" <table class='table table-striped' id='data-table'>";
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Farmer Name</th>
                <th>Farmer Address</th>
                <th>Milk Type</th>
                <th>Date</th>
                <th>Quantity (liters)</th>
                <th>Action</th>
            </tr>";

    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $id . "</td>
                <td>" . $row["f_name"] . "</td>
                <td>" . $row["f_homeaddress"] . "</td>
                <td>" . $row["milk_type"] . "</td>
                <td>" . $row["t_date"] . "</td>
                <td>" . $row["c_ltr"] . "</td>
                <td>
                    <a href='edit_milk_record.php?id=" . $row["m_id"] . "'>Edit</a>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

// Close the connection
$con->close();
?>