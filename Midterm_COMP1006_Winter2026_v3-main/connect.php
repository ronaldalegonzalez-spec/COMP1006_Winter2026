<?php
//connection file for the database
$host = "localhost";
$dbname = "book_manager";
$username = "root";
$password = ""; 

// trying to connect
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} 

catch (PDOException $e) {
    //if there is an error show this
    die("Database not working: " . $e->getMessage());
}