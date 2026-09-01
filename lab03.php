<?php
// Task 1
// MAX_BOOKS is a constant because the maximum number of books should not change.
class Library {
    const MAX_BOOKS = 3;
}

echo "Maximum books allowed: " . Library::MAX_BOOKS . "<br><br>";


// Task 2
class StudentCounter {
    public static $count = 0;

    public static function addStudent() {
        self::$count++;
    }
}

// Calling the static method three times without creating an object
StudentCounter::addStudent();
StudentCounter::addStudent();
StudentCounter::addStudent();

echo "Total students: " . StudentCounter::$count . "<br><br>";


// Task 3
abstract class Vehicle {
    abstract public function start();
}

class Car extends Vehicle {
    public function start() {
        echo "Car engine started.<br>";
    }
}

class Bike extends Vehicle {
    public function start() {
        echo "Bike started.<br>";
    }
}

// Creating objects
$car = new Car();
$bike = new Bike();

// Calling the start() method
$car->start();
$bike->start();

?>