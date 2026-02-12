<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require "includes/header.php";
//  TODO: connect to the database 
require "includes/connect.php";
//   TODO: Grab form data (no validation or sanitization for this lab)
$first_Name = $_POST['first_name'];
$last_Name = $_POST['last_name'];
$email = $_POST['email'];
/*
  1. Write an INSERT statement with named placeholders*/
  $sql = "INSERT INTO subscribers (first_name, last_name, email) VALUES (:first_name, :last_name, :email)";
//   2. Prepare the statement
$stmt = $pdo->prepare($sql);

$stmt->bindParam(':first_name', $first_Name);
$stmt->bindParam(':last_name', $last_Name);
$stmt->bindParam(':email', $email);
//   3. Execute the statement with an array of values
$stmt->execute();



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <main class="container mt-4">
        <h2>Thank You for Subscribing</h2>

        <!-- TODO: Display a confirmation message -->
         <p>
            <?php echo "Thank you, " . htmlspecialchars($firstName) . ", for subscribing to our mailing list! We will contact you at
            <strong>" . htmlspecialchars($email) . "</strong>. "; ?>
        </p>
        <!-- Example: "Thanks, Name! You have been added to our mailing list." -->


        <p class="mt-3">
            <a href="subscribers.php">View Subscribers</a>
        </p>
    </main>
</body>

</html>