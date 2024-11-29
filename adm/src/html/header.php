<header class="app-header">
        <nav class="navbar navbar-expand-lg navbar-light">
         
          <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
              <li class="nav-item dropdown">
          <?php
              $c_id = $_SESSION['s_Id'];
              $stmt = $con->prepare("SELECT s.s_name,m.loc_name FROM tbl_society s,tbl_location m WHERE m.loc_id=s.location_society and s.s_Id = ? ");
              $stmt->bind_param("i", $c_id); // Assuming c_id is an integer
          
              // Execute the statement
              $stmt->execute();
          
              // Bind the result
              $stmt->bind_result($c_name,$loc);
          
              // Fetch the result
              if ($stmt->fetch()) {
                  echo "<h3>Welcome  &nbsp; &nbsp;" . $c_name."  (&nbsp;&nbsp;Milk Society  &nbsp;$loc &nbsp;&nbsp;)</h3>";
              } else {
                  echo "No collector found with the given ID.";
              }
          
              // Close the statement
              $stmt->close();
              
              ?>
              
              </li>
            </ul>
          </div>
        </nav>
      </header>