<!doctype html>
<html lang="en">
<?php
include "../databases/connection.php";

?>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Modernize Free</title>
  <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="../assets/css/styles.min.css" />
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div
      class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
              <div class="card-body">
                <a href="./index.html" class="text-nowrap logo-img text-center d-block py-3 w-100">
                  <img src="../assets/images/logos/dark-logo.svg" width="180" alt="">
                </a>


                
                <p class="text-center">Society Register</p>
                <form method="post" action="../databases/register.php" id="signupForm">
                  <div class="mb-3">
                    <label for="exampleInputtext1" class="form-label">Name</label>
                    <input type="text" class="form-control" name="p1" id="exampleInputtext1" aria-describedby="textHelp">
                  </div>
                  <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">User Name</label>
                    <input type="email" class="form-control" name="p2" id="exampleInputEmail1" aria-describedby="emailHelp">
                  </div>
                  <div class="mb-4">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" class="form-control" name="p3" id="exampleInputPassword1">
                  </div>
                  <div class="mb-4">
                    <label for="exampleInputPassword2" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword2">
                    <mn id="message" style="font: size 20px; color:red;"></mn><br>
                  </div>
                  <div class="mb-4">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" class="form-control" name="p5" id="address">
                  </div>
                  <div class="mb-4">
                    <label for="phn" class="form-label">Phone Number</label>
                    <input type="text" class="form-control" name="p6" id="mobile">
                    <mn id="newl" style="font: size 20px; color:red;"></mn><br>

                  </div>
                  <div>
                  
                  <label for="location" class="form-label">Location</label>
<select class="form-control" id="location" name="p7">
  <option disabled selected value>---select an option---&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;▼</option>
  <?php  
  $sql = "SELECT loc_id,loc_name FROM tbl_location order by loc_name ASC ";  // Replace 'locations' with your table name and 'name' with your column name
  $result = mysqli_query($con,$sql);
  // Check if there are results
  if (mysqli_num_rows($result)>0) {
    // Fetch each row and display in the dropdown
    while ($row = mysqli_fetch_array($result)) {
      echo "<option value='" . $row["loc_id"] . "'>" . $row["loc_name"] . "</option>";
    }
  } else {
    echo "<option value=''>No locations found.</option>";
  }
  mysqli_close($con);
  ?>
  
</select>
<br><br>
<input type="submit" class="btn btn-primary" style="margin-left:100px;" value="Sign Up" name="Submit">
<br><br>
 <?php
                      if (isset($_GET['error'])) {
                        $error_message = htmlspecialchars($_GET['error']); // Sanitize the output
                        echo "<br><h3 style='color:red; font-size:20px; text-align:center;'>$error_message</h3><br>"; // Display the error message
                    }

                 ?>
                 
                  <div class="d-flex align-items-center justify-content-center">
                    <p class="fs-4 mb-0 fw-bold">Already have an Account?</p>
                    <a class="text-primary fw-bold ms-2" href="./authentication-login.php">Sign In</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
        document.getElementById('signupForm').addEventListener('submit', function(event) {
            var password = document.getElementById('exampleInputPassword1').value;
            var confirmPassword = document.getElementById('exampleInputPassword2').value;
            var message = document.getElementById('message');
            if (password !== confirmPassword) {
                event.preventDefault();
                message.textContent = "Passwords do not match!";
            }
        });
        
    // Function to validate the mobile number
    function validateMobileNumber() {
        var mobileInput = document.getElementById('mobile');
        var message = document.getElementById('newl');
        var pattern = /^[0-9]{10}$/; // Pattern for a 10-digit mobile number
        var submitBtn = document.getElementById('submitBtn'); // Get the submit button

        if (!pattern.test(mobileInput.value)) {
            message.textContent = "Please enter a valid mobile number (10 digits).";
            mobileInput.style.borderColor = "red"; // Highlight the input
            submitBtn.disabled = true; // Disable the submit button
            return false;
        } else {
            message.textContent = ""; // Clear the message if valid
            mobileInput.style.borderColor = ""; // Reset the border color
            submitBtn.disabled = false; // Enable the submit button
            return true;
        }
    }

    // Add event listener to the mobile input to validate on input
    document.getElementById('mobile').addEventListener('input', validateMobileNumber);

    // Optional: Validate the mobile number when the form is submitted
    document.getElementById('editForm').addEventListener('submit', function(event) {
        if (!validateMobileNumber()) {
            event.preventDefault(); // Prevent form submission if invalid
        }
    });
</script>

  
  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>