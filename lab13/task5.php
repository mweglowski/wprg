<?php

interface Animal {
    public function makeSound();
    public function eat();
}

class Dog implements Animal {
    public function makeSound() {
        return "Woof!";
    }

    public function eat() {
        return "The dog is eating.";
    }
}

$dog = new Dog();
echo $dog->makeSound();
echo "\n";
echo $dog->eat();