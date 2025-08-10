<?php
header('Content-Type: application/json');
include_once "../Homepage/connection.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['order_id']) && isset($_POST['dp_id'])) {
        $order_id = intval($_POST['order_id']);
        $dp_id = intval($_POST['dp_id']);

        // Insert or update delivery_status_map
        $update = mysqli_query($con, "
            INSERT INTO delivery_status_map (order_id, dp_id, delivery_status)
            VALUES ('$order_id', '$dp_id', 'Cancelled')
            ON DUPLICATE KEY UPDATE 
                delivery_status = 'Cancelled',
                dp_id = '$dp_id'
        ");

        if ($update) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Database update failed.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Missing order_id or dp_id.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}
?>
