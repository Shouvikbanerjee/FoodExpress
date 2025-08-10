<?php
session_start();
include_once "connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $message = mysqli_real_escape_string($con, $_POST['message']);

    $query = "INSERT INTO contact_message (name, email, message) VALUES ('$name', '$email', '$message')";

    if (mysqli_query($con, $query)) {
        echo "success";
    } else {
        echo "error";
    }
} else {
    echo "invalid";
}
?>
