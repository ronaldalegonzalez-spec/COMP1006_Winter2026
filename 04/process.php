<?php
echo"<p> Thank you for your submitting !</p>";



















//What I did -->
echo"<p> Here is a summary of your order:</p>";

echo "<p>Your Name is: " . ($_POST['first_name']) . " " . htmlspecialchars($_POST['last_name']) . "." . "</p>";
echo "<p>Your phone number is: " . (int) $_POST['phone'] . "." . "</p>";