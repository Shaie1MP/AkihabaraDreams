<?php

class Cart {
    public $id_user;
    public $cart;

    public function __construct($id_user, array $cart = []) {
        $this->id_user = $id_user;
        $this->cart = $cart;
    }

    public function getId() {
        return $this->id_user;
    }
    
    public function getCart() {
        return $this->cart;
    }

    public function addProduct(CartProduct $product, $quantity = 1) {
        $notFound = true;

        foreach ($this->cart as &$item) {
            if ($item['id'] == $product->getProductId()) {
                $notFound = false;

                $item['quantity'] += $quantity;
                break;
            }
        }

        if ($notFound) {
            $this->cart[] = ['id' => $product->getProductId(), 'quantity' => $quantity, 'product' => $product];
        }
    }

    public function removeProduct($productId) {
        foreach ($this->cart as $key => $item) {
            if ($item['id'] == $productId) {
                unset($this->cart[$key]);
                $this->cart = array_values($this->cart);
                break;
            }
        }
    }

    public function getCartJSON() {
        $simplifiedCart = [];

        foreach ($this->cart as $item) {
            $simplifiedCart[] = [
                'id_product' => $item['id'],
                'quantity' => $item['quantity']
            ];
        }
        return json_encode($simplifiedCart);
    }
}