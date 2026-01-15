<?php
declare(strict_types=1);

// //3. Variables, Data Tyoes, Concatenation, Conditional Statements & Echo

// $firstName = "Jessica Gilfillan"; //string
// $lastName = "Gilfillan"; //string
// $age = 40; //integer
// $isInstructor = True; //boolean

// echo "<p>Hello there! my name is " . $firstName . " " . $lastName . "</p>";

// if ($isInstructor){
//     echo "<p> I am your teacher <p>";
// }
// else {
//     echo "<p> Opps, teach didn't show! <p>";
// }
// //4. Loosely Typed Language Demo

// $num1 = 1; 
// $num2 = 10;

// function add(int $num1, int $num2) : int {
//     return $num1 + $num2;
// }

// echo "<p>" . add($num1, $num2) . "</p>";
//5. Strict Types & Types Hints


//6. OOP with PHP 

//create the class

class Person {
public string $name;
public int $age;
public bool $isInstructor;

public function __construct(string $name, int $age, bool $isInstructor){
    $this->name = $name;
    $this->age = $age;
    $this->isInstructor = $isInstructor;
}
public function getBadge(): string {
$role = $this->isInstructor ? "Instructor" : "Student";
return "Name: {$this->name} | Age: {$this->age} | Role:  $role";
 }
}

//create an object from the class

$person = new Person("Jessica",40,true);

//use object

echo $person->getBadge();

//7. Push to Github & Run on XAMPP
