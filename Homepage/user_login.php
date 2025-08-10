<?php
session_start();
include_once "connection.php";

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query_str = "SELECT * FROM user WHERE email = '$email'";
    $res = mysqli_query($con, $query_str);

    if ($res && mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_array($res);

        if ($password == $row['password']) {
            $_SESSION['email'] = $row['email'];
            $_SESSION['OTP']=rand(11111,55555);
            header("Location: ../Homepage/Otp_verify.php");
            exit();
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "User not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>User Login - FoodExpress</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="style.css">
 <link rel="stylesheet" href="user.css">
</head>
<body>

  <!-- Navbar -->
<?php  include_once "navbar.php" ?>

  <!-- Login Form -->
  <div class="login-wrapper">
    <div class="col-md-5 col-lg-4">
      <div class="card p-4 p-md-5">
         <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
          <?php endif; ?>
        <div class="card-body">
          <h3 class="text-center mb-4 fw-bold">USER LOGIN</h3>
          <form action="user_login.php" method="POST">
            <div class="mb-3">
              <label for="email" class="form-label">Email address</label>
              <input type="email" name="email" class="form-control" id="email" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" name="password" class="form-control" id="password" required>
            </div>
            <div class="d-grid">
              <button type="submit" class="btn btn-primary">Login</button>
            </div>
            <p class="mt-3 text-center register-link">
              Don’t have an account? <a href="user_register.php">Register here</a>
            </p>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
