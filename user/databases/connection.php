<?php
$server="localhost";
$user= "root";
$pass="";
$db="dairy_direct";
$con = mysqli_connect($server, $user, $pass, $db);

if($con)
{
echo "Connection Success";
}
else{
die("connection error" . mysqli_connect_error());}
?>