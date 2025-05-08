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
        // Verificar tanto la propiedad discount como la propiedad promotion
        return ($this->discount !== null && $this->discount > 0) || 
               (isset($this->promotion) && !empty($this->promotion));
    }

    public function getDiscount(): ?float {
        // Si tenemos discount directamente, usarlo
        if ($this->discount !== null) {
            return $this->discount;
        }
        // Si no, intentar obtenerlo de la propiedad promotion
        if (isset($this->promotion) && isset($this->promotion['discount'])) {
            return $this->promotion['discount'];
        }
        return 0;
    }

    public function setDiscount(?float $discount): void {
        $this->discount = $discount;
    }

    public function setPromotion(array $promotionData): void
    {
        $this->promotion = $promotionData;
    }

    public function getPromotionDescription(): ?string {
        // Si tenemos description directamente, usarlo
        if ($this->promotionDescription !== null) {
            return $this->promotionDescription;
        }
        // Si no, intentar obtenerlo de la propiedad promotion
        if (isset($this->promotion) && isset($this->promotion['description'])) {
            return $this->promotion['description'];
        }
        return null;
    }

    public function setPromotionDescription(?string $promotionDescription): void {
        $this->promotionDescription = $promotionDescription;
    }

    public function getDiscountedPrice(): ?float {
        // Si tenemos discountedPrice directamente, usarlo
        if ($this->discountedPrice !== null) {
            return $this->discountedPrice;
        }
        // Si no, intentar obtenerlo de la propiedad promotion
        if (isset($this->promotion) && isset($this->promotion['discounted_price'])) {
            return $this->promotion['discounted_price'];
        }
        // Si no hay precio con descuento pero hay un descuento, calcularlo
        if ($this->hasPromotion()) {
            return round($this->price * (1 - ($this->getDiscount() / 100)), 2);
        }
        return $this->price;
    }

    public function setDiscountedPrice(?float $discountedPrice): void {
        $this->discountedPrice = $discountedPrice;
    }
}