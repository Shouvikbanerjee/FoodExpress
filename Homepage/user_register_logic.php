<?php
    session_start();
    include_once "connection.php";

    $res=mysqli_query($con,"insert into user set name='".$_POST['name']."',email='".$_POST['email']."',phone='".$_POST['phone']."',
    address='".$_POST['address']."',password='".$_POST['password']."'");

    $_SESSION['email']=$_POST['email'];
    $_SESSION['OTP']=rand(11111,55555);
    header("Location: ../Homepage/Otp_verify.php");


?>