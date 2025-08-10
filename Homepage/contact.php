<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Contact Us | FoodExpress</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f4f4f4;
      color: #333;
    }

    .contact-header {
      background: linear-gradient(120deg, rgb(41, 40, 40), rgb(45, 22, 16));
      color: white;
      padding: 80px 0;
    }

    .contact-header h1 {
      font-size: 3rem;
    }

    .contact-form,
    .contact-info {
      background: #fff;
      border-radius: 20px;
      padding: 40px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
    }

    .contact-form:hover,
    .contact-info:hover {
      transform: translateY(-5px);
    }

    .form-control {
      border-radius: 12px;
      font-size: 0.95rem;
    }

    .btn-primary {
      background: #ff7e5f;
      border: none;
      transition: background 0.3s ease;
    }

    .btn-primary:hover {
      background: #e65b44;
    }

    .contact-icon {
      font-size: 1.6rem;
      color: #ff7e5f;
    }

    @media (max-width: 768px) {
      .contact-header h1 {
        font-size: 2.2rem;
      }
    }
  </style>
</head>
<body>

<?php include_once "navbar.php"; ?>

<!-- Header Section -->
<header class="contact-header text-center">
  <div class="container">
    <h1 class="fw-bold mb-2">Contact Us</h1>
    <p class="lead">We’d love to hear from you!</p>
  </div>
</header>

<!-- Main Contact Section -->
<section class="py-5">
  <div class="container">
    <div class="row g-4 align-items-start">
      
      <!-- Contact Form -->
      <div class="col-lg-7">
        <div class="contact-form">
          <h4 class="mb-4">Send us a message</h4>
          <form id="contactForm">
            <div class="mb-3">
              <label for="name" class="form-label fw-semibold">Full Name</label>
              <input type="text" name="name" class="form-control" id="name" placeholder="Your name" required />
            </div>
            <div class="mb-3">
              <label for="email" class="form-label fw-semibold">Email Address</label>
              <input type="email" name="email" class="form-control" id="email" placeholder="Your email" required />
            </div>
            <div class="mb-3">
              <label for="message" class="form-label fw-semibold">Message</label>
              <textarea name="message" class="form-control" id="message" rows="5" placeholder="Write your message here..." required></textarea>
            </div>
            <button type="submit" class="btn btn-primary px-5 py-2 rounded-pill">Send Message</button>
          </form>
        </div>
      </div>

      <!-- Contact Info -->
      <div class="col-lg-5">
        <div class="contact-info">
          <h5 class="mb-4">Get in Touch</h5>
          <div class="d-flex align-items-start mb-4">
            <i class="bi bi-geo-alt-fill contact-icon me-3"></i>
            <div>
              <strong>Address:</strong><br/>
              All West Bengal<br/>
            </div>
          </div>
          <div class="d-flex align-items-start mb-4">
            <i class="bi bi-envelope-fill contact-icon me-3"></i>
            <div>
              <strong>Email:</strong><br/>
              Verify@foodexpress.com
            </div>
          </div>
          <div class="d-flex align-items-start mb-4">
            <i class="bi bi-telephone-fill contact-icon me-3"></i>
            <div>
              <strong>Phone:</strong><br/>
              +91 97494 97770
            </div>
          </div>
          <div class="d-flex align-items-start">
            <i class="bi bi-clock-fill contact-icon me-3"></i>
            <div>
              <strong>Hours:</strong><br/>
               24/7
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-success">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="successModalLabel">Message Sent</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        Your message has been sent successfully!
      </div>
       <div class="modal-footer">
        <button class="btn btn-light" data-bs-dismiss="modal">Done</button>
        
      </div>
    </div>
  </div>
</div>

<!-- Error Modal -->
<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-danger">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="errorModalLabel">Error</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        Something went wrong. Please try again later.
      </div>
       <div class="modal-footer">
        <button class="btn btn-light" data-bs-dismiss="modal">Done</button>
        
      </div>
    </div>
  </div>
</div>

<?php include_once "footer.php"; ?>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function () {
    $('#contactForm').on('submit', function (e) {
      e.preventDefault();

      $.ajax({
        type: 'POST',
        url: 'submit_contact.php',
        data: $(this).serialize(),
        success: function (response) {
          if (response.trim() === 'success') {
            $('#contactForm')[0].reset();
            new bootstrap.Modal(document.getElementById('successModal')).show();
          } else {
            new bootstrap.Modal(document.getElementById('errorModal')).show();
          }
        },
        error: function () {
          new bootstrap.Modal(document.getElementById('errorModal')).show();
        }
      });
    });
  });
</script>
</body>
</html>
