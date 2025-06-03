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
$stmt = $conn->prepare("SELECT userID, firstName, lastName FROM users WHERE keyName = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$userResult = $stmt->get_result();
$user = $userResult->fetch_assoc();
$userID = $user['userID'];

if (!$user) {
    die("User not found.");
}

$stmt->close();

$enrolledCourses = [];
$stmt = $conn->prepare("
    SELECT c.courseID, c.courseName, c.courseDescription, c.courseDate, c.coursePrice
    FROM enrollments e
    INNER JOIN courses c ON e.courseID = c.courseID
    WHERE e.userID = ?
");
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $enrolledCourses[] = $row;
}

error_log("Enrolled courses fetched for userID: $userID");
foreach ($enrolledCourses as $course) {
    error_log("CourseID: " . $course['courseID'] . ", CourseName: " . $course['courseName']);
}

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
    <link href="css/profilePage.css" rel="stylesheet">
    <script defer src="js/profilePage.js"></script>
    <title>Profile - DataSense Academy</title>
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
        <h1 class="mb-4">Welcome, <?php echo htmlspecialchars($user['firstName'] . ' ' . $user['lastName']); ?>!</h1>
        <h3>Your Enrolled Courses</h3>
        <div class="row g-4 mt-4">
          <?php if (!empty($enrolledCourses)): ?>
            <?php foreach ($enrolledCourses as $course): ?>
              <div class="col-md-6">
                <div class="card h-100">
                  <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($course['courseName']); ?></h5>
                    <p class="card-text"><?php echo htmlspecialchars($course['courseDescription']); ?></p>
                    <p class="card-text"><strong>Start Date:</strong> <?php echo htmlspecialchars($course['courseDate']); ?></p>
                    <p class="card-text"><strong>Price:</strong> ₱<?php echo htmlspecialchars(number_format($course['coursePrice'], 2)); ?></p>
                    <button class="btn btn-outline-primary" onclick="confirmCancelEnrollment(<?php echo isset($course['courseID']) ? htmlspecialchars(json_encode($course['courseID'])) : 'null'; ?>)">Cancel Enrollment</button>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <p class="text-muted">You are not enrolled in any courses yet.</p>
          <?php endif; ?>
        </div>
      </main>
    </div>
  </div>
</body>
</html>