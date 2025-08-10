<?php
session_start();
include_once "../Homepage/connection.php";

if (isset($_POST['dp_id'])) {
  $id = $_POST['dp_id'];
  $name = $_POST['p_name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $address = $_POST['address'];

  $query = "UPDATE delivery_partner SET p_name='$name', email='$email', phone='$phone', address='$address' WHERE dp_id='$id'";
  
  if (mysqli_query($con, $query)) {
    $_SESSION['message'] = "Account updated successfully!";
  } else {
    $_SESSION['message'] = "Failed to update account.";
  }

  header("Location: home.php");
}
?>
