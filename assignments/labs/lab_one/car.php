<?php
//create the class
class Car {
//Properties
public string $make;
public string $model;
public int $year;

//Constructor
public function __construct(string $make, string $model, int $year){
    $this->make = $make;
    $this->model = $model;
    $this->year = $year;
}
//Method returning car information
public function Info() : string{

    return "Car Make: {$this->make} | Car Model : {$this->model} | Car Year: {$this->year}";
    }
}
?>