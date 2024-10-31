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
    include('sidebar.php');
    ?>
      <!--  Main wrapper -->
      <div class="body-wrapper">
        <!--  Header Start -->
        <header class="app-header">
          <nav class="navbar navbar-expand-lg navbar-light">
            <ul class="navbar-nav">
              <li class="nav-item d-block d-xl-none">
                <!-- <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)"> -->
                  <i class="ti ti-menu-2"></i>
                </a>
              </li>
              <li class="nav-item">
                <!-- <a class="nav-link nav-icon-hover" href="javascript:void(0)"> -->
                  <!-- <i class="ti ti-bell-ringing"></i> -->
                  <!-- <div class="notification bg-primary rounded-circle"></div> -->
                </a>
              </li>
            </ul>
            <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
              <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                <!-- <a href="https://adminmart.com/product/modernize-free-bootstrap-admin-dashboard/" target="_blank" class="btn btn-primary">Download Free</a> -->
                <li class="nav-item dropdown">
                  <!-- <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown" -->
                    <!-- aria-expanded="false"> -->
                    <!-- <img src="../assets/images/profile/user-1.jpg" alt="" width="35" height="35" class="rounded-circle"> -->
                  </a>
                  <!-- <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
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
                  </div> -->
                </li>
              </ul>
            </div>
          </nav>
        </header>
        <!--  Header End -->
        <div class="container-fluid">
          <!--  Row 1 --
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
                        <option value="2">April 2023</option>
                        <option value="3">May 2023</option>
                        <option value="4">June 2023</option>
                      </select>
                    </div>
                  </div>
                  <div id="chart"></div>
                </div>
              </div>
            </div>-->
            <div class="col-lg-12" style="align-items: center;;">
      <div class="row">
          <div class="col-lg-12">
              <div class="container-fluid">
                  <div class="card">
                      <div class="card-body">
                          
  <?php
include('../databases/connection.php');

// Initialize search variable
$search = isset($_POST['search']) ? $_POST['search'] : '';

// Prepare the SQL statement with JOIN to get the admin usernames and their corresponding locations
$stmt = $con->prepare("
    SELECT a.s_Id, a.s_username, l.loc_name AS location
    FROM tbl_society a
    JOIN tbl_location l ON a.location_society = l.loc_id
    WHERE l.loc_name LIKE ?
    ORDER BY l.loc_name ASC
");

// Bind the search parameter
$search_param = "%" . $search . "%";
$stmt->bind_param("s", $search_param);

// Execute the statement
$stmt->execute();

// Get the result
$result = $stmt->get_result();
?>
<form id="milkprice1" method="post" action="">
    <h5 class="card-title fw-semibold mb-12">View Admin and Corresponding Location</h5><br><br>
    <div class="input-group mb-3" style="width: 500px;">
    <input type="text" name="search" class="form-control" placeholder="Search by Location" aria-label="Search" value="<?php echo htmlspecialchars($search); ?>">
    <button type="submit" class="btn btn-primary">
        <i class="ti ti-search"></i> <!-- Font Awesome Search Icon -->
    </button>
</div> <?php
    if ($result->num_rows > 0) {
        echo '<table class="table">';
        echo '<thead><tr><th>S.ID</th><th>Location</th><th>Username</th></tr></thead>';
        echo '<tbody>';
        $id=1;
        while ($row = $result->fetch_assoc()) {
            // Display each row in the table
            echo '<tr>';
            echo '<td class="border-bottom-0"><h6 class="fw-semibold mb-0">' . htmlspecialchars($id) . '</h6></td>';
            echo '<td class="border-bottom-0"><h6 class="fw-semibold mb-0">' . htmlspecialchars($row['location']) . '</h6></td>';
            echo '<td class="border-bottom-0"><h6 class="fw-semibold mb-1">' . htmlspecialchars($row['s_username']) . '</h6></td>';
            echo '</tr>';
            $id++;
        }
        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<tr><td colspan="3" class="text-center">No results found.</td></tr>';
    }
    ?>
</form>
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