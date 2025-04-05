<?php

class CartController {
    public CartRepository $cartRepository;
    protected Cart $cart;

    public function __construct($cartRepository, Cart $cart) {
        $this->cartRepository = $cartRepository;
        $this->cart = $cart;
    }

    public function addElement($id_product) {
        try {
            $result = $this->cartRepository->getProduct($id_product);

            if ($result) {
                $product = new CartProduct($id_product, 
                                            $result['name'], 
                                            $result['price'], 
                                            $result['photo']);
                $this->cart->addProduct($product);
                $this->saveCart();
            } else {
                throw new Exception('Producto no encontrado');
            }
        } catch (Exception $e) {
            error_log('Error adding product to cart: ' . $e->getMessage());
        }
    }
    public function deleteElement($id_product) {
        $this->cart->removeProduct($id_product);
        $this->saveCart();
    }

    public function saveCart() {
        $_SESSION['carrito'] = serialize($this->cart);
    }

    public function saveCartDatabase() {
        $this->cartRepository->saveCartDatabase($this->cart);
    }

    //realmente esta función es el builder del carrito
    public function getCartDatabase() {
        $result = $this->cartRepository->getCartDatabase($this->cart); //array de datos de la consulta
        $newCart = [];
        
        if (is_array($result)) {
            if(!empty($result)){
                foreach ($result as $item) {
                    $cartProduct = new CartProduct($item['id_product'], 
                                                        $item['productName'], 
                                                        $item['price'], 
                                                        $item['photo']);

                    $newCart[] = ['id' => $cartProduct->getProductId(), 
                                    'quantity' => $item['quantity'], 
                                    'product' => $cartProduct];
                }
            }
            $_SESSION['carrito'] = serialize(new Cart($this->cart->getId(), $newCart));
        } else {
            throw new Exception('Error al obtener el carrito');
        }
    }

    public function emptyCart() {
        $_SESSION['carrito'] = serialize(new Cart($this->cart->getId()));
    }

    public function deleteCart() {
        $this->cartRepository->deleteCart($this->cart->getId());
    }

}

