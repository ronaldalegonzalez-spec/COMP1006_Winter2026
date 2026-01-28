<?php
require "includes/header.php"; 
//accessing the form data and clean data using filter_input( ) 
//think grab, store and clean 

$firstName = $_POST['first_name'];
$lastName = $_POST['last_name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$address = $_POST['address'];
$comments = $_POST['comments']; 
//what about the products? 
$items = $_POST['items']; 

//validation using filter_var

?>
  <main>
    <h1>Thank You for Your Order! 🧁</h1>

    <p>
      Thanks <strong><?= $firstName ?></strong>!
      Your order has been received and sent to the bakery.
    </p>

    <h2>Your Order Details</h2>

    <p><strong>Name:</strong> <?= $firstName ?> <?= $lastName ?></p>
    <p><strong>Phone:</strong> <?= $phone ?></p>
    <p><strong>Address:</strong> <?= $address ?></p>

    <h3>Items Ordered</h3>
    <ul>
      <?php foreach ($items as $item => $quantity): ?>
        <li><?= $item ?> — <?= $quantity ?></li>
      <?php endforeach; ?>
    </ul>

    <h3>Additional Comments</h3>
    <p><?= $comments === "" ? "(none)" : $comments ?></p>

    <p>
      A confirmation has been sent to the bakery.
    </p>

      <a href="index.php">Place another order</a>
      </main>

<?php require "includes/footer.php"; ?> 