<?php

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: loginPage.php");
    exit();
}

$servername = "localhost";
$username = "root"; 
$password = "";     
$database = "fakedata"; 

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT courseID, courseName, courseDescription, coursePrice FROM courses";
$result = $conn->query($sql);

$courses = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $courses[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script defer src="js/bootstrap.bundle.min.js"></script>
    <script defer src="js/coursePage.js"></script>
    <link href="css/coursePage.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Courses - DataSense Academy</title>
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
        <h1 class="mb-4">Available Courses</h1>
        <div class="search-bar mb-4">
          <input type="text" class="form-control" placeholder="Search courses">
        </div>
        <div class="row g-4">
          <?php foreach ($courses as $course): ?>
            <div class="col-md-4 course-wrapper" data-course-price="<?php echo $course['coursePrice']; ?>">
              <div class="card h-100">
                <div class="card-body">
                  <h5 class="card-title"><?php echo htmlspecialchars($course['courseName']); ?></h5>
                  <p class="card-text"><?php echo htmlspecialchars($course['courseDescription']); ?></p>
                  <input type="hidden" name="courseID" value="<?php echo $course['courseID']; ?>">
                  <button type="button" class="btn btn-dark w-100" onclick="showConfirmation('<?php echo $course['courseID']; ?>', '<?php echo htmlspecialchars($course['courseName']); ?>', '<?php echo htmlspecialchars($course['courseDescription']); ?>', '<?php echo $course['coursePrice']; ?>')">Enroll</button>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </main>
    </div>
  </div>

  <div id="confirmationModal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirm Enrollment</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p id="courseDetails"></p>
        </div>
        <div class="modal-footer">
          <form method="post" action="enrollPage.php">
            <input type="hidden" id="confirmCourseID" name="courseID">
            <button type="submit" class="btn btn-primary">Confirm</button>
          </form>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    function toggleLogoutConfirmation() {
        const confirmationDiv = document.getElementById('logoutConfirmation');
        confirmationDiv.style.display = confirmationDiv.style.display === 'none' ? 'block' : 'none';
    }

    function showConfirmation(courseID, courseName, courseDescription, coursePrice) {
      const modal = document.getElementById('confirmationModal');
      const courseDetails = document.getElementById('courseDetails');
      const confirmCourseID = document.getElementById('confirmCourseID');

      courseDetails.innerHTML = `<strong>Course Name:</strong> ${courseName}<br>
                                 <strong>Description:</strong> ${courseDescription}<br>
                                 <strong>Price:</strong> $${coursePrice}`;
      confirmCourseID.value = courseID;

      $(modal).modal('show');
    }

    // Ensure the cancel button hides the modal
    $(document).on('click', '[data-dismiss="modal"]', function() {
      const modal = document.getElementById('confirmationModal');
      $(modal).modal('hide');
    });
  </script> 
</body>
</html>
