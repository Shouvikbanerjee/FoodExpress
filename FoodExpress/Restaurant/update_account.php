<?php
session_start();
include_once "../Homepage/connection.php";

if (isset($_POST['res_id'])) {
  $id = $_POST['res_id'];
  $name = $_POST['restaurantname'];
  $owner = $_POST['ownername'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $address = $_POST['address'];

  $query = "UPDATE restaurant SET restaurantname='$name', ownername='$owner', email='$email', phone='$phone', address='$address' WHERE res_id='$id'";
  
  if (mysqli_query($con, $query)) {
    $_SESSION['message'] = "Account updated successfully!";
  } else {
    $_SESSION['message'] = "Failed to update account.";
  }

  header("Location: home.php");
}
?>
