<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("location:../Homepage/admin_login.php");
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Orders | FoodExpress</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <link rel="stylesheet" href="style.css" />
  <style>
    body {
      background: linear-gradient(to right, #f1f2f6, #dfe4ea);
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    }

    .main-content {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 20px;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
      padding: 30px;
    }

    .table thead {
      background-color: #1e272e;
      color: white;
    }

    .btn-sm {
      border-radius: 8px;
      padding: 6px 10px;
    }

    .topbar {
      margin-bottom: 20px;
    }

    .table-hover tbody tr:hover {
      background-color: #f1f3f5;
    }
  </style>
</head>
<body>

<div class="container-fluid">
  <div class="row">

    <?php include_once "sidenav.php"; ?>

    <!-- Main Content -->
    <main class="col-md-10 ms-sm-auto main-content">
      <div class="topbar d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0 text-dark">📦 All Orders</h3>
        <button class="btn btn-outline-primary rounded-pill shadow-sm" onclick="location.reload();">
          <i class="bi bi-arrow-clockwise me-1"></i> Refresh
        </button>
      </div>

      <!-- Orders Table -->
      <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle rounded-3 overflow-hidden">
          <thead>
            <tr>
              <th>#</th>
              <th>Customer</th>
              <th>Restaurant</th>
              <th>Items</th>
              <th>Total amount</th>
              <th>Status</th>
              <th>Ordered At</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
              <?php
                $count=1;
                 include_once "../Homepage/connection.php";
             $res=mysqli_query($con,"SELECT 
    user.name as name,
    restaurant.restaurantname as res_name, 
    item.name as item_name,
    IFNULL(delivery_partner.p_name, 'Not assigned') as dp_name,
    IFNULL(delivery_partner.phone, 'Not assigned') as dp_phone,
    IFNULL(delivery_partner.email, '') as dp_email,
    order_items.* 
FROM order_items  
INNER JOIN user ON user.user_id=order_items.user_id 
INNER JOIN item ON item.item_id=order_items.item_id 
INNER JOIN restaurant ON restaurant.res_id=order_items.res_id 
LEFT JOIN delivery_partner ON delivery_partner.dp_id=order_items.dp_id 
ORDER BY order_id DESC");
                while($row=mysqli_fetch_array($res))
                {
            ?>
            <tr>
              <td><?php echo $count++ ?></td>
              <td><?php  echo $row['name']?></td>
              <td><?php  echo $row['res_name']?></td>
              <td><?php  echo $row['item_name']?></td>
              <td><?php  echo $row['price']?></td>
              
                  <?php
                  $badgeClass = 'bg-secondary';
                  if ($row['order_status'] === 'Pending') {
                      $badgeClass = 'bg-warning text-dark';
                  } elseif ($row['order_status'] === 'Completed') {
                      $badgeClass = 'bg-success text-white';
                  } elseif ($row['order_status'] === 'Cancelled') {
                      $badgeClass = 'bg-danger text-white';
                  }
                  $statusClass = $badgeClass;
                ?>
                <td><span class="badge <?php echo $badgeClass; ?>"><?php echo $row['order_status']; ?></span></td>
              <td><?php  echo $row['date']?></td>
              <td>
                <?php
                    $items = htmlspecialchars($row['item_name']); // Currently 1 item per row
                    $customer = htmlspecialchars($row['name']);
                    $restaurant = htmlspecialchars($row['res_name']);
                    $user_address= htmlspecialchars($row['address']);
                    $total = $row['price'];
                    $status = $row['order_status'];
                    $date = htmlspecialchars($row['date']);
                  ?>
                  <button class="btn btn-sm btn-outline-primary me-1 view-order-btn"
    data-bs-toggle="modal"
    data-bs-target="#viewOrderModal"
    data-customer="<?php echo $customer; ?>"
    data-restaurant="<?php echo $restaurant; ?>"
    data-address="<?php echo $user_address; ?>"
    data-items="<?php echo $items; ?>"
    data-total="<?php echo $total; ?>"
    data-status="<?php echo $status; ?>"
    data-date="<?php echo $date; ?>"
    data-dp-name="<?php echo htmlspecialchars($row['dp_name']); ?>"
    data-dp-phone="<?php echo htmlspecialchars($row['dp_phone']); ?>"
    data-dp-email="<?php echo htmlspecialchars($row['dp_email']); ?>">
    <i class="bi bi-eye"></i>
</button>
              </td>
              <?php

                }
              ?>
            </tr>
            <!-- More rows can be added here -->
          </tbody>
        </table>
      </div>
    </main>
  </div>
</div>

<!-- View Order Modal -->
<div class="modal fade" id="viewOrderModal" tabindex="-1" aria-labelledby="viewOrderModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content rounded-4">
      <div class="modal-header bg-info text-white rounded-top">
        <h5 class="modal-title" id="viewOrderModalLabel">Order Details</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p><strong>Customer:</strong> <span id="modalCustomer"></span></p>
        <p><strong>Restaurant:</strong> <span id="modalRestaurant"></span></p>
         <p><strong>Delivery Address:</strong> <span id="modaladdress"></span></p>
        <p><strong>Items:</strong> <span id="modalItems"></span></p>
        <div id="deliveryPartnerSection" class="card border-0 shadow-sm mt-3" style="display: none;">
            <div class="card-header bg-light">
              <h6 class="mb-0">
                <i class="bi bi-truck text-primary me-2"></i> <strong>Delivery Partner Details</strong>
              </h6>
            </div>
            <div class="card-body">
              <div class="row g-3">
                <div class="col-md-6">
                  <p class="mb-1 text-muted"><strong>Partner Name</strong></p>
                  <p class="mb-0">
                    <i class="bi bi-person-badge text-primary me-1"></i>
                    <span id="modalDPName">—</span>
                  </p>
                </div>
                <div class="col-md-6">
                  <p class="mb-1 text-muted"><strong>Mobile</strong></p>
                  <p class="mb-0">
                    <i class="bi bi-telephone-fill text-primary me-1"></i>
                    <span id="modalDPMobile">—</span>
                  </p>
                </div>
                <div class="col-md-6">
                  <p class="mb-1 text-muted"><strong>Email</strong></p>
                  <p class="mb-0">
                    <i class="bi bi-envelope-at text-primary me-1"></i>
                    <span id="modalDPEmail">—</span>
                  </p>
                </div>
              </div>
            </div>
          </div>
        <p><strong>Total:</strong> <span id="modalTotal"></span></p>
        <p><strong>Status:</strong> <span id="modalStatus"></span></p>
        <p><strong>Ordered At:</strong> <span id="modalDate"></span></p>

      </div>
      

      <div class="modal-footer">
        <button class="btn btn-light" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Cancel Order Modal -->
<div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-labelledby="cancelOrderModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content rounded-4">
      <div class="modal-header bg-danger text-white rounded-top">
        <h5 class="modal-title" id="cancelOrderModalLabel">Cancel Order</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to cancel this order?
      </div>
      <div class="modal-footer">
        <button class="btn btn-light" data-bs-dismiss="modal">No</button>
        <button class="btn btn-danger">Yes, Cancel</button>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.querySelectorAll('.view-order-btn').forEach(button => {
    button.addEventListener('click', () => {
        const customer = button.getAttribute('data-customer');
        const restaurant = button.getAttribute('data-restaurant');
        const address = button.getAttribute('data-address');
        const items = button.getAttribute('data-items');
        const total = button.getAttribute('data-total');
        const status = button.getAttribute('data-status');
        const date = button.getAttribute('data-date');
        
        // Delivery partner details
        const dpName = button.getAttribute('data-dp-name');
        const dpPhone = button.getAttribute('data-dp-phone');
        const dpEmail = button.getAttribute('data-dp-email');
        const partnerSection = document.getElementById('deliveryPartnerSection');

        // Fill modal content
        document.getElementById('modalCustomer').textContent = customer;
        document.getElementById('modalRestaurant').textContent = restaurant;
        document.getElementById('modaladdress').textContent = address;
        document.getElementById('modalItems').textContent = items;
        document.getElementById('modalTotal').textContent = '₹' + parseFloat(total).toFixed(2);
        document.getElementById('modalDate').textContent = date;

        // Status with badge styling
        const statusSpan = document.getElementById('modalStatus');
        statusSpan.textContent = status;
        statusSpan.className = 'badge ' + (() => {
            switch(status) {
                case 'Pending': return 'bg-warning text-dark';
                case 'Completed': return 'bg-success text-white';
                case 'Cancelled': return 'bg-danger text-white';
                default: return 'bg-secondary';
            }
        })();

        // Handle delivery partner section
        if (dpName && dpName !== 'Not assigned') {
            partnerSection.style.display = 'block';
            document.getElementById('modalDPName').textContent = dpName;
            
            // Show call button if phone exists and order isn't completed
            if (dpPhone && dpPhone !== 'Not assigned' && status !== 'Completed') {
                document.getElementById('modalDPMobile').innerHTML = 
                    dpPhone + ' <a href="tel:' + dpPhone + '" class="btn btn-sm btn-outline-primary ms-2">📞 Call</a>';
            } else {
                document.getElementById('modalDPMobile').textContent = dpPhone;
            }
            
            document.getElementById('modalDPEmail').textContent = dpEmail || 'N/A';
        } else {
            partnerSection.style.display = 'none';
        }
    });
});
</script>

</body>
</html>
