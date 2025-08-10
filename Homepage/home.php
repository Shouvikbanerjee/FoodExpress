<?php
session_start();
include_once "connection.php";

// Handle search functionality
$searchResults = [];
if (isset($_GET['query'])) {
    $searchTerm = mysqli_real_escape_string($con, $_GET['query']);
    
    // Search both restaurants and items
    $restaurantQuery = "SELECT * FROM restaurant WHERE restaurantname LIKE '%$searchTerm%'";
    $itemQuery = "SELECT restaurant.restaurantname ,item.* FROM item
                  inner join restaurant on restaurant.res_id=item.res_id 
                  WHERE name LIKE '%$searchTerm%' OR description LIKE '%$searchTerm%'";
    
    $restaurantResult = mysqli_query($con, $restaurantQuery);
    $itemResult = mysqli_query($con, $itemQuery);
    
    while ($row = mysqli_fetch_assoc($restaurantResult)) {
        $row['type'] = 'restaurant';
        $searchResults[] = $row;
    }
    
    while ($row = mysqli_fetch_assoc($itemResult)) {
        $row['type'] = 'item';
        $searchResults[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Online Food Booking | FoodExpress</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <link rel="stylesheet" href="style.css">
  <style>
   /* ========================
   Base Styling
======================== */
body {
  font-family: 'Poppins', sans-serif;
  background-color: #f8f9fa;
  color: #333;
}

/* ========================
   Hero Section
======================== */
.hero {
  background: url('https://images.unsplash.com/photo-1600891964599-f61ba0e24092?auto=format&fit=crop&w=1500&q=80')
    no-repeat center center / cover;
  height: 100vh;
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
}
.hero::before {
  content: '';
  position: absolute;
  inset: 0;
  background: rgba(0, 0, 0, 0.55);
  z-index: 1;
}
.hero-content {
  position: relative;
  z-index: 2;
  color: white;
  max-width: 650px;
  padding: 20px;
}
.hero-content h1 {
  font-size: 3.2rem;
  font-weight: 700;
}
.hero-content p {
  font-size: 1.25rem;
  margin-bottom: 30px;
}

/* ========================
   Buttons
======================== */
.btn-primary {
  background: linear-gradient(45deg, #2f0f08ff, #545353ff);
  border: none;
  padding: 12px 28px;
  font-size: 1rem;
  font-weight: 500;
  border-radius: 50px;
  transition: all 0.3s ease;
}
.btn-primary:hover {
  background: linear-gradient(45deg, #100f0fff, #28120bff);
  transform: translateY(-2px);
  box-shadow: 0px 8px 18px rgba(255, 87, 34, 0.3);
}

/* ========================
   Section Titles
======================== */
.section-title {
  font-weight: 700;
  margin-top: 40px;
  margin-bottom: 15px;
  color: #222;
}

/* ========================
   Food Cards
======================== */
.food-card {
  transition: all 0.3s ease-in-out;
  background-color: #fff;
  box-shadow: 0px 12px 25px rgba(0, 0, 0, 0.21);
}
.food-hover:hover {
  transform: translateY(-5px);
  box-shadow: 0px 12px 25px rgba(0, 0, 0, 0.82);
}
.food-img-wrapper {
  position: relative;
  height: 220px;
  overflow: hidden;
}
.food-img-wrapper img {
  object-fit: cover;
  height: 100%;
  width: 100%;
  transition: transform 0.35s ease-in-out;
}
.food-hover:hover .food-img-wrapper img {
  transform: scale(1.06);
}
.rating-badge {
  position: absolute;
  top: 12px;
  left: 12px;
  background: rgba(0,0,0,0.75);
  color: #fff;
  padding: 4px 8px;
  font-size: 0.85rem;
  border-radius: 8px;
  display: flex;
  align-items: center;
  gap: 4px;
}
.star-rating i {
  font-size: 0.85rem;
}


/* ========================
   Restaurant Cards
======================== */
.restaurant-card {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  border: none;
  border-radius: 12px;

}
.restaurant-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 14px 24px rgba(0, 0, 0, 0.98);
}
.object-fit-cover {
  object-fit: cover;
  width: 100%;
  height: 100%;
}

/* ========================
   Feature Cards
======================== */
.feature-card {
  background: linear-gradient(135deg, #d6d3d3ff, #fffcfcff);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  border-radius: 14px;
}
.feature-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 14px 28px rgba(0, 0, 0, 0.12);
}

/* ========================
   How Cards
======================== */
.how-card {
  background: linear-gradient(135deg, #d6d3d3ff, #fffcfcff);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  border-radius: 14px;
}
.how-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 12px 24px rgba(0, 0, 0, 0.12);
}

/* ========================
   Search Results
======================== */
.search-result-card {
  transition: all 0.3s ease;
  border-radius: 12px;
  background-color: #fff;
}
.search-result-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 12px 20px rgba(0, 0, 0, 0.1);
}
.result-type-badge {
  position: absolute;
  top: 10px;
  right: 10px;
  font-size: 0.75rem;
  padding: 5px 10px;
  border-radius: 12px;
}

  </style>
</head>
<body>

  <!-- Navbar -->
  <?php include_once "navbar.php"; ?>

  <!-- Hero Section -->
<section class="hero position-relative py-5"
  style="background: linear-gradient(120deg, rgba(103,99,98,0.8), rgba(184,72,38,0.8)), 
         url('https://images.unsplash.com/photo-1586190848861-99aa4a171e90') 
         no-repeat center center;
         background-size: cover; color: white;">

  <div class="overlay position-absolute top-0 start-0 w-100 h-100" style="background-color: rgba(0,0,0,0.4); z-index: 0;"></div>
  
  <div class="container position-relative" style="z-index: 1;">
    <div class="row align-items-center">
      
      <!-- Left: Text + Search -->
      <div class="col-lg-6 col-md-7 hero-content text-white">
        <h1 class="mb-4 fw-bold" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
          Welcome to <img src="https://cdn-icons-png.flaticon.com/512/3075/3075977.png" width="40" class="me-2">FoodExpress
        </h1>
        <p class="mb-4 fs-5" style="max-width: 480px;">
          Order delicious food from your favorite restaurants delivered right to your door.
        </p>

        <form class="d-flex" role="search" action="" method="GET">
          <input
            class="form-control me-2 shadow-sm"
            type="search"
            name="query"
            placeholder="Search restaurants or dishes"
            aria-label="Search"
            required
            style="
              border-radius: 50px;
              padding: 12px 20px;
              font-size: 1.1rem;
              border: none;
            "
          />
          <button
            class="btn btn-light text-danger fw-bold shadow"
            type="submit"
            style="
              border-radius: 50px;
              padding: 12px 30px;
              font-size: 1.1rem;
              text-transform: uppercase;
              letter-spacing: 1px;
            "
          >
            Search
          </button>
        </form>
      </div>

      <!-- Right: Modern Image -->
    <div class="col-lg-6 col-md-5 text-center mt-4 mt-md-0 hero-content">
  <div class="position-relative d-inline-block image-wrapper bg-white rounded-4 shadow-lg p-3" 
       style="max-width: 100%; border-radius: 24px; background: linear-gradient(135deg, #fff5f5, #ffe6e6); transition: transform 0.3s ease;">
    
    <!-- Food Image -->
    <img
      src="https://images.unsplash.com/photo-1586190848861-99aa4a171e90?auto=format&fit=crop&w=700&q=80"
      alt="Delicious food"
      class="img-fluid rounded-4 food-image"
      style="max-height: 360px; object-fit: cover; border-radius: 18px; box-shadow: 0 6px 15px rgba(0,0,0,0.1); transition: transform 0.3s ease;"
    />

    <!-- Emoji Badge -->
    <div class="position-absolute top-0 start-0 translate-middle badge rounded-circle bg-danger p-3 shadow"
         style="font-size: 1.8rem; left: 20px; top: 20px;">
      🍕
    </div>
  </div>
</div>

    </div>
  </div>
</section>

<!-- Search Results Section -->
<?php if (isset($_GET['query']) && !empty($_GET['query'])): ?>
<section class="container my-5">
  <h2 class="text-center section-title">🔍 Search Results for "<?php echo htmlspecialchars($_GET['query']); ?>"</h2>
  
  <?php if (empty($searchResults)): ?>
    <div class="alert alert-info text-center">
      No results found for "<?php echo htmlspecialchars($_GET['query']); ?>". Try a different search term.
    </div>
  <?php else: ?>
    <div class="row g-4">
      <?php foreach ($searchResults as $result): ?>
        <?php if ($result['type'] == 'restaurant'): ?>
          <div class="col-md-6 col-lg-4">
            <div class="card search-result-card h-100 shadow-sm">
              <div class="card-body">
                <span class="badge bg-primary result-type-badge">Restaurant</span>
                <h5 class="card-title"><?php echo htmlspecialchars($result['restaurantname']); ?></h5>
                <p class="card-text text-muted">Famous for its fast delivery & authentic flavors.</p>
                <a href="restaurant_menu.php?res_id=<?php echo urlencode($result['res_id']); ?>" 
                   class="btn btn-sm btn-outline-primary rounded-pill">View Menu</a>
              </div>
            </div>
          </div>
        <?php else: ?>
          <div class="col-md-6 col-lg-4">
            <div class="card search-result-card h-100 shadow-sm">
              <div class="card-body">
                <span class="badge bg-success result-type-badge">Dish</span>
                <h5 class="card-title"><?php echo htmlspecialchars($result['name']); ?></h5>
                <p class="card-text text-muted"><i class="bi bi-shop-window me-2"></i><?php echo htmlspecialchars($result['restaurantname']); ?></p>
                <p class="card-text text-muted"><?php echo htmlspecialchars($result['description']); ?></p>
                <div class="d-flex justify-content-between align-items-center">
                  <span class="price">₹<?php echo htmlspecialchars($result['price']); ?></span>
                  <a href="order_details.php?res_id=<?php echo urlencode($result['res_id']); ?>&item_id=<?php echo urlencode($result['item_id']); ?>" 
                     class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-cart-plus me-1"></i>Order Now
                  </a>
                </div>
              </div>
            </div>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</section>
<?php endif; ?>

 <!-- Why Choose FoodExpress -->
<section class="container my-5">
  <h2 class="text-center fw-bold display-6 mb-3">🚀 Why Choose <img src="https://cdn-icons-png.flaticon.com/512/3075/3075977.png" width="40" class="me-2">FoodExpress?</h2>
  <p class="text-center text-muted mb-5">Experience the ultimate food delivery service with these exclusive features</p>

  <div class="row g-4">
    <!-- Feature 1 -->
    <div class="col-md-6 col-lg-3">
      <div class="card text-center border-0 shadow-sm h-100 rounded-4 p-4 feature-card">
        <div class="mb-3">
          <i class="bi bi-lightning-charge-fill text-warning fs-1"></i>
        </div>
        <h5 class="fw-bold">Super Fast Delivery</h5>
        <p class="text-muted small">Your favorite meals delivered in under 30 minutes — hot and fresh every time!</p>
      </div>
    </div>

    <!-- Feature 2 -->
    <div class="col-md-6 col-lg-3">
      <div class="card text-center border-0 shadow-sm h-100 rounded-4 p-4 feature-card">
        <div class="mb-3">
          <i class="bi bi-shield-lock-fill text-primary fs-1"></i>
        </div>
        <h5 class="fw-bold">Secure Payments</h5>
        <p class="text-muted small">Pay safely via UPI, cards, wallets — your data is always protected with us.</p>
      </div>
    </div>

    <!-- Feature 3 -->
    <div class="col-md-6 col-lg-3">
      <div class="card text-center border-0 shadow-sm h-100 rounded-4 p-4 feature-card">
        <div class="mb-3">
          <i class="bi bi-star-fill text-success fs-1"></i>
        </div>
        <h5 class="fw-bold">Top-rated Restaurants</h5>
        <p class="text-muted small">We partner only with the best to ensure top taste and hygiene every time.</p>
      </div>
    </div>

    <!-- Feature 4 -->
    <div class="col-md-6 col-lg-3">
      <div class="card text-center border-0 shadow-sm h-100 rounded-4 p-4 feature-card">
        <div class="mb-3">
          <i class="bi bi-emoji-smile-fill text-danger fs-1"></i>
        </div>
        <h5 class="fw-bold">Customer Satisfaction</h5>
        <p class="text-muted small">24/7 support, easy refunds, real-time tracking — your happiness is our priority.</p>
      </div>
    </div>
  </div>
</section>

<!-- 🏆 Best Restaurants Section -->
<section class="container my-5">
  <h2 class="text-center fw-bold display-6 mb-3">🏆 Best Restaurants</h2>
  <p class="text-center text-muted mb-4">Top-rated for taste, service, and speed</p>

  <div class="row g-4">
    <?php
      $resRestaurants = mysqli_query($con, "SELECT * FROM restaurant");

      while ($restaurant = mysqli_fetch_assoc($resRestaurants)) {
        echo '
        <div class="col-xl-3 col-lg-4 col-md-6">
          <div class="card restaurant-card border-0 shadow-sm h-100 rounded-4 overflow-hidden">
            <div class="ratio ratio-4x3">
              <img src="https://images.unsplash.com/photo-1541544741938-0af808871cc0" 
                   class="img-fluid object-fit-cover" 
                   alt="' . htmlspecialchars($restaurant['restaurantname']) . '">
            </div>
            <div class="card-body d-flex flex-column">
              <h5 class="card-title fw-semibold mb-1">' . htmlspecialchars($restaurant["restaurantname"]) . '</h5>
              <p class="card-text small text-muted mb-3">Famous for its fast delivery & authentic flavors.</p>
              <div class="d-flex justify-content-between align-items-center mt-auto">
                <span class="text-warning small">
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                </span>
                <a href="restaurant_menu.php?res_id=' . urlencode($restaurant["res_id"]) . '" 
                   class="btn btn-sm btn-outline-primary rounded-pill">View Menu</a>
              </div>
            </div>
          </div>
        </div>';
      }
    ?>
  </div>
</section>

<?php
$res=mysqli_query($con,"select restaurant.restaurantname,item.* from item
                        inner join restaurant on restaurant.res_id=item.res_id");
?>

<!-- Food Cards Section -->
<div class="container my-5">
  <h2 class="text-center section-title fw-bold mb-2">🍕 Popular Dishes</h2>
  <p class="text-center text-muted mb-5">Hand-picked favorites, fresh & delicious</p>
  
  <div class="row g-4">
    <?php while ($food = mysqli_fetch_array($res)) { ?>
      <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="card food-card border-0 h-100 rounded-4 overflow-hidden position-relative food-hover">
          
          <!-- Image with rating badge -->
          <div class="food-img-wrapper">
            <img src="../uploads/<?= basename($food['image']) ?>" 
                 class="card-img-top img-fluid" 
                 alt="<?= htmlspecialchars($food['name']) ?>">
            <span class="rating-badge">
              <i class="bi bi-star-fill text-warning"></i> 4.5
            </span>
          </div>
          
          <!-- Content -->
          <div class="card-body p-3 d-flex flex-column">
            <h5 class="card-title fw-semibold mb-1"><?= htmlspecialchars($food["name"]) ?></h5>
            
            <!-- Static stars -->
            <div class="star-rating mb-2">
              <i class="bi bi-star-fill text-warning"></i>
              <i class="bi bi-star-fill text-warning"></i>
              <i class="bi bi-star-fill text-warning"></i>
              <i class="bi bi-star-fill text-warning"></i>
              <i class="bi bi-star-half text-warning"></i>
            </div>
            
            <p class="card-text text-muted small flex-grow-1"><i class="bi bi-shop-window me-2"></i><?= htmlspecialchars($food["restaurantname"]) ?></p>
            <p class="card-text text-muted small flex-grow-1"><?= htmlspecialchars($food["description"]) ?></p>
            
            <div class="d-flex justify-content-between align-items-center mt-2">
              <span class="fw-bold text-success fs-6">₹<?= htmlspecialchars($food["price"]) ?></span>
              <a href="order_details.php?res_id=<?= urlencode($food["res_id"]) ?>&item_id=<?= urlencode($food["item_id"]) ?>" 
                 class="btn btn-sm btn-primary rounded-pill px-3 shadow-sm">
                 <i class="bi bi-cart-plus me-1"></i> Order Now
              </a>
            </div>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
</div>






<!-- How It Works Section -->
<section class="container my-5">
  <h2 class="text-center fw-bold display-6 mb-3">📱 How  <img src="https://cdn-icons-png.flaticon.com/512/3075/3075977.png" width="40" class="me-2">FoodExpress Works</h2>
  <p class="text-center text-muted mb-5">Just a few simple steps to get your food delivered</p>

  <div class="row g-4 justify-content-center">
    <!-- Step 1 -->
    <div class="col-md-6 col-lg-3">
      <div class="card text-center border-0 shadow-sm h-100 rounded-4 p-4 how-card">
        <div class="mb-3">
          <i class="bi bi-search text-primary fs-1"></i>
        </div>
        <h5 class="fw-bold">Browse Restaurants</h5>
        <p class="text-muted small">Explore menus from a wide range of restaurants near you.</p>
      </div>
    </div>

    <!-- Step 2 -->
    <div class="col-md-6 col-lg-3">
      <div class="card text-center border-0 shadow-sm h-100 rounded-4 p-4 how-card">
        <div class="mb-3">
          <i class="bi bi-cart-check-fill text-success fs-1"></i>
        </div>
        <h5 class="fw-bold">Place Your Order</h5>
        <p class="text-muted small">Add items to cart, customize your dish, and confirm your order.</p>
      </div>
    </div>

    <!-- Step 3 -->
    <div class="col-md-6 col-lg-3">
      <div class="card text-center border-0 shadow-sm h-100 rounded-4 p-4 how-card">
        <div class="mb-3">
          <i class="bi bi-truck text-warning fs-1"></i>
        </div>
        <h5 class="fw-bold">Track Delivery</h5>
        <p class="text-muted small">Watch your food being prepared and delivered in real time.</p>
      </div>
    </div>

    <!-- Step 4 -->
    <div class="col-md-6 col-lg-3">
      <div class="card text-center border-0 shadow-sm h-100 rounded-4 p-4 how-card">
        <div class="mb-3">
          <i class="bi bi-emoji-heart-eyes-fill text-danger fs-1"></i>
        </div>
        <h5 class="fw-bold">Enjoy Your Meal</h5>
        <p class="text-muted small">Get ready to feast — hot, fresh, and right to your doorstep!</p>
      </div>
    </div>
  </div>
</section>

  <?php include_once "footer.php" ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>