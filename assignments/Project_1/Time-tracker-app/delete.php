<?php
//delete.php
//Deletes selected task securely using prepared statement
//Redirects back to index after deletion

require("db.php");

//Check if ID exists in URL
if (isset($_GET['id'])) {

    $id = $_GET['id'];

    //Prepare delete statement
    $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } 
    else {
        echo "Error deleting task."; }
   

    $stmt->close();
}

$conn->close();
?>
