<html>
 <head> 
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
        /* Style for the Sort By label */



.form-group {
    margin-bottom: 1rem; /* Adds space below the form group */
}

.d-flex {
    display: flex; /* Enables flexbox layout */
    flex-wrap: wrap; /* Allows items to wrap in case of small screens */
}

.align-items-center {
    align-items: center; /* Vertically centers the items */
}

.me-3 {
    margin-right: 1rem; /* Adds space between the elements */
}

.form-control {
    min-width: 150px; /* Minimum width for select elements */
    max-width: 200px; /* Maximum width for select elements */
}

.btn {
    margin-left: 1rem; /* Adds space to the left of the button */
}
    </style>
    
<?php
session_start();
if (!isset($_SESSION['f_Id'])) {
  header('Location: fsignlogin.php');
  exit;
}

include("headlogin.php");
include("./databases/connection.php");
?>   
 </head> 
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
                
                <div class="col-md-12 " style="background-color:#f8f9fa;color:#2d3f4e;">
                  <div class="detail-box mb-5 mt-5">
                    <h2 >
                      Dairy  Direct Report
                    </h2>
                  </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
<div class="form-group" >
    <form method="POST" action="" class="d-flex align-items-center">
       
        <div class="me-3">
        <label for="year">Select Year:</label>
        <select id="year" name="year" class="form-control" onchange="this.form.submit()">
            <option disabled selected value>Select year &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&darr;</option>
            <?php 
                // Define the range of years you want to display
                $currentYear = date("Y"); // Get the current year
                $startYear = $currentYear - 10; // Start from 10 years ago
                $endYear = $currentYear + 10; // End 10 years in the future
                
                for ($y = $startYear; $y <= $endYear; $y++): ?>
                    <option value="<?php echo $y; ?>" <?php echo (isset($_POST['year']) && $_POST['year'] == $y) ? 'selected' : ''; ?>>
                        <?php echo $y; ?>
                    </option>
            <?php endfor; ?>
        </select>
        </div>
        <div class="me-3">
            <label for="month">Select Month:</label>
            <select id="month" name="month" class="form-control" onchange="this.form.submit()">
            <option disabled selected value>Select month &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&darr;</option>
            <?php for ($m = 1; $m <= 12; $m++): ?>
                    <option value="<?php echo $m; ?>" <?php echo (isset($_POST['month']) && $_POST['month'] == $m) ? 'selected' : ''; ?>>
                        <?php echo date('F', mktime(0, 0, 0, $m, 1)); ?>
                    </option>
                <?php endfor; ?>
            </select>
        </div>

        <div class="me-3">
            <label for="day">Select Day:</label>
            <select id="day" name="day" class="form-control" onchange="this.form.submit()">
            <option disabled selected value>Select date </option>
            <?php for ($d = 1; $d <= 31; $d++): ?>
                    <option value="<?php echo $d; ?>" <?php echo (isset($_POST['day']) && $_POST['day'] == $d) ? 'selected' : ''; ?>>
                        <?php echo $d; ?>
                    </option>
                <?php endfor; ?>
            </select>
        </div>
        <div class="me-3">
    <label for="filter">Filter</label>
    <select id="filter" name="order" class="form-control" onchange="this.form.submit()">
    <option disabled selected value>Select Filter</option>
        <option value="asc" <?php echo (isset($_POST['order']) && $_POST['order'] == 'asc') ? 'selected' : ''; ?>>ASC</option>
        <option value="desc" <?php echo (isset($_POST['order']) && $_POST['order'] == 'desc') ? 'selected' : ''; ?>>DESC</option>
    </select>
        </div>
        <button class="btn btn-success mt-4" style="margin-left: 100px;" id="download-btn">Download CSV</button>
    </form>
</div>

<?php
$fid=$_SESSION['f_Id'];
// Default sorting option
// Capture the month and day from the form
// Capture the month and day from the form
$selectedYear = isset($_POST['year']) ? $_POST['year'] : null; // Year input from user
$selectedMonth = isset($_POST['month']) ? $_POST['month'] : null; // Month input from user
$selectedDay = isset($_POST['day']) ? $_POST['day'] : null; // Day input from user

// Check if 'order' is set in the POST request; default to 'ASC'
$order = isset($_POST['order']) ? $_POST['order'] : 'ASC'; // Default to ASC if not set

// Execute your query and fetch results as usual
// Fetch records from the database with the dynamic ORDER BY clause
$sql = "SELECT m.fat, m.snf, m.reading, 
    m.a_ltr, m.amount, 
    m.message, m.m_id, m.f_id, m.milk_type, m.t_date, m.val_status, m.c_ltr, d.f_Id, d.f_homeaddress, d.f_name, d.location_society 
FROM tbl_milk_records m, tbl_dairyf d 
WHERE d.f_Id = m.f_id AND d.f_Id=$fid";

// Add date filters based on user selection
if ($selectedMonth) {
    $sql .= " AND MONTH(m.t_date) = '$selectedMonth'"; // Filter by month
}

if ($selectedDay) {
    $sql .= " AND DAY(m.t_date) = '$selectedDay'"; // Filter by day
}

if ($selectedYear) {
    $sql .= " AND YEAR(m.t_date) = '$selectedYear'"; // Filter by year
}

// Complete the SQL query with ordering
$sql .= " ORDER BY m.t_date " . strtoupper($order); // Ensure it's in uppercase (ASC or DESC)

// Now you can execute the SQL query using your database connection
error_log("SQL Query: " . $sql);

    $result = $con->query($sql);
    if ($result->num_rows > 0): ?>
        <div class="table-responsive">
        <table class="table table-striped table-bordered" id="data-table">
    <thead class="thead-dark">
        <tr>
            <th>S.No</th>
            <th>Date</th>
            <th>Quantity (liters)</th>
            <th>Analyzer Readings </th>
            <th>Milk Type</th>

            <th>Amount</th>
            
          </tr>
    </thead>
    <tbody>
    <?php
$id = 1;
// Output data of each row
while ($row = $result->fetch_assoc()) {
    echo "<tr>"; // Start a new row for each record
    echo "<td>" . $id . "</td>";
    echo "<td>" . htmlspecialchars($row["t_date"]) . "</td>";
    echo "<td>" . htmlspecialchars($row["milk_type"]) . "</td>";

    // Prepare the quantity and analyzer readings
    $quantityAndReadings = '';
    if ($row["c_ltr"] == $row["a_ltr"]) {
        $quantityAndReadings = htmlspecialchars($row["c_ltr"]) . " ltr";
    } else {
        $quantityAndReadings = "Collected from home: " . htmlspecialchars($row["c_ltr"]) . " ltr, Reported in center: " . htmlspecialchars($row["a_ltr"]) . " ltr";
    }

    // Combine quantity and analyzer readings into a single column
    echo "<td>" . $quantityAndReadings . "</td>";
    echo "<td> Fat: " . htmlspecialchars($row["fat"]) . ", SNF: " . htmlspecialchars($row["snf"]) . ", Reading: " . htmlspecialchars($row["reading"]) . "</td>";
    echo "<td> ₹ " . htmlspecialchars($row["amount"]) . "</td>";
    echo "</tr>"; // Close the row

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
                      
                    
                    </div>
                  </div></form>
                </div>
                <!-- <div class="col-md-2">
                 <div class="img-box">
                    <img src="images/slider-img.png" alt="">
                  </div>
                </div> -->
              </div>
            </div>
            
    </section>
    <!-- end slider section -->
</body>
<script>
    document.getElementById('download-btn').addEventListener('click', function() {
        // Get the table element
        var table = document.getElementById('data-table');
        var csv = [];
        
        // Loop through each row of the table
        for (var i = 0; i < table.rows.length; i++) {
            var row = [];
            var cols = table.rows[i].querySelectorAll('td, th');
            
            // Loop through each cell of the row
            for (var j = 0; j < cols.length; j++) {
              var cellText = cols[j].innerText.replace(/₹/g, 'Rs');
              row.push(cellText);

            }
            csv.push(row.join(',')); // Join the cells with commas
        }

        // Create a CSV string
        var csvString = csv.join('\n');

        // Create a blob from the CSV string
        var blob = new Blob([csvString], { type: 'text/csv;charset=utf-8;' });
        var link = document.createElement("a");
        var url = URL.createObjectURL(blob);
        
        link.setAttribute("href", url);
        link.setAttribute("download", "milk_data_farmer.csv"); // Set the file name
        link.style.visibility = 'hidden';
        
        document.body.appendChild(link);
        link.click(); // Trigger the download
        document.body.removeChild(link); // Clean up
    });

</script>

</html>