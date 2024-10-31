<!doctype html>
<html lang="en">
<?php

// session_start();
// if (!isset($_SESSION['a_Id'])) {
//   header('Location: fsignlogin.php');
//   exit;
// }

include("../databases/connection.php");


?>
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
        
          <div class="card">
            <div class="card-body">
              <h5 class="card-title fw-semibold mb-4">Validate Society</h5>
              <div class="table-responsive">
                  <table class="table text-nowrap mb-0 align-middle">
                    <thead class="text-dark fs-4">
                      <tr>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">S.Id</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Name</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Username</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Address</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Location</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Phone number</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Reject</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Delete</h6>
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                     <?php
                     $stmt = $con->prepare("SELECT s.s_Id, s.s_name, s.s_username, s.s_homeaddress, s.phone_no, 
           l.loc_name AS location_society, s.s_status 
    FROM tbl_society s
    JOIN tbl_location l ON s.location_society = l.loc_id 
    WHERE s.s_status = 1");
                     $stmt->execute();

                          // Get the result
                          $result = $stmt->get_result();
                     if ($result->num_rows > 0) {
                      $id = 1; // To keep track of the ID for display
                      while ($row = $result->fetch_assoc()) {
                          // Display each row in the table
                          echo '<tr>';
                          echo '<td class="border-bottom-0"><h6 class="fw-semibold mb-0">' . $id . '</h6></td>';
                          echo '<td class="border-bottom-0">';
                          echo '<h6 class="fw-semibold mb-1">' . htmlspecialchars($row['s_name']) . '</h6>';
                          echo '</td>';
                          echo '<td class="border-bottom-0"><p class="mb-0 fw-normal">'.htmlspecialchars($row['s_username']) . '</p></td>';
                          echo '<td class="border-bottom-0"><p class="mb-0 fw-normal">'.htmlspecialchars($row['s_homeaddress']) . '</p></td>';
                          echo '<td class="border-bottom-0"><h6 class="fw-semibold mb-0 fs-4">' . htmlspecialchars($row['location_society']) . '</h6></td>';
                          echo '<td class="border-bottom-0"><h6 class="fw-semibold mb-0 fs-4">' . htmlspecialchars($row['phone_no']) . '</h6></td>';
                          echo '<td class="border-bottom-0"><form method="POST" action="../databases/reject_user.php">';
                          echo '<input type="hidden" name="user_id" value="' . $row['s_Id'] . '">'; // Assuming you have an ID column
                          echo '<button type="submit" class="btn btn-dark">Reject</button>';
                          echo '</form></td>';
                          echo '<td class="border-bottom-0"><form method="POST" action="../databases/delete_society.php">';
                          echo '<input type="hidden" name="user_id" value="' . $row['s_Id'] . '">'; // Assuming you have an ID column
                          echo '<button type="submit" class="btn btn-danger">Delete</button>';
                          echo '</form></td>';
                          echo '</tr>';
                          $id++; // Increment the ID for the next row
                      }
                  } else {
                      echo '<tr><td colspan="7" class="text-center">No results found.</td></tr>';
                  }
                     ?>
                                      
                    </tbody>
                  </table>
                
                
                </div>
              
          </div>
        </div>
              
                    
                  </form>
                </div>
              </div>
              <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/sidebarmenu.js"></script>
  <script src="../assets/js/app.min.js"></script>
  <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
</body>

</html>