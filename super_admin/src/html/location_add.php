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
    include('sidebar.php');
    ?>
     
    <!--  Main wrapper -->
    <div class="body-wrapper">
      <!--  Header Start -->
      <header class="app-header">
        <nav class="navbar navbar-expand-lg navbar-light">
          <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
              <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                <i class="ti ti-menu-2"></i>
              </a>
            </li>
            <!-- <li class="nav-item">
              <a class="nav-link nav-icon-hover" href="javascript:void(0)">
                <i class="ti ti-bell-ringing"></i>
                <div class="notification bg-primary rounded-circle"></div>
              </a>
            </li> -->
          </ul>
          <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
              <!-- <a href="https://adminmart.com/product/modernize-free-bootstrap-admin-dashboard/" target="_blank" class="btn btn-primary">Download Free</a> -->
              <li class="nav-item dropdown">
                <!-- <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <img src="../assets/images/profile/user-1.jpg" alt="" width="35" height="35" class="rounded-circle">
                </a> -->
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                  <div class="message-body">
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-user fs-6"></i>
                      <p class="mb-0 fs-3">My Profile</p>
                    </a>
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-mail fs-6"></i>
                      <p class="mb-0 fs-3">My Account</p>
                    </a>
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-list-check fs-6"></i>
                      <p class="mb-0 fs-3">My Task</p>
                    </a>
                    <a href="./authentication-login.html" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!--  Header End -->
      
              <div class="container-fluid">
        <div class="container-fluid">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title fw-semibold mb-4" style="margin-left:300px;margin-bottom:100px" required>Add Location</h5>
              
              <form action="../databases/location.php" method="post">

              <p style="size: 100px;">
<<<<<<< HEAD
        admin id:  <input type="text" id="admin id" name="p2" placeholder="Name Of Admin" style="margin-left:30px;margin-top:50px;width: 500px;height:50px" required>
        <br></p>

              <p style="size: 100px;">
        Location:  <input type="text" id=".
        location" name="p3" placeholder="Enter Location" style="margin-left:30px;margin-top:50px;width: 500px;height:50px" required>
=======
        Location:  <input type="text" id="location" name="p3" placeholder="Enter Location" style="margin-left:30px;margin-top:50px;width: 500px;height:50px" required>
>>>>>>> be827e788e99e03177736ff9ce6fe7034a2a03df
        <br><br></p>
                    
        

                    <input type="submit" class="btn btn-primary"style="margin-left:300px;" name="Submit"  required>
              </div>
              </div>
</form></div>

<div class="container-fluid">
        <div class="container-fluid">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title fw-semibold mb-4" style="margin-left:300px;margin-bottom:100px" required>View Location</h5>
              <table  class="table table-striped table-bordered" style="width: 1000px;">

        <tr>
            <th>Location ID</th>
            <th>Location Name</th>
            <th>Action</th>
        </tr>
        <?php
          include('../databases/connection.php');
        // Check connection
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }
        
        // Handle deletion
        if (isset($_GET['delete'])) {
            $loc_id = intval($_GET['delete']);
            $delete_query = "DELETE FROM tbl_location WHERE loc_id = $loc_id";
            $con->query($delete_query);
        }
        
        // Fetch all locations
        $sql = "SELECT loc_id,loc_name FROM tbl_location order by loc_name ASC";
        $result = $con->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['loc_id']}</td>
                        <td>{$row['loc_name']}</td>
                        <td><button class='btn btn-danger'><a href='?delete={$row['loc_id']}'  style='color:white;' onclick='return confirm(\"Are you sure you want to delete this location?\");'>Delete</a></button></td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No locations found</td></tr>";
        }
        ?>
    </table>
              </div>
          </div>


</div></body>
              
                    
                    

              <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/sidebarmenu.js"></script>
  <script src="../assets/js/app.min.js"></script>
  <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
</body>

</html>