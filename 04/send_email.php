<?php // ---------------------------------------------------------
// Email configuration
// ---------------------------------------------------------
$to = "bitumi@gmail.com";
$subject = "New Bakery Order Submission";

// ---------------------------------------------------------
//  Build the email message
// ---------------------------------------------------------
// Email content is just a STRING.
$message  = "NEW BAKERY ORDER\n";
$message .= "=========================\n";
$message .= "Customer: {$firstName} {$lastName}\n";
$message .= "Phone: {$phone}\n";
$message .= "Address: {$address}\n\n";

$message .= "Items Ordered:\n";

foreach ($items as $item => $quantity) {
    $message .= "- {$item}: {$quantity}\n";
}

$message .= "\nAdditional Comments:\n";
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