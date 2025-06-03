<?php
$servername = "localhost";
$username = "root";
$password = ""; 
$database = "users"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

// Execute query
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "User: " . $row["user"] . " - Password: " . $row["pass"] . "<br>";
    }
} else {
    echo "0 results";
}

$conn->close();
?>
