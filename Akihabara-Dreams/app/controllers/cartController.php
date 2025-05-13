<?php

class CartController {
    public CartRepository $cartRepository;
    protected Cart $cart;

    public function __construct($cartRepository, Cart $cart) {
        $this->cartRepository = $cartRepository;
        $this->cart = $cart;
    }

    // Modificar el método addElement para obtener la cantidad desde $_GET
    public function addElement($id_product) {
        try {
            $quantity = isset($_GET['quantity']) ? intval($_GET['quantity']) : 1;

            $productsRepository = new ProductsRepository($this->cartRepository->getConnection());
            $fullProduct = $productsRepository->searchProduct($id_product);
            
            // Verificar si hay suficiente stock
            if ($fullProduct->getStock() < $quantity) {
                $_SESSION['error'] = "No hay suficiente stock disponible. Stock actual: " . $fullProduct->getStock();
                
                // Si es una petición AJAX, devolver JSON
                if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'error' => $_SESSION['error']]);
                    exit;
                }
                
                // Si no es AJAX, redirigir
                header('Location: /Akihabara-Dreams/products/info/' . $id_product);
                exit;
            }
            
            // Determinar el precio correcto
            $price = $fullProduct->hasPromotion() ? $fullProduct->getDiscountedPrice() : $fullProduct->getPrice();
            
            $result = $this->cartRepository->getProduct($id_product);

            if ($result) {
                $product = new CartProduct(
                    $id_product,
                    $result['name'],
                    $price, 
                    $result['photo']
                );
                $this->cart->addProduct($product, $quantity);
                $this->saveCart();
                
                // Si es una petición AJAX, devolver JSON
                if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true]);
                    exit;
                }
                
                // Si no es AJAX, redirigir
                header('Location: /Akihabara-Dreams/products/info/' . $id_product);
                exit;
            } else {
                throw new Exception('Producto no encontrado');
            }
        } catch (Exception $e) {
            error_log('Error adding product to cart: ' . $e->getMessage());

            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'error' => $e->getMessage()]);
                exit;
            }

            $_SESSION['error'] = "Error al añadir al carrito: " . $e->getMessage();
            header('Location: /Akihabara-Dreams/products/info/' . $id_product);
            exit;
        }
    }

    public function deleteElement($id_product) {
        try {
            $this->cart->removeProduct($id_product);
            $this->saveCart();

            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                header('Content-Type: application/json');
                echo json_encode(['success' => true]);
                exit;
            }

            $referer = $_SERVER['HTTP_REFERER'] ?? '/Akihabara-Dreams/catalog';
            header('Location: ' . $referer);
            exit;
        } catch (Exception $e) {
            error_log('Error removing product from cart: ' . $e->getMessage());
            
            // Si es una solicitud AJAX, devolver JSON con error
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'error' => $e->getMessage()]);
                exit;
            }

            $_SESSION['error'] = "Error al eliminar del carrito: " . $e->getMessage();
            $referer = $_SERVER['HTTP_REFERER'] ?? '/Akihabara-Dreams/catalog';
            header('Location: ' . $referer);
            exit;
        }
    }

    public function saveCart() {
        $_SESSION['carrito'] = serialize($this->cart);
    }

    public function saveCartDatabase() {
        try {
            $this->cartRepository->saveCartDatabase($this->cart);
            $_SESSION['success'] = "Carrito guardado correctamente";
        } catch (Exception $e) {
            $_SESSION['error'] = "Error al guardar el carrito: " . $e->getMessage();
        }

        $referer = $_SERVER['HTTP_REFERER'] ?? '/Akihabara-Dreams/catalog';
        header('Location: ' . $referer);
        exit;
    }

    public function getCartDatabase() {
        try {
            $result = $this->cartRepository->getCartDatabase($this->cart); 
            $newCart = [];

            if (is_array($result)) {
                if (!empty($result)) {
                    foreach ($result as $item) {
                        $cartProduct = new CartProduct(
                            $item['id_product'],
                            $item['productName'],
                            $item['price'],
                            $item['photo']
                        );

                        $newCart[] = [
                            'id' => $cartProduct->getProductId(),
                            'quantity' => $item['quantity'],
                            'product' => $cartProduct
                        ];
                    }
                }
                $_SESSION['carrito'] = serialize(new Cart($this->cart->getId(), $newCart));
            } else {
                throw new Exception('Error al obtener el carrito');
            }
        } catch (Exception $e) {
            $_SESSION['error'] = "Error al obtener el carrito: " . $e->getMessage();
        }
    }

    public function emptyCart() {
        try {
            $_SESSION['carrito'] = serialize(new Cart($this->cart->getId()));
            $_SESSION['success'] = "Carrito vaciado correctamente";
        } catch (Exception $e) {
            $_SESSION['error'] = "Error al vaciar el carrito: " . $e->getMessage();
        }

        $referer = $_SERVER['HTTP_REFERER'] ?? '/Akihabara-Dreams/catalog';
        header('Location: ' . $referer);
        exit;
    }

    public function deleteCart() {
        try {
            $this->cartRepository->deleteCart($this->cart->getId());
            $_SESSION['carrito'] = serialize(new Cart($this->cart->getId()));
            $_SESSION['success'] = "Carrito eliminado correctamente";
        } catch (Exception $e) {
            $_SESSION['error'] = "Error al eliminar el carrito: " . $e->getMessage();
        }

        $referer = $_SERVER['HTTP_REFERER'] ?? '/Akihabara-Dreams/catalog';
        header('Location: ' . $referer);
        exit;
    }
    
    // Método para realizar un pedido
    public function realizarPedido() {
        header('Location: /Akihabara-Dreams/orders/realizar');
        exit;
    }
}
