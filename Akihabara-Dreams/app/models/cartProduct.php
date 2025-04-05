<?php
class CartProduct {
    public $id_product;
    public $productName;
    public $price;
    public $main_photo;

    public function __construct($id_product, $productName, $price, $main_photo) {
        $this->id_product = $id_product;
        $this->productName = $productName;
        $this->price = $price;
        $this->main_photo = $main_photo;
    }

    public function getProductId() {
        return $this->id_product;
    }

    public function getProductName() {
        return $this->productName;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getMainPhoto() {
        return $this->main_photo;
    }
}
