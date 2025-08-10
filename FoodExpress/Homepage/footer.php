<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>FoodExpress Footer</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>

  <style>
    footer {
      background: linear-gradient(135deg, #181817ff, #3b230cff); /* vibrant orange-pink gradient */
      color: #fff;
    }

    .footer-link {
      display: block;
      color: #f5f5f5;
      text-decoration: none;
      margin-bottom: 8px;
      transition: all 0.3s ease;
    }

    .footer-link:hover {
      color: #fff;
      text-decoration: underline;
    }

    .footer-social {
      font-size: 1.4rem;
      color: #f0f0f0;
      transition: all 0.3s ease;
    }

    .footer-social:hover {
      color: #ffffff;
      transform: scale(1.2);
    }

    .footer-heading {
      color: #ffffff;
    }

    .footer-text-muted {
      color: rgba(253, 246, 246, 0.85);
    }

    hr {
      border-color: rgba(255, 255, 255, 0.2);
    }

    a.text-muted:hover {
      color: #fff !important;
    }
  </style>
</head>
<body>

  <!-- Footer -->
  <footer>
    <div class="container py-5">
      <div class="row g-4">

        <!-- Logo & Description -->
        <div class="col-md-4">
          <div class="d-flex align-items-center mb-3">
            <img src="https://cdn-icons-png.flaticon.com/512/3075/3075977.png" width="40" class="me-2">
            <h5 class="mb-0 fw-bold text-white">FoodExpress</h5>
          </div>
          <p class="footer-text-muted">
            Delivering food that’s fast, fresh & full of flavor. Explore top restaurants near you!
          </p>
        </div>

        <!-- Quick Links -->
        <div class="col-md-2">
          <h6 class="fw-bold mb-3 text-uppercase footer-heading">Links</h6>
          <ul class="list-unstyled">
            <li><a href="index.php" class="footer-link">Home</a></li>
            <li><a href="about.php" class="footer-link">About</a></li>
            <li><a href="contact.php" class="footer-link">Contact</a></li>
            <li><a href="#" class="footer-link">FAQ</a></li>
          </ul>
        </div>

        <!-- Contact Info -->
        <div class="col-md-3">
          <h6 class="fw-bold mb-3 text-uppercase footer-heading">Contact</h6>
          <ul class="list-unstyled footer-text-muted">
            <li><i class="bi bi-geo-alt-fill me-2"></i> All West Bengal</li>
            <li><i class="bi bi-envelope-fill me-2"></i> Verify@foodexpress.com</li>
            <li><i class="bi bi-phone-fill me-2"></i> +91 9749497770</li>
          </ul>
        </div>

        <!-- Social Icons -->
        <div class="col-md-3">
          <h6 class="fw-bold mb-3 text-uppercase footer-heading">Follow Us</h6>
          <div class="d-flex gap-3">
            <a href="#" class="footer-social"><i class="bi bi-facebook"></i></a>
            <a href="#" class="footer-social"><i class="bi bi-instagram"></i></a>
            <a href="#" class="footer-social"><i class="bi bi-linkedin"></i></a>
          </div>
        </div>
      </div>

      <hr class="my-4" />

      <div class="d-flex flex-column flex-md-row justify-content-between footer-text-muted small">
        <div>
          &copy; <?php echo date("Y"); ?> FoodExpress. All rights reserved.
        </div>
      <div>
  <a href="#" class="text-white text-decoration-none me-3">Privacy Policy</a>
  <a href="#" class="text-white text-decoration-none">Terms of Service</a>
</div>

      </div>
    </div>
  </footer>

</body>
</html>
