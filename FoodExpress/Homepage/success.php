<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Order Successful</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(135deg, #dff6f0, #f4f9f9);
      font-family: 'Segoe UI', sans-serif;
    }

    .success-card {
      background: #ffffff;
      border-radius: 20px;
      padding: 40px 20px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.08);
      animation: fadeInUp 0.8s ease;
    }

    .success-icon {
      font-size: 70px;
      color: #28a745;
      margin-bottom: 20px;
      animation: bounce 1.2s infinite;
    }

    .btn-home {
      border-radius: 50px;
      padding: 10px 30px;
      font-weight: 500;
    }

    .countdown {
      font-size: 0.95rem;
      color: #6c757d;
      margin-top: 10px;
    }

    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes bounce {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-6px); }
    }

    @media (max-width: 576px) {
      .success-card {
        padding: 30px 15px;
      }
      .success-icon {
        font-size: 55px;
      }
      .btn-home {
        width: 100%;
      }
    }
  </style>
</head>
<body>
  <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="col-md-8 col-lg-6">
      <div class="success-card text-center">
        <div class="success-icon">
          <i class="bi bi-check-circle-fill"></i>
        </div>
        <h2 class="text-success fw-bold mb-3">Booking Confirmed!</h2>
        <p class="lead">Thank you for your order.</p>
        <p>Your delicious <strong><?php echo htmlspecialchars($_SESSION['item_name'] ?? 'Item'); ?></strong> will be delivered soon! 🍽️</p>
        
        <a href="home.php" class="btn btn-outline-success btn-home mt-4">
          <i class="bi bi-house-door me-1"></i> Go to Home
        </a>

        <div class="countdown">Redirecting to Home in <span id="timer">10</span> seconds...</div>
      </div>
    </div>
  </div>

  <script>
    let timeLeft = 10;
    const timerElem = document.getElementById("timer");

    const countdown = setInterval(() => {
      timeLeft--;
      timerElem.textContent = timeLeft;
      if (timeLeft <= 0) {
        clearInterval(countdown);
        window.location.href = "home.php";
      }
    }, 1000);
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
