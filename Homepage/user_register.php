<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Registration - FoodExpress</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="style.css">
 <link rel="stylesheet" href="user.css">
</head>
<body>

<!-- Navbar -->
<?php  include_once "navbar.php" ?>

<!-- Registration Form -->
<div class="register-wrapper">
  <div class="col-md-6 col-lg-5">
    <div class="card p-4 p-md-5">
      <div class="card-body">
        <h3 class="text-center mb-4 fw-bold">USER REGISTRATION</h3>
        <form action="user_register_logic.php" method="POST">
          <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" id="name" name="name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text"  id="phone" name="phone" class="form-control" required>
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
            <button type="submit" class="btn btn-primary">Register</button>
          </div>
          <p class="mt-3 text-center login-link">
            Already have an account? <a href="user_login.php">Login here</a>
          </p>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
