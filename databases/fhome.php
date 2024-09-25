<?php
include("connection.php");
session_start();
$id=$_SESSION['f_Id'];
if(isset($_POST['done']))
{
$time=$_POST['time'];
$opt=$_POST['opt'];
$dt=date('y-m-d');
echo $dt;
if($opt==='Yes')
{
    $s="select t_date,t_opt from tbl_todaysel where t_date='$dt'  and t_opt=$time and f_Id=$id";
    $st=mysqli_query($con,$s);
    if($st->num_rows ==0){
        $sql="insert into tbl_todaysel (t_date,t_opt,f_Id) values ('$dt',$time,$id)";
        $stm=mysqli_query($con,$sql);

        if ($stm){
            header('Location: ../fhome.php?done=1');
            exit();
        }
        else{
           header('Location : ../fhome.php?did=1');
        }
    }
    else{
        header('Location: ../fhome.php?did=1');
    }
   
    }
    else{
        header('Location: ../fhome.php?error=1');
    }
    mysqli_close($con);
}
?>