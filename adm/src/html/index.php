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
if (!isset($_SESSION['s_Id'])) {
  header('Location: authentication-login.php');
  exit;
}
$loca=$_SESSION['loc'];
include('../databases/connection.php');
include("sidebar.php");
?>  
    <div class="body-wrapper">
      <!--  Header Start -->
     <?php include('header.php');?>
      <!--  Header End -->
      <div class="container-fluid">
          <div class="container-fluid">
    <div class="row">
        <!-- Column for Adding New Milk Type -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <form id="milkprice2" method="post" action="../databases/addmilktype.php">
                        <h5 class="card-title fw-semibold mb-4">Add New Milk Type</h5>
                        <input type="text" name="p2" placeholder="Milk Type" style="font-size: 20px;" required><br><br>
                        <input type="submit" class="btn btn-primary" value="Add" name="sub">
                    </form>
                    <h5 class="mt-4">Available Milk Types</h5>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>S.no</th>
                                <th>Milk Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sno = 1;
                            // Fetch available milk types
                            $result = $con->query("SELECT type_id, type_name,loc_id FROM tbl_milk_type where loc_id=$loca");

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $sno . "</td>";
                                    echo "<td>" . htmlspecialchars($row['type_name']) . "</td>";
                                    echo "<td><a href='?delete=" . $row['type_id'] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this milk type?\");'>Delete</a></td>";
                                    echo "</tr>";
                                    $sno++;
                                }
                            } else {
                                echo "<tr><td colspan='3'>No milk types available.</td></tr>";
                            }

                            if (isset($_GET['delete'])) {
                                $milkId = intval($_GET['delete']);
                                $deleteStmt = $con->prepare("DELETE FROM tbl_milk_type WHERE type_id = ?");
                                $deleteStmt->bind_param("i", $milkId);

                                if ($deleteStmt->execute()) {
                                    echo "<div class='alert alert-success'>Milk type deleted successfully! Refresh the tab!</div>";
                                } else {
                                    echo "<div class='alert alert-danger'>Error: " . $deleteStmt->error . "</div>";
                                }

                                $deleteStmt->close();
                            }
                            
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Column for Milk Sold Today -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <form id="milkprice2" method="post" action="">
                        <h5 class="card-title fw-semibold mb-4">Milk Stock Today</h5>
                        <?php
$rsql = "SELECT SUM(m.a_ltr) AS collected_milk, val_status
          FROM tbl_milk_records m
          JOIN tbl_dairyf d ON m.f_id = d.f_Id
          WHERE m.t_date = CURDATE() AND d.location_society = ? AND val_status = 1";

$stmt = $con->prepare($rsql);
if (!$stmt) {
    die("Database query preparation failed: " . $con->error);
}

$stmt->bind_param("i", $loca); // Assuming $loca is an integer
$stmt->execute();
$rresult = $stmt->get_result();

if ($row = $rresult->fetch_assoc()) {
    $totalLiters = $row['collected_milk'];

    if (is_null($totalLiters)) {
        echo "<b>No milk collected today for this location.<br></b>";
    } else {
        echo "<b>Total Collected Milk: <p style='font-size:50px;'>" . number_format($totalLiters, 2) . " ltrs<br></b></p>";

        $checkSql = "SELECT * FROM tbl_stock WHERE loc_id = ? AND stock_date = CURDATE()";
        $checkStmt = $con->prepare($checkSql);
        if (!$checkStmt) {
            die("Check query preparation failed: " . $con->error);
        }

        $checkStmt->bind_param("i", $loca);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();
        
        if ($checkResult->num_rows > 0) {
            
            $updateSql = "UPDATE tbl_stock 
            SET collected_milk = $totalLiters, 
                milk_sold = collected_milk - milk_sold
            WHERE loc_id = $loca AND stock_date = CURDATE()";

            if ($con->query($updateSql) === TRUE) {
            echo "Stock updated successfully.<br>";
            } else {
            echo "Error updating stock: " . $con->error;
            }

          
        } else {
            // No entry exists, perform an insert
            $insertSql = "INSERT INTO tbl_stock (loc_id, stock_date, collected_milk, milk_sold) 
            VALUES ($loca, CURDATE(), $totalLiters, 0)";

                    if ($con->query($insertSql) === TRUE) {
                    echo "Stock inserted successfully.<br>";
                    } else {
                    echo "Error inserting stock: " . $con->error;
                    }
                }

        $checkStmt->close();
    }
} else {
    echo "No records found for the specified location and date.<br>";
}

$stmt->close();
?>

<!-- Form for entering sold liters -->
<form method="post" action="">
    <label for="sold_liters" class="mt-5">Enter Sold Liters:</label>
    <input type="number" step=0.1  name="sold_liters" id="sold_liters" required>
    <input type="submit" class="btn btn-primary mt-5" value="Update Sold Liters">
</form><?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input for sold liters
    if (isset($_POST['sold_liters'])) {
        $soldLiters = filter_var($_POST['sold_liters'], FILTER_VALIDATE_FLOAT);

        // Check if the input is valid
        if ($soldLiters === false || $soldLiters < 0) {
            echo "Please enter a valid number of sold liters.";
        } else {
            // Prepare SQL statement to check current milk sold
            $checkSoldSql = "SELECT collected_milk, milk_sold FROM tbl_stock WHERE loc_id = ? AND stock_date = CURDATE()";
            $checkSoldStmt = $con->prepare($checkSoldSql);
            $checkSoldStmt->bind_param("i", $loca);
            $checkSoldStmt->execute();
            $checkSoldResult = $checkSoldStmt->get_result();

            // Fetch the results
            if ($checkSoldRow = $checkSoldResult->fetch_assoc()) {
                $collectedMilk = $checkSoldRow['collected_milk'];
                $currentMilkSold = $checkSoldRow['milk_sold'];
                $blup=$currentMilkSold + $soldLiters;
                $pew=$collectedMilk-$blup;

                // Check if the new sold liters would exceed the collected milk
                if (($blup) > $collectedMilk) {
                    echo "Error: Total sold liters cannot exceed the collected milk.";
                } else {
                    $updateSql = "UPDATE tbl_stock SET milk_sold = $blup WHERE loc_id = $loca AND stock_date = CURDATE()";

                            // Execute the query directly
                            if ($con->query($updateSql) === TRUE) {
                                echo "<br><center><b>Total Sold liters Today:<p style='font-size:20px;'>" . number_format($blup, 2) . " ltrs<br></b></p>";
                                echo "<b>Total to Sell:<p style='font-size:20px;'>" . number_format($pew, 2) . " ltrs<br></b></p></center>
                                ";

                            } else {
                                echo "Error updating sold liters: " . $con->error;
                            }
                                                
                }
            }

            echo "<script>
            setTimeout(function() {
                window.location.href='./index.php';
            }, 10000); // 10000 milliseconds = 10 seconds
          </script>";            // Close the check statement
            $checkSoldStmt->close();
        }
    }
    // Close the database connection outside of the condition
    $con->close();
}
?>


                </div>
            </div>
        </div>
    </div></div></div></div></div>

             
    
  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/sidebarmenu.js"></script>
  <script src="../assets/js/app.min.js"></script>
  <script src="../assets/libs/apexcharts/dist/apexcharts.min.js"></script>
  <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
  <script src="../assets/js/dashboard.js"></script>
</body>

</html>