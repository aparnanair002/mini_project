
<html>
<?php

include("headlogin.php")
?>    

<body>
  <div class="hero_area">

    <div class="hero_bg_box" style="background-color: #2D3f4e;">
      <!-- <div class="bg_img_box">
        <img src="images/hero-bg.png" alt="">
      </div> -->
    </div>

    <!-- header section strats -->
    <header class="header_section">
      <div class="container-fluid">
        <nav class="navbar navbar-expand-lg custom_nav-container ">
          <a class="navbar-brand" href="index.html">
            <img src="images/logo2.png" style="margin-left: 100px;" height="70px" width="70px">

            <span>
              &nbsp; Dairy Direct
            </span>
          </a>

          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class=""> </span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav  ">
          
              <li class="nav-item">
                <a class="nav-link" href="fsignlogin.php"> <i class="fa fa-user" aria-hidden="true"></i> &nbsp;Already have an account ? Login</a>
              </li>
             
            </ul>
          </div>
        </nav>
      </div>
    </header>
    <!-- end header section -->
 <!-- slider section -->
 <section class="slider_section " style="background-color: #2d3f4e;">
            <div class="container ">
                <div class="row">
                <div class="col-md-5" >
                 <div class="img-box" style="align-items:start;">
                    <img src="images/slider-img.png" alt="">

                  </div>
                  <img src="images/tram.png" alt="" height="500px">

                </div>
                <div class="col-md-7 ">
                  <div class="detail-box" style="margin-bottom: 155px;">
                    <h1 >
                      Dairy  Direct
                    </h1>
                    <h2 style="color: white; font-family:Georgia, 'Times New Roman', Times, serif; margin-top: 30px;">
                      Sign Up<br>
                    </h2>
                    <?php
                      if (isset($_GET['error'])) {
                          echo "<br><h3 style='color:red; text-size:3px'>Sign In Please... username exists !!</h3><br>";
                      }
                    
                 ?>
                 
                    <form id=signupForm action="databases/fsignup.php" method="post">
                    <p style="size: 50px;">Name   :<input type="text" name="p1" placeholder="Your Name" style="margin-left:55px;" required><br>
                    Username :<input type="text" name="p2" placeholder="Your Email" required><br>
                    Password :<input type="password" name="p3" id="p3" style="margin-left:25px;" placeholder="Password" required><br>
                    Confirm :<input type="password" name="conp3" id="conp3" placeholder="Confirm password" style="margin-left: 35px;">
                    <mn id="message" style="font: size 20px; color:red;"></mn><br>
                    Address :<input type="text" name="p4" style="margin-left:35px;" placeholder="Address" required><br>
                    Phone no :<input type="text" name="p5" id="mobile" placeholder="Phone Number" oninput="return validateMobileNumber()"><br>
                    
                    <mn id="newl" style="font: size 20px; color:red;"></mn><br>
                    Location :
                    <select name="p6" id="p6" style="width: 450px; height:50px; margin-left:20px;">
                    <?php  
                    include "databases/connection.php";
                    $sql = "SELECT loc_name FROM tbl_location order by loc_name ASC ";  // Replace 'locations' with your table name and 'name' with your column name
                    $result = mysqli_query($con,$sql);
                    echo "<option disabled selected value>---select an option---</option>";
                    // Check if there are results
                    if (mysqli_num_rows($result)>0) {
                        // Fetch each row and display in the dropdown
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<option value='" . $row["loc_name"] . "'>" . $row["loc_name"] . "</option>";
                        }
                    
                        // End the HTML dropdown
                        echo "</select><br><br>";
                    } else {
                        echo "No locations found.";
                    }
                    mysqli_close($con);
                    ?>
                    </select>
                    Gender :<input type="radio" name="ctype" value="Female" style="margin-left: 50px;">Female
                    <input type="radio" name="ctype" value="Male"  style="margin-left: 50px;">Male</p>
                    <div class="btn-box" style="margin: left 235px; margin-top: 50px;">
                    <input type="submit" value="       Sign up         " name="submit" class="btn1">
                    <button class="btn1"><a href="fsignlogin.php" style="color: #2d3f4e; text-decoration: none;">  &nbsp; &nbsp;   Login  &nbsp;  &nbsp; </a></button></div><div class="col-md-4" style="margin-top:25px">
                      <a href="fhome.php">
                        Forgot password?
                      </a></div>
                     
                 <script>
        document.getElementById('signupForm').addEventListener('submit', function(event) {
            var password = document.getElementById('p3').value;
            var confirmPassword = document.getElementById('conp3').value;
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
    
   
    </div>
                  </div></form>
                </div>
                
              </div>
            </div>
        
    </section>
    <!-- end slider section -->
</body>

</html>