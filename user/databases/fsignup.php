<?php
include "connection.php";
if(isset($_POST["submit"]))
{
$nm=$_POST["p1"];
$usr=$_POST["p2"];
$pas=$_POST["p3"];
$add=$_POST["p4"];
$phn=$_POST["p5"];
$location=$_POST["p6"];
$gender=$_POST["ctype"];

$sqse="select f_username from tbl_dairyf where f_username='$usr'";
$sel=mysqli_query($con,$sqse) or die("Failed".$con->error);
if($sel->num_rows == 0)
{
   
    $sq="insert into tbl_dairyf (f_name,f_username,f_password,f_homeaddress,phone_no,location_society,gender,f_status) values ('$nm','$usr','$pas','$add',$phn,'$location','$gender',0)";
    $result=mysqli_query($con,$sq) or die("Failed".$con->error);
    
    if ($result){
        header('Location: ../fsignlogin.php');
        exit();
    }
    else{
       header('Location : ../fsignup.php');
    }
}
else{
    header('Location: ../fsignup.php?error=1');
}
mysqli_close($con);
}
?>