<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Society </title>
  <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="../assets/css/styles.min.css" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/themify-icons/0.1.0/css/themify-icons.min.css">

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
include("../databases/connection.php");
include("sidebar.php");
?> 
    <!--  Main wrapper -->
    <div class="body-wrapper">
      <!--  Header Start -->
      <?php  include("header.php"); ?>
  
              <div class="container-fluid">
          <div class="card">
          
          <div class="container table-container">
          <h2>Milk Records</h2>
<div class="d-flex justify-content-between align-items-center mb-3">
<div class="form-group">
    <form method="POST" action="" class="d-flex align-items-center">
        <div class="me-3">
            <label for="sortOptions">Sort By:</label>
            <select id="sortOptions" name="sort" class="form-control" onchange="this.form.submit()">
                <option disabled selected value>Sort By &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&darr;</option>
                <option value="name">Farmer Name</option>
                <option value="address">Farmer Address</option>
                <option value="date">Date</option>
            </select>
        </div>
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
            <option disabled selected value>Select date &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&darr;</option>
            <?php for ($d = 1; $d <= 31; $d++): ?>
                    <option value="<?php echo $d; ?>" <?php echo (isset($_POST['day']) && $_POST['day'] == $d) ? 'selected' : ''; ?>>
                        <?php echo $d; ?>
                    </option>
                <?php endfor; ?>
            </select>
        </div>

        <button class="btn btn-success" style="margin-left: 200px;" id="download-btn">Download CSV</button>
    </form>
</div>

<?php
$loca = $_SESSION['loc'];
// Default sorting option
$sortOption = 'name'; // Default sorting by name
if (isset($_POST['sort'])) {
    $sortOption = $_POST['sort'];
    error_log("Sort option: " . $sortOption); // Debugging line
}

// Determine the ORDER BY clause based on the selected sort option
$orderBy = "d.f_name"; // Default order by farmer name
if ($sortOption == 'address') {
    $orderBy = "d.f_homeaddress";
} elseif ($sortOption == 'date') {
    $orderBy = "m.t_date";
}

// Capture the month and day from the form
$selectedYear = isset($_POST['year']) ? $_POST['year'] : null; // Year input from user
$selectedMonth = isset($_POST['month']) ? $_POST['month'] : null; // Month input from user
$selectedDay = isset($_POST['day']) ? $_POST['day'] : null; // Day input from user

// Fetch records from the database with the dynamic ORDER BY clause
$sql = "SELECT m.fat, m.snf, m.reading, 
    m.a_ltr, m.amount, 
    m.message, m.m_id, m.f_id, m.milk_type, m.t_date, m.val_status, m.c_ltr, d.f_Id, d.f_homeaddress, d.f_name, d.location_society 
FROM tbl_milk_records m, tbl_dairyf d 
WHERE d.f_Id = m.f_id AND d.location_society = '$loca' AND m.val_status=1";

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
$sql .= " ORDER BY $orderBy ASC";

// Now you can execute the SQL query using your database connection



// Debugging line to check the final SQL query
error_log("SQL Query: " . $sql);

    $result = $con->query($sql);
    if ($result->num_rows > 0): ?>
        <div class="table-responsive">
        <table class="table table-striped table-bordered" id="data-table">
    <thead class="thead-dark">
        <tr>
            <th>S.No</th>
            <th>Farmer Name</th>
            <th>Farmer Address</th>
            <th>Milk Type</th>
            <th>Quantity (liters)</th>
            <th>Analyzer Readings </th>
            <th>Date</th>
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
    echo "<td>" . htmlspecialchars($row["f_name"]) . "</td>";
    echo "<td>" . htmlspecialchars($row["f_homeaddress"]) . "</td>";
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
    echo "<td>" . htmlspecialchars($row["t_date"]) . "</td>";
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
                  </form>
                </div>
              </div>
              </div></div></div></body>
              <script>
document.getElementById('download-btn').addEventListener('click', function() {
    let csv = [];
    const rows = document.querySelectorAll('#data-table tr');

    for (let i = 0; i < rows.length; i++) {
        const cols = rows[i].querySelectorAll('td, th');
        const rowData = [];
        for (let j = 0; j < cols.length; j++) { // Iterate through all columns
            // Get the text content of the cell
            let cellText = cols[j].innerText;

            // Escape double quotes by replacing " with ""
            cellText = cellText.replace(/₹/g, 'Rs');

            cellText = cellText.replace(/"/g, '""');

            // Wrap the cell text in double quotes
            rowData.push(`"${cellText}"`);
        }
        csv.push(rowData.join(',')); // Join columns with a comma
    }
    
    // Create a CSV file and trigger download
    const csvFile = new Blob([csv.join('\n')], { type: 'text/csv' });
    const tempLink = document.createElement('a');

    // Set the filename for the CSV file
    tempLink.download = `data_report_milk.csv`; // Filename for the downloaded file
    tempLink.href = URL.createObjectURL(csvFile);
    tempLink.style.display = 'none';
    document.body.appendChild(tempLink);
    tempLink.click(); // Trigger the download
    document.body.removeChild(tempLink); // Clean up
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