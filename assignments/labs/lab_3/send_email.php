<?php // ---------------------------------------------------------
// Email configuration
// ---------------------------------------------------------
$to = "ronaldalegonzalez@gmail.com";
$subject = "New customer message";

// ---------------------------------------------------------
//  Build the email message
// ---------------------------------------------------------
// Email content is just a STRING.
$message  = "NEW CUSTOMER MESSAGE!\n";
$message .= "=========================\n";
$message .= "Customer name: {$firstName} {$lastName}\n";
$message .= "Customer email: {$email}\n\n";

$message .= "\nMessage:\n";
$message .= ($comments === "") ? "(none)\n" : "{$comments}\n";

// ---------------------------------------------------------
//  Send the email
// ---------------------------------------------------------
// NOTE:
// mail() may not work on local machines without configuration.
// That’s okay — the confirmation page will still display.
$headers = "From: no-reply@bakeittillyoumakeit.example\r\n";
mail($to, $subject, $message, $headers);
?>