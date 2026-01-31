<?php
require "includes/header.php"; 
/**
 * process.php
 * -----------
 * PURPOSE:
 * - Receive form data from an HTML form
 * - Sanitize and validate user input
 * - Build and send an email to the client
 * - Display a confirmation message
 *
 * This version includes:
 * - filter_input() for sanitizing
 * - filter_var() for validation
 */

// ---------------------------------------------------------
// 1) Ensure the form was submitted using POST
// ---------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "<p>This page expects a POST form submission.</p>";
    exit;
}

// ---------------------------------------------------------
// 2) Sanitize data using filter_input()
// ---------------------------------------------------------
// Instructor note:
// - filter_input() reads from INPUT_POST instead of $_POST
// - FILTER_SANITIZE_SPECIAL_CHARS prevents HTML injection
$firstName = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_SPECIAL_CHARS);
$lastName  = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_SPECIAL_CHARS);
$email     = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$comments  = filter_input(INPUT_POST, 'comments', FILTER_SANITIZE_SPECIAL_CHARS);

// ---------------------------------------------------------
//Validate required fields
// ---------------------------------------------------------

$errors = [];

// Required text fields
if ($firstName === null || $firstName === '') {
    $errors[] = "First name is required.";
}
// Last name validation
if ($lastName === null || $lastName === '') {
    $errors[] = "Last name is required.";
}

// Email validation
if ($email === null || $email === '') {
    $errors[] = "Email address is required.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Email address must be valid.";
}

//Message validation
if ($comments === null || $comments === '') {
    $errors[] = "Please enter a message.";
}


?>


  <main>
  <?php if (!empty($errors)) {
    ?>
        <h1>There was a problem with your submission</h1>

        <ul>
          <?php foreach ($errors as $error): ?>
            <li><?= $error ?></li>
          <?php endforeach; ?>
        </ul>

        <p>
          <a href="index.php">Return to the form</a>
        </p>
      </main>
    </body>
    </html>
    <?php
    exit;
}
?>
    <h1>Thank You for Your Message! 🧁</h1>

    <p>
      Thanks <strong><?= $firstName ?></strong>!
      Your message has been received and sent to the bakery.
    </p>

    <h2>Your Contact Details</h2>

    <p><strong>Name:</strong> <?= $firstName ?> <?= $lastName ?></p>
    <p><strong>Email:</strong> <?= $email ?></p>

    <h3>Your Message</h3>
    <p><?= $comments === "" ? "(none)" : $comments ?></p>

    <p>
      A confirmation has been sent to the bakery.
    </p>

      <a href="index.php">Send another message</a>
      </main>

<?php require "includes/footer.php"; ?> 