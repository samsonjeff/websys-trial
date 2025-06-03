<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

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

    $notification = "";

    // 8-character minimum for the password
    if (strlen($password) < 8) {
        $notification = '<div class="alert alert-danger mt-3 w-50 mx-auto shadow rounded-3 d-flex align-items-center" role="alert">'
            . '<i class="bi bi-x-circle-fill me-2"></i>'
            . 'Password must be at least 8 characters long.'
            . '</div>';
    } else {
        $stmt = $conn->prepare("SELECT keyPass FROM users WHERE keyName = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['keyPass'])) {
                $_SESSION['username'] = $username;
                $_SESSION['logged_in'] = true;

                // Redirect to mainPage.php
                redirect("mainPage.php");
            } else {
                $notification = '<div class="alert alert-danger mt-3 w-50 mx-auto shadow rounded-3 d-flex align-items-center" role="alert">'
                    . '<i class="bi bi-x-circle-fill me-2"></i>'
                    . 'Invalid username or password'
                    . '</div>';
            }
        } else {
            $notification = '<div class="alert alert-danger mt-3 w-50 mx-auto shadow rounded-3 d-flex align-items-center" role="alert">'
                . '<i class="bi bi-x-circle-fill me-2"></i>'
                . 'Invalid username or password'
                . '</div>';
        }

        $stmt->close();
    }

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
    <title>Login - DataSense Academy</title>
</head>
<body class="d-flex flex-column min-vh-100">

<!-- Navbar -->
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
<div id="mainContent" class="d-flex justify-content-center align-items-center mt-5">
    <div class="card p-4 shadow" style="width: 22rem;">
        <form method="post" id="loginForm">
            <!-- Notification -->
            <?php if (!empty($notification)) : ?>
                <div class="text-center">
                    <?php echo $notification; ?>
                </div>
            <?php endif; ?>
            <!-- Username Input -->
            <div class="form-outline mb-4">
                <input type="text" id="form2Example1" name="username" class="form-control" required />
                <label class="form-label d-flex justify-content-center" for="form2Example1">Username</label>
            </div>
            <!-- Password Input -->
            <div class="form-outline mb-4">
                <input type="password" id="form2Example2" name="password" class="form-control" required />
                <label class="form-label d-flex justify-content-center" for="form2Example2">Password</label>
            </div>
            <!-- Spinner -->
            <div id="loadingSpinner" class="spinner-border text-primary d-none" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <!-- Submit Button -->
            <button type="submit" class="btn btn-outline-primary btn-block mb-4 shadow-lg d-block mx-auto">Sign in</button>
            <!-- Sign Up Link -->
            <p class="text-center mt-3">
                Don't have an account? <a href="signupPage.php" class="text-primary">Sign Up</a>
            </p>
            <!-- Forgot Password Link -->
            <p class="text-center mt-3">
                <a href="resetPasswordForm.php" class="text-primary">Forgot Password?</a>
            </p>
        </form>
    </div>
</div>

<!-- Footer -->
<footer class="bg-dark text-center text-white mt-auto mb-1 p-1 m-1 rounded">
  <p>For inquiries, please email us using the contact information below.</p>
  <p><a href="https://linktr.ee/hotwetsauce" class="text-white" target="_blank" rel="noopener noreferrer" aria-label="Contact us via Linktree">Contact Us</a></p>
</footer>

</body>
</html>