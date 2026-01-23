<?php
// Turn on error reporting so syntax and runtime errors are visible during development
ini_set('display_errors', 1);
error_reporting(E_ALL);

//semicolon missing
$host = "localhost";

$dbname = "week_two";
$username = "root";
$password = "";
          //missing semicolon here
$dsn = "mysql:host=$host;dbname=$dbname";

try {
                //we need a also use password
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//missing a comma and instead of SILENT we should use EXCEPTION

    echo "Connected to database!";
//missing closing parenthesis
} 
catch (PDOException $e) {
    //call the function getMEssage
    echo "Database error: " . $e->getMessage();
}

