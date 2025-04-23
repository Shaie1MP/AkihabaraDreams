<?php
class OrderDetails {
    private $id_product;
    private $quantity;
    private $subtotal;
    private $productName;
    
    public function __construct($id_product, $quantity, $subtotal, $productName = null) {
        $this->id_product = $id_product;
        $this->quantity = $quantity;
        $this->subtotal = $subtotal;
        $this->productName = $productName;
    }
    
    public function getId() {
        return $this->id_product;
    }
    
    public function getQuantity() {
        return $this->quantity;
    }
    
    public function getSubtotal() {
        return $this->subtotal;
    }
    
    public function getProductName() {
        return $this->productName;
    }
    
    public function setProductName($productName) {
        $this->productName = $productName;
    }
}
