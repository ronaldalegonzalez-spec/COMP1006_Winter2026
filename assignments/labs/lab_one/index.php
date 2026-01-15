<?php 
require "header.php"; 
echo "<p> Follow the instructions outlined in instructions.txt to complete this lab. Good luck & have fun!😀 </p>";
require "footer.php"; 

require "car.php";
require "connection.php";

$car = new Car("BMW"," Vantablack BMW X6",2019);
echo $car->Info();

?>
