<?php
session_start();
include_once "connection.php";

$res_id = $_GET['res_id'] ?? '';

if (!$res_id) {
    die("Invalid restaurant ID");
}

// Get restaurant name
$resInfo = mysqli_query($con, "SELECT restaurantname FROM restaurant WHERE res_id = '$res_id'");
$restaurant = mysqli_fetch_assoc($resInfo);

// Get all menu items
$menuItems = mysqli_query($con, "SELECT * FROM item WHERE res_id = '$res_id'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo htmlspecialchars($restaurant['restaurantname']); ?> | Menu</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap + Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Segoe UI', sans-serif;
    }

    /* Restaurant Header */
    .restaurant-header {
      background: linear-gradient(120deg, rgb(41, 40, 40), rgb(45, 22, 16));
      color: white;
      padding: 80px 0;
      text-align: center;
      border-radius: 0 0 30px 30px;
      margin-bottom: 50px;
    }

    /* Menu Cards */
    .menu-card {
      border: none;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.62);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .menu-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.96);
    }

    .menu-img {
      width: 100%;
      height: 220px;
      object-fit: cover;
    }

    .price-tag {
      font-weight: 600;
      font-size: 1rem;
      color: #267c07ff;
    }

    .order-btn {
      border-radius: 20px;
      padding: 5px 15px;
    }

    .card-text {
      min-height: 50px;
    }

    @media (max-width: 576px) {
      .restaurant-header h1 {
        font-size: 1.8rem;
      }
    }
  </style>
</head>

<body>
<?php include_once "navbar.php"; ?>

<!-- 🍽️ Restaurant Header -->
<section class="restaurant-header">
  <div class="container">
    <h1 class="display-5 fw-bold mb-2"><?php echo htmlspecialchars($restaurant['restaurantname']); ?></h1>
    <p class="lead">Explore the mouth-watering menu below</p>
  </div>
</section>

<!-- 🧾 Menu Section -->
<section class="container mb-5">
  <?php if (mysqli_num_rows($menuItems) > 0) { ?>
    <div class="row g-4">
      <?php while ($item = mysqli_fetch_assoc($menuItems)) { ?>
        <div class="col-xl-3 col-lg-4 col-md-6">
          <div class="card menu-card h-100">
            <img src="<?php echo '../uploads/' . htmlspecialchars(basename($item['image'])); ?>" class="menu-img" alt="<?php echo htmlspecialchars($item['name']); ?>">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title fw-semibold"><?php echo htmlspecialchars($item['name']); ?></h5>
              <p class="card-text text-muted small"><?php echo htmlspecialchars($item['description']); ?></p>
              <div class="d-flex justify-content-between align-items-center mt-auto">
                <span class="price-tag">₹<?php echo htmlspecialchars($item['price']); ?></span>
                <a href="order_details.php?res_id=<?php echo $res_id; ?>&item_id=<?php echo $item['item_id']; ?>" class="btn btn-sm btn-outline-primary order-btn">
                  <i class="bi bi-cart-plus me-1"></i> Order
                </a>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  <?php } else { ?>
    <div class="text-center py-5">
      <h4 class="text-muted">No menu items found for this restaurant.</h4>
      <p class="text-secondary">Please check back later or explore other restaurants.</p>
      <a href="index.php" class="btn btn-outline-secondary mt-3">
        <i class="bi bi-arrow-left"></i> Back to Restaurants
      </a>
    </div>
  <?php } ?>
</section>

<?php include_once "footer.php"; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
