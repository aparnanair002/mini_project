<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Milk Collector </title>
  <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="../assets/css/styles.min.css" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

  <style>
        body {
            background-color: #f8f9fa;
        }
        .table-container {
            margin: 20px;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h2 {
            margin-bottom: 20px;
        }
        .btn-edit {
            color: #007bff;
            text-decoration: none;
        }
        .btn-edit:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
    <?php
session_start();
if (!isset($_SESSION['c_Id'])) {
  header('Location: authentication-login.php');
  exit;
}
include("../databases/connection.php");
include("sidebar.php");
?> 
    <!--  Main wrapper -->
    <div class="body-wrapper">
      <!--  Header Start -->
      <?php  include("header.php"); ?>
  
              <div class="container-fluid">
          <div class="card">
            
              <?php
 // Include your database connection

$loca = $_SESSION['locat'];

// Fetch records from the database
$sql = "SELECT m.m_id, m.f_id, m.milk_type, m.t_date, m.c_ltr, d.f_Id, d.f_homeaddress, d.f_name, d.location_society 
FROM tbl_milk_records m, tbl_dairyf d WHERE d.f_Id = m.f_id AND d.location_society = '$loca' and m.t_date=CURDATE();";

$result = $con->query($sql);
?>

<div class="container table-container">
    <h2>Milk Records Today
    <button class="btn btn-success" id="download-btn" style="margin-left: 650px;">Download CSV</button></h2>
    <?php if ($result->num_rows > 0): ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="data-table">
                <thead class="thead-dark">
                    <tr>
                        <th>S.No</th>
                        <th>Farmer Name</th>
                        <th>Farmer Address</th>
                        <th>Milk Type</th>
                        <th>Quantity (liters)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $id = 1;
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo "
                               <tr>
                                <td>" . $id . "</td>
                                <td>" . htmlspecialchars($row["f_name"]) . "</td>
                                <td>" . htmlspecialchars($row["f_homeaddress"]) . "</td>
                                <td>" . htmlspecialchars($row["milk_type"]) . "</td>
                                <td>" . htmlspecialchars($row["c_ltr"]) . "</td>
                                
                              </tr>";
                        $id++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="alert alert-warning">No records found.</p>
    <?php endif; ?>

</div>

<?php
// Close the connection
$con->close();
?>
                  </form>
                </div>
              </div>
              </div></div></div></body>
<script>document.getElementById('download-btn').addEventListener('click', function() {
    let csv = [];
    const rows = document.querySelectorAll('#data-table tr');

    for (let i = 0; i < rows.length; i++) {
        const cols = rows[i].querySelectorAll('td, th');
        const rowData = [];
        for (let j = 0; j < cols.length - 1; j++) {
            // Get the text content of the cell
            let cellText = cols[j].innerText;

            // Escape double quotes by replacing " with ""
            cellText = cellText.replace(/"/g, '""');

            // Wrap the cell text in double quotes
            rowData.push(`"${cellText}"`);
        }
        csv.push(rowData.join(','));
    }
    // Create a CSV file and trigger download
    const csvFile = new Blob([csv.join('\n')], { type: 'text/csv' });
    const tempLink = document.createElement('a');
    
    // Get today's date in YYYY-MM-DD format
    const today = new Date();
    const dateString = today.toISOString().split('T')[0]; // Format: YYYY-MM-DD

    // Set the filename with today's date
    tempLink.download = `data_todays_milk_${dateString}.csv`; // e.g., data_2023-10-10.csv
    tempLink.href = URL.createObjectURL(csvFile);
    tempLink.style.display = 'none';
    document.body.appendChild(tempLink);
    tempLink.click();
    document.body.removeChild(tempLink);
});
</script>           
                    
              <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/sidebarmenu.js"></script>
  <script src="../assets/js/app.min.js"></script>
  <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
</body>

</html>