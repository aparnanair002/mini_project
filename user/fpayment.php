<html>
<?php
session_start();
if (!isset($_SESSION['f_Id'])) {
  header('Location: fsignlogin.php');
  exit;
}
include("./databases/connection.php");
include("headlogin.php");
?>    
<body>

  <div class="hero_area">

    <div class="hero_bg_box" style="background-color: #2D3f4e;">
      <!-- <div class="bg_img_box">
        <img src="images/hero-bg.png" alt="">
      </div> -->
    </div>

    <!-- header section strats -->
    <header class="header_section">
      <div class="container-fluid">
        <nav class="navbar navbar-expand-lg custom_nav-container ">
          <a class="navbar-brand" href="index.html">
            <img src="images/logo2.png" style="margin-left: 100px;" height="70px" width="70px">

            <span>
              &nbsp; Dairy Direct
            </span>
          </a>

          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class=""> </span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav  ">
          
              <li class="nav-item">
                <!-- <a class="nav-link" href="fsignlogin.php"> <i class="fa fa-user" aria-hidden="true"></i> &nbsp;Already have an account ? Login</a> -->
              </li>
             
            </ul>
          </div>
        </nav>
      </div>
    </header>
    <!-- end header section -->
 <!-- slider section -->
 <section class="slider_section " style="background-color: #2d3f4e;">
            <div class="container ">
                <div class="row">
                <div class="col-md-6">
                 <div class="img-box">
                    <img src="images/slider-img.png" alt="">
                  </div>
                </div>
                <div class="col-md-6 ">
                  <div class="detail-box" style="margin-bottom: 155px;">
                    <h1 >
                      Dairy  Direct
                    </h1>
                    <h2 style="color: white; font-family:Georgia, 'Times New Roman', Times, serif; margin-top: 30px;">
                      Payment details
                    </h2>
                    <div class="table-responsive">
                <table class="table table-striped bg-light" id="data-table">
                    <thead>
                        <tr>
                            
                            <th scope="col">Date Last paid</th>
                            <th scope="col">Amount</th>

                            <th scope="col">Paid till Now</th>
                            <th scope="col">to Pay</th>

                        </tr>
                       
                    </thead>
                    <tbody>
                    <?php
// Assuming you have already established a database connection in $con

$f_Id=$_SESSION['f_Id'];
// Fetch data from the database
$query = "SELECT * from tbl_payment where f_id=$f_Id";

$result = mysqli_query($con, $query);

if ($result) {
    $d = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                
                <td>{$row['date']}</td>
                <td>{$row['amount']}</td>
                 <td>{$row['paid']}</td>
                <td>{$row['rest']}</td>
               <td></tr>";    
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