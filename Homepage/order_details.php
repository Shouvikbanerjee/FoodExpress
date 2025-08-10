<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("location:../Homepage/user_login.php");
    exit();
}
include_once "connection.php";

// Validate GET params
$res_id = $_GET['res_id'] ?? '';
$item_id = $_GET['item_id'] ?? '';

if (!$res_id || !$item_id) {
    die("Invalid request.");
}

// Fetch menu item details
$res = mysqli_query($con, "SELECT * FROM item WHERE res_id='" . mysqli_real_escape_string($con, $res_id) . "' AND item_id='" . mysqli_real_escape_string($con, $item_id) . "'");
$food = mysqli_fetch_array($res);

if (!$food) {
    die("Menu item not found.");
}

$image = htmlspecialchars(basename($food['image']));
$name = htmlspecialchars($food['name']);
$description = htmlspecialchars($food['description']);
$price = htmlspecialchars($food['price']);

// Default address
$prefilled_address = "";

// Fetch address from user
$email = $_SESSION['email'];
$user_q = mysqli_query($con, "SELECT * FROM user WHERE email='$email'");
if ($user_q && mysqli_num_rows($user_q) > 0) {
    $user = mysqli_fetch_assoc($user_q);
    $prefilled_address = htmlspecialchars($user['address']);
    $user_id = htmlspecialchars($user['user_id']);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['res_id'] = $_POST['res_id'] ?? null;
    $_SESSION['item_id'] = $_POST['item_id'] ?? null;
    $_SESSION['user_id'] = $_POST['user_id'] ?? null;
    $_SESSION['quantity'] = $_POST['quantity'] ?? 1;
    $_SESSION['price'] = $_POST['price'] ?? null;
    $_SESSION['item_name'] = $name;

    // Determine which address option was selected
    $address_option = $_POST['address_option'] ?? 'saved';

    switch ($address_option) {
        case 'saved':
            $submitted_address = $prefilled_address;
            break;
        case 'detected':
            $submitted_address = $_POST['detected_address'] ?? '';
            break;
        case 'manual':
            $submitted_address = $_POST['manual_address'] ?? '';
            break;
        default:
            $submitted_address = $prefilled_address;
    }

    $_SESSION['address'] = $submitted_address;

    // Update DB if address changed and not empty
    if (!empty($submitted_address) && $submitted_address !== $prefilled_address) {
        $new_address = mysqli_real_escape_string($con, $submitted_address);
        mysqli_query($con, "UPDATE user SET address='$new_address' WHERE user_id='$user_id'");
    }

    header("Location: payment.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Order Details</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <style>
    body {
      background: linear-gradient(120deg, #fdfbfb, #ebedee);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .order-wrapper {
      background: #fff;
      border-radius: 1rem;
      box-shadow: 0 10px 25px rgba(0,0,0,0.1);
      overflow: hidden;
      padding: 2rem;
    }
    .card-img-top {
      height: 280px;
      object-fit: cover;
      border-radius: 0.75rem;
    }
    .price {
      font-size: 1.5rem;
      font-weight: bold;
      color: #e65100;
    }
    .btn-success {
      background-color: #28a745;
      border: none;
    }
    .btn-success:hover {
      background-color: #218838;
    }
    label {
      font-weight: 600;
    }
    .address-textarea {
      resize: vertical;
    }
  </style>
</head>
<body>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-7 col-md-9">
      <div class="order-wrapper">

        <img src="../uploads/<?php echo $image; ?>" class="img-fluid card-img-top mb-4" alt="<?php echo $name; ?>" />

        <h2 class="mb-2"><?php echo $name; ?></h2>
        <p class="text-muted mb-3"><?php echo $description; ?></p>
        <p class="price mb-4">₹<?php echo $price; ?></p>

        <form action="" method="POST" id="orderForm">
          <input type="hidden" name="res_id" value="<?php echo htmlspecialchars($res_id); ?>" />
          <input type="hidden" name="item_id" value="<?php echo htmlspecialchars($item_id); ?>" />
          <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>" />
          <input type="hidden" name="price" value="<?php echo $price; ?>" />

          <div class="mb-3">
            <label for="quantity">Quantity</label>
            <input
              type="number"
              class="form-control"
              id="quantity"
              name="quantity"
              value="1"
              min="1"
              required
            />
          </div>

          <!-- Delivery Address Options -->
          <div class="mb-3">
            <label class="form-label d-block fw-bold mb-2">Delivery Address</label>

            <div class="form-check">
              <input
                class="form-check-input"
                type="radio"
                name="address_option"
                id="use_saved"
                value="saved"
                checked
              />
              <label class="form-check-label" for="use_saved">
                Use Registered Address:
              </label>
              <textarea
                class="form-control mt-1 address-textarea"
                readonly
                rows="3"
              ><?php echo $prefilled_address ?: 'Not Available'; ?></textarea>
            </div>

            <div class="form-check mt-3">
              <input
                class="form-check-input"
                type="radio"
                name="address_option"
                id="use_detected"
                value="detected"
              />
              <label class="form-check-label" for="use_detected">
                Detect My Location:
              </label>
              <textarea
                class="form-control mt-1 address-textarea"
                id="detected_address"
                name="detected_address"
                rows="3"
                readonly
                placeholder="Click 'Detect Location' to fill address"
              ></textarea>
              <button type="button" class="btn btn-outline-primary mt-2" id="detectLocationBtn">
                <i class="bi bi-geo-alt-fill me-1"></i> Detect Location
              </button>
              <small id="locationStatus" class="text-muted ms-2"></small>
            </div>

            <div class="form-check mt-3">
              <input
                class="form-check-input"
                type="radio"
                name="address_option"
                id="use_manual"
                value="manual"
              />
              <label class="form-check-label" for="use_manual">
                Enter New Address:
              </label>
              <textarea
                class="form-control mt-1 address-textarea"
                id="manual_address"
                name="manual_address"
                rows="3"
                placeholder="Enter delivery address here..."
                disabled
              ></textarea>
            </div>
          </div>

          <div class="d-grid">
            <button type="submit" class="btn btn-success btn-lg">Proceed to Payment</button>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>

<script>
  const detectBtn = document.getElementById('detectLocationBtn');
  const locationStatus = document.getElementById('locationStatus');

  const savedTextarea = document.querySelector('#use_saved').closest('.form-check').querySelector('textarea');
  const detectedTextarea = document.getElementById('detected_address');
  const manualTextarea = document.getElementById('manual_address');

  const radios = document.querySelectorAll('input[name="address_option"]');

  function updateTextareaState() {
    if(document.getElementById('use_saved').checked) {
      savedTextarea.removeAttribute('disabled');
      savedTextarea.setAttribute('readonly', true);
      detectedTextarea.setAttribute('disabled', true);
      detectedTextarea.setAttribute('readonly', true);
      manualTextarea.setAttribute('disabled', true);
      manualTextarea.removeAttribute('readonly');
    } else if(document.getElementById('use_detected').checked) {
      savedTextarea.setAttribute('disabled', true);
      detectedTextarea.removeAttribute('disabled');
      detectedTextarea.removeAttribute('readonly');
      manualTextarea.setAttribute('disabled', true);
      manualTextarea.removeAttribute('readonly');
    } else if(document.getElementById('use_manual').checked) {
      savedTextarea.setAttribute('disabled', true);
      detectedTextarea.setAttribute('disabled', true);
      detectedTextarea.setAttribute('readonly', true);
      manualTextarea.removeAttribute('disabled');
      manualTextarea.removeAttribute('readonly');
    }
  }

  radios.forEach(radio => {
    radio.addEventListener('change', () => {
      updateTextareaState();
      locationStatus.textContent = '';
    });
  });

  detectBtn.addEventListener('click', () => {
    if (!navigator.geolocation) {
      locationStatus.textContent = 'Geolocation is not supported by your browser';
      return;
    }

    locationStatus.textContent = 'Locating...';

    navigator.geolocation.getCurrentPosition(success, error, {timeout: 10000});

    function success(position) {
      const lat = position.coords.latitude;
      const lon = position.coords.longitude;

      fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lon}`)
        .then(response => response.json())
        .then(data => {
          if (data && data.display_name) {
            detectedTextarea.value = data.display_name;
            locationStatus.textContent = 'Location detected. You can edit the address if needed.';
            detectedTextarea.removeAttribute('readonly');
          } else {
            locationStatus.textContent = 'Unable to determine address';
          }
        })
        .catch(() => {
          locationStatus.textContent = 'Failed to fetch address';
        });
    }

    function error() {
      locationStatus.textContent = 'Unable to retrieve your location';
    }
  });

  // Initialize textarea states on load
  updateTextareaState();
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
