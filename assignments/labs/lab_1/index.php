<?php 
require "header.php"; 
echo "<p> Follow the instructions outlined in instructions.txt to complete this lab. Good luck & have fun!😀 </p>";
require "footer.php"; 
//Include the car class and connection file
require "car.php";
require "connection.php"; //connection to the database

//New Car object to show all the information
$car = new Car("BMW"," Vantablack BMW X6",2019);
echo $car->Info();

?>
