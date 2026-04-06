<?php
// db.php
// Database connection using PDO

$host = "localhost";
$dbname = "time_tracker";
$username = "time_user";
$password = "TimePass123";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    // Set error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>