<?php
session_start();
include_once "../Homepage/connection.php";

if (!isset($_SESSION['res_id'])) {
    header("location:../Homepage/restaurant_login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = intval($_POST['order_id']);
    $action = $_POST['action'];

    $validActions = [
        'accept' => 'Accepted',
        'cancel' => 'Cancelled',
        'out_for_delivery' => 'Out for Delivery',
    ];

    if (array_key_exists($action, $validActions)) {
        $newStatus = $validActions[$action];

        // Optional: check if order belongs to this restaurant for security
        $check = mysqli_query($con, "SELECT res_id FROM order_items WHERE order_id = $order_id");
        $order = mysqli_fetch_assoc($check);
        if ($order && $order['res_id'] == $_SESSION['res_id']) {
            $update = mysqli_query($con, "UPDATE order_items SET order_status = '$newStatus' WHERE order_id = $order_id");
            if ($update) {
                $_SESSION['msg'] = "Order status updated to $newStatus.";
            } else {
                $_SESSION['msg'] = "Failed to update order status.";
            }
        } else {
            $_SESSION['msg'] = "Unauthorized action.";
        }
    } else {
        $_SESSION['msg'] = "Invalid action.";
    }
}

header("Location: order.php"); // Redirect back to orders page
exit();
