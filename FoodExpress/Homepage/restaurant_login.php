<?php
session_start();
include_once "connection.php";

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query_str = "SELECT * FROM restaurant WHERE email = '$email'";
    $res = mysqli_query($con, $query_str);

    if ($res && mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_array($res);

        if ($password == $row['password']) {
            $_SESSION['res_id'] = $row['res_id'];
            $_SESSION['OTP']=rand(11111,55555);
            header("Location: ../Homepage/Otp_verify_res.php");
            exit();
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "Restaurant not found!";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Restaurant Login - FoodExpress</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="restaurant.css">
</head>
<body>

  <!-- Navbar -->
<?php  include_once "navbar.php" ?>

  <!-- Login Form -->
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-6 col-lg-5">
        <div class="card p-4 p-md-5">
          <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
          <?php endif; ?>
          <div class="card-body">
            <h3 class="text-center mb-4 fw-bold">RESTAURANT LOGIN</h3>
            <form action="" method="POST">
              <div class="mb-3">
                <label class="form-label">Email address</label>
                <input type="email" id="email" name="email" class="form-control" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
              </div>
              <div class="d-grid">
                <button type="submit" class="btn btn-success">Login</button>
              </div>
              <p class="mt-3 text-center">
                Don't have an account? <a href="restaurant_register.php">Register here</a>
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
