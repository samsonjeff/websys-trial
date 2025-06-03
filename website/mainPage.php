<?php
session_start();


if (!isset($_SESSION['username'])) {
    header("Location: loginPage.php");
    exit();
}

$servername = "localhost";
$dbUsername = "root"; 
$dbPassword = "";     
$database = "fakedata";  

$conn = new mysqli($servername, $dbUsername, $dbPassword, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_SESSION['username'];
$stmt = $conn->prepare("SELECT firstName, lastName FROM users WHERE keyName = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script defer src="js/bootstrap.bundle.min.js"></script>
    <link href="css/mainPage.css" rel="stylesheet">
    <title>Main Page - DataSense Academy</title>
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar -->
      <nav class="col-md-3 text-light sidebar py-4">
        <a href="mainPage.php" class="d-flex align-items-center text-decoration-none text-light mb-3">
          <div class="logo d-flex align-items-center justify-content-center mt-3 mb-5">
            <img src="img/mainlogo.png" width="70" height="70" class="me-2" alt="DataSense Academy Logo">
            <div>
              <span class="fs-4 fw-bold">DataSense</span><br>
              <span class="fs-6">Academy</span>
            </div>
          </div>
        </a>
        <ul class="nav flex-column">
          <li class="nav-item"><a href="mainPage.php" class="nav-link text-light">Home</a></li>
          <li class="nav-item"><a href="coursePage.php" class="nav-link text-light">Courses</a></li>
          <li class="nav-item"><a href="#" class="nav-link text-light">Practice</a></li>
          <li class="nav-item"><a href="#" class="nav-link text-light">Assessments</a></li>
          <li class="nav-item"><a href="profilePage.php" class="nav-link text-light">Profile</a></li>
          <li class="nav-item"><a href="settingsPage.php" class="nav-link text-light">Settings</a></li>
        </ul>
        <!-- Log Out Button -->
        <div class="mt-4">
          <button id="logoutButton" class="btn btn-secondary w-100" onclick="toggleLogoutConfirmation()">Log Out</button>
          <div id="logoutConfirmation" class="mt-2" style="display: none;">
            <form method="post" action="logingOut.php">
              <button type="submit" class="btn btn-light w-100">Confirm Log Out</button>
            </form>
          </div>
        </div>
      </nav>
      <!-- Main Content -->
      <main class="col-md-9 p-5 bg-light">
        <h1 class="mb-4">Welcome back, <?php echo htmlspecialchars($user['firstName'] . ' ' . $user['lastName']); ?>!</h1>
        <div class="row g-4">
          <div class="col-md-6">
            <div class="card h-100">
              <div class="card-body">
                <div class="bg-secondary d-flex align-items-center justify-content-center mb-3 rounded" style="height: 150px;">
                  <div class="play-icon"></div>
                </div>
                <h5 class="card-title">Data Visualization</h5>
                <p class="card-text">Learn how to effectively visualize data.</p>
                <button class="btn btn-outline-primary">Featured Course</button>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card h-100">
              <div class="card-body">
                <h5 class="card-title">Continue Learning</h5>
                <p class="card-text">Introduction to Statistics</p>
                <div class="progress mb-2">
                  <div class="progress-bar" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <p class="card-text">75% complete</p>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
  <script>
    function toggleLogoutConfirmation() {
        const confirmationDiv = document.getElementById('logoutConfirmation');
        confirmationDiv.style.display = confirmationDiv.style.display === 'none' ? 'block' : 'none';
    }
  </script>
</body>
</html>
