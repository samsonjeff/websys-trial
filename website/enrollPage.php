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

        // Insert enrollment record
        $stmt = $conn->prepare("INSERT INTO enrollments (userID, courseID) VALUES (?, ?)");
        $stmt->bind_param("ii", $userID, $courseID);

        if ($stmt->execute()) {
            echo "<script>alert('Enrollment successful!'); window.location.href='profilePage.php';</script>";
        } else {
            echo "<script>alert('Failed to enroll. Please try again.'); window.location.href='coursePage.php';</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('User not found.'); window.location.href='loginPage.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request.'); window.location.href='coursePage.php';</script>";
}

$conn->close();
?>