<?php

    include_once "connection.php";

    $res=mysqli_query($con,"UPDATE order_items SET order_status = 'Cancelled' WHERE order_id = '".$_POST['order_id']."'");

    header("location:order_history.php");



?>