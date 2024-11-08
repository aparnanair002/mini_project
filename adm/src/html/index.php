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
        <!--  Row 1 --
        <div class="row">
          <div class="col-lg-6 d-flex align-items-strech">
            <div class="card w-100">
              <div class="card-body">
                <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                  <div class="mb-3 mb-sm-0">
                    <h5 class="card-title fw-semibold">Sales Overview</h5>
                  </div>
                  <div>
                    <select class="form-select">
                      <option value="1">March 2023</option>
                      <option value="2">April 2
                        
                      </option>
                      <option value="3">May 2023</option>
                      <option value="4">June 2023</option>
                    </select>
                  </div>
                </div>
                <div id="chart"></div>
              </div>
            </div>
          </div>-->
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
                            $con->close();
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
                        <h5 class="card-title fw-semibold mb-4">Milk Sold Today</h5>
                        <input type="text" name="p2" placeholder="Milk Sold Today" style="font-size: 20px;" required><br><br>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
             
    
  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/sidebarmenu.js"></script>
  <script src="../assets/js/app.min.js"></script>
  <script src="../assets/libs/apexcharts/dist/apexcharts.min.js"></script>
  <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
  <script src="../assets/js/dashboard.js"></script>
</body>

</html>