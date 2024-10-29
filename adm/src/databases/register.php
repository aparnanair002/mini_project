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

$sqse="select s_username from tbl_society where s_username='$usr'";
$sel=mysqli_query($con,$sqse) or die("Failed".$con->error);
if($sel->num_rows == 0)
{
   
    $sq="insert into tbl_society (s_name,s_username,s_password,location_society,s_homeaddress,phone_no,gender,s_status) values ('$nm','$usr','$pas','$add',$phn,'$location','$gender',0)";
    $result=mysqli_query($con,$sq) or die("Failed".$con->error);
    
    if ($result){
        header('Location: ../authentication-register.php');
        exit();
    }
    else{
       header('Location : ../authentication-register.php');
    }
}
else{
    header('Location: ../authentication-register.php?error=1');
}
mysqli_close($con);
}
?>