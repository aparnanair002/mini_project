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
                <div class="col-md-6">
                 <div class="img-box">
                    <img src="images/slider-img.png" alt="">
                  </div>
                </div>
                <div class="col-md-6 ">
                  <div class="detail-box" style="margin-bottom: 155px;">
                    <h1 >
                      Dairy  Direct
                    </h1>
                    <h2 style="color: white; font-family:Georgia, 'Times New Roman', Times, serif; margin-top: 30px;">
                      Edit Profile
                    </h2>
                    <form action="post">
                    <p style="size: 50px;">Name   :<input type="text" name="p1">
                    Username :<input type="text" name="p2">
                    Password :<input type="password" name="p3">
                    Address :<input type="text" name="p4">
                    Phone no :<input type="text" name="p5">
                    Location :<input type="text" name="p6">
                    Gender :<input type="radio" name="ctype" value="Female">Female
                    <input type="radio" name="ctype" value="Male">Male</p>
                    <div class="btn-box" style="margin: left 235px;">
                      <a href="fhome.php" class="btn1">
                        Submit
                      </a>
                      <a href="fsignlogin.php" class="btn1">
                        Cancel
                      </a></div><div class="col-md-4" style="margin-top:25px">
                      <!-- <a href="fhome.php" class="btn1"> -->
                        <!-- Forgot password? -->
                      <!-- </a> -->
                    </div>
                      
                    
                    </div>
                  </div></form>
                </div>
                
              </div>
            </div>
        
    </section>
    <!-- end slider section -->
</body>

</html>