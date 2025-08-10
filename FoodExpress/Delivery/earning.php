<?php

  session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Payment History | FoodExpress</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      background-color: #f4f6f9;
      font-family: 'Segoe UI', sans-serif;
    }
    .main-content {
      max-width: 900px;
      margin: 40px auto;
    }
    .payment-card {
      border: none;
      border-radius: 12px;
      box-shadow: 0 2px 8px rgba(99, 82, 82, 0.93);
      transition: transform 0.2s ease-in-out;
    }
    .payment-card:hover {
      transform: translateY(-4px);
    }
    .status-badge {
      font-size: 0.9rem;
      padding: 6px 12px;
      border-radius: 20px;
    }
    .status-paid {
      background-color: #d1fae5;
      color: #065f46;
    }
    .status-pending {
      background-color: #fef3c7;
      color: #92400e;
    }
  </style>
</head>
<body >

<div class="container-fluid">
  <div class="row">
    
    <!-- Sidebar -->

      <?php include_once "sidenav.php"; ?>
   

    <!-- Main Content -->
    <div class="col-md-9 col-lg-10 main-content py-4 px-3">
      <h3 class="fw-bold mb-4"><i class="bi bi-wallet2 me-2"></i>Payment History</h3>

        <?php
          include_once "../Homepage/connection.php";

          $res = mysqli_query($con, "SELECT * FROM order_items WHERE dp_id='" . intval($_SESSION['dp_id']) . "' and order_status='Completed' ORDER BY date DESC");

          if (mysqli_num_rows($res) > 0) {
              while ($row = mysqli_fetch_array($res)) {
                  ?>
                  <div class="card payment-card mb-3 p-3">
                      <div class="d-flex justify-content-between align-items-center flex-wrap">
                          <div>
                              <h6 class="mb-1">Order ID: <strong>#<?php echo $row['order_id']; ?></strong></h6>
                              <small class="text-muted">Date: <?php echo $row['date']; ?></small>
                          </div>
                          <div class="text-end">
                              <h5 class="mb-1 text-success fw-bold">&#8377;70</h5>
                              <span class="status-badge status-paid">Paid</span>
                          </div>
                      </div>
                  </div>
                  <?php
              }
          } else {
              echo '<div class="alert alert-warning">No payments found.</div>';
          }
          ?>
    </div>
  </div>
</div>

</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</html>
