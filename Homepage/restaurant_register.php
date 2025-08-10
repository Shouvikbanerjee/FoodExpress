<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Restaurant Registration - FoodExpress</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="restaurant.css">
</head>
<body>

  <!-- Navbar -->
<?php   include_once "navbar.php" ?>

  <!-- Registration Form -->
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-7 col-lg-6">
        <div class="card p-4 p-md-5">
          <div class="card-body">
            <h3 class="text-center mb-4 fw-bold"> RESTAURANT REGISTRATION</h3>
            <form action="restaurant_register_logic.php" method="POST">
              <div class="mb-3">
                <label class="form-label">Restaurant Name</label>
                <input type="text" id="res_name" name="res_name" class="form-control" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Owner Name</label>
                <input type="text" id="owner" name="owner" class="form-control" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" id="phone" name="phone" class="form-control" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Address</label>
                <input type="text" id="address" name="address" class="form-control" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
              </div>
              <div class="d-grid">
                <button type="submit" class="btn btn-success">Register</button>
              </div>
              <p class="mt-3 text-center">
                Already registered? <a href="restaurant_login.php">Login here</a>
              </p>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
