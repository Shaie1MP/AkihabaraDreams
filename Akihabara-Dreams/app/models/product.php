<?php

class Product {
    private $id_product;
    protected $name;
    protected $price;
    protected $photo;
    protected $description;
    protected $stock;
    protected $category;
    protected $additionalPhotos;

    public function __construct($id_product, $name, $price, $photo, $description, $stock, $category) {
        $this->id_product = $id_product;
        $this->name = $name;
        $this->price = $price;
        $this->photo = $photo;
        $this->description = $description;
        $this->stock = $stock;
        $this->category = $category;
        $this->additionalPhotos = [];
    }

    public function getId() {
        return $this->id_product;
    }

    public function getName() {
        return $this->name;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getPhoto() {
        return $this->photo;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getStock() {
        return $this->stock;
    }

    public function getCategory() {
        return $this->category;
    }

    public function getAdditionalPhotos() {
        return $this->additionalPhotos;
    }

    public function addPhotos($photoname) {
        array_push($this->additionalPhotos, $photoname);
    }
}



