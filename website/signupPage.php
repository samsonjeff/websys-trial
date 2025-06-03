<?php

$servername = "localhost";
$username = "root"; 
$password = "";      
$dbname = "fakedata";   

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

error_reporting(E_ALL);
ini_set('display_errors', 1);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['firstName']) || empty($_POST['lastName']) || empty($_POST['username']) || empty($_POST['email']) || empty($_POST['pass'])) {
        echo "<div class='alert alert-danger'>All fields are required.</div>";
    } else {
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $user_name = $_POST['username'];
        $email = $_POST['email'];
        $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
        
        // Check for duplicate username or email
        $checkStmt = $conn->prepare("SELECT * FROM users WHERE keyName = ? OR email = ?");
        $checkStmt->bind_param("ss", $user_name, $email);
        $checkStmt->execute();
        $result = $checkStmt->get_result();
        if ($result->num_rows > 0) {
            echo "<div class='alert alert-danger'>Username or email already exists.</div>";
        } else {
            // Use prepared statements to prevent SQL injection
            $stmt = $conn->prepare("INSERT INTO users (firstName, lastName, keyName, email, keyPass) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $firstName, $lastName, $user_name, $email, $pass);

            if ($stmt->execute()) {
                echo "<div class='alert alert-success'>Registration successful. <a href='loginPage.php'>Login here</a></div>";
            } else {
                echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
            }

            $stmt->close();
        }
        $checkStmt->close();
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up - DataSense Academy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="js/signupPage.js" defer></script> <!-- Add this line -->
</head>
<body class="bg-light">

    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow p-4" style="width: 100%; max-width: 400px;">
            <div class="text-center mb-4">
                <img src="img/mainlogo.png" alt="Logo" style="width: 60px;">
                <h3 class="mt-2">DataSense Academy</h3>
            </div>
            <h4 class="text-center mb-4">Register</h4>

            <form action="signupPage.php" method="POST" onsubmit="return validateForm()">
                <div class="mb-3">
                    <label for="firstName" class="form-label">First Name</label>
                    <input type="text" class="form-control" name="firstName" id="firstName" required>
                </div>
                <div class="mb-3">
                    <label for="lastName" class="form-label">Last Name</label>
                    <input type="text" class="form-control" name="lastName" id="lastName" required>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" id="username" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" name="email" id="email" required>
                </div>
                <div class="mb-3">
                    <label for="pass" class="form-label">Password</label>
                    <input type="password" class="form-control" name="pass" id="pass" required>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-outline-primary">Register</button>
                </div>
            </form>

            <div class="mt-3 text-center">
                <small>Already have an account? <a href="loginPage.php">Log In</a></small>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
