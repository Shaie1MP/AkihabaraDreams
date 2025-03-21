<?php 
class OrderDetails {
    private $id_product;
    private $productName;
    private $quantity;
    private $subtotal;

    public function __construct($id_product, $productName, $quantity, $subtotal) {
        $this->id_product = $id_product;
        $this->productName = $productName;
        $this->quantity = $quantity;
        $this->subtotal = $subtotal;
    }

    public function getProductId() {
        return $this->id_product;
    }

    public function getProductName() {
        return $this->productName;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function getSubtotal() {
        return $this->subtotal;
    }
}