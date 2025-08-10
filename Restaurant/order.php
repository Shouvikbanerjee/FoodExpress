<?php
session_start();
if (!isset($_SESSION['res_id'])) {
    header("location:../Homepage/restaurant_login.php");
    exit();
}

include_once "../Homepage/connection.php";

$query = "SELECT * FROM restaurant WHERE res_id='" . $_SESSION['res_id'] . "'";
$res = mysqli_query($con, $query);
$row = mysqli_fetch_array($res);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Restaurant Orders | FoodExpress</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
  <link rel="stylesheet" href="style.css">
  <style>
    .topbar {
      background-color: #fff;
      padding: 1rem 1.5rem;
      border-radius: 0.5rem;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
      margin-bottom: 2rem;
    }
    .table-responsive {
      background-color: #fff;
      border-radius: 0.5rem;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      padding: 1rem;
    }
    .progress-step {
      flex: 1;
      text-align: center;
      position: relative;
      font-size: 0.85rem;
      color: #6c757d;
    }
    .progress-step::before {
      content: attr(data-step);
      display: inline-block;
      width: 2rem;
      height: 2rem;
      line-height: 2rem;
      border: 2px solid #6c757d;
      border-radius: 50%;
      background-color: white;
      margin-bottom: 0.5rem;
      z-index: 1;
      position: relative;
    }
    .progress-step.active {
      color: #0d6efd;
      font-weight: 600;
    }
    .progress-step.active::before {
      background-color: #0d6efd;
      border-color: #0d6efd;
      color: white;
    }
    .progress-step:not(:last-child)::after {
      content: '';
      position: absolute;
      top: 1rem;
      left: 50%;
      width: 100%;
      height: 3px;
      background-color: #6c757d;
      z-index: 0;
    }
    .progress-step.active:not(:last-child)::after {
      background-color: #0d6efd;
    }
  </style>
</head>
<body>

<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
   <?php  include_once "sidenav.php"?>

    <!-- Main content -->
    <main class="col-md-10 ms-sm-auto p-4">
      <div class="topbar d-flex justify-content-between align-items-center">
        <h3 class="fw-bold mb-0">Orders</h3>
        <button class="btn btn-outline-primary rounded-pill shadow-sm" onclick="location.reload();">
          <i class="bi bi-arrow-clockwise"></i> Refresh
        </button>
      </div>

    
      <div class="table-responsive">
        <table class="table table-striped align-middle">
          <thead class="table-dark">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Customer Name</th>
              <th scope="col">Item(s)</th>
              <th scope="col">Address</th>
              <th scope="col">Total Price</th>
              <th scope="col">Status</th>
              <th scope="col">Order Date</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
            
          <tbody>
            <?php
               
        $res=mysqli_query($con,"SELECT user.name as name,order_items.address, GROUP_CONCAT(item.name SEPARATOR ', ') AS items, 
        order_items.order_id, order_items.price, order_items.order_status, order_items.date,
        IFNULL(delivery_partner.p_name, 'Not assigned') as p_name, 
        IFNULL(delivery_partner.phone, 'Not assigned') as phone, 
        IFNULL(delivery_partner.email, '') as email
        FROM order_items  
        INNER JOIN user ON user.user_id=order_items.user_id 
        INNER JOIN item ON item.item_id=order_items.item_id 
        LEFT JOIN delivery_partner ON delivery_partner.dp_id=order_items.dp_id 
        WHERE order_items.res_id='".$_SESSION['res_id']."' 
        AND order_items.order_status IN ('Pending', 'Accepted', 'Completed','Out for Delivery')
        GROUP BY order_items.order_id 
        ORDER BY order_items.order_id DESC");
                
                function getStatusBadgeClass($status) {
                  return match($status) {
                    'Pending' => 'bg-warning text-dark',
                    'Accepted' => 'bg-primary text-white',
                    'Out for Delivery' => 'bg-info text-white',
                    'Completed' => 'bg-success text-white',
                    'Cancelled' => 'bg-danger text-white',
                    default => 'bg-secondary',
                  };
                }
                
                while($row=mysqli_fetch_assoc($res))
                {
                  $badgeClass = getStatusBadgeClass($row['order_status']);
            ?>
              <tr>
                <td><?php echo htmlspecialchars($row['order_id'])?></td>
                <td><?php  echo htmlspecialchars($row['name'])?></td>
                <td><?php  echo htmlspecialchars($row['items'])?></td>
                <td><?php  echo htmlspecialchars($row['address'])?></td>
                <td>₹<?php  echo number_format($row['price'], 2)?></td>
                <td><span class="badge <?php echo $badgeClass; ?>"><?php echo $row['order_status']; ?></span></td>
                <td><?php  echo $row['date']?></td>
                <td>
               <button
                class="btn btn-sm btn-outline-primary me-2 view-details-btn"
                title="View Details"
                data-orderid="<?php echo $row['order_id']; ?>"
                data-customer="<?php echo htmlspecialchars($row['name']); ?>"
                data-items-list="<?php echo htmlspecialchars(json_encode(explode(',', $row['items']))); ?>"
                data-total="<?php echo $row['price']; ?>"
                data-status="<?php echo $row['order_status']; ?>"
                data-orderdate="<?php echo $row['date']; ?>"
                data-address="<?php echo htmlspecialchars($row['address']); ?>"
                
     
             data-dpname="<?php echo htmlspecialchars($row['p_name']); ?>"
data-dpmobile="<?php echo htmlspecialchars($row['phone']); ?>"
data-dpemail="<?php echo htmlspecialchars($row['email']); ?>"
              >
                <i class="bi bi-eye"></i>
              </button>


                </td>
              </tr>
            <?php
                }
            ?>
          </tbody>
        </table>
      </div>
    </main>
  </div>
</div>

<!-- Upgraded Order Details Modal with action buttons -->
<div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-labelledby="orderDetailsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content shadow-sm border-0 rounded-4">
      <div class="modal-header bg-dark text-white rounded-top-4">
        <h5 class="modal-title" id="orderDetailsModalLabel">
          <i class="bi bi-card-list me-2"></i> Order Details
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form id="orderActionForm" method="POST" action="update_order_status.php">
      <div class="modal-body px-4 py-3">
        <input type="hidden" name="order_id" id="modalOrderIDInput" value="">
        <div class="row g-3">
          <div class="col-md-6">
            <h6><i class="bi bi-hash text-primary me-1"></i><strong>Order ID:</strong> <span id="modalOrderID"></span></h6>
          </div>
          <div class="col-md-6">
            <h6><i class="bi bi-person-fill text-primary me-1"></i><strong>Customer:</strong> <span id="modalCustomerName"></span></h6>
          </div>
          <div class="col-md-12">
            <h6><i class="bi bi-basket text-primary me-1"></i><strong>Items Ordered:</strong></h6>
            <ul id="modalItemsList" class="list-group list-group-flush ps-3"></ul>
          </div>
          <div class="col-md-12">
            <h6><i class="bi bi-geo-alt-fill text-primary me-1"></i><strong>Delivery Address:</strong> <span id="modalAddress"></span></h6>
          </div>
          
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




          <div class="col-md-6">
            <h6><i class="bi bi-wallet2 text-primary me-1"></i><strong>Total Price:</strong> ₹<span id="modalTotalPrice"></span></h6>
          </div>
          <div class="col-md-6">
            <h6><i class="bi bi-clipboard-check text-primary me-1"></i><strong>Status:</strong> 
              <span id="modalStatus" class="badge fs-6 px-2 py-1"></span>
            </h6>
          </div>
          <div class="col-md-12">
            <h6><i class="bi bi-clock-history text-primary me-1"></i><strong>Ordered At:</strong> <span id="modalOrderDate"></span></h6>
          </div>
        </div>

        <hr>

        

      </div>

      <div class="modal-footer bg-light rounded-bottom-4" id="modalButtons">
        <!-- Buttons will be inserted dynamically here -->
      </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document.querySelectorAll('.view-details-btn').forEach(button => {
    button.addEventListener('click', () => {
      const orderId = button.getAttribute('data-orderid');
      const customer = button.getAttribute('data-customer');
      const itemsList = JSON.parse(button.getAttribute('data-items-list'));
      const total = button.getAttribute('data-total');
      const status = button.getAttribute('data-status');
      const orderDate = button.getAttribute('data-orderdate');

      document.getElementById('modalOrderID').textContent = '#' + orderId;
      document.getElementById('modalOrderIDInput').value = orderId;
      document.getElementById('modalCustomerName').textContent = customer;

      const ul = document.getElementById('modalItemsList');
      ul.innerHTML = ''; // clear previous items
      itemsList.forEach(item => {
        const li = document.createElement('li');
        li.textContent = item.trim();
        ul.appendChild(li);
      });
      





  const dpName = button.getAttribute('data-dpname');
const dpMobile = button.getAttribute('data-dpmobile');
const dpEmail = button.getAttribute('data-dpemail');

const partnerSection = document.getElementById('deliveryPartnerSection');

// Show section only if delivery partner is assigned (not "Not assigned")
if (dpName && dpName !== 'Not assigned') {
    partnerSection.style.display = 'block';
    document.getElementById('modalDPName').textContent = dpName;
    document.getElementById('modalDPMobile').textContent = dpMobile;
    
    // Add call button if mobile number exists and order isn't completed
    if (dpMobile && dpMobile !== 'Not assigned' && status !== 'Completed') {
        document.getElementById('modalDPMobile').innerHTML = 
            dpMobile + ' <a href="tel:' + dpMobile + '" class="btn btn-sm btn-outline-primary ms-2">📞 Call</a>';
    }
    
    document.getElementById('modalDPEmail').textContent = dpEmail || 'N/A';
} else {
    partnerSection.style.display = 'none';
}


      document.getElementById('modalTotalPrice').textContent = parseFloat(total).toFixed(2);

      // Status badge with color
      const statusSpan = document.getElementById('modalStatus');
      statusSpan.textContent = status;
      statusSpan.className = 'badge px-2 py-1 fs-6 ' + (() => {
        switch(status) {
          case 'Pending': return 'bg-warning text-dark';
          case 'Accepted': return 'bg-primary text-white';
          case 'Out for Delivery': return 'bg-info text-white';
          case 'Completed': return 'bg-success text-white';
          case 'Cancelled': return 'bg-danger text-white';
          default: return 'bg-secondary';
        }
      })();

      const address = button.getAttribute('data-address');
document.getElementById('modalAddress').textContent = address;

      document.getElementById('modalOrderDate').textContent = orderDate;

      // Update progress steps active class based on status
      const steps = document.querySelectorAll('.progress-step');
      let activeStep = 1;
      switch(status) {
        case 'Pending': activeStep = 1; break;
        case 'Accepted': activeStep = 2; break;
        case 'Out for Delivery': activeStep = 3; break;
        case 'Completed': activeStep = 4; break;
        default: activeStep = 0;
      }
      steps.forEach((step, index) => {
        if(index < activeStep) {
          step.classList.add('active');
        } else {
          step.classList.remove('active');
        }
      });

      // Build buttons dynamically based on current status
      const modalButtons = document.getElementById('modalButtons');
      modalButtons.innerHTML = ''; // clear previous buttons

      // Helper to create a button with form submit
      function createActionButton(text, value, btnClass, iconClass) {
        const btn = document.createElement('button');
        btn.type = 'submit';
        btn.name = 'action';
        btn.value = value;
        btn.className = 'btn ' + btnClass + ' me-2 d-flex align-items-center';
        btn.innerHTML = `<i class="${iconClass} me-1"></i> ${text}`;
        return btn;
      }

      if (status === 'Pending') {
        // Show Accept and Cancel buttons
        modalButtons.appendChild(createActionButton('Accept', 'accept', 'btn-primary', 'bi bi-check-circle'));
        modalButtons.appendChild(createActionButton('Cancel', 'cancel', 'btn-danger', 'bi bi-x-circle'));
      } else if (status === 'Accepted') {
        // Show Out for Delivery button
        modalButtons.appendChild(createActionButton('Mark Out for Delivery', 'out_for_delivery', 'btn-info', 'bi bi-truck'));
      } else if (status === 'Out for Delivery' || status === 'Completed') {
        // Show only Close button (already exists)
        // So add a Details/Close button that just dismisses modal:
        const closeBtn = document.createElement('button');
        closeBtn.type = 'button';
        closeBtn.className = 'btn btn-outline-secondary d-flex align-items-center';
        closeBtn.setAttribute('data-bs-dismiss', 'modal');
        closeBtn.innerHTML = '<i class="bi bi-x-circle me-1"></i> Close';
        modalButtons.appendChild(closeBtn);
      } else {
        // For Cancelled or other statuses, just show Close button
        const closeBtn = document.createElement('button');
        closeBtn.type = 'button';
        closeBtn.className = 'btn btn-outline-secondary d-flex align-items-center';
        closeBtn.setAttribute('data-bs-dismiss', 'modal');
        closeBtn.innerHTML = '<i class="bi bi-x-circle me-1"></i> Close';
        modalButtons.appendChild(closeBtn);
      }

      // Show modal
      const orderModal = new bootstrap.Modal(document.getElementById('orderDetailsModal'));
      orderModal.show();
    });
  });
</script>

</body>
</html>
