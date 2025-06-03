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

$conn = new mysqli($servername, $dbUsername, $dbPassword, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$stmt = $conn->prepare("SELECT email FROM users WHERE keyName = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$userEmail = $result->fetch_assoc()['email'];
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
    <title>Settings - DataSense Academy</title>
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
        <h1 class="mb-4">Settings</h1>
        <form method="post" onsubmit="return confirmUpdate()">
          <div class="mb-3">
            <label for="firstName" class="form-label">First Name</label>
            <input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo htmlspecialchars($user['firstName']); ?>" disabled required>
          </div>
          <div class="mb-3">
            <label for="lastName" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="lastName" name="lastName" value="<?php echo htmlspecialchars($user['lastName']); ?>" disabled required>
          </div>
          <div class="mb-3">
            <label for="keyName" class="form-label">Username (Key Name)</label>
            <input type="text" class="form-control" id="keyName" name="keyName" value="<?php echo htmlspecialchars($username); ?>" disabled>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($userEmail); ?>" disabled required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">New Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter new password" disabled>
          </div>
          <div class="mb-3">
            <label for="confirmPassword" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm new password" disabled>
          </div>
          <button type="button" class="btn btn-outline-secondary" id="editButton" onclick="enableEditing()">Edit</button>
          <button type="submit" class="btn btn-outline-primary" id="updateButton" disabled>Update</button>
        </form>
        <script>
          function enableEditing() {
              document.getElementById('firstName').disabled = false;
              document.getElementById('lastName').disabled = false;
              document.getElementById('email').disabled = false;
              document.getElementById('password').disabled = false;
              document.getElementById('confirmPassword').disabled = false;
              document.getElementById('updateButton').disabled = false;
          }

          function confirmUpdate() {
              const password = document.getElementById('password').value;
              const confirmPassword = document.getElementById('confirmPassword').value;

              if (password !== confirmPassword) {
                  alert('Passwords do not match. Please try again.');
                  return false;
              }

              // Enable all fields before submission
              document.getElementById('firstName').disabled = false;
              document.getElementById('lastName').disabled = false;
              document.getElementById('email').disabled = false;
              document.getElementById('password').disabled = false;
              document.getElementById('confirmPassword').disabled = false;

              return confirm('Are you sure you want to update your information?');
          }
        </script>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $newFirstName = $_POST['firstName'];
            $newLastName = $_POST['lastName'];
            $newEmail = $_POST['email'];
            $newPassword = $_POST['password'];

            $conn = new mysqli($servername, $dbUsername, $dbPassword, $database);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Check if the password field is empty
            if (empty($newPassword)) {
                $stmt = $conn->prepare("UPDATE users SET firstName = ?, lastName = ?, email = ? WHERE keyName = ?");
                $stmt->bind_param("ssss", $newFirstName, $newLastName, $newEmail, $username);
            } else {
                if (strlen($newPassword) < 8) {
                    echo "<div class='alert alert-danger' style='position: fixed; top: 10px; right: 10px; z-index: 1000;'>Password must be at least 8 characters long.</div>";
                    $stmt->close();
                    $conn->close();
                    exit();
                }
                $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
                $stmt = $conn->prepare("UPDATE users SET firstName = ?, lastName = ?, email = ?, keyPass = ? WHERE keyName = ?");
                $stmt->bind_param("sssss", $newFirstName, $newLastName, $newEmail, $hashedPassword, $username);
            }

            if ($stmt->execute()) {
                echo "<div class='alert alert-success' style='position: fixed; top: 10px; right: 10px; z-index: 1000;'>Changes saved successfully!</div>";
            } else {
                echo "<div class='alert alert-danger' style='position: fixed; top: 10px; right: 10px; z-index: 1000;'>Failed to save changes. Please try again.</div>";
            }

            $stmt->close();
            $conn->close();
        }
        ?>
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