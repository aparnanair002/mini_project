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
include('../databases/connection.php');
include("sidebar.php");
?>  
    <div class="body-wrapper">
      <!--  Header Start -->
     <?php include('header.php');?>
      <!--  Header End -->
      <div class="container-fluid">
        <!--  Row 1 -->
        <div class="row">
          <div class="col-lg-8 d-flex align-items-strech">
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
          </div>
          <div class="col-lg-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <form id="milkprice1" method="post" action="">
                            <h5 class="card-title fw-semibold mb-4">Today's Milk Price</h5>
                            <input type="text" name="p1" placeholder="Milk Price" style="font-size: 20px;"><br><br>
                            <button type="submit" class="btn btn-primary">Enter</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-12">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <form id="milkprice2" method="post" action="">
                            <h5 class="card-title fw-semibold mb-4">Add New Milk Type</h5>
                            <input type="text" name="p2" placeholder="Milk Type" style="font-size: 20px;"><br><br>
                            <button type="submit" class="btn btn-primary">Add</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <form id="milkprice2" method="post" action="">
                            <h5 class="card-title fw-semibold mb-4">Milk Sold Today</h5>
                            <input type="text" name="p2" placeholder="Milk Sold Today" style="font-size: 20px;"><br><br>
                            <button type="submit" class="btn btn-primary">Add</button>
                        </form>
                    </div>
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