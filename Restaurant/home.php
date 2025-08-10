<?php

  session_start();

if (!isset($_SESSION['res_id'])) {
    header("location:../Homepage/restaurant_login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Restaurant Dashboard | FoodExpress</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
  include_once "../Homepage/connection.php";
  $query="select * from restaurant where res_id='".$_SESSION['res_id']."'";
  $res=mysqli_query($con,$query);

  $row=mysqli_fetch_array($res);

?>
   
<div class="container-fluid">
  <div class="row">

    <!-- Sidebar for Desktop -->
 <?php include_once "sidenav.php" ?>

    <!-- Main Content -->
    <main class="col-md-10 ms-sm-auto p-4">
      <!-- Topbar -->
      <div class="topbar d-flex justify-content-between align-items-center mb-4 rounded">
        <h3 class="mb-0 fw-bold">Dashboard</h3>
        <button class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#accountModal">
  <i class="bi bi-person-circle me-2"></i>Profile
</button>

      </div>
      <?php

        $res1=mysqli_query($con,"select count(*) as total_order from order_items where res_id='".$_SESSION['res_id']."' 
        AND order_items.order_status IN ('Accepted', 'Out for Delivery','Completed')");
        $row1=mysqli_fetch_array($res1);


        $res2=mysqli_query($con,"select count(*) as total_item from item where res_id='".$_SESSION['res_id']."'");
        $row2=mysqli_fetch_array($res2);

       $query = "SELECT SUM(price) as total_price FROM order_items WHERE order_status='Completed' and res_id='".$_SESSION['res_id']."'";
       $result = mysqli_query($con, $query);
       $row3 = mysqli_fetch_assoc($result);
       $totalPrice = $row3['total_price'];

      ?>
      <!-- Dashboard Cards -->
      <div class="row g-4">
        <div class="col-sm-6 col-lg-4">
          <div class="card dashboard-card p-3">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h6>Total Orders</h6>
                <h3><?php  echo $row1['total_order'] ?></h3>
              </div>
              <i class="bi bi-basket card-icon"></i>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-lg-4">
          <div class="card dashboard-card p-3">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h6>Total Earnings</h6>
                <h3><?php  echo $row3['total_price'] ?></h3>
              </div>
              <i class="bi bi-currency-rupee card-icon"></i>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-lg-4">
          <div class="card dashboard-card p-3">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h6>Active Items</h6>
                <h3><?php  echo $row2['total_item'] ?></h3>
              </div>
              <i class="bi bi-list-ul card-icon"></i>
            </div>
          </div>
        </div>
      </div>

    <!-- Order Summary Table -->
      <div class="mt-5">
        <h5 class="mb-3">Recent Orders</h5>
        <div class="table-responsive">
          <table class="table table-bordered table-hover">
            <thead class="table-dark">
              <tr>
                <th>#Order ID</th>
                <th>Customer</th>
                <th>Items</th>
                <th>Total</th>
                <th>Status</th>
              </tr>
            </thead>
             <tbody>
          <?php

              $res=mysqli_query($con,"select user.name as cus_name, item.name as item_name, order_items.* from order_items 
                                      inner join user on user.user_id=order_items.user_id
                                      inner join item on item.item_id=order_items.item_id
                                      where DATE(order_items.date) = CURDATE()
                                      and order_items.res_id='".$_SESSION['res_id']."'
                                      order by order_items.order_id DESC");
              while($details=mysqli_fetch_array($res))
              {
          ?>
                <tr>
                  <td>#<?php echo $details['order_id']?></td>
                  <td><?php echo $details['cus_name']?></td>
                  <td><?php echo $details['item_name']?></td>
                  <td><?php echo $details['price']?></td>
                  <?php
                  // Sample order_status from database
                  $order_status = $details['order_status']; // Example: "Delivered"

                  // Map status to Bootstrap badge classes
                  $status_classes = [
                      'Completed' => 'bg-success',
                      'Pending'   => 'bg-warning text-dark',
                      'Cancelled' => 'bg-danger',
                      'Accepted'   => 'bg-primary',
                      'Out for Delivery'   => 'bg-info'
                  ];

                  // Pick the correct class
                  $badge_class = $status_classes[$order_status] ?? 'bg-secondary';

                  // Output the badge
                  echo '<td><span class="badge ' . $badge_class . '">' . htmlspecialchars($order_status) . '</span></td>';
                  ?>

                </tr>
          <?php
              }
          ?>
      
           
              
            </tbody>
          </table>
        </div>
      </div>

    </main>
  </div>
</div>
<!-- My Account Modal -->
<div class="modal fade" id="accountModal" tabindex="-1" aria-labelledby="accountModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 shadow">
      <div class="modal-header bg-primary text-white rounded-top-4">
        <h5 class="modal-title" id="accountModalLabel"><i class="bi bi-person-circle me-2"></i>My Profile Details</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form action="update_account.php" method="POST">
        <div class="modal-body p-4">
          <input type="hidden" name="res_id" value="<?php echo $row['res_id']; ?>">

          <div class="mb-3">
            <label class="form-label">Restaurant Name</label>
            <input type="text" class="form-control" name="restaurantname" value="<?php echo $row['restaurantname']; ?>" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Owner Name</label>
            <input type="text" class="form-control" name="ownername" value="<?php echo $row['ownername']; ?>" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" value="<?php echo $row['email']; ?>" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" class="form-control" name="phone" value="<?php echo $row['phone']; ?>" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Address</label>
            <textarea class="form-control" name="address" rows="2"><?php echo $row['address']; ?></textarea>
          </div>
        </div>

        <div class="modal-footer bg-light rounded-bottom-4">
          <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Save Changes</button>
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
