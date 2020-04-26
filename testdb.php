<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "csit314";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM Users";
$result = $conn->query($sql);

if (mysqli_num_rows($result) > 0) {
    echo "1> results!!";
} else {
    echo "0 results";
}

$conn->close();
