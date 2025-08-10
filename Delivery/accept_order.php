<?php
session_start();
header('Content-Type: application/json');

include_once "../Homepage/connection.php"; // Ensure this path is correct

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dp_id = $_POST['dp_id'] ?? '';
    $order_id = $_POST['order_id'] ?? '';

    if (!empty($dp_id) && !empty($order_id)) {
        // First, check if order exists and hasn't already been accepted (dp_id NULL or 0)
        $check = $con->prepare("SELECT * FROM order_items WHERE order_id = ? AND (dp_id IS NULL OR dp_id = 0)");
        $check->bind_param("i", $order_id);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows === 0) {
            echo json_encode(['status' => 'error', 'message' => 'Order already accepted or does not exist.']);
            exit;
        }

        // Update dp_id in order_items table
        $stmt = $con->prepare("UPDATE order_items SET dp_id = ? WHERE order_id = ?");
        $stmt->bind_param("ii", $dp_id, $order_id);

        if ($stmt->execute()) {
            // Insert or update delivery_status_map with accept status
            $insert = $con->prepare("
                INSERT INTO delivery_status_map (order_id, dp_id, delivery_status)
                VALUES (?, ?, 'Accepted')
                ON DUPLICATE KEY UPDATE delivery_status = 'accept', dp_id = VALUES(dp_id)
            ");
            $insert->bind_param("ii", $order_id, $dp_id);
            $insert->execute();
            $insert->close();

            echo json_encode(['status' => 'success', 'message' => 'Order accepted.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update order.']);
        }

        $stmt->close();
        $check->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Missing dp_id or order_id.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
