<?php
//Database connection details
$host = "localhost";
$dbname = "lab_one";
$username = "root";
$password = "";

try {
      //Crear conexión PDO (nota el puerto 3307)
    $conn = new PDO(
        "mysql:host=$host;port=3307;dbname=$dbname",
        $username,
        $password
    );

    //Show PDO errors
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // echo "Database connected successfully";

} catch (PDOException $e) {
    //Message if connection fails
    echo "Database connection failed: " . $e->getMessage();
}
?>
