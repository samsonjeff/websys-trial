<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script defer src="js/bootstrap.bundle.min.js"></script>
    <script defer src="js/frontPage.js"></script>
    <link href="css/frontPage.css" rel="stylesheet">
    <title>Data Sense</title>
</head>
<body class="d-flex flex-column min-vh-100">

<nav class="navbar navbar-dark bg-dark text-white mt-1 mb-1 p-1 m-1 rounded">
  <a class="navbar-brand d-flex align-items-center" href="#">
    <img src="img/mainlogo.png" width="70" height="70" class="d-inline-block align-top me-2" alt="DataSense Academy Logo">
    <div>
      <span style="font-size: 1.5rem; font-weight: bold; line-height: 1;">DataSense</span><br>
      <span style="font-size: 1rem; line-height: 1;">Academy</span>
    </div>
  </a>
</nav>

<!-- Main Content -->
<div class="container align-items-center d-flex flex-column justify-content-center mt-5 mb-5">
  <div class="card w-50 align-self-center mt-5 mb-5">
    <div class="mt-4 mb-4 align-self-center text-center">
      <h2>Welcome to DataSense Academy</h2>
      <p class="mt-1 mb-1 p-2">where affordable courses and concise, practical challenges help you learn effectively.</p>
      <!-- Button to trigger modal -->
      <button class="btn btn-outline-primary mt-3 shadow-lg" data-bs-toggle="modal" data-bs-target="#getStartedModal">Get Started</button>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="getStartedModal" tabindex="-1" aria-labelledby="getStartedModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="getStartedModalLabel">Get Started</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        Welcome to DataSense Academy!<br>Click the button below to proceed to the login page.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-outline-primary" onclick="location.href='loginPage.php'">Go to Login</button>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
<footer class="bg-dark text-center text-white mt-auto mb-1 p-1 m-1 rounded">
  <p>For inquiries, please email us using the contact information below.</p>
  <p><a href="https://linktr.ee/hotwetsauce" class="text-white" target="_blank" rel="noopener noreferrer" aria-label="Contact us via Linktree">Contact Us</a></p>
</footer>

</body>
</html>