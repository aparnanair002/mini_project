<!DOCTYPE html>
<html>
  <head>
<style>
  .warn{
    color:#E8FFB7; 
  margin-top: 20px; 
  text-align:left;
  font-size: 25px;


  }
  
</style></head>

<?php
include("head.php");
session_start();
$_SESSION['f_Id'];
?>
<body>
<!-- slider section -->
<section class="slider_section ">
            <div class="container ">
                <div class="row">
                <div class="col-md-6 ">
                  <div class="detail-box" style="margin-bottom: 155px;">
                    <h1 >
                      Dairy  Direct  Home
                    </h1>
                    <form action="databases/fhome.php" method="post">
                    <br>
                    
                    <select name="time" class="sel" required>
                      <option disabled selected value>--select--</option>
                        <option value="0">Morning</option>
                            <option value="1">Evening</option>
                        </select>    
                    
                    <br>
                    <p style="size: 100px;">Am I selling today ?  <br>   
                    <input type="radio" id="y" name="opt" value="Yes"> Yes <br>
                    <input type="radio" id="n" name="opt" value="No"> No
                    </p>
                    <div class="btn-box" style="margin: left 235px;">
                    <input type="submit" value="Done" name="done" class="btn1">
<br></form></div>
<form name="payment">
                    <br>
                    <k style="margin-top: 25px; font-size:40px; color:white">Payment Till Date : &#8377</k>
                    <label for="Payment" style="size: 64px; color:white" name="pay" value="Payment Till Date :"><!--****php code********-->
                    </label>
                      
                    </form>
                    <?php
    if (isset($_GET['done'])) {
        echo "<h4 class='warn'>Successfully Entered !!</h4>";
    }
    if (isset($_GET['did'])) {
      echo "<h4 class='warn'>Todays Entry already exists !!</h4>";
  }
  if (isset($_GET['error'])) {
    echo "<h4 class='warn'>Not entered Successfully !!</h4>";
}
    ?>
                  </div>
                </div>
                <div class="col-md-6">
                 <div class="img-box">
                    <img src="images/slider-img.png" alt="">
                  </div>
                </div>
              </div>
            </div>
        
    </section>
    <!-- end slider section -->
</body>

</html>

