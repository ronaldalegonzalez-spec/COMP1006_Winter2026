<?php
// Establishes connection to MySQL database using mysqli
$host = "127.0.0.1";
$username = "root";
$password = "";
$database = "time_tracker";
$port = 3307;

$conn = mysqli_init();
$conn->real_connect($host, $username, $password, $database, $port);

// Check database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
