<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    $data = json_decode(file_get_contents('php://input'), true);
    $keyName = htmlspecialchars($data['keyName']);
    $newPassword = htmlspecialchars($data['newPassword']);

    // 8-character minimum for the password
    if (strlen($newPassword) < 8) {
        echo json_encode(['success' => false, 'message' => 'Password must be at least 8 characters long.']);
        exit();
    }

    $servername = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $database = "fakedata";

    $conn = new mysqli($servername, $dbUsername, $dbPassword, $database);

    if ($conn->connect_error) {
        error_log('Database connection failed: ' . $conn->connect_error);
        echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
        exit();
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE keyName = ?");
    $stmt->bind_param("s", $keyName);
    $stmt->execute();
    $result = $stmt->get_result();

    // Debugging output for username validation
    if ($result->num_rows > 0) {
        error_log('Valid username: ' . $keyName);
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("UPDATE users SET keyPass = ? WHERE keyName = ?");
        $stmt->bind_param("ss", $hashedPassword, $keyName);

        // Debugging output for password update
        if ($stmt->execute()) {
            error_log('Password updated successfully for username: ' . $keyName);
            echo json_encode(['success' => true, 'message' => 'Password updated successfully.']);
        } else {
            error_log('Failed to update password for username: ' . $keyName . ' - Error: ' . $stmt->error);
            echo json_encode(['success' => false, 'message' => 'Failed to update password.']);
            exit();
        }
    } else {
        error_log('Invalid username: ' . $keyName);
        echo json_encode(['success' => false, 'message' => 'Invalid username.']);
        exit();
    }

    $stmt->close();
    $conn->close();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script defer src="js/bootstrap.bundle.min.js"></script>
    <title>Reset Password</title>
</head>
<body class="d-flex flex-column min-vh-100">

<div class="container d-flex justify-content-center align-items-center mx-auto min-vh-100">
    <div class="card p-4 shadow" style="width: 22rem;">
        <h5 class="text-center mb-4">Reset Your Password</h5>
        <form id="resetPasswordForm">
            <div class="form-outline mb-4">
                <input type="text" id="keyName" class="form-control" placeholder="Enter your username" required />
                <label class="form-label" for="keyName">Username</label>
            </div>
            <div class="form-outline mb-4">
                <input type="password" id="newPassword" class="form-control" placeholder="Enter new password" required />
                <label class="form-label" for="newPassword">New Password</label>
            </div>
            <button type="submit" class="btn btn-outline-primary btn-block">Reset Password</button>
        </form>
    </div>
</div>

<script>
    document.getElementById('resetPasswordForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const keyName = document.getElementById('keyName').value;
        const newPassword = document.getElementById('newPassword').value;

        fetch('resetPasswordForm.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ keyName, newPassword }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                window.location.href = 'loginPage.php';
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again later.');
        });
    });
</script>

</body>
</html>
