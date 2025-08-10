<?php
session_start();
include_once "../Homepage/connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dp_id = $_SESSION['dp_id'];
    $entered_otp = $_POST['otp'];
    $order_id = $_POST['order_id'];

    // Check if OTP exists in session
    if (!isset($_SESSION['OTP'])) {
        echo "OTP session expired or not set.";
        exit;
    }

    // Compare OTPs
    if ($entered_otp == $_SESSION['OTP']) {
        // ✅ OTP is correct

        // Update delivery_status_map
        $check = mysqli_query($con, "SELECT * FROM delivery_status_map WHERE order_id = $order_id");

        if (mysqli_num_rows($check) > 0) {
            mysqli_query($con, "UPDATE delivery_status_map SET delivery_status = 'Completed' WHERE order_id = $order_id and dp_id=$dp_id");
        } else {
            mysqli_query($con, "INSERT INTO delivery_status_map (dp_id, order_id, delivery_status) VALUES ($dp_id, $order_id, 'Completed')");
        }

        // ✅ Always update order_items status
        mysqli_query($con, "UPDATE order_items SET order_status = 'Completed' WHERE order_id = $order_id");

        // Clear OTP
        unset($_SESSION['OTP']);

        // Redirect
        header("Location: home.php?msg=otp_success");
        exit;
    } else {
        // ❌ OTP is incorrect
        header("Location: home.php?error=invalid_otp");
        exit;
    }
} else {
    echo "Invalid request.";
}
?>
