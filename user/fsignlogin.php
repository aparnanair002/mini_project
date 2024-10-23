<!DOCTYPE html>
<html>
  <style>
  .flex-container {
    margin-top: 50px;
    display: flex;               /* Enables flexbox layout */
    justify-content: center;     /* Centers items horizontally */
    align-items: center;         /* Centers items vertically */
    background-color: white;  
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
    color: red;               /* White text color */
    font-size: 18px;           /* Font size of 20px */
    padding: 15px;             /* Padding around the text */
    border-radius: 5px;   /* Blue background */
}
</style>
<?php
session_start();
if (!isset($_SESSION['f_Id'])) {
  header('Location: fsignlogin.php');
  exit;
}

include("headlogin.php")
?>
<body>

<div class="hero_area">

  <div class="hero_bg_box">
  <div class="bg_img_box">
      <img src="images/hero-bg.png" alt="">
    </div>
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
              <a class="nav-link" href="fsignup.php"> <i class="fa fa-user" aria-hidden="true"></i> Sign Up / New User</a>
            </li>
           
          </ul>
        </div>
      </nav>
    </div>
  </header>
  <!-- end header section -->
    <!-- slider section -->
    <section class="slider_section ">
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
                      Login
                    </h2>
                    <form action="databases/fsignlogin.php" method="post">
                    <p style="size: 50px;">Username :<input type="text" name="p1">
                   Password :<input type="password" name="p2"></p>
                    <div class="btn-box" style="margin: left 235px;">
                      <input type="submit" name="sub" value="Submit" class="btn1" style="width:160px; height:47px;">
                      <a href="fsignup.php" class="btn1">
                        Sign up
                      </a></div><div class="col-md-4" style="margin-top:25px">
                      <a href="fhome.php" class="btn1">
                        Forgot password?
                      </a></div>
                      <?php
    if (isset($_GET['error'])) {
        echo "<div  class='flex-container'>Invalid username or password!!</div>";
    }
    if (isset($_GET['yes'])) {
      echo "<div  class='flex-container'>You are yet to be authenticated by your society !!<br> Contact your respective society for further details!!</div>";
  }
    ?>
                    
                    </div>
                  </div></form>
                </div>
                
              </div>
            </div>
        
    </section>
    <!-- end slider section -->
</body>

</html>