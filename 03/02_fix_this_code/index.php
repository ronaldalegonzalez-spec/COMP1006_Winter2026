<?php
// Turn on error reporting so syntax and runtime errors are visible during development
ini_set('display_errors', 1);
error_reporting(E_ALL);

//semicolon missing
$host = "localhost"

$dbname = "week_two";
$username = "root";
$password = "";
//missing semicolon here
$dsn = "mysql:host=$hostdbname=$dbname";

try {
    //we need a also use password
    $pdo = new PDO($dsn $username,);
    $pdo->setAttribute(PDO::ATTR_ERRMODE PDO::ERRMODE_SILENT);//missing a comma and instead of SILENT we should use EXCEPTION

    echo "Connected to database!";

    //call the function getMEssage
catch (PDOException $e {
    echo "Database error: " . $e
}
