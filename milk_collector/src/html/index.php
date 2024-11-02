<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Diary_Direct</title>
  <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="../assets/css/styles.min.css" />
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <?php
session_start();
if (!isset($_SESSION['c_Id'])) {
  header('Location: authentication-login.php');
  exit;
}
include "../databases/connection.php";
include("sidebar.php");
?> 
    <!--  Main wrapper -->
    <div class="body-wrapper">
      <?php include('header.php');?>
      <!--  Header End -->
      <div class="container-fluid">
    <div class="row">
        
        <div class="col-lg-8">
            <div class="card w-100">
            <div class="card-body p-4">
            <div class="mb-4">
                <h3 class="card-title fw-semibold">Houses to Visit

           
            <button id="download-csv" style="margin-left: 450px;" class="btn btn-success">Download</button></h3>
             </div>
            <div class="table-responsive">
                <table class="table table-striped" id="data-table">
                    <thead>
                        <tr>
                            <th scope="col">To Do</th>
                            <th scope="col">Name</th>
                            <th scope="col">Address</th>
                            <th scope="col">Shift</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Assuming you have already established a database connection in $con
                       
                        // Fetch data from the database
                        $stmt = $con->prepare("SELECT f.f_Id, f.f_name, f.f_homeaddress, f.location_society,t.t_id, t.t_status, t.t_opt, t.t_date 
                                                FROM tbl_dairyf f, tbl_todaysel t 
                                                WHERE f.f_Id = t.f_Id AND t.t_date = CURDATE() AND f.location_society = ?
                                                ORDER BY t.t_status asc;");
                        $stmt->bind_param("s", $loca); // Bind the $loca variable as a string parameter
                        $stmt->execute();
                        $stmt->bind_result($f_id, $name, $address, $location_society, $tid,$status, $opt, $date);
                        $count=0;
                        // Loop through the results and create table rows
                        while ($stmt->fetch()) {
                          $shift = ($opt == 0) ? "Morning" : "Evening";
                          $checked = ($status == 1) ? "checked" : ""; // Checkbox state based on t_status
                          echo "<tr>";
                          echo "<td><input type='checkbox' style='width:20px;height: 20px;' class='house-checkbox' data-fid='$tid' $checked onchange='updateCheckbox(this)'></td>"; // Use $f_Id for the data attribute
                          echo "<td>" . htmlspecialchars($name) . "</td>";
                          echo "<td>" . htmlspecialchars($address) . "</td>";
                          echo "<td>" . htmlspecialchars($shift) . "</td>";
                          echo "</tr>";
                          if($status==1){
                          $count++; //to count total  number of unchecked houses
                        }
                        $dilan++; //to count total targets
                        }
                      
                        // Close the statement
                        $stmt->close();
                        ?>
                    </tbody>
                </table>
               
            </div>
        </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-start">
                        <div class="col-8">
                            <h4 class="fw-semibold mb-3"> Houses Visited:&nbsp; <?php echo htmlspecialchars($count);?></h4>
                            
                          
                            <h4 class="card-title mb-9 fw-semibold"><i class="ti ti-home fs-6"></i> Target:   <?php echo htmlspecialchars($dilan);?></h4>
                            <h4 class="card-title mb-9 fw-semibold"> <?php echo $dilan-$count?> &nbsp; more</h4>

                          </div>
                        <div class="col-4">
                            <div class="d-flex justify-content-end">
                                <div class="text-white bg-secondary rounded-circle p-6 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-home fs-6"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="earning"></div>
            </div>
        </div>

    </div>
</div>
<script>
function updateCheckbox(checkbox) {
    var fId = checkbox.getAttribute('data-fid');
    var checked = checkbox.checked ? 1 : 0; // 1 if checked, 0 if unchecked
   

    // Create an AJAX request
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../databases/update_status.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            console.log(xhr.responseText); // Handle response if necessary
        }
    };
    xhr.send("f_id=" + fId + "&checked=" + checked);
}

document.getElementById('download-csv').addEventListener('click', function() {
    let csv = [];
    const rows = document.querySelectorAll('#data-table tr');

    for (let i = 0; i < rows.length; i++) {
        const cols = rows[i].querySelectorAll('td, th');
        const rowData = [];
        for (let j = 0; j < cols.length; j++) {
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
    tempLink.download = `data_todaysmilk_${dateString}.csv`; // e.g., data_2023-10-10.csv
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
  <script src="../assets/libs/apexcharts/dist/apexcharts.min.js"></script>
  <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
  <script src="../assets/js/dashboard.js"></script>
</body>

</html>