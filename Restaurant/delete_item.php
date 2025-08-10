<?php

    session_start();

    include_once "../Homepage/connection.php";

    $res=mysqli_query($con,"delete from item where item_id='".$_GET['item_id']."'");

    header('location:../Restaurant/menu.php');


?>