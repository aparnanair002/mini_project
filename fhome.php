<!DOCTYPE html>
<html>

<?php
include("head.php")
?>
<!-- slider section -->
<section class="slider_section ">
            <div class="container ">
                <div class="row">
                <div class="col-md-6 ">
                  <div class="detail-box" style="margin-bottom: 155px;">
                    <h1 >
                      Dairy  Direct  Home
                    </h1>
                    <form action="post">
                    <br>
                    
                    <select name="time" class="sel">
                        <option value="AM">Morning</option>
                            <option value="PM">Evening</option>
                        </select>    
                    
                    <br>
                    <p style="size: 100px;">Am I selling today ?  <br>   
                    <input type="radio" id="y" name="option" value="Yes"> Yes <br>
                    <input type="radio" id="n" name="option" value="No"> No
                    </p>
                    <div class="btn-box" style="margin: left 235px;">
                    <input type="submit" value="Done" name="submit" class="btn1">
<br></form></div>
<form name="payment">
                    <br>
                    <k style="margin-top: 25px; font-size:40px; color:white">Payment Till Date : &#8377</k>
                    <label for="Payment" style="size: 64px; color:white" name="pay" value="Payment Till Date :"><!--****php code********-->
                    </label>
                      
                    </form>
                   
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

