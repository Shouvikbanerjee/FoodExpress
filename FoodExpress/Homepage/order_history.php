<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("location:../Homepage/user_login.php");
    exit();
}

include_once "../Homepage/connection.php";
$res = mysqli_query($con, "SELECT user_id FROM user WHERE email ='" . $_SESSION['email'] . "'");
$row = mysqli_fetch_assoc($res);
$user_id = $row['user_id'];

$query = "
SELECT 
  o.order_id, o.order_status, o.price, o.date, 
  i.name, r.restaurantname,dp.p_name AS dp_name,
  dp.phone AS dp_mobile,
  dp.email AS dp_email
FROM order_items o
JOIN item i ON o.item_id = i.item_id
JOIN restaurant r ON o.res_id = r.res_id
LEFT JOIN delivery_partner dp ON dp.dp_id = o.dp_id
WHERE o.user_id = $user_id
ORDER BY o.date DESC
";

$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>My Orders</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    .tracking-step {
      flex: 1;
      text-align: center;
      position: relative;
    }
    .tracking-step::after {
      content: '';
      position: absolute;
      top: 50%;
      right: 0;
      width: 100%;
      height: 3px;
      background: #dee2e6;
      z-index: -1;
      transform: translateY(-50%);
    }
    .tracking-step:last-child::after {
      display: none;
    }
    .tracking-step .circle {
      width: 32px;
      height: 32px;
      line-height: 32px;
      border-radius: 50%;
      background: #dee2e6;
      margin: auto;
      margin-bottom: 8px;
      color: #000;
    }
    .tracking-step.active .circle {
      background: #0d6efd;
      color: #fff;
    }
  </style>
</head>
<body>
<?php include_once "navbar.php"; ?>
<div class="container py-5">
  <h2 class="mb-4">My Orders</h2>
  <div class="row">
<?php
while ($row = mysqli_fetch_assoc($result)) {
    // Prepare badge class, icon, and step
    $badgeClass = '';
    $icon = '';
    $step = 0;
    switch ($row['order_status']) {
        case 'Pending':
            $badgeClass = 'bg-warning text-dark';
            $icon = '⏳';
            $step = 1;
            break;
        case 'Accepted':
            $badgeClass = 'bg-info';
            $icon = '✅';
            $step = 2;
            break;
        case 'Out for Delivery':
            $badgeClass = 'bg-primary';
            $icon = '🚚';
            $step = 3;
            break;
        case 'Completed':
            $badgeClass = 'bg-success';
            $icon = '✔️';
            $step = 4;
            break;
        case 'Cancelled':
            $badgeClass = 'bg-danger';
            $icon = '❌';
            $step = -1;
            break;
    }

    $dp_name = htmlspecialchars($row['dp_name'] ?? 'Not assigned');
    // Prepare mobile number and call button HTML
    $mobile = htmlspecialchars($row['dp_mobile'] ?? 'Not assigned');
    $order_status = $row['order_status'] ?? ''; // Make sure this is fetched from DB

    if ($mobile !== 'Not assigned' && strtolower($order_status) !== 'completed') {
        $mobileHtml = $mobile . ' <a href="tel:' . $mobile . '" class="btn btn-sm btn-outline-primary ms-2" title="Call Delivery Partner">📞 Call</a>';
    } else {
        $mobileHtml = $mobile;
    }

    // Prepare email
    $email = htmlspecialchars($row['dp_email'] ?? 'Not assigned');

    // Now output the card and modal HTML with variables embedded
    echo "
    <div class='col-md-6 col-lg-4 mb-4'>
      <div class='card shadow-sm h-100'>
        <div class='card-body d-flex flex-column justify-content-between'>
          <div>
            <h5 class='card-title mb-2'>{$row['name']}</h5>
            <h6 class='text-muted mb-3'>from <strong>{$row['restaurantname']}</strong></h6>
            <ul class='list-unstyled mb-3'>
              <li><strong>Amount:</strong> ₹{$row['price']}</li>
              <li><strong>Ordered At:</strong> {$row['date']}</li>
              <li><strong>Status:</strong> <span class='badge {$badgeClass}'>{$icon} {$row['order_status']}</span></li>
            </ul>
          </div>
          <button class='btn btn-outline-primary btn-sm mt-auto' data-bs-toggle='modal' data-bs-target='#orderModal{$row['order_id']}'>
            View Details
          </button>
        </div>
      </div>
    </div>

    <div class='modal fade' id='orderModal{$row['order_id']}' tabindex='-1' aria-labelledby='orderModalLabel{$row['order_id']}' aria-hidden='true'>
      <div class='modal-dialog modal-dialog-centered modal-lg'>
        <div class='modal-content'>
          <div class='modal-header'>
            <h5 class='modal-title' id='orderModalLabel{$row['order_id']}'>Order Details</h5>
            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
          </div>
          <div class='modal-body'>
            <p><strong>Item:</strong> {$row['name']}</p>
            <p><strong>Restaurant:</strong> {$row['restaurantname']}</p>
            <p><strong>Price:</strong> ₹{$row['price']}</p>
            <p><strong>Date:</strong> {$row['date']}</p>
            <p><strong>Status:</strong> <span class='badge {$badgeClass}'>{$row['order_status']}</span></p>

            <hr>
            <p><strong>Delivery Partner Name:</strong> $dp_name</p>
            <p><strong>Delivery Partner Mobile:</strong> $mobileHtml</p>
            <p><strong>Delivery Partner Email:</strong> $email</p>

            <hr>
            <h6>🚚 Tracking</h6>
            <div class='d-flex justify-content-between mb-3'>
              <div class='tracking-step " . ($step >= 1 ? 'active' : '') . "'>
                <div class='circle'>1</div>
                <small>Pending</small>
              </div>
              <div class='tracking-step " . ($step >= 2 ? 'active' : '') . "'>
                <div class='circle'>2</div>
                <small>Accepted</small>
              </div>
              <div class='tracking-step " . ($step >= 3 ? 'active' : '') . "'>
                <div class='circle'>3</div>
                <small>Out for Delivery</small>
              </div>
              <div class='tracking-step " . ($step == 4 ? 'active' : '') . "'>
                <div class='circle'>4</div>
                <small>Completed</small>
              </div>
            </div>

            <div class='progress mb-3' style='height: 10px;'>
              <div class='progress-bar bg-" . ($row['order_status'] == 'Pending' ? 'warning' : ($row['order_status'] == 'Accepted' ? 'info' : ($row['order_status'] == 'Out for Delivery' ? 'primary' : ($row['order_status'] == 'Completed' ? 'success' : 'danger')))) . "' 
                   role='progressbar' 
                   style='width: " . ($step == -1 ? '100%' : $step * 25) . "%;' 
                   aria-valuenow='$step' aria-valuemin='0' aria-valuemax='100'>
              </div>
            </div>

            " . ($row['order_status'] == 'Pending' ? "
            <form action='cancel_order.php' method='POST'>
              <input type='hidden' name='order_id' value='{$row['order_id']}'>
              <button type='submit' class='btn btn-danger'>Cancel Order</button>
            </form>
            " : "
            <div class='alert alert-info mt-3'>This order is {$row['order_status']} and cannot be modified.</div>
            ") . "
          </div>
        </div>
      </div>
    </div>
    ";
}
?>
  </div>
</div>
<?php include_once "footer.php"; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
