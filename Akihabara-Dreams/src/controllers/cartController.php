<?php
class CartController {
    private CartRepository $cartRepository;
    private Cart $cart;

    public function __construct(CartRepository $cartRepository, Cart $cart) {
        $this->cartRepository = $cartRepository;
        $this->cart = $cart;
    }

    public function addElement($id_product) {
        $result = $this->cartRepository->searchProduct($id_product);

        if ($result) {
            $product = new CartProduct(
                $id_product,
                $result['productName'],
                $result['price'],
                $result['main_photo']
            );
            $this->cart->addProduct($product);
            $this->saveCart();
        } else {
            throw new Exception('Producto no encontrado');
        }
    }

    public function deleteElement($id_product) {
        $this->cart->removeProduct($id_product);
        $this->saveCart();
    }

    public function saveCart() {
        $_SESSION['cart'] = serialize($this->cart);
    }

    public function saveCartDatabase() {
        $this->cartRepository->saveCartDatabase($this->cart);
    }

    public function getCartDatabase() {
        $result = $this->cartRepository->getCartDatabase($this->cart);
        $newCart = [];

        if (is_array($result)) {
            if (!empty($result)) {
                foreach ($result as $item) {
                    $cartProduct = new CartProduct(
                        $item['id_product'],
                        $item['productName'],
                        $item['price'],
                        $item['main_photo']
                    );
                    $newCart[] = [
                        'id_product' => $cartProduct->getProductId(),
                        'quantity' => $item['quantity'],
                        'product' => $cartProduct];
                }
            }
            $_SESSION['cart'] = serialize(new Cart($this->cart->getId(), $newCart));
        } else {
            throw new Exception('Error al obtener el carrito');
        }
    }

    public function emptyCart() {
        $_SESSION['cart'] = serialize(new Cart($this->cart->getId()));
    }

    public function deleteCart() {
        $this->cartRepository->deleteCart($this->cart->getId());
    }
}