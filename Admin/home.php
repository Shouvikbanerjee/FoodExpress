<?php
session_start();
include_once "../Homepage/connection.php";

if (!isset($_SESSION['admin_id'])) {
    header("location:../Homepage/admin_login.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_admin'])) {
    $name = $_POST['admin_name'];
    $email = $_POST['admin_email'];
    $phone = $_POST['admin_phone'];
    $password = $_POST['admin_password'];

    $update_query = "UPDATE admin SET name='$name', email='$email', phone='$phone', password='$password' WHERE admin_id='".$_SESSION['admin_id']."'";
    mysqli_query($con, $update_query);

    // Optional: redirect to refresh data
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}

$query = "SELECT * FROM admin WHERE admin_id='".$_SESSION['admin_id']."'";
$res = mysqli_query($con, $query);
$row = mysqli_fetch_array($res);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard | FoodExpress</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

  <link rel="stylesheet" href="style.css">
     <style>
  .dashboard-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(12, 12, 12, 0.79);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    background: linear-gradient(135deg, #e2dcdcff, #fff8f8ff);
    min-height: 140px;
  }
  .dashboard-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
  }
  .dashboard-card h6 {
    font-size: 0.9rem;
    color: #244e72ff;
    font-weight: 500;
  }
  .dashboard-card h3 {
    font-weight: bold;
    color: #333;
  }
  .card-icon {
    font-size: 2.2rem;
    color: #6c63ff; /* Accent color */
  }
</style>
</head>
<body>



<div class="container-fluid">
  <div class="row">

    <!-- Sidebar -->
    
    <?php  include_once "sidenav.php"  ?>

    <!-- Main Content -->
    <main class="col-md-10 p-4 main-content">
      <!-- Topbar -->
      <div class="topbar d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0 fw-bold">Dashboard</h3>
        <button class="btn btn-outline-dark rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#editAdminModal">
          <i class="bi bi-person-circle me-2"></i>Profile
        </button>

      </div>

      <?php


          $res=mysqli_query($con,"SELECT COUNT(*) AS total_items FROM order_items ");
          $row=mysqli_fetch_array($res);

          $res1=mysqli_query($con,"SELECT COUNT(*) AS total_users FROM user ");
          $row1=mysqli_fetch_array($res1);

          $res2=mysqli_query($con,"SELECT COUNT(*) AS total_restaurants FROM restaurant ");
          $row2=mysqli_fetch_array($res2);

          $res3=mysqli_query($con,"SELECT COUNT(*) AS total_partners FROM delivery_partner ");
          $row3=mysqli_fetch_array($res3);
      ?>
   

<div class="row g-4">
  <div class="col-lg-3 col-md-6 col-sm-6">
    <div class="card dashboard-card p-3">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h6>Total Orders</h6>
          <h3><?php echo $row['total_items'] ?></h3>
        </div>
        <i class="bi bi-basket card-icon"></i>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-sm-6">
    <div class="card dashboard-card p-3">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h6>Total Users</h6>
          <h3><?php echo $row1['total_users'] ?></h3>
        </div>
        <i class="bi bi-person card-icon"></i>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-sm-6">
    <div class="card dashboard-card p-3">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h6>Total Restaurants</h6>
          <h3><?php echo $row2['total_restaurants'] ?></h3>
        </div>
        <i class="bi bi-shop-window card-icon"></i>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-sm-6">
    <div class="card dashboard-card p-3">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h6>Total Delivery Partner</h6>
          <h3><?php echo number_format($row3['total_partners']) ?></h3>
        </div>
        <i class="bi bi-person card-icon"></i>
      </div>
    </div>
  </div>
</div>




    </main>
  </div>
</div>
<?php

    include_once "../Homepage/connection.php";

    $query="select * from admin where admin_id='".$_SESSION['admin_id']."'";

    $res=mysqli_query($con,$query);

    $row=mysqli_fetch_array($res);


?>
<!-- Edit Admin Modal -->
<div class="modal fade" id="editAdminModal" tabindex="-1" aria-labelledby="editAdminModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <form method="post" class="modal-content rounded-4 shadow-sm border-0">
      <div class="modal-header bg-primary text-white rounded-top">
        <h5 class="modal-title" id="editAdminModalLabel">
          <i class="bi bi-person-circle me-2"></i>Edit Admin Details
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body px-5 py-4">
        <div class="mb-4">
          <label for="adminName" class="form-label fw-semibold">Full Name</label>
          <input type="text" class="form-control form-control-lg rounded-pill" id="adminName" name="admin_name" value="<?php echo $row['name']; ?>" required />
        </div>
        <div class="mb-4">
          <label for="adminEmail" class="form-label fw-semibold">Email</label>
          <input type="email" class="form-control form-control-lg rounded-pill" id="adminEmail" name="admin_email" value="<?php echo $row['email']; ?>" required />
        </div>
        <div class="mb-4">
          <label for="adminPhone" class="form-label fw-semibold">Phone</label>
          <input type="tel" class="form-control form-control-lg rounded-pill" id="adminPhone" name="admin_phone" value="<?php echo $row['phone']; ?>" required />
        </div>
        <div class="mb-3">
          <label for="adminPassword" class="form-label fw-semibold">Password</label>
          <input type="password" class="form-control form-control-lg rounded-pill" id="adminPassword" name="admin_password" value="<?php echo $row['password']; ?>" required />
        </div>
      </div>

      <div class="modal-footer border-0 px-5 pb-4 pt-0">
        <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" name="update_admin" class="btn btn-primary rounded-pill px-4">Save Changes</button>
      </div>
    </form>
  </div>
</div>


      

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
