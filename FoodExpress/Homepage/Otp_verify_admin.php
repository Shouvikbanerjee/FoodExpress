<?php
session_start();

$error = '';
$success = false;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 

    if (!isset($_SESSION['OTP'])) {
        $error = "Session expired. Please request OTP again.";
    } else {
        $OTP = $_SESSION['OTP'];
        $matchOTP = $_POST['otp1'] . $_POST['otp2'] . $_POST['otp3'] . $_POST['otp4'] . $_POST['otp5'];

        if ($OTP == $matchOTP) {
            unset($_SESSION['OTP']); // Clear OTP after success
            header("Location: ../admin/home.php"); // Correct redirect
            exit(); // Important to stop script execution after redirect
        } else {
            $error = "Invalid OTP! Please try again.";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>OTP Verification</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(135deg, #dff6f0, #f4f9f9);
      font-family: 'Segoe UI', sans-serif;
    }
    .otp-card {
      background: #fff;
      padding: 40px 30px;
      border-radius: 20px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.08);
      text-align: center;
      animation: fadeIn 0.6s ease-in-out;
    }
    .otp-icon {
      font-size: 60px;
      color: #0d6efd;
      margin-bottom: 15px;
    }
    .otp-inputs input {
      width: 50px;
      height: 50px;
      font-size: 20px;
      text-align: center;
      border-radius: 10px;
      border: 1px solid #ccc;
      margin: 0 5px;
      outline: none;
      transition: border-color 0.3s;
    }
    .otp-inputs input:focus {
      border-color: #0d6efd;
      box-shadow: 0 0 5px rgba(13,110,253,0.3);
    }
    .btn-verify {
      border-radius: 50px;
      padding: 10px 30px;
    }
    @keyframes fadeIn {
      from {opacity: 0; transform: translateY(20px);}
      to {opacity: 1; transform: translateY(0);}
    }
    @media (max-width: 576px) {
      .otp-inputs input {
        width: 40px;
        height: 40px;
        font-size: 18px;
      }
    }
  </style>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center vh-100">
  <div class="col-md-6 col-lg-4">
    <div class="otp-card">
      <div class="otp-icon">
        <i class="bi bi-shield-lock-fill"></i>
      </div>
      <h4 class="fw-bold">OTP Verification</h4>
      <p class="text-muted">Enter the 5-digit code is <?php echo $_SESSION['OTP']?></p>

      <?php if ($error): ?>
        <div class="alert alert-danger py-2"><?php echo $error; ?></div>
      <?php endif; ?>

      <?php if ($success): ?>
        <div class="alert alert-success py-2">✅ OTP Verified! Redirecting...</div>
      <?php endif; ?>

      <form method="POST">
        <div class="otp-inputs d-flex justify-content-center mb-4">
          <input type="text" name="otp1" maxlength="1" required>
          <input type="text" name="otp2" maxlength="1" required>
          <input type="text" name="otp3" maxlength="1" required>
          <input type="text" name="otp4" maxlength="1" required>
          <input type="text" name="otp5" maxlength="1" required>
        </div>
        <button type="submit" class="btn btn-primary btn-verify">
          Verify OTP
        </button>
      </form>

    
    </div>
  </div>
</div>

<script>
  const inputs = document.querySelectorAll('.otp-inputs input');
  inputs.forEach((input, index) => {
    input.addEventListener('input', () => {
      if (input.value.length === 1 && index < inputs.length - 1) {
        inputs[index + 1].focus();
      }
    });
    input.addEventListener('keydown', (e) => {
      if (e.key === 'Backspace' && !input.value && index > 0) {
        inputs[index - 1].focus();
      }
    });
  });
</script>

</body>
</html>
