<?php
class Product {
    private $name;
    private $price;
    private $quantity;

    public function __construct($name, $price, $quantity) {
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
    }

    public function getName() {
        return $this->name;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function __toString() {
        return "Product: $this->name, Price: $this->price, Quantity: $this->quantity\n";
    }
}

class Cart {
    private $products;

    public function __construct() {
        $this->products = [];
    }

    public function addProduct(Product $product) {
        array_push($this->products, $product);
    }

    public function removeProduct(Product $product) {
        $this->products = array_diff($this->products, [$product]);
    }

    public function getTotal() {
        $totalPrice = 0;
        foreach ($this->products as $product) {
            $totalPrice += $product->getPrice() * $product->getQuantity();
        }
        return $totalPrice;
    }

    public function __toString() {
        $result = "Products in cart:\n";
        foreach ($this->products as $product) {
            $result .= $product->__toString();
        }
        $totalPrice = $this->getTotal();
        $result .= "Total price: $totalPrice\n";
        return $result;
    }
}

$books = new Product("Reinforcement Learning: An Introduction", 110, 2);
$gpus = new Product("NVIDIA H100", 23500, 10);
$cart = new Cart();

$cart->addProduct($books);
$cart->addProduct($gpus);
echo $cart->__toString();

$cart->removeProduct($books);
echo $cart->__toString();
?>
