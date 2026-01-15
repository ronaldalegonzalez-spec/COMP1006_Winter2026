<?php

class Car {

public string $make;
public string $model;
public int $year;

public function __construct(string $make, string $model, int $year){
    $this->make = $make;
    $this->model = $model;
    $this->year = $year;
}
public function Info() : string{

    return "Car Make: {$this->make} | Car Model : {$this->model} | Car Year: {$this->year}";
    }
}
?>