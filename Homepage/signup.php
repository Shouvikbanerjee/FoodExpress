<!-- login_portal.html -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Choose Portal | FoodExpress</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <!-- Navbar (Shared) -->
 <?php  include_once "navbar.php" ?>

  <!-- Main Content -->
  <div class="container login-container">
    <h2 class="text-center mb-5 fw-bold">Choose Your Account</h2>
    <div class="row g-4">

      <!-- User Login Card -->
      <div class="col-md-4">
        <div class="card card-login text-center h-100">
          <div class="card-body">
            <img src="https://cdn-icons-png.flaticon.com/512/1077/1077114.png" alt="user" width="60" class="mb-3">
            <h5 class="card-title">User Login</h5>
            <p class="card-text">Access your account and place orders easily.</p>
            <a href="user_login.php" class="btn btn-primary">Login as User</a>
          </div>
        </div>
      </div>

      <!-- Restaurant Login Card -->
      <div class="col-md-4">
        <div class="card card-login text-center h-100">
          <div class="card-body">
            <img src="https://cdn-icons-png.flaticon.com/512/3176/3176364.png" alt="restaurant" width="60" class="mb-3">
            <h5 class="card-title">Restaurant Login</h5>
            <p class="card-text">Manage your menu and view customer orders.</p>
            <a href="restaurant_login.php" class="btn btn-success">Login as Restaurant</a>
          </div>
        </div>
      </div>

      <!-- Admin Login Card -->
      <div class="col-md-4">
        <div class="card card-login text-center h-100">
          <div class="card-body">
            <img src="https://cdn-icons-png.flaticon.com/512/1828/1828490.png" alt="admin" width="60" class="mb-3">
            <h5 class="card-title">Admin Login</h5>
            <p class="card-text">Monitor and manage the full platform operations.</p>
            <a href="admin_login.php" class="btn btn-dark">Login as Admin</a>
          </div>
        </div>
      </div>

       <!-- Delivery Partner Login Card -->
      <div class="col-md-4">
        <div class="card card-login text-center h-100">
          <div class="card-body">
            <img src="https://cdn-icons-png.flaticon.com/512/3176/3176364.png" alt="admin" width="60" class="mb-3">
            <h5 class="card-title">Delivery Partner Login</h5>
            <p class="card-text">Monitor and manage the full platform operations.</p>
            <a href="delivery_login.php" class="btn btn-dark">Login as Delivery Partner</a>
          </div>
        </div>
      </div>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
