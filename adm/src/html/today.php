<div class="container-fluid">
    <div class="row">
        
        <div class="col-lg-8">
            <div class="card w-100">
            <div class="card-body p-4">
            <div class="mb-4">
                <h3 class="card-title fw-semibold">Per House Report - <span id="tod"></span>

<script>
    // Create a new Date object
    const tod = new Date();

    // Format the date as mm/dd/yyyy
    const dd = String(tod.getDate()).padStart(2, '0');
    const mm = String(tod.getMonth() + 1).padStart(2, '0'); // January is 0!
    const yyyy = tod.getFullYear();

    // Set the innerHTML of the span to the formatted date
    document.getElementById("tod").innerHTML = `${mm}/${dd}/${yyyy}`;
</script>
           
            <button id="download-csv" style="margin-left:300px;" class="btn btn-success">Download</button></h3>
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
                       $loca=$_SESSION['loc'];
                        // Fetch data from the database
                        $stmt = $con->prepare("SELECT f.f_Id, f.f_name, f.f_homeaddress, f.location_society,t.t_id, t.t_status, t.t_opt, t.t_date 
                                                FROM tbl_dairyf f, tbl_todaysel t 
                                                WHERE f.f_Id = t.f_Id AND t.t_date = CURDATE() AND f.location_society = ?
                                                ORDER BY t.t_status asc;");
                        $stmt->bind_param("s", $loca); // Bind the $loca variable as a string parameter
                        $stmt->execute();
                        $stmt->bind_result($f_id, $name, $address, $location_society, $tid,$status, $opt, $date);
                        $count=0;
                        $dilan=0;
                        
                        // Loop through the results and create table rows
                        while ($stmt->fetch()) {
                          $shift = ($opt == 0) ? "Morning" : "Evening";
                          $checked = ($status == 1) ? "Visited" : "Not Visited"; // Checkbox state based on t_status
                          echo "<tr>";
                          echo "<td>".htmlspecialchars($checked)."</td>"; // Use $f_Id for the data attribute
                          echo "<td>" . htmlspecialchars($name) . "</td>";
                          echo "<td>" . htmlspecialchars($address) . "</td>";
                          echo "<td>" . htmlspecialchars($shift) . "</td>";
                          echo "</tr>";
                          if($status==1){
                          $count++; //to count total  number of unchecked houses
                        }
                        $dilan++; //to count total targets
                        }
                        echo "<tr></tr><tr></tr><tr>";
                        
                        // Close the statement
                        $stmt->close();
                    echo "</tbody><p style='color:black'>Total Houses Visited:$count<br><br>Total Houses logged:$dilan</p>"; ?>
                    
                   <br><br>
                </table>
               
            </div>
        </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body" style="background-image:url('../assets/images/backgrounds/pd.jpg')">
                    <div class="row align-items-start">
                        <div class="col-8">
                        <form id="deleteForm" method="post" action="../databases/dltyst.php" onsubmit="return confirmDelete()">
    <input type="submit" name="sub"  style="height: 50px;font-size:13px;" value="Delete Previous Days Milk Log records" class="btn btn-primary">
</form>

                        </div>
                        <div class="col-4">
                            <div class="d-flex justify-content-end">
                                <div class="text-white bg-primary rounded-circle p-6 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-trash fs-6"></i>
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
function confirmDelete() {
        return confirm("Do you really want to delete the data until yesterday?");
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
    tempLink.download = `data_Society_todaysmilk_${dateString}.csv`; // e.g., data_2023-10-10.csv
    tempLink.href = URL.createObjectURL(csvFile);
    tempLink.style.display = 'none';
    document.body.appendChild(tempLink);
    tempLink.click();
    document.body.removeChild(tempLink);
});

</script>