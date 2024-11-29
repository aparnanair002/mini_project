<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Milk Collector </title>
  <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="../assets/css/styles.min.css" />
  <style>
  .dropdown {
    display: none;
    border: 1px solid #ccc;
    max-height: 150px;
    overflow-y: auto;
    position: absolute;
    background: white;
    z-index: 1000;
    width: calc(100% - 22px); /* Adjust width to match the input */
}

.dropdown div {
    padding: 8px;
    cursor: pointer;
}

.dropdown div:hover {
    background-color: #f0f0f0;
}
  .form-container {
    max-width: 300px;
    margin: 0 auto;
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.form-inline {
    display: flex;
    flex-direction: column;
}

.search-container {
    display: flex;
    align-items: center;
    width: 100%;
    margin-bottom: 20px;
}

#search-bar {
    flex: 1;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;

    margin-right: 10px;
}

.search-button {
    padding: 10px;
    background-color: #007bff;
    color: white;
    border: none;
    width:50px;
    height: 45px;
    border-radius: 4px;
    cursor: pointer;
}

.input-group {
    margin-bottom: 15px;
}

input[type="text"], select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

input[type="submit"] {
    background-color: #28a745;
    color: white;
    border: none;
    width:50%;
    margin-left: 120px;
    padding: 10px;
    border-radius: 4px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #218838;
    
}

select {
    cursor: pointer;
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
include('../databases/connection.php');
include("sidebar.php");
?> 
    <!--  Main wrapper -->
    <div class="body-wrapper">
      <!--  Header Start -->
        <?php include('header.php');?>
 
    
            <div class="container-fluid">
            <div class="row">
            <div class="col-lg-6">
    <div class="card bg-dark">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-5 text-center text-light">Milk of the Day</h5>
            
            <form action="../databases/add_milk.php" method="post" class="form-inline">
            <div class="input-group mb-5">
            <div id="selectedValueDisplay" style="color:white;font-size:20px;text-align:center;"></div>
            </div>
            
            <div class="search-container">




    
  <?php
if (isset($_SESSION['locat'])) {
  $loc_id = $_SESSION['locat'];

  // Prepare the SQL statement
  $sql = "SELECT f_Id, f_name, f_homeaddress FROM tbl_dairyf WHERE location_society=? AND f_status=1 ORDER BY f_homeaddress ASC";    
  $stmt = $con->prepare($sql);
  $stmt->bind_param("i", $loc_id); // Assuming loc_id is an integer

  // Execute the statement
  $stmt->execute();
  $result = $stmt->get_result();

  // Start the dropdown
  echo '<select name="fid" id="myDropdown" required>';
  echo '<option disabled selected value>---Select Address---</option>'; // Default option

  // Fetch and display the options
  while ($row = $result->fetch_assoc()) {
      // Use f_Id as the value and f_name and f_homeaddress as the display text
      echo '<option value="' . htmlspecialchars($row['f_Id']) . '" data-name="' . htmlspecialchars($row['f_name']) . '">' . htmlspecialchars($row['f_homeaddress']) . '</option>';
  }

  // Close the dropdown
  echo '</select>';

  // Close the statement
  $stmt->close();
} else {
  echo "Location ID not set in session.";
}

// Close the database connection
?></div> 
   
           

<br><br>



                <div class="input-group mb-5">
                <?php
// Assuming you have already started the session and connected to the database

if (isset($_SESSION['locat'])) {
    $loc_id = $_SESSION['locat'];

    // Prepare the SQL statement
    $sql = "SELECT type_name FROM tbl_milk_type WHERE loc_id = ?";
    $stn = $con->prepare($sql);
    $stn->bind_param("i", $loc_id); // Assuming loc_id is an integer

    // Execute the statement
    $stn->execute();
    $result = $stn->get_result();

    // Start the dropdown
    echo '<select name="milk_type" id="milkTypeDropdown" required onchange="storeMilkType()">';
    echo '<option disabled selected value>---Select Milk Type---</option>'; // Default option

    // Fetch and display the options
    while ($row = $result->fetch_assoc()) {
        echo '<option value="' . htmlspecialchars($row['type_name']) . '">' . htmlspecialchars($row['type_name']) . '</option>';
    }

    // Close the dropdown
    echo '</select>';

    // Close the statement
    $stn->close();
} else {
    echo "Location ID not set in session.";
}

// Close the database connection
$con->close();
?>



                </div><br><br>

                <div class="input-group" style="display: flex; align-items: center; width: 50%; margin: 0 auto;">
    <input type="text" name="quantity" placeholder="Quantity" required style="flex: 1; margin-right: 10px;">
    
    <select name="unit" required style="width: auto;">
        <option value="litre">Litre</option>
        <option value="millilitre">Millilitre</option>
    </select>
</div><br><br><br>
          
                <div class="input-group">
                    <input type="submit" name="sub" class="btn btn-primary" value="Submit">
                </div>
            </form>
        </div>
    </div>
</div>
   </div></div></div></div>
 
<script>


document.getElementById('myDropdown').addEventListener('change', function() {
    var selectedOption = this.options[this.selectedIndex]; // Get the selected option
    var selectedValue = this.value; // Get the selected option's value (f_Id)
    var farmerName = selectedOption.getAttribute('data-name'); // Get the farmer's name from data attribute

    // Display the selected value and farmer's name
    document.getElementById('selectedValueDisplay').innerHTML = ' Name: ' + farmerName ;
});

</script>  
</body>
</html>