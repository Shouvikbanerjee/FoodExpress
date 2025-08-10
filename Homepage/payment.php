<?php
session_start();
include_once "connection.php";

if (!isset($_SESSION['email'])) {
    header("location:../Homepage/user_login.php");
    exit();
}

// Fetch from session
$res_id    = $_SESSION['res_id'] ?? '';
$item_id   = $_SESSION['item_id'] ?? '';
$user_id   = $_SESSION['user_id'] ?? '';
$quantity  = $_SESSION['quantity'] ?? 1;
$address   = $_SESSION['address'] ?? '';
$price     = $_SESSION['price'] ?? 0;
$item_name = $_SESSION['item_name'] ?? 'Selected Item';
$total     = $quantity * $price;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $payment_method = $_POST['payment_method']; // Only COD available
    $payment_status = 'Pending';

    $stmt = $con->prepare("INSERT INTO order_items (res_id, item_id, user_id, quantity, address, price) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iiiiss", $res_id, $item_id, $user_id, $quantity, $address, $total);

    if ($stmt->execute()) {
        header("Location: success.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Payment | FoodExpress</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #f8f9fa, #e3f2fd);
      font-family: 'Segoe UI', sans-serif;
    }
    .payment-card {
      background: #ffffff;
      border: none;
      border-radius: 15px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.08);
      padding: 25px;
    }
    .btn-group .btn {
      padding: 10px;
      font-weight: 500;
      border-radius: 10px !important;
    }
    .disabled-option {
      background-color: #fcfcfcff;
      cursor: not-allowed;
      opacity: 0.6;
    }
    .alert-info {
      border-radius: 10px;
      background: linear-gradient(135deg, #e3f2fd, #ffffff);
      box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }
    .order-summary {
      font-size: 0.95rem;
      color: #555;
    }
  </style>
</head>
<body>
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="payment-card">
          <h4 class="mb-3 text-center">
            Payment for <span class="text-success"><?php echo htmlspecialchars($item_name); ?></span>
          </h4>
          <p class="text-center order-summary">Quantity: <strong><?php echo $quantity; ?></strong></p>
          <p class="text-center order-summary mb-4">Total Amount: <strong>₹<?php echo $total; ?></strong></p>

          <form method="POST">
            <!-- Payment Methods -->
            <div class="mb-4 text-center">
              <div class="btn-group w-100" role="group">
                <input type="radio" class="btn-check" id="card" value="card" disabled>
                <label class="btn btn-outline-dark disabled-option" for="card">
                  <i class="bi bi-credit-card me-1"></i> Card <small>(Coming Soon)</small>
                </label>

                <input type="radio" class="btn-check" id="upi" value="upi" disabled>
                <label class="btn btn-outline-dark disabled-option" for="upi">
                  <i class="bi bi-phone me-1"></i> UPI <small>(Coming Soon)</small>
                </label>

                <input type="radio" class="btn-check" name="payment_method" id="cod" value="cod" checked>
                <label class="btn btn-outline-primary" for="cod">
                  <i class="bi bi-cash-stack me-1"></i> Cash on Delivery
                </label>
              </div>
            </div>

            <!-- COD Info -->
            <div class="alert alert-info text-center">
              <i class="bi bi-info-circle me-1"></i> 
              You have selected <strong>Cash on Delivery</strong>. Please keep ₹<?php echo $total; ?> ready.
            </div>

            <button type="submit" class="btn btn-success w-100 py-2 mt-3">
              <i class="bi bi-check-circle me-1"></i> Confirm & Place Order
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
