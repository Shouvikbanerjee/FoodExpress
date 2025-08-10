<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("location:../Homepage/admin_login.php");
    exit();
}

include_once "../Homepage/connection.php"; // Update the path if needed
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Total Users | FoodExpress</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      background: linear-gradient(to right, #f1f2f6, #dfe4ea);
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    }
    .main-content {
      background: rgba(255, 255, 255, 0.9);
      border-radius: 20px;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
      padding: 30px;
    }
    .user-avatar {
      width: 45px;
      height: 45px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid #dee2e6;
    }
    .table thead {
      background-color: #1e272e;
      color: white;
    }
    .btn-sm {
      border-radius: 8px;
      padding: 6px 10px;
    }
    .btn-outline-secondary:hover, .btn-outline-danger:hover {
      box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
    }
    .topbar {
      background: transparent;
      margin-bottom: 20px;
    }
    .table-hover tbody tr:hover {
      background-color: #f1f3f5;
    }
  </style>
</head>
<body>

<div class="container-fluid">
  <div class="row">
    <?php include_once "sidenav.php"; ?>

    <!-- Main Content -->
    <main class="col-md-10 ms-sm-auto main-content">
      <div class="topbar d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0 text-dark">👥 Total Users</h3>
        <button class="btn btn-outline-primary rounded-pill shadow-sm" onclick="location.reload();">
          <i class="bi bi-arrow-clockwise me-1"></i> Refresh
        </button>
      </div>

      <!-- User Table -->
      <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle rounded-3 overflow-hidden">
          <thead>
            <tr>
              <th>#</th>
              <th>Avatar</th>
              <th>Name</th>
              <th>Address</th>
              <th>Email</th>
              <th>Phone</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
          <?php
          $count = 1;
          $query = mysqli_query($con, "SELECT * FROM user ORDER BY user_id DESC");
          while ($row = mysqli_fetch_assoc($query)) {
              $avatar =  'https://cdn-icons-png.flaticon.com/512/3176/3176364.png';
             
              echo '
              <tr>
                  <td>' . $count++ . '</td>
                  <td><img src="' . $avatar . '" class="user-avatar" alt="User Avatar" /></td>
                  <td>' . htmlspecialchars($row['name']) . '</td>
                  <td>' . htmlspecialchars($row['address']) . '</td>
                  <td>' . htmlspecialchars($row['email']) . '</td>
                  <td>' . htmlspecialchars($row['phone']) . '</td>
                  <td>
                      <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal" data-bs-target="#editUserModal"
                          data-name="' . htmlspecialchars($row['name']) . '" 
                          data-address="' . htmlspecialchars($row['address']) . '" 
                          data-email="' . htmlspecialchars($row['email']) . '" 
                          data-phone="' . htmlspecialchars($row['phone']) . '">
                          <i class="bi bi-eye"></i>
                      </button>
                      
                  </td>
              </tr>';
          }
          ?>
          </tbody>
        </table>
      </div>
    </main>
  </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content rounded-4">
      <div class="modal-header bg-primary text-white rounded-top">
        <h5 class="modal-title" id="editUserModalLabel">View User</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">Name</label>
          <input type="text" class="form-control" id="viewName" readonly />
        </div>
        <div class="mb-3">
          <label class="form-label">Address</label>
          <input type="text" class="form-control" id="viewaddress" readonly />
        </div>
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" class="form-control" id="viewEmail" readonly />
        </div>
        <div class="mb-3">
          <label class="form-label">Phone</label>
          <input type="text" class="form-control" id="viewPhone" readonly />
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
      </div>
    </form>
  </div>
</div>

<!-- Delete User Modal -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content rounded-4">
      <div class="modal-header bg-danger text-white rounded-top">
        <h5 class="modal-title" id="deleteUserModalLabel">Confirm Delete</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this user?
      </div>
      <div class="modal-footer">
        <button class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-danger">Delete</button>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS and Dynamic Modal Script -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.getElementById('editUserModal').addEventListener('show.bs.modal', function (event) {
  const button = event.relatedTarget;
  document.getElementById('viewName').value = button.getAttribute('data-name');
  document.getElementById('viewaddress').value = button.getAttribute('data-address'); // Add this line
  document.getElementById('viewEmail').value = button.getAttribute('data-email');
  document.getElementById('viewPhone').value = button.getAttribute('data-phone');
});
</script>


</body>
</html>
