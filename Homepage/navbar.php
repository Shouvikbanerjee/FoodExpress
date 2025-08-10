<?php

include_once "connection.php";

// Handle profile update
if (isset($_POST['update_user']) && isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    $update = "UPDATE user SET name='$name', email='$email', phone='$phone', password='$password' WHERE email='$email'";
    mysqli_query($con, $update);

    
}

// Fetch user data
$user_row = null;
if (isset($_SESSION['email'])) {
    $uid = $_SESSION['email'];
    $res = mysqli_query($con, "SELECT * FROM user WHERE email = '$uid'");
    $user_row = mysqli_fetch_assoc($res);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>FoodExpress</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm sticky-top">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center fs-3 fw-bold">
      <img src="https://cdn-icons-png.flaticon.com/512/3075/3075977.png" alt="logo" width="50" height="50" class="me-3">
      FoodExpress
    </a>


    
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>



 

    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav gap-2">
       <li class="nav-item">
          <?php if (isset($_SESSION['email'])): ?>
            <button id="locationBtn" type="button" class="btn btn-outline-light me-3" data-bs-toggle="modal" data-bs-target="#locationModal" style="white-space: nowrap;">
              <i class="bi bi-geo-alt-fill me-1"></i>
              <?php 
                echo !empty($user_row['address']) 
                  ? htmlspecialchars($user_row['address']) 
                  : 'Set Location'; 
              ?>
            </button>
          <?php endif; ?>
        </li>


        <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="contact.php">Contact Us</a></li>
        <?php if (isset($_SESSION['email'])): ?>
          <li class="nav-item"><a class="nav-link" href="order_history.php">Order</a></li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="modal" data-bs-target="#userProfileModal" style="cursor:pointer;">
              <img src="https://cdn-icons-png.flaticon.com/512/1077/1077063.png" width="18" height="18" class="me-1 icon-white" alt="profile icon">
              Profile
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">
              <img src="https://cdn-icons-png.flaticon.com/512/1828/1828479.png" width="18" height="18" class="me-1 icon-white" alt="logout icon">
              Logout
            </a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link" href="signup.php">
              <img src="https://cdn-icons-png.flaticon.com/512/1828/1828391.png" width="18" height="18" class="me-1 icon-white" alt="sign in icon">
              Sign in
            </a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<!-- Profile Modal -->
<?php if ($user_row): ?>
<div class="modal fade" id="userProfileModal" tabindex="-1" aria-labelledby="userProfileModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <form method="post" class="modal-content rounded-4 shadow-sm border-0">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="userProfileModalLabel">
          <i class="bi bi-person-circle me-2"></i>Your Profile
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body px-4 py-3">
        <div class="mb-3">
          <label class="form-label fw-semibold">Full Name</label>
          <input type="text" name="name" class="form-control rounded-pill" value="<?php echo $user_row['name']; ?>" required />
        </div>
        <div class="mb-3">
          <label class="form-label fw-semibold">Email</label>
          <input type="email" name="email" class="form-control rounded-pill" value="<?php echo $user_row['email']; ?>" required />
        </div>
        <div class="mb-3">
          <label class="form-label fw-semibold">Phone</label>
          <input type="tel" name="phone" class="form-control rounded-pill" value="<?php echo $user_row['phone']; ?>" required />
        </div>
        <div class="mb-3">
          <label class="form-label fw-semibold">Password</label>
          <input type="password" name="password" class="form-control rounded-pill" value="<?php echo $user_row['password']; ?>" required />
        </div>
      </div>

      <div class="modal-footer border-0 px-4 pb-3">
        <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" name="update_user" class="btn btn-success rounded-pill px-4">Update</button>
      </div>
    </form>
  </div>
</div>
<?php endif; ?>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const locationBtn = document.getElementById('locationBtn');

  if (navigator.geolocation && locationBtn) {
    navigator.geolocation.getCurrentPosition(success, error, {timeout: 10000});
  }

  function success(position) {
    const lat = position.coords.latitude;
    const lon = position.coords.longitude;

    // Use OpenStreetMap Nominatim Reverse Geocoding API (no API key required)
    fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lon}`)
      .then(response => response.json())
      .then(data => {
        if (data && data.address) {
          const city = data.address.city || data.address.town || data.address.village || '';
          const state = data.address.state || '';
          const country = data.address.country || '';
          const displayAddress = [city, state, country].filter(Boolean).join(', ');

          if(displayAddress) {
            locationBtn.innerHTML = `<i class="bi bi-geo-alt-fill me-1"></i> ${displayAddress}`;
            
            // Optionally: send address to server to update user profile
            updateUserAddress(displayAddress);
          }
        }
      })
      .catch(() => {
        console.log('Failed to fetch location address');
      });
  }

  function error() {
    console.log('Geolocation not allowed or failed.');
  }

  // Example AJAX to update user address on server
  function updateUserAddress(address) {
    fetch('update_location.php', {
      method: 'POST',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      body: `address=${encodeURIComponent(address)}`
    }).then(res => res.text())
      .then(response => console.log('Location updated:', response))
      .catch(err => console.error('Error updating location:', err));
  }
});
</script>

</body>
</html>
