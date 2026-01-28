<?php
echo"<p> Thank you for your submitting !</p>";



















//What I did -->
echo"<p> Here is a summary of your order:</p>";

echo "<p>Your Name is </p>" . htmlspecialchars($_POST['first_name']) . " " . htmlspecialchars($_POST['last_name']) . ".";
echo "Your phone Number " . (int) $_POST['phone'] . " years old.";