<!-- Mobile Sidebar -->
<div class="d-md-none sidebar-mobile">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="text-white d-flex align-items-center gap-2 mb-0">
      <i class="bi bi-shop-window fs-3 text-warning"></i>
      <span class="fw-bold text-warning" style="letter-spacing: 1px; text-shadow: 0 1px 3px rgba(0,0,0,0.4);">
        <?php echo htmlspecialchars($row['restaurantname']); ?>
      </span>
    </h3>
    <button class="btn btn-sm btn-light" type="button" data-bs-toggle="collapse" data-bs-target="#mobileMenu" aria-label="Toggle navigation">
      <i class="bi bi-list fs-4"></i>
    </button>
  </div>
  <nav class="collapse" id="mobileMenu">
    <a href="home.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'home.php' ? 'active' : ''; ?>">
      <i class="bi bi-house me-2"></i> Dashboard
    </a>
    <a href="order.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'order.php' ? 'active' : ''; ?>">
      <i class="bi bi-receipt me-2"></i> Orders
    </a>
    <a href="menu.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'menu.php' ? 'active' : ''; ?>">
      <i class="bi bi-box-seam me-2"></i> Menu Items
    </a>
    <a href="logout.php" class="text-danger mt-3">
      <i class="bi bi-box-arrow-right me-2"></i> Logout
    </a>
  </nav>
</div>

<!-- Desktop Sidebar -->
<nav class="col-md-2 d-none d-md-flex flex-column sidebar min-vh-100 p-4">
  <h2 class="d-flex align-items-center gap-2 mb-4">
    <i class="bi bi-shop-window fs-3 text-warning"></i>
    <span class="fw-bold text-warning" style="letter-spacing: 2px; text-shadow: 0 1px 3px rgba(0,0,0,0.4);">
      <?php echo htmlspecialchars($row['restaurantname']); ?>
    </span>
  </h2>

  <nav class="nav flex-column flex-grow-1">
    <a href="home.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'home.php' ? 'active' : ''; ?>">
      <i class="bi bi-house me-2"></i> Dashboard
    </a>
    <a href="order.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'order.php' ? 'active' : ''; ?>">
      <i class="bi bi-receipt me-2"></i> Orders
    </a>
    <a href="menu.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'menu.php' ? 'active' : ''; ?>">
      <i class="bi bi-box-seam me-2"></i> Menu Items
    </a>
  </nav>

  <a href="logout.php" class="mt-auto text-danger fw-semibold">
    <i class="bi bi-box-arrow-right me-2"></i> Logout
  </a>
</nav>
