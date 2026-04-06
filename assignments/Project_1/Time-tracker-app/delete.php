<?php
//delete.php
//Deletes selected task securely using prepared statement
//Redirects back to index after deletion
require("auth.php");
require("db.php");

if (isset($_GET['id'])) {

    $id = intval($_GET['id']);
    $user_id = $_SESSION['user_id'];
    
    $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = :id AND user_id = :user_id");
    $stmt->execute([':id' => $id,':user_id' => $user_id]);

    header("Location: index.php");
    exit();
}
?>
