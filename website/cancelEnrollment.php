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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['courseID'])) {
    $courseID = intval($_POST['courseID']);
    $username = $_SESSION['username'];

    $stmt = $conn->prepare("SELECT userID FROM users WHERE keyName = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        $userID = $user['userID'];

        $stmt = $conn->prepare("DELETE FROM enrollments WHERE userID = ? AND courseID = ?");
        $stmt->bind_param("ii", $userID, $courseID);

        error_log("Attempting to delete enrollment with userID: $userID and courseID: $courseID");

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                error_log("Enrollment successfully deleted.");
                echo "<script>alert('Enrollment canceled successfully!'); window.location.href='profilePage.php';</script>";
            } else {
                error_log("No enrollment record found to delete.");
                echo "<script>alert('No enrollment record found to cancel.'); window.location.href='profilePage.php';</script>";
            }
        } else {
            error_log("Failed to execute DELETE query: " . $stmt->error);
            echo "<script>alert('Failed to cancel enrollment. Please try again.'); window.location.href='profilePage.php';</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('User not found.'); window.location.href='loginPage.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request.'); window.location.href='profilePage.php';</script>";
}

$conn->close();
?>
