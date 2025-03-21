<?php
class Product {
    private $id_product;
    private $name;
    private $description;
    private $price;
    private $stock;
    private $category;
    private $photo;
    private $additionalPhotos = [];

    public function __construct($id_product, $name, $description, $price, $stock, $category, $photo) {
        $this->id_product = $id_product;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->stock = $stock;
        $this->category = $category;
        $this->photo = $photo;
    }

    public function getId() {
        return $this->id_product;
    }

    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getStock() {
        return $this->stock;
    }

    public function getCategory() {
        return $this->category;
    }

    public function getPhoto() {
        return $this->photo;
    }

    public function getAdditionalPhotos() {
        return $this->additionalPhotos;
    }

    public function addPhotos($photoName){
        array_push($this->additionalPhotos,$photoName);
    }
}