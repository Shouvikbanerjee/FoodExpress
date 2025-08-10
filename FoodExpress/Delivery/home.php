<?php
session_start();

// Check if email exists in session
if (!isset($_SESSION['email'])) {
    die("Access denied. Please login.");
}

$_SESSION['OTP'] = rand(11111, 99999); // Generates a 5-digit OTP

include_once "../Homepage/connection.php";

// Secure the email input
$email_safe = mysqli_real_escape_string($con, $_SESSION['email']);

// Query delivery partner data
$query = "SELECT * FROM delivery_partner WHERE email = '$email_safe'";
$res = mysqli_query($con, $query);

// Check if data was found
if ($row1 = mysqli_fetch_assoc($res)) {
    $_SESSION['address'] = $row1['address'];
    $_SESSION['dp_id'] = $row1['dp_id'];
} else {
    die("Delivery partner not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Delivery partner Dashboard | FoodExpress</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
  <link rel="stylesheet" href="style.css">
</head>
<body>


   
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

          $result1=mysqli_query($con,"select count(*) as total_orders from order_items where dp_id='".$_SESSION['dp_id']."'");
          $row0=mysqli_fetch_assoc($result1);

          $result2=mysqli_query($con,"select count(*) as total_orders from order_items where dp_id='".$_SESSION['dp_id']."'");
          $row2=mysqli_fetch_assoc($result2);

          $amount=70*$row2['total_orders'];

          $result3 = mysqli_query($con, " SELECT COUNT(*) AS todays_orders FROM order_items WHERE dp_id = '" . intval($_SESSION['dp_id']) . "'
          AND DATE(date) = CURDATE()");

          $row3=mysqli_fetch_assoc($result3);
      ?>
      <!-- Dashboard Cards -->
      <div class="row g-4">
        <div class="col-sm-6 col-lg-4">
          <div class="card dashboard-card p-3">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h6>Total Orders</h6>
                <h3><?php echo $row0['total_orders']  ?></h3>
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
                <h3><?php echo $amount  ?></h3>
              </div>
              <i class="bi bi-currency-rupee card-icon"></i>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-lg-4">
          <div class="card dashboard-card p-3">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h6>Today's Orders</h6>
                <h3><?php echo $row3['todays_orders']  ?></h3>
              </div>
              <i class="bi bi-list-ul card-icon"></i>
            </div>
          </div>
        </div>
      </div>



      <!-- Include Bootstrap CSS & JS in your page head or before closing body -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<div class="mt-5">
 
  <h5 class="mb-3">Ongoing Orders</h5>
  <div class="table-responsive">
    <table class="table table-bordered table-hover align-middle">
      <?php
        include_once "../Homepage/connection.php";

        // Example: get delivery partner's location (replace with real logic, maybe from session)
        $location ="burdwan"; // Replace this with dynamic location from login/session

        $location_safe = mysqli_real_escape_string($con, $location);

$dp_id_safe = intval($_SESSION['dp_id']); // logged-in delivery partner id

$res = mysqli_query($con, "
  SELECT 
    u.name AS user_name,
    u.phone as user_phone,
    u.address AS delivery_address,
    r.restaurantname AS res_name,
    r.address AS res_address,
    i.name AS item_name,
    oi.*
  FROM order_items oi
  INNER JOIN user u ON u.user_id = oi.user_id 
  INNER JOIN item i ON i.item_id = oi.item_id
  INNER JOIN restaurant r ON r.res_id = oi.res_id
  LEFT JOIN delivery_status_map dsm ON dsm.order_id = oi.order_id
  WHERE r.address = '$location_safe'
    AND DATE(oi.date) = CURDATE()
    AND oi.order_status = 'Accepted'
    AND (
        -- Case 1: No delivery partner assigned yet
        dsm.dp_id IS NULL 
        
        -- Case 2: The order was cancelled by a partner (not the current one)
        OR (dsm.delivery_status = 'Cancelled' AND dsm.dp_id != $dp_id_safe)
        
        -- Case 3: This partner is already assigned (still needs to see it)
        OR (dsm.dp_id = $dp_id_safe AND dsm.delivery_status NOT IN ('Cancelled', 'Completed'))
    )
  ORDER BY oi.order_id ASC
  LIMIT 1
");






      ?>
      <thead class="table-dark">
        <tr>
          <th>#Order ID</th>
          <th>Customer</th>
          <th>Restaurant</th>
          <th>Delivery Address</th>
          <th>Restaurant Address</th>
          <th>Items</th>
          <th>Customer Mobile No.</th>
          <th>Total</th>
          <th>Action</th>  
        </tr>
      </thead>
      <tbody>
        <?php while ($row = mysqli_fetch_assoc($res)) { ?>
          <tr>
            <td>#<?php echo $row['order_id']; ?></td>
            <td><?php echo $row['user_name']; ?></td>
            <td><?php echo $row['res_name']; ?></td>
            <td><?php echo $row['delivery_address']; ?></td>
            <td><?php echo $row['res_address']; ?></td>
            <td><?php echo $row['item_name']; ?></td>
            <td><?php echo $row['user_phone']; ?></td>
            <td>₹<?php echo $row['price']; ?></td>
           <td>
            <div class="order-actions">
<button 
  class="btn btn-sm btn-primary accept-btn" 
  data-dp-id="<?php echo $_SESSION['dp_id']; ?>" 
  data-order-id="<?php echo $row['order_id']; ?>">
  Accept
</button>



              <button class="btn btn-sm btn-danger cancel-btn" data-order-id="<?php echo $row['order_id']; ?>">Cancel</button>
              <button class="btn btn-sm btn-success otp-btn d-none" data-bs-toggle="modal" data-bs-target="#otpModal" data-order-id="<?php echo $row['order_id']; ?>">Enter OTP</button>
            </div>
          </td>



          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>


<input type="hidden" id="dpId" value="<?= $_SESSION['dp_id'] ?>">

<!-- OTP Modal -->
<!-- Modern OTP Modal -->
<div class="modal fade" id="otpModal" tabindex="-1" aria-labelledby="otpModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm"> <!-- smaller modal -->
    <div class="modal-content rounded-4 shadow-lg border-0">
      <div class="modal-header bg-primary text-white rounded-top-4">
        <h5 class="modal-title d-flex align-items-center gap-2" id="otpModalLabel">
          <i class="bi bi-shield-lock-fill fs-4"></i> OTP Verification is <?php echo $_SESSION['OTP'] ?>
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="otpForm" method="POST" action="verify_otp.php" class="p-4">
        <div class="mb-4">
          <label for="otpInput" class="form-label fw-semibold">Enter OTP</label>
          <input type="text" class="form-control form-control-lg rounded-3" id="otpInput" name="otp" placeholder="5-digit OTP" maxlength="5" required autofocus pattern="\d{5}" title="Enter 5-digit OTP">
        </div>
        <input type="hidden" name="order_id" id="otp-order-id" value="">
        <button type="submit" class="btn btn-primary w-100 btn-lg rounded-3">
          <i class="bi bi-check-circle me-2"></i> Verify OTP
        </button>
      </form>
    </div>
  </div>
</div>




<!-- Cancel Confirmation Modal -->
<div class="modal fade" id="cancelConfirmModal" tabindex="-1" aria-labelledby="cancelConfirmLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 shadow">
      <div class="modal-header bg-danger text-white rounded-top-4">
        <h5 class="modal-title" id="cancelConfirmLabel"><i class="bi bi-exclamation-triangle me-2"></i>Confirm Cancellation</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to cancel this order?
      </div>
      <div class="modal-footer">
        <button type="button" id="confirmCancelBtn" class="btn btn-danger">Yes, Cancel Order</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No, Keep Order</button>
      </div>
    </div>
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
          <input type="hidden" name="dp_id" value="<?php echo $row1['dp_id']; ?>">

          <div class="mb-3">
            <label class="form-label">Restaurant Name</label>
            <input type="text" class="form-control" name="p_name" value="<?php echo $row1['p_name']; ?>" required>
          </div>


          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" value="<?php echo $row1['email']; ?>" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" class="form-control" name="phone" value="<?php echo $row1['phone']; ?>" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Address</label>
            <textarea class="form-control" name="address" rows="2"><?php echo $row1['address']; ?></textarea>
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





<script>
document.addEventListener("DOMContentLoaded", function () {
    const alertPlaceholder = document.getElementById('alert-placeholder');

    function showAlert(message, type = 'success') {
        const wrapper = document.createElement('div');
        wrapper.innerHTML = `
          <div class="alert alert-${type} alert-dismissible fade show" role="alert">
              ${message}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>`;
        alertPlaceholder.append(wrapper);
        setTimeout(() => {
            wrapper.remove();
        }, 4000);
    }

    document.querySelectorAll(".accept-btn").forEach(button => {
        button.addEventListener("click", function () {
            const dp_id = this.getAttribute("data-dp-id");
            const order_id = this.getAttribute("data-order-id");
            const container = this.closest("tr"); // ✅ fixed

            fetch("accept_order.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: `dp_id=${dp_id}&order_id=${order_id}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    container.querySelector(".accept-btn").classList.add("d-none");
                    container.querySelector(".cancel-btn").classList.add("d-none");

                    const otpBtn = container.querySelector(".otp-btn");
                    otpBtn.classList.remove("d-none");

                    // Bind OTP modal opening event
                    otpBtn.addEventListener("click", function (e) {
                        e.preventDefault();
                        document.getElementById("otp-order-id").value = order_id;
                        const otpModal = new bootstrap.Modal(document.getElementById('otpModal'));
                        otpModal.show();
                    });

                    showAlert('Order accepted successfully!', 'success');
                } else {
                    showAlert(data.message || 'Something went wrong.', 'danger');
                }
            })
            .catch(error => {
                console.error(error);
                showAlert('An error occurred while processing the request.', 'danger');
            });
        });
    });
});



document.addEventListener("DOMContentLoaded", function () {
    let orderIdToCancel = null;
    let dpId = document.getElementById("dpId")?.value || ""; // Assuming <input type="hidden" id="dpId" value="...">

    // Open cancel confirmation modal
    document.querySelectorAll(".cancel-btn").forEach(button => {
        button.addEventListener("click", function () {
            orderIdToCancel = this.getAttribute("data-order-id");
            const cancelModal = new bootstrap.Modal(document.getElementById("cancelConfirmModal"));
            cancelModal.show();
        });
    });

    // Confirm cancellation
    document.getElementById("confirmCancelBtn").addEventListener("click", function () {
        if (!orderIdToCancel || !dpId) return;

        fetch("cancel_order.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `order_id=${orderIdToCancel}&dp_id=${dpId}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                const row = document.querySelector(`.cancel-btn[data-order-id="${orderIdToCancel}"]`).closest("tr");
                row.remove(); // remove row or update UI
                showAlert("Order cancelled successfully", "success");
            } else {
                showAlert(data.message || "Failed to cancel order", "danger");
            }
        })
        .catch(error => {
            console.error("Cancel error:", error);
            showAlert("Error cancelling order", "danger");
        });

        // Close modal
        bootstrap.Modal.getInstance(document.getElementById("cancelConfirmModal")).hide();
    });
});



</script>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
