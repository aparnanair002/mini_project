<!DOCTYPE html>
<html>
  <head>
  <link rel="icon" href="images/logo.png" type="images/logo.png">
    <link rel="stylesheet" href="fontawesome/css/all.min.css"> <!-- https://fontawesome.com/ -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400" rel="stylesheet" /> <!-- https://fonts.google.com/ -->
    <link rel="stylesheet" href="css/tooplate-wave-cafe.css">

<style>
  .warn{
    color:#E8FFB7; 
  margin-top: 20px; 
  text-align:left;
  font-size: 25px;


  }
  .btn-circle {
    width: 40px;
    height: 40px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-circle i {
    font-size: 16px; /* Adjust icon size */
}
  
</style></head>

<?php

session_start();
if (!isset($_SESSION['f_Id'])) {
  header('Location: fsignlogin.php');
  exit;
}
include("head.php");
include("./databases/connection.php");
?>
<body>
<!-- slider section -->

<h1 style="color:white;font-weight:50px; text-align:center;">
                      Dairy  Direct  Home
                    </h1>
<section class="slider_section " style="padding: 0%;">
            <div class="container"style="padding: 0%;" >
                <div class="row">
                <div class="col-md-6 ">
                  <div class="detail-box" >
                    <form action="databases/fhome.php" method="post">
                    <br>
                    
                    <select name="time" class="sel" style="width:200px;margin-left:0px;margin-bottom:100px;" required>
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
                    <k style="margin-top: 25px; font-size:38px; color:white">Payment Till Date : &#8377</k>
                    <label for="Payment" style="font-size: 50px; color:white" name="pay" value="Payment Till Date :"><!--****php code********-->
                    </label>
                      
                    </form>
                    <?php
    if (isset($_GET['done'])) {
        echo "<h4 class='warn'>Successfully Entered !!</h4>";
    }
    if (isset($_GET['did'])) {
      echo "<h4 class='warn'>Todays Entry already exists !!</h4>";
  }
  if (isset($_GET['eprir'])) {
    echo "<script>alert('Details Edited!!')</script>";
}
  if (isset($_GET['error'])) {
    echo "<h4 class='warn'>Not entered Successfully !!</h4>";
}
    ?>
                  </div>
                </div>
                
                <div class="col-lg-6">
            <div class="card w-100">
            <div class="card-body p-4">
           
           
                        <?php
                        // Assuming you have already established a database connection in $con
                        $fid=$_SESSION['f_Id'];
                        // Fetch data from the database
                        $stmt = $con->prepare("SELECT *
                                                FROM  tbl_todaysel 
                                                WHERE f_Id = ? AND t_date = CURDATE() ORDER BY t_status asc;");
                        $stmt->bind_param("s", $fid); // Bind the $loca variable as a string parameter
                        $stmt->execute();
                        $stmt->bind_result($tid, $tdate, $opt, $fid,$status);
                        
                        $todayDate = date('d-m-y');
                        echo"  <div class='mb-2'>
                <h3 class='card-title fw-semibold'>Today's Milk Log  &nbsp; &nbsp;  ( &nbsp;".htmlspecialchars($todayDate)."  &nbsp;)
           
             </div>
             <div class='table-responsive'>
                <table class='table table-striped' id='data-table'>
                    <thead>
                        <tr>
                            <th scope='col'>To Do</th>
                            <th scope='col'>Shift</th>
                            <th scope='col'>Status</th>
                        </tr>
                    </thead>
                    <tbody>";
                   
                        // Loop through the results and create table rows
                        while ($stmt->fetch()) {
                          $shift = ($opt == 0) ? "Morning" : "Evening";
                          $checked = ($status == 1) ? "Visited" : "Not Visited"; // Checkbox state based on t_status
                          $name = ($status == 1) ? "<p style='color:green'>Collected !!</p>" 
                          : "<button class='btn btn-primary rounded-circle btn-circle' onclick='confirmDelete(" . htmlspecialchars($tid) . ")'>
                              <i class='fas fa-trash'></i>
                            </button>";                          
                            if (empty($name)) {
                              $name = "Delete"; // Fallback text if icon fails
                          }
                           echo "<tr>";
                          echo "<td>".$name ."</td>";
                          echo "<td>" . htmlspecialchars($shift) . "</td>";
                          echo "<td>" . htmlspecialchars($checked) . "</td>";
                          echo "</tr>";
                        }
                        echo "<tr></tr><tr></tr><tr>";
                        
                        // Close the statement
                        $stmt->close();
                    echo "</tbody>"; ?>
                    
                   <br><br>
                </table>
               
            </div>
        </div>
            </div>
        </div>
        <div class="col-md-4">
                <div class="img-box">
                    <img src="images/slider-img.png" alt="">
                  
                  </div> 
                </div>
        <div class="col-lg-8">
            <div class="card w-100">
            <div class="card-body p-4">
           
           
                        <?php

                        $stmt = $con->prepare("SELECT m_id,f_id,c_ltr,a_ltr,message,amount,val_status,t_date
                                                FROM  tbl_milk_records 
                                                WHERE f_id = ? AND t_date = CURDATE();");
                        $stmt->bind_param("s", $fid); // Bind the $loca variable as a string parameter
                        $stmt->execute();
                        $stmt->bind_result($mid,$f_id,$coll,$rep,$msg, $amnt,$val,$tdate);
                        
                        $todayDate = date('d-m-y');
                        echo"  <div class='mb-2'>
                <h3 class='card-title fw-semibold'>Today's Milk Log  &nbsp; &nbsp;  ( &nbsp;".htmlspecialchars($todayDate)."  &nbsp;)
           
             </div>
             <div class='table-responsive'>
                <table class='table table-striped' id='data-table'>
                    <thead>
                        <tr>
                            <th scope='col'>Status</th>
                            <th scope='col'>Collected litres</th>
                            <th scope='col'>Reported litres</th>
                            <th scope='col'>Message</th>
                            <th scope='col'>Amount</th>
                            </tr>
                    </thead>
                    <tbody>";
                   
                        // Loop through the results and create table rows
                        while ($stmt->fetch()) {
                          switch ($val) {
                            case 0:
                                $checked = "Not Authenticated";
                                break;
                            case 1:
                                $checked = "Accepted";
                                break;
                            case 2:
                                $checked = "<button class='btn btn-danger rounded-circle btn-circle' onclick='confirmDeletemilk(" . htmlspecialchars($mid) . ")'>
                              <i class='fas fa-trash'></i>
                            </button>";
                                break;
                            default:
                                $checked = "Unknown Status"; // Optional: handle unexpected values
                                break;
                        }     
                        
                        if(empty($msg))
                        {
                          $msg="No Messages to display.";
                        }
                          
                           echo "<tr>";
                          echo "<td>".$checked ."</td>";
                          echo "<td>" . htmlspecialchars($coll) . "</td>";
                          echo "<td>" . htmlspecialchars($rep) . "</td>";
                          echo "<td>" . htmlspecialchars($msg) . "</td>";
                          echo "<td>" . htmlspecialchars($amnt) . "</td>";

                          echo "</tr>";
                        }
                        echo "<tr></tr><tr></tr><tr>";
                        
                        // Close the statement
                        $stmt->close();
                    echo "</tbody>";
                    $con->close(); ?>
                    
                   <br><br>
                </table>
               
            </div>
        </div>
            </div>
        </div>
              
        
    </section>
    <script>
function confirmDelete(tid) {
    // Show a confirmation dialog
    var result = confirm("Are you sure you want to delete this record?");
    if (result) {
        // If the user clicked "OK", proceed with the deletion
        // You can redirect to a PHP script or make an AJAX call to delete the record
        window.location.href = "./databases/deletemilklog.php?id=" + tid; // Example of redirecting to a delete script
    }
}
function confirmDeletemilk(mid) {
    // Show a confirmation dialog
    var result = confirm("Your log is set to delete by society. press ok if you are sure of this delete or cancel to cancel.Contact your society for further details");
    if (result) {
        // If the user clicked "OK", proceed with the deletion
        // You can redirect to a PHP script or make an AJAX call to delete the record
        window.location.href = "./databases/deletemilk.php?id=" + mid; // Example of redirecting to a delete script
    }}
</script>

</body>

</html>

