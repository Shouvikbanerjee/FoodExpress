<?php

  session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Order History | FoodExpress</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Segoe UI', sans-serif;
    }
    .order-card {
      border: none;
      border-radius: 12px;
      box-shadow: 0 2px 8px rgba(60, 47, 47, 1);
      margin-bottom: 1rem;
      transition: 0.3s ease;
    }
    .order-card:hover {
      transform: translateY(-3px);
    }
    .status {
      padding: 5px 12px;
      font-size: 0.85rem;
      border-radius: 20px;
      font-weight: 500;
    }
    .status-delivered {
      background-color: #d1fae5;
      color: #065f46;
    }
    .status-cancelled {
      background-color: #fee2e2;
      color: #991b1b;
    }
    .status-ongoing {
      background-color: #e0f2fe;
      color: #1e40af;
    }
  </style>
</head>
<body>

<div class="container-fluid">
  <div class="row">
    
    <!-- Sidebar -->

      <?php include_once "sidenav.php"; ?>
   
    <?php

        include_once "../Homepage/connection.php";

       $res = mysqli_query($con, "
    SELECT 
        u.name AS user_name,
        u.phone as user_phone,
        i.name AS item_name,
        r.restaurantname AS res_name,
        oi.*,
        dsm.delivery_status
    FROM delivery_status_map dsm
    INNER JOIN order_items oi ON oi.order_id = dsm.order_id
    INNER JOIN user u ON u.user_id = oi.user_id 
    INNER JOIN item i ON i.item_id = oi.item_id
    INNER JOIN restaurant r ON r.res_id = oi.res_id
    WHERE dsm.dp_id = '" . intval($_SESSION['dp_id']) . "'
    ORDER BY oi.date DESC
");
    ?>
    <!-- Main Content -->
    <div class="col-md-9 col-lg-10 px-4 py-5">
      <h3 class="fw-bold mb-4"><i class="bi bi-bag-check me-2"></i>Order History</h3>
    <?php
      while($row=mysqli_fetch_array($res))
        {
      ?>
            <!-- Order 1 -->
            <div class="card order-card p-3">
              <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                  <h6>Order ID: <strong>#<?php  echo $row['order_id'] ?></strong></h6>
                  <p class="mb-1 text-muted">Customer: <?php  echo $row['user_name'] ?></p>
                  <p class="mb-1 text-muted">Restaurant Name: <?php  echo $row['res_name'] ?></p>
                  <p class="mb-1 text-muted">Food Name: <?php  echo $row['item_name'] ?></p>
                  <p class="mb-1 text-muted">Customer Phone No: <?php  echo $row['user_phone'] ?></p>
                  <p class="mb-1 text-muted">Delivery To: <?php  echo $row['address'] ?></p>
                  <small class="text-muted">Delivered on: <?php  echo $row['date'] ?></small>
                </div>
                <div class="text-end">
                  <?php 
                      $status = strtolower($row['delivery_status']);
                      switch ($status) {
                          case 'completed': $badge = 'bg-success'; break;
                          case 'cancelled': $badge = 'bg-danger'; break;
                          case 'accepted':  $badge = 'bg-primary'; break;
                          default: $badge = ''; break; // No color for completed or unknown
                      }
                  ?>
                  <span class="badge <?php echo $badge; ?>">
                      <?php echo htmlspecialchars($row['delivery_status']); ?>
                  </span>
                </div>

              </div>
            </div>  
      <?php
          }
        ?>
     

    </div>
  </div>
</div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</html>
