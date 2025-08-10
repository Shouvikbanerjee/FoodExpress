<?php
session_start();
if (!isset($_SESSION['res_id'])) {
    header("location:../Homepage/restaurant_login.php");
    exit();
}
include_once "../Homepage/connection.php";

// Ensure the uploads directory exists
$uploadDir = __DIR__ . '/uploads';
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Add Menu Logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title']) && !isset($_POST['edit_id'])) {
    $title = $_POST['title'];
    $price = $_POST['price'];
    $desc = $_POST['description'];
    $res_id = $_SESSION['res_id'];
    $imagePath = '';

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imgName = time() . '_' . basename($_FILES['image']['name']);
        $target = $uploadDir . '/' . $imgName;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $imagePath = 'uploads/' . $imgName;
        }
    }

    $query = "INSERT INTO item (res_id, name, description, price, image) VALUES ('$res_id', '$title', '$desc', '$price', '$imagePath')";
    mysqli_query($con, $query);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Edit Menu Logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_id'])) {
    $id = $_POST['edit_id'];
    $title = $_POST['edit_title'];
    $price = $_POST['edit_price'];
    $desc = $_POST['edit_description'];
    $imagePart = "";

    if (isset($_FILES['edit_image']) && $_FILES['edit_image']['error'] == 0) {
        $imgName = time() . '_' . basename($_FILES['edit_image']['name']);
        $target = $uploadDir . '/' . $imgName;
        if (move_uploaded_file($_FILES['edit_image']['tmp_name'], $target)) {
            $imagePath = 'uploads/' . $imgName;
            $imagePart = ", image='$imagePath'";
        }
    }

    $query = "UPDATE item SET name='$title', price='$price', description='$desc' $imagePart WHERE item_id='$id'";
    mysqli_query($con, $query);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

$query = "SELECT * FROM restaurant WHERE res_id='" . $_SESSION['res_id'] . "'";
$res = mysqli_query($con, $query);
$row = mysqli_fetch_array($res);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Restaurant Menu Item | FoodExpress</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
  <link rel="stylesheet" href="style.css">
  <style>
     .topbar {
      background-color: #fff;
      padding: 1rem 1.5rem;
      border-radius: 0.5rem;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
      margin-bottom: 2rem;
    }
    .card {
      border: none;
      border-radius: 18px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.08);
      transition: all 0.3s ease;
      overflow: hidden;
    }
    .card:hover { transform: translateY(-5px); }
    .card-img-top {
      height: 150px;
      object-fit: contain;
    }
    .btn-outline-danger, .btn-outline-primary { border-radius: 25px; }
    .modal-header {
      background: linear-gradient(to right, #1a2b53ff, #bfe9ff);
      color: white;
      border-top-left-radius: 15px;
      border-top-right-radius: 15px;
    }
    .modal-content {
      border-radius: 15px;
      border: none;
    }
    .form-control, .form-select, textarea {
      background-color: #f3f6f9;
      border: 1px solid #ced4da;
      border-radius: 12px;
      padding: 10px 14px;
    }
    .form-control:focus { box-shadow: 0 0 0 3px rgba(0,123,255,0.1); }
    .btn-primary { border-radius: 30px; padding: 0.5rem 1.5rem; }
  </style>
</head>
<body>

<div class="container-fluid">
  <div class="row">
    <?php include_once "sidenav.php" ?>

    <main class="col-md-10 ms-sm-auto p-4">
      <div class="topbar d-flex justify-content-between align-items-center">
        <h3 class="fw-bold mb-0">Menu Items</h3>
        <button class="btn btn-success rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#addMenuModal">
          <i class="bi bi-plus-circle me-1"></i> Add Menu
        </button>
      </div>

      <div class="row">
        <?php
        $result = mysqli_query($con, "SELECT * FROM item WHERE res_id='" . $_SESSION['res_id'] . "'");
        while ($item = mysqli_fetch_assoc($result)) {
          echo '  
          <div class="col-md-4 mb-4">
            <div class="card">
              <img src="../uploads/' . basename($item['image']) . '" class="card-img-top" alt="' . $item['name'] . '">
              <div class="card-body">
                <h5 class="card-title">' . $item['name'] . '</h5>
                <p class="card-text text-muted">' . $item['description'] . '</p>
                <div class="d-flex justify-content-between align-items-center">
                  <span class="fw-bold text-success">₹' . number_format($item['price'], 2) . '</span>
   
<div class="d-flex gap-2">
  <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editMenuModal' . $item['item_id'] . '">
    <i class="bi bi-pencil-square"></i>
  </button>

 <a href="delete_item.php?item_id=' . $item['item_id'] . '" 
   class="btn btn-sm btn-outline-danger">
    <i class="bi bi-trash"></i>
</a>

</div>


                </div>
              </div>
            </div>
          </div>

          <div class="modal fade" id="editMenuModal' . $item['item_id'] . '" tabindex="-1">
            <div class="modal-dialog modal-lg">
              <form method="post" enctype="multipart/form-data" class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Edit Menu Item</h5>
                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body row g-3">
                  <input type="hidden" name="edit_id" value="' . $item['item_id'] . '">
                  <div class="col-md-6"><label>Title</label><input type="text" name="edit_title" class="form-control" value="' . $item['name'] . '"></div>
                  <div class="col-md-6"><label>Price (₹)</label><input type="number" name="edit_price" class="form-control" value="' . $item['price'] . '"></div>
                  <div class="col-md-12"><label>Description</label><textarea name="edit_description" class="form-control" rows="2">' . $item['description'] . '</textarea></div>
                  <div class="col-md-12"><label>Change Image</label><input type="file" name="edit_image" class="form-control"></div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle me-1"></i> Save Changes</button>
                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
              </form>
            </div>
          </div>';
        }
        ?>
      </div>
    </main>
  </div>
</div>

<!-- Add Menu Modal -->
<div class="modal fade" id="addMenuModal" tabindex="-1" aria-labelledby="addMenuModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="post" enctype="multipart/form-data" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Add New Menu Item</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body row g-3">
        <div class="col-md-6"><label>Title</label><input type="text" name="title" class="form-control" required></div>
        <div class="col-md-6"><label>Price (₹)</label><input type="number" name="price" class="form-control" required></div>
        <div class="col-md-12"><label>Description</label><textarea name="description" class="form-control" rows="2"></textarea></div>
        <div class="col-md-12"><label>Upload Image</label><input type="file" name="image" class="form-control"></div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle me-1"></i> Add Menu</button>
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>