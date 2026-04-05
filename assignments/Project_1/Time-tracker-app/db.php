<?php
// db.php
// Database connection using PDO

$host = "172.31.22.43";
$dbname = "Ronald200631594";
$username = "Ronald200631594";
$password = "cEdLv7vTFS";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    // Set error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>