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
  <title>Restaurants | FoodExpress</title>
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

    .restaurant-logo {
      width: 45px;
      height: 45px;
      border-radius: 8px;
      object-fit: cover;
      border: 1px solid #ccc;
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
        <h3 class="fw-bold mb-0 text-dark">🏪 All Restaurants</h3>
         <button class="btn btn-outline-primary rounded-pill shadow-sm" onclick="location.reload();">
          <i class="bi bi-arrow-clockwise me-1"></i> Refresh
        </button>
      </div>
     
      <!-- Restaurant Table -->
      <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle rounded-3 overflow-hidden">
          <thead>
            <tr>
              <th>#</th>
              <th>Shop Name</th>
              <th>Owner Name</th>
              <th>Phone</th>
              <th>Email</th>
              <th>Address</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
             <?php
                include_once "../Homepage/connection.php";

                $query_str="select * from restaurant";

                $res=mysqli_query($con,$query_str);
                $count=1;
                while($row=mysqli_fetch_array($res))
                {

             ?>
            <tr>
              <td><?php  echo $count++ ?></td>
              <td><?php  echo $row['restaurantname'] ?></td>
              <td><?php  echo $row['ownername'] ?></td>
              <td><?php  echo $row['phone'] ?></td>
              <td><?php  echo $row['email'] ?></td>
              <td><?php  echo $row['address'] ?></td>
              <td>
                <button class="btn btn-sm btn-outline-primary me-1 editBtn"
                  data-bs-toggle="modal"
                  data-bs-target="#editRestaurantModal"
                  data-id="<?= $row['res_id']; ?>"
                  data-name="<?= htmlspecialchars($row['restaurantname']); ?>"
                  data-owner="<?= htmlspecialchars($row['ownername']); ?>"
                  data-phone="<?= $row['phone']; ?>"
                  data-email="<?= $row['email']; ?>">
                  <i class="bi bi-eye"></i>
                </button>

              
              </td>
            </tr>
            <?php

        }

          ?>
            <!-- More rows can be added here -->
          </tbody>
        </table>
      </div>
    </main>
  </div>
</div>




      <!-- Edit Restaurant Modal -->
<div class="modal fade" id="editRestaurantModal" tabindex="-1" aria-labelledby="editRestaurantModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content rounded-4">
      <div class="modal-header bg-primary text-white rounded-top">
        <h5 class="modal-title">View Restaurant Details</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="res_id" id="resId">

        <div class="mb-3">
          <label class="form-label">Restaurant Name</label>
          <input type="text" class="form-control" name="restaurantname" id="restaurantName" readonly />
        </div>

        <div class="mb-3">
          <label class="form-label">Owner Name</label>
          <input type="text" class="form-control" name="ownername" id="ownerName" readonly />
        </div>

        <div class="mb-3">
          <label class="form-label">Phone</label>
          <input type="text" class="form-control" name="phone" id="phone" readonly />
        </div>

        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" class="form-control" name="email" id="email" readonly />
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-light" data-bs-dismiss="modal">Close</button>
        
      </div>
    </form>
  </div>
</div>



<!-- Delete Restaurant Modal -->
<div class="modal fade" id="deleteRestaurantModal" tabindex="-1" aria-labelledby="deleteRestaurantModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content rounded-4">
      <div class="modal-header bg-danger text-white rounded-top">
        <h5 class="modal-title" id="deleteRestaurantModalLabel">Delete Restaurant</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this restaurant?
      </div>
      <div class="modal-footer">
        <button class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-danger">Delete</button>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
 <script>
  const editButtons = document.querySelectorAll(".editBtn");
  const resId = document.getElementById("resId");
  const resName = document.getElementById("restaurantName");
  const ownerName = document.getElementById("ownerName");
  const phone = document.getElementById("phone");
  const email = document.getElementById("email");

  editButtons.forEach(btn => {
    btn.addEventListener("click", () => {
      resId.value = btn.getAttribute("data-id");
      resName.value = btn.getAttribute("data-name");
      ownerName.value = btn.getAttribute("data-owner");
      phone.value = btn.getAttribute("data-phone");
      email.value = btn.getAttribute("data-email");
    });
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
