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

    public function addProduct(CartProduct $product) {
        $notFound = true;

        foreach ($this->cart as &$item) {
            if ($item['id'] == $product->getProductId()) {
                $notFound = false;
                $item['quantity']++;

                break;
            }
        }

        if ($notFound) {
            $this->cart[] = ['id' => $product->getProductId(), 'quantity' => 1, 'product' => $product];
        }
    }

    public function removeProduct($id_product) {
        foreach ($this->cart as $key => $item) {
            if ($item['id'] == $id_product) {
                unset($this->cart[$key]);
                $this->cart = array_values($this->cart);

                break;
            }
        }
    }

    public function getCartJSON() {
        $simpleCart = [];

        foreach ($this->cart as $item) {
            $simpleCart[] = [
                'id_product' => $item['id'],
                'quantity' => $item['quantity']
            ];
        }

        return json_encode($simpleCart);
    }
}