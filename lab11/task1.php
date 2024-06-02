<?php
class Car {
    private $model;
    private $price;
    private $currencyValue;

    public function __construct($model, $price, $currencyValue) {
        $this->model = $model;
        $this->price = $price;
        $this->currencyValue = $currencyValue;
    }

    public function calculatePricePLN() {
        return $this->price * $this->currencyValue;
    }
}

class CarWithFacilities extends Car {
    private $alarm;
    private $radio;
    private $airconditioning;
    public function __construct($model, $price, $currencyValue, $alarm, $radio, $airconditioning) {
        parent::__construct($model, $price, $currencyValue);
        $this->alarm = $alarm;
        $this->radio = $radio;
        $this->airconditioning = $airconditioning;
    }

    public function calculatePricePLN() {
        return parent::calculatePricePLN() + $this->alarm + $this->radio + $this->airconditioning;
    }
}

class Insurance extends CarWithFacilities {
    private $insurancePercentageValue;
    private $yearsOfAquiring;
    public function __construct($model, $price, $currencyValue, $alarm, $radio, $airconditioning, $insurancePercentageValue, $yearsOfAquiring) {
        parent::__construct($model, $price, $currencyValue, $alarm, $radio, $airconditioning);
        $this->insurancePercentageValue = $insurancePercentageValue;
        $this->yearsOfAquiring = $yearsOfAquiring;
    }

    public function calculatePricePLN() {
        return $this->insurancePercentageValue * parent::calculatePricePLN() * ((100 - $this->yearsOfAquiring) / 100);
    }
}

$insurance = new Insurance("Corvette", 100000, 4.3, 2000, 2000, 6000, 1, 10);
echo $insurance->calculatePricePLN();
?>