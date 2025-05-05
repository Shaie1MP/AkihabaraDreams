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
    public $promotion = null;

    private  $discount = null;
    private  $promotionDescription = null;
    private  $discountedPrice = null;

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
        return translateProductName($this->id_product, $this->name);
    }

    public function getPrice() {
        return $this->price;
    }

    public function getPhoto() {
        return $this->photo;
    }

    public function getDescription() {
        return translateProductDescription($this->id_product, $this->description);
    }

    public function getStock() {
        return $this->stock;
    }

    public function getCategory() {
        return translateCategory($this->category);
    }

    public function getAdditionalPhotos() {
        return $this->additionalPhotos;
    }

    public function addPhotos($photoname) {
        array_push($this->additionalPhotos, $photoname);
    }

    // Métodos para promociones
    public function hasPromotion(): bool {
        return $this->discount !== null && $this->discount > 0;
    }

    public function getDiscount(): ?float {
        return $this->discount;
    }

    public function setDiscount(?float $discount): void {
        $this->discount = $discount;
    }

    public function getPromotionDescription(): ?string {
        return $this->promotionDescription;
    }

    public function setPromotionDescription(?string $promotionDescription): void {
        $this->promotionDescription = $promotionDescription;
    }

    public function getDiscountedPrice(): ?float {
        return $this->discountedPrice;
    }

    public function setDiscountedPrice(?float $discountedPrice): void {
        $this->discountedPrice = $discountedPrice;
    }
}