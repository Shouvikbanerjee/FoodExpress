<?php
  
    include_once "connection.php";

    $res=mysqli_query($con,"insert into restaurant set restaurantname='".$_POST['res_name']."',ownername='".$_POST['owner']."',
    email='".$_POST['email']."',phone='".$_POST['phone']."',address='".$_POST['address']."',password='".$_POST['password']."'");

    
    header("location:../restaurant/home.php");


?>