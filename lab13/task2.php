<?php

interface Employee {
    public function getSalary();
    public function setSalary($salary);
    public function getRole();
}

class Manager implements Employee {
    private $salary;
    private $employees = array();

    public function addEmployee(Employee $employee) {
        array_push($this->employees, $employee);
    }

    public function getEmployees() {
        for ($i = 0; $i < count($this->employees); $i++) {
            echo "[$i] ";
            echo $this->employees[$i]->getRole();
            echo "\n";
        }
    }

    public function getRole() {
        return "Manager";
    }

    public function getSalary() {
        return $this->salary;
    }

    public function setSalary($salary) {
        $this->salary = $salary;
    }
}

class Developer implements Employee {
    private $salary;
    private $programmingLanguage;

    public function setProgrammingLanguage($language) {
        $this->programmingLanguage = $language;
    }

    public function getProgrammingLanguage() {
        return $this->programmingLanguage;
    }

    public function getRole() {
        return "Developer";
    }

    public function getSalary() {
        return $this->salary;
    }

    public function setSalary($salary) {
        $this->salary = $salary;
    }
}

class Designer implements Employee {
    private $salary;
    private $designingTool;

    public function setDesigningTool($designingTool) {
        $this->designingTool = $designingTool;
    }

    public function getDesigningTool() {
        return $this->designingTool;
    }

    public function getRole() {
        return "Designer";
    }

    public function getSalary() {
        return $this->salary;
    }

    public function setSalary($salary) {
        $this->salary = $salary;
    }
}

$designer = new Designer();
echo $designer->getRole();
echo "\n";
$manager = new Manager();
$manager->addEmployee($designer);
$developer = new Developer();
$developer->setProgrammingLanguage("Rust");
$manager->addEmployee($developer);
echo $manager->getRole();
echo "\n";
$manager->getEmployees();
