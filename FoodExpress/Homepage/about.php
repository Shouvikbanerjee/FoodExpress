<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>About Us | FoodExpress</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
    }

    .hero-section {
      background: linear-gradient(135deg, #181817ff, #452920ff);
      color: white;
      padding: 80px 0;
    }

    .hero-img {
      max-width: 100%;
      border-radius: 1rem;
      margin-top: 2rem;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .hover-card {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      border: none;
    }

    .hover-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 12px 24px rgba(0, 0, 0, 0.85);
 background:linear-gradient(135deg, #ddddd4ff, #f4e3deff);
    }

    .stat-box {
      background: linear-gradient(135deg, #dfdcdcff, #fffcfcff);
      border-radius: 1rem;
      padding: 2rem;
      box-shadow: 0 4px 10px rgba(0,0,0,0.05);
      transition: transform 0.3s ease;
    }

    .stat-box:hover {
      transform: scale(1.05);
       background:linear-gradient(135deg, #ddddd4ff, #f4e3deff);
    }

    .value-icon {
      font-size: 2rem;
      color: #ff5722;
    }

    footer {
      background-color: #212529;
    }
  </style>
</head>
<body>

<?php include_once "navbar.php"; ?>

<!-- Hero Section -->
<section class="hero-section text-center">
  <div class="container">
    <h1 class="display-5 fw-bold">Delivering Happiness at Your Doorstep</h1>
    <p class="lead mt-3">We connect people with the best food in town, every single day.</p>
    
  </div>
</section>

<!-- Our Story -->
<!-- Our Story / Mission & Values Combined Example -->
<section class="py-5">
  <div class="container">
    <h2 class="text-center mb-5">Our Mission & Values</h2>
    <div class="row g-4 text-center">
      <!-- Passion for Food -->
      <div class="col-md-4">
        <div class="card h-100 shadow-sm hover-card">
          <div class="value-icon mb-3">😊</div>
          <h5>Customer Delight</h5>
          <p>We go the extra mile to ensure an amazing experience with every order.</p>
        </div>
      </div>
      <!-- Growth & Expansion -->
      <div class="col-md-4">
        <div class="card h-100 shadow-sm hover-card">
          <div class="value-icon mb-3">📈</div>
          <h5>Growth & Expansion</h5>
          <p>From one city to over 50+, we keep growing with love and loyalty.</p>
        </div>
      </div>
      <!-- Community Impact -->
      <div class="col-md-4">
        <div class="card h-100 shadow-sm hover-card">
          <i class="bi bi-emoji-heart-eyes-fill text-danger fs-2"></i>
          <h5>Enjoy Your Meal</h5>
          <p>Get ready to feast — hot, fresh, and right to your doorstep!.</p>
        </div>
      </div>
  </div>
</section>


<!-- Mission & Values -->
<section class="py-5">
  <div class="container">
    <h2 class="text-center mb-5">Our Mission & Values</h2>
    <div class="row text-center g-4">
      <div class="col-md-4">
        <div class="card h-100 shadow-sm hover-card">
          <div class="card-body">
            <div class="value-icon mb-3">🌟</div>
            <h5>Customer Delight</h5>
            <p>We go the extra mile to ensure an amazing experience with every order.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card h-100 shadow-sm hover-card">
          <div class="card-body">
            <div class="value-icon mb-3">⚡</div>
            <h5>Speed & Reliability</h5>
            <p>We value your time. Fast and safe delivery is our priority.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card h-100 shadow-sm hover-card">
          <div class="card-body">
            <div class="value-icon mb-3">🌱</div>
            <h5>Community Impact</h5>
            <p>From eco-friendly packaging to food drives — we care beyond business.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Stats -->
<section class="py-5 bg-light">
  <div class="container text-center">
    <h2 class="mb-5">We’ve come a long way</h2>
    <div class="row g-4">
      <div class="col-md-3">
        <div class="stat-box">
          <h3 class="text-orange">10K+</h3>
          <p>Restaurants</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-box">
          <h3 class="text-orange">50+</h3>
          <p>Cities Served</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-box">
          <h3 class="text-orange">5M+</h3>
          <p>Happy Customers</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-box">
          <h3 class="text-orange">24/7</h3>
          <p>Support</p>
        </div>
      </div>
    </div>
  </div>
</section>



<!-- Footer -->
  <?php include_once "footer.php"; ?>


</body>
</html>
