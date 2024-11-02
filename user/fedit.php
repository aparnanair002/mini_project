<html>
<?php

session_start();
if (!isset($_SESSION['f_Id'])) {
  header('Location: fsignlogin.php');
  exit;
}

include("databases/connection.php");
include("headlogin.php");

$se = $_SESSION['f_Id'];; // or use $_POST['session_id'] based on your form method

// Prepare and bind the SQL statement
$stmt = $con->prepare("
    SELECT df.*, l.loc_name 
    FROM tbl_dairyf df
    JOIN tbl_location l ON df.location_society = l.loc_id
    WHERE df.f_Id = ?
");

$stmt->bind_param("s", $se);

// Execute the statement
$stmt->execute();

// Get the result
$result = $stmt->get_result();

// Check if there are results
if ($result->num_rows > 0) {
    // Fetch the data
    $row = $result->fetch_assoc();
    // Display the data in a textbox
    $name=$row['f_name'];
    $username=$row['f_username'];
    $password=$row['f_password'];
    $homeaddress=$row['f_homeaddress'];
    $phone_no=$row['phone_no'];
    $location_society=$row['loc_name'];
    $gender=$row['gender'];
    $status=$row['f_status'];

} else {
    echo "No results found.";
}

// Close the statement and connection
$stmt->close();
$con->close();
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
                <!-- <a class="nav-link" href="fsignlogin.php"> <i class="fa fa-user" aria-hidden="true"></i> &nbsp;Already have an account ? Login</a> -->
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
                      Edit My Details
                    </h2>
                    <form id="editForm" action="databases/fedit.php" method="post">
    <p style="size: 50px;">Name: <input type="text" name="p1" value="<?php echo htmlspecialchars($name); ?>" style="margin-left:55px;"><br>
    Username: <input type="text" name="p2" placeholder="Your Email" value="<?php echo htmlspecialchars($username); ?>"><br>
    
    Address: <input type="text" name="p4" style="margin-left:35px;" value="<?php echo htmlspecialchars($homeaddress); ?>"><br>
    Phone no: <input type="text" name="p5" id="mobile" value="<?php echo htmlspecialchars($phone_no); ?>" oninput="return validateMobileNumber()"><br>

    <mn id="newl" style="font: size 20px; color:red;"></mn><br>
    Location:
    <select name="p6" id="p6" style="width: 450px; height:50px; margin-left:20px;">
    <?php  
    include "databases/connection.php";
    $sql = "SELECT loc_id,loc_name FROM tbl_location ORDER BY loc_name ASC";  
    $result = mysqli_query($con, $sql);
    echo "<option value='" . htmlspecialchars($location_society) . "'>" . htmlspecialchars($location_society) . "</option>";
    
    // Check if there are results
    if (mysqli_num_rows($result) > 0) {
        // Fetch each row and display in the dropdown
        while ($row = mysqli_fetch_array($result)) {
            echo "<option value='" . htmlspecialchars($row["loc_id"]) . "'>" . htmlspecialchars($row["loc_name"]) . "</option>";
        }
    } else {
        echo "<option disabled>No locations found.</option>";
    }
    mysqli_close($con);
    ?>
    </select><br> <br>
    
    Gender: <input type="radio" name="ctype" value="Female" style="margin-left: 50px;" 
    <?php echo ($gender == "Female") ? 'checked' : ''; ?>>Female
    <input type="radio" name="ctype" value="Male" style="margin-left: 50px;" 
    <?php echo ($gender == "Male") ? 'checked' : ''; ?>>Male
    
    <div class="btn-box" style="margin: left 235px; margin-top: 50px;">
        <input type="submit" value="       Update         " name="submit" id="submitBtn" class="btn1">
    </div>
    

    
    <script>
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
</form>
                </div>
                
              </div>
            </div>
        
    </section>
    <!-- end slider section -->
</body>

</html>