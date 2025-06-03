<?php
session_start(); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $servername = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $database = "fakedata";

    $conn = new mysqli($servername, $dbUsername, $dbPassword, $database);

    function redirect($url) {
        header("Location: $url");
        exit();
    }

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE keyName = ? AND keyPass = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    $notification = "";

    if ($result->num_rows > 0) {

        $_SESSION['username'] = $username;


        redirect("mainPage.php");
    } else {
        $notification = "
        <div class='alert alert-danger mt-3 w-50 mx-auto shadow rounded-3 d-flex align-items-center' role='alert'>
            <i class='bi bi-x-circle-fill me-2'></i>
            Invalid username or password.
        </div>";
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script defer src="js/bootstrap.bundle.min.js"></script>
    <script defer src="js/loginPage.js"></script>
    <link href="css/loginPage.css" rel="stylesheet">
    <title>website</title>
</head>
<body class="d-flex flex-column min-vh-100">
        <!-- Image and text -->
        <nav class="navbar navbar-dark bg-dark text-white mt-1 mb-1 p-1 m-1 rounded">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="img/plainLogo.png" width="50" height="50" class="d-inline-block align-top me-2" alt="DataSense Academy Logo">
                <div>
                    <span style="font-size: 1.5rem; font-weight: bold; line-height: 1;">DataSense</span><br>
                    <span style="font-size: 1rem; line-height: 1;">Academy</span>
                </div>
            </a>
        </nav>
        
        <!-- Modal -->
        <div id="getStartedModal" class="modal d-flex justify-content-center align-items-center" tabindex="-1" style="display: block; background: rgba(0, 0, 0, 0.5);">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Get Started</h5>
                    </div>
                    <div class="modal-body">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>
                    <div class="modal-footer">
                        <button id="getStartedButton" class="btn btn-primary">Get Started</button>
                    </div>
                </div>
            </div>
        </div>

<!-- Fullscreen Flex Container to Center the Card -->
<div id="mainContent" class="d-flex justify-content-center align-items-center mt-5" style="filter: blur(5px);">
    <div class="card p-4 shadow" style="width: 22rem;">
        <form method="post">
            <!-- Notification -->
            <?php if (!empty($notification)) : ?>
                <div class="position-absolute top-0 start-50 translate-middle-x text-center text-muted mb-2" style="z-index: 20;">
                    <?php echo strip_tags($notification); ?>
                </div>
            <?php endif; ?>
            <!-- Email input -->
            <div data-mdb-input-init class="form-outline mb-4">
                <input type="text" id="form2Example1" name="username" class="form-control" required />
                <label class="form-label d-flex justify-content-center" for="form2Example1">Username</label>
            </div>
            <!-- Password input -->
            <div data-mdb-input-init class="form-outline mb-4">
                <input type="password" id="form2Example2" name="password" class="form-control" required />
                <label class="form-label d-flex justify-content-center" for="form2Example2">Password</label>
            </div>
            <!-- Sign Up Link -->
<p class="text-center mt-3">
    Don't have an account? <a href="signupPage.php" class="text-primary">Sign Up</a>
            <!-- Submit button -->
            <button type="submit" class="btn btn-primary btn-block mb-4 shadow-lg d-block mx-auto">Sign in</button>

            </p>
        </form>
    </div>
</div>

<footer class="bg-dark text-center text-white mt-auto mb-1 p-1 m-1 rounded">
  <p>Welcome to my footer</p>
  <p><a href="mailto:abc.efg@gmail.com" class="text-white">email us</a></p>
</footer>

</body>
</html>