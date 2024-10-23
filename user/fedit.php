<html>
<?php
session_start();
include("headlogin.php");
include("databases/connection.php");
$se = $_SESSION['f_Id'];; // or use $_POST['session_id'] based on your form method

// Prepare and bind the SQL statement
$stmt = $conn->prepare("SELECT * FROM your_table WHERE session_id = ?");
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
    $location_society=$row['location_society'];
    $gender=$row['gender'];
    $status=$row['f_status'];

} else {
    echo "No results found.";
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
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
                    <form action="post">
                    <p style="size: 50px;">Name   :<input type="text" name="p1" style="margin-left:55px;"><br>
                    Username :<input type="text" name="p2"><br>
                    Password :<input type="password" name="p3" style="margin-left:25px;"><br>
                    Address :<input type="text" name="p4" style="margin-left:35px;"><br>
                    Phone no :<input type="text" name="p5"><br>
                    Location :<input type="text" name="p6" style="margin-left:25px;"><br>
                    Gender :<input type="radio" name="ctype" value="Female" style="margin-left: 50px;">Female
                    <input type="radio" name="ctype" value="Male"  style="margin-left: 50px;">Male</p>
                    <div class="btn-box" style="margin: left 235px; margin-top: 50px;">
                      <a href="fhome.php" class="btn1">
                        Submit
                      </a>
                      <a href="fsignlogin.php" class="btn1">
                        Login
                      </a></div><div class="col-md-4" style="margin-top:25px">
                      <a href="fhome.php" class="btn1">
                        Forgot password?
                      </a></div>
                      
                    
                    </div>
                  </div></form>
                </div>
                
              </div>
            </div>
        
    </section>
    <!-- end slider section -->
</body>

</html>