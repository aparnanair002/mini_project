<!--  Header Start -->
<header class="app-header">
        <nav class="navbar navbar-expand-lg navbar-light">
          <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
              <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                <i class="ti ti-menu-2"></i>
              </a>
            </li>
            
          </ul>
          <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
              <?php
              $dilan=0;

              $c_id = $_SESSION['c_Id'];
              $loca = $_SESSION['locat'];
                        
              $stmt = $con->prepare("SELECT c_name FROM tbl_collector WHERE c_id = ?");
              $stmt->bind_param("i", $c_id); // Assuming c_id is an integer
          
              // Execute the statement
              $stmt->execute();
          
              // Bind the result
              $stmt->bind_result($c_name);
          
              // Fetch the result
              if ($stmt->fetch()) {
                  echo "<h3>Welcome  &nbsp;" . $c_name." !!</h3>";
              } else {
                  echo "No collector found with the given ID.";
              }
          
              // Close the statement
              $stmt->close();
              
              ?>
             </ul>
          </div>
        </nav>
      </header>