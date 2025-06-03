<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $token = htmlspecialchars($data['token']);
    $newPassword = htmlspecialchars($data['newPassword']);

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

    $stmt = $conn->prepare("SELECT * FROM users WHERE reset_token = ? AND reset_token_expiry > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        error_log('Valid token: ' . $token);
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("UPDATE users SET keyPass = ?, reset_token = NULL, reset_token_expiry = NULL WHERE reset_token = ?");
        $stmt->bind_param("ss", $hashedPassword, $token);

        // Debugging output for password update
        if ($stmt->execute()) {
            error_log('Password updated successfully for token: ' . $token);
            echo json_encode(['success' => true, 'message' => 'Password updated successfully.']);
        } else {
            error_log('Failed to update password for token: ' . $token . ' - Error: ' . $stmt->error);
            echo json_encode(['success' => false, 'message' => 'Failed to update password.']);
            exit();
        }
    } else {
        error_log('Invalid or expired token: ' . $token);
        echo json_encode(['success' => false, 'message' => 'Invalid or expired token.']);
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
