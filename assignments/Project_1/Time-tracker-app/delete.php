<?php
//delete.php
//Deletes selected task securely using prepared statement
//Redirects back to index after deletion
require("auth.php");
require("db.php");

if (isset($_GET['id'])) {

    $id = intval($_GET['id']);

    $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = :id");
    $stmt->execute([':id' => $id]);

    header("Location: index.php");
    exit();
}
?>
