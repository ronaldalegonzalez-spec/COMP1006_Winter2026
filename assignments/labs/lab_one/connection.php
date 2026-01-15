<?php
// Datos de conexión a la base de datos
$host = "localhost";
$dbname = "lab_one";
$username = "root";
$password = "";

try {
    // Crear conexión PDO (nota el puerto 3307)
    $conn = new PDO(
        "mysql:host=$host;port=3307;dbname=$dbname",
        $username,
        $password
    );

    // Mostrar errores de PDO
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // echo "Database connected successfully";

} catch (PDOException $e) {
    // Mensaje si falla la conexión
    echo "Database connection failed: " . $e->getMessage();
}
?>
