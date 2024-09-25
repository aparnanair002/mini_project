<?php
include "connection.php";
session_start();

if(isset($_POST["sub"]))
{
    
$usr=$_POST["p1"];
$pas=$_POST["p2"];

$sqse="select f_Id,f_username,f_password from tbl_dairyf where f_username='$usr' and f_password='$pas'"; //add status flag after modyfying admin page
$sel=mysqli_query($con,$sqse) or die("Failed".$con->error);
while ($row=mysqli_fetch_array($sel)) {
    if ($row >0){
        $_SESSION['f_Id'] = $row['f_Id'];
        echo $_SESSION['f_Id'];
        header("Location: ../fhome.php");
        exit();
    } 
else {
    header("Location: ../fsignlogin.php?error=1");
    exit();}
}
$sel->close();


}
$con->close();
?>