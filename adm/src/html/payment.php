<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin-Diarydiary</title>
  <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="../assets/css/styles.min.css" />
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
    <?php
   session_start();
if (!isset($_SESSION['s_Id'])) {
  header('Location: authentication-login.php');
  exit;
}
include('../databases/connection.php');
include("sidebar.php");
    ?>
     
    <!--  Main wrapper -->
    <div class="body-wrapper">
      <!--  Header Start -->
        <?php include('header.php');?>
      <!--  Header End -->
      <div class="container-fluid">
    <div class="row">
        
        <div class="col-lg-12">
            <div class="card w-100">
            <div class="card-body p-4">
            <div class="mb-4">
                <h3 class="card-title fw-semibold">Payment Report <span id="tod"></span>


            <button id="download-csv" style="margin-left:800px;" class="btn btn-success">Download</button></h3>
             </div>
            <div class="table-responsive">
                <table class="table table-striped" id="data-table">
                    <thead>
                        <tr>
                            <th scope="col">S.No  </th>
                            <th scope="col">Total Amount</th>
                            <th scope="col">Farmer Name</th>
                            <th scope="col">Home Address</th>
                            <th scope="col">To pay</th>

                            <th scope="col">Message</th>
                            <th scope="col">details</th>

                        </tr>
                       
                    </thead>
                    <tbody>
                    <?php
// Assuming you have already established a database connection in $con
$loca = $_SESSION['loc'];
// Fetch data from the database
$query = "SELECT SUM(m.amount) AS total_amount, d.f_id, d.f_name, d.f_homeaddress 
          FROM tbl_milk_records m 
          JOIN tbl_dairyf d ON m.f_id = d.f_Id 
          WHERE m.val_status = 1 and d.location_society = $loca
          GROUP BY d.f_id, d.f_name, d.f_homeaddress";

$result = mysqli_query($con, $query);

if ($result) {
    $d = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>$d</td>
                <td>{$row['total_amount']}</td>
                <td>{$row['f_name']}</td>
                <td>{$row['f_homeaddress']}</td>
               <td>";
        
        // Insert into payment table
        $f_id = $row['f_id'];
        $amount = $row['total_amount'];
       
        
        $query = "SELECT rest FROM tbl_payment WHERE f_id = '$f_id'";
        $res = mysqli_query($con, $query);
        while ($prow = mysqli_fetch_assoc($res)) {
            $rest= $prow['rest'];
        }
        echo"$rest</td>;
               <td>";
        if (!$res) {
            // Handle query error
            echo "Error checking payment record: " . mysqli_error($con);
        } elseif (mysqli_num_rows($res) > 0) {
            // Record exists, perform an update
            $update_query = "UPDATE tbl_payment 
                             SET amount = '$amount'
                               
                             WHERE f_id = '$f_id'";
            
            if (!mysqli_query($con, $update_query)) {
                echo "Error updating payment record: " . mysqli_error($con);
            } else {
                echo "Payment record updated successfully.";
            }
        } else {
            // Record does not exist, perform an insert
            $insert_query = "INSERT INTO tbl_payment (f_id, date, amount, paid, rest) 
                             VALUES ('$f_id', CURDATE(), '$amount', 0,'$amount')";
            
            if (!mysqli_query($con, $insert_query)) {
                echo "Error inserting payment record: " . mysqli_error($con);
            } else {
                echo "Payment record inserted successfully.";
            }
        }
        
        // Output the update link
       
       
        echo "</td><td><a href='./updatepayment.php?id=$f_id' class='btn btn-primary'>Details</a>";
        echo "</td></tr>";
        
        $d++;
        
        
        }
    echo "</tbody></table>";}
        
         else {
            echo "Error: " . mysqli_error($con);
        }
    $con->close();

?>             
                   <br><br>
                </table>
               
            </div>
        </div>
            </div>
        </div>
       
    </div>
</div>
<script>

document.getElementById('download-csv').addEventListener('click', function() {
    let csv = [];
    const rows = document.querySelectorAll('#data-table tr');

    for (let i = 0; i < rows.length; i++) {
        const cols = rows[i].querySelectorAll('td, th');
        const rowData = [];
        for (let j = 0; j < cols.length-2; j++) {
          if (cols[j].querySelector('input[type="checkbox"]')) {
                // If the checkbox is checked, add "Checked", otherwise add "Unchecked"
                const checkbox = cols[j].querySelector('input[type="checkbox"]');
                rowData.push(`"${checkbox.checked ? 'Visited' : 'Not Visited'}"`);
            } else {
                // Get the text content of the cell
                let cellText = cols[j].innerText;

                // Escape double quotes by replacing " with ""
                cellText = cellText.replace(/"/g, '""');

                // Wrap the cell text in double quotes
                rowData.push(`"${cellText}"`);
            }
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
    tempLink.download = `payment_report_${dateString}.csv`; // e.g., data_2023-10-10.csv
    tempLink.href = URL.createObjectURL(csvFile);
    tempLink.style.display = 'none';
    document.body.appendChild(tempLink);
    tempLink.click();
    document.body.removeChild(tempLink);
});


</script>

              <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/sidebarmenu.js"></script>
  <script src="../assets/js/app.min.js"></script>
  <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
</body>

</html>