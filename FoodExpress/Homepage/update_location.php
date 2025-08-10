<?php
session_start();
include_once "connection.php";

if (!isset($_SESSION['email']) || !isset($_POST['address'])) {
    http_response_code(400);
    echo "Invalid request";
    exit;
}

$address = mysqli_real_escape_string($con, $_POST['address']);
$email = $_SESSION['email'];

$query = "UPDATE user SET address='$address' WHERE email='$email'";
if (mysqli_query($con, $query)) {
    echo "Address updated";
} else {
    http_response_code(500);
    echo "Failed to update address";
}
?>
