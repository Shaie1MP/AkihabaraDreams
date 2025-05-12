<?php

class WishlistController {
    private WishlistRepository $wishlistRepository;
    private ProductsRepository $productsRepository;

    public function __construct(WishlistRepository $wishlistRepository, ProductsRepository $productsRepository) {
        $this->wishlistRepository = $wishlistRepository;
        $this->productsRepository = $productsRepository;
    }

    /**
     * Muestra la página de la wishlist
     */
    public function showWishlist() {
        // Verificar si hay un usuario logueado
        if (!isset($_SESSION['usuario'])) {
            $_SESSION['error'] = "Debes iniciar sesión para ver tu lista de deseos";
            header('Location: /Akihabara-Dreams/login');
            exit;
        }

        $user = unserialize($_SESSION['usuario']);
        $userId = $user->getId();

        try {
            // Obtener los productos de la wishlist
            $wishlistItems = $this->wishlistRepository->getWishlist($userId);
            
            // Cargar la vista
            include '../app/views/wishlist.php';
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: /Akihabara-Dreams/');
            exit;
        }
    }

    /**
     * Añade un producto a la wishlist
     * 
     * @param int $productId ID del producto a añadir
     */
    public function addToWishlist($productId) {
        // Verificar si hay un usuario logueado
        if (!isset($_SESSION['usuario'])) {
            if ($this->isAjaxRequest()) {
                $this->sendJsonResponse(['success' => false, 'message' => 'Debes iniciar sesión para añadir productos a tu lista de deseos']);
                exit;
            }
            
            $_SESSION['error'] = "Debes iniciar sesión para añadir productos a tu lista de deseos";
            header('Location: /Akihabara-Dreams/login');
            exit;
        }

        $user = unserialize($_SESSION['usuario']);
        $userId = $user->getId();

        try {
            // Verificar que el producto existe
            $product = $this->productsRepository->searchProduct($productId);
            
            // Añadir a la wishlist
            $result = $this->wishlistRepository->addToWishlist($userId, $productId);
            
            // Si es una solicitud AJAX, devolver JSON
            if ($this->isAjaxRequest()) {
                $this->sendJsonResponse([
                    'success' => $result,
                    'message' => $result ? 'Producto añadido a tu lista de deseos' : 'Error al añadir el producto'
                ]);
                exit;
            }
            
            // Si no es AJAX, redirigir con mensaje
            if ($result) {
                $_SESSION['success'] = "Producto añadido a tu lista de deseos";
            } else {
                $_SESSION['error'] = "Error al añadir el producto a tu lista de deseos";
            }
            
            // Redirigir a la página anterior o a la página del producto
            $referer = $_SERVER['HTTP_REFERER'] ?? '/Akihabara-Dreams/products/info/' . $productId;
            header('Location: ' . $referer);
            exit;
            
        } catch (Exception $e) {
            // Si es una solicitud AJAX, devolver JSON con error
            if ($this->isAjaxRequest()) {
                $this->sendJsonResponse(['success' => false, 'message' => $e->getMessage()]);
                exit;
            }
            
            $_SESSION['error'] = $e->getMessage();
            header('Location: /Akihabara-Dreams/products/info/' . $productId);
            exit;
        }
    }

    /**
     * Elimina un producto de la wishlist
     * 
     * @param int $productId ID del producto a eliminar
     */
    public function removeFromWishlist($productId) {
        // Verificar si hay un usuario logueado
        if (!isset($_SESSION['usuario'])) {
            if ($this->isAjaxRequest()) {
                $this->sendJsonResponse(['success' => false, 'message' => 'Debes iniciar sesión para gestionar tu lista de deseos']);
                exit;
            }
            
            $_SESSION['error'] = "Debes iniciar sesión para gestionar tu lista de deseos";
            header('Location: /Akihabara-Dreams/login');
            exit;
        }

        $user = unserialize($_SESSION['usuario']);
        $userId = $user->getId();

        try {
            // Registrar información de depuración
            error_log("Intentando eliminar producto ID: $productId para usuario ID: $userId");
            
            // Eliminar de la wishlist
            $result = $this->wishlistRepository->removeFromWishlist($userId, $productId);
            
            error_log("Resultado de eliminar: " . ($result ? "Éxito" : "Fallo"));
            
            // Si es una solicitud AJAX, devolver JSON
            if ($this->isAjaxRequest()) {
                $this->sendJsonResponse([
                    'success' => true,
                    'message' => 'Producto eliminado de tu lista de deseos'
                ]);
                exit;
            }
            
            // Si no es AJAX, redirigir con mensaje
            if ($result) {
                $_SESSION['success'] = "Producto eliminado de tu lista de deseos";
            } else {
                $_SESSION['error'] = "Error al eliminar el producto de tu lista de deseos";
            }
            
            // Redirigir a la wishlist
            header('Location: /Akihabara-Dreams/wishlist');
            exit;
            
        } catch (Exception $e) {
            error_log("Error al eliminar de wishlist: " . $e->getMessage());
            
            // Si es una solicitud AJAX, devolver JSON con error
            if ($this->isAjaxRequest()) {
                $this->sendJsonResponse(['success' => false, 'message' => $e->getMessage()]);
                exit;
            }
            
            $_SESSION['error'] = $e->getMessage();
            header('Location: /Akihabara-Dreams/wishlist');
            exit;
        }
    }

    /**
     * Vacía la wishlist del usuario
     */
    public function clearWishlist() {
        // Verificar si hay un usuario logueado
        if (!isset($_SESSION['usuario'])) {
            $_SESSION['error'] = "Debes iniciar sesión para gestionar tu lista de deseos";
            header('Location: /Akihabara-Dreams/login');
            exit;
        }

        $user = unserialize($_SESSION['usuario']);
        $userId = $user->getId();

        try {
            // Vaciar la wishlist
            $result = $this->wishlistRepository->clearWishlist($userId);
            
            if ($result) {
                $_SESSION['success'] = "Tu lista de deseos ha sido vaciada";
            } else {
                $_SESSION['error'] = "Error al vaciar tu lista de deseos";
            }
            
            // Redirigir a la wishlist
            header('Location: /Akihabara-Dreams/wishlist');
            exit;
            
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: /Akihabara-Dreams/wishlist');
            exit;
        }
    }

    /**
     * Compra un producto de la wishlist
     * 
     * @param int $productId ID del producto a comprar
     */
    public function buyFromWishlist($productId) {
        // Verificar si hay un usuario logueado
        if (!isset($_SESSION['usuario'])) {
            $_SESSION['error'] = "Debes iniciar sesión para comprar productos";
            header('Location: /Akihabara-Dreams/login');
            exit;
        }

        try {
            // Verificar que el producto existe y tiene stock
            $product = $this->productsRepository->searchProduct($productId);
            
            if ($product->getStock() <= 0) {
                $_SESSION['error'] = "Lo sentimos, este producto está agotado";
                header('Location: /Akihabara-Dreams/wishlist');
                exit;
            }
            
            // Añadir al carrito
            if (!isset($_SESSION['carrito'])) {
                $user = unserialize($_SESSION['usuario']);
                $_SESSION['carrito'] = serialize(new Cart($user->getId()));
            }
            
            $cart = unserialize($_SESSION['carrito']);
            
            // Crear el producto para el carrito
            $cartProduct = new CartProduct(
                $productId,
                $product->getName(),
                $product->hasPromotion() ? $product->getDiscountedPrice() : $product->getPrice(),
                $product->getPhoto()
            );

            $cart->addProduct($cartProduct, 1);
            $_SESSION['carrito'] = serialize($cart);
            
            // Guardar en la base de datos si es necesario
            $cartRepository = new CartRepository($this->wishlistRepository->getConnection());
            $cartRepository->saveCartDatabase($cart);
            
            $_SESSION['success'] = "Producto añadido al carrito";
            
            // Redirigir al carrito para finalizar la compra
            header('Location: /Akihabara-Dreams/orders/realizar');
            exit;
            
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: /Akihabara-Dreams/wishlist');
            exit;
        }
    }

    /**
     * Verifica si un producto está en la wishlist
     * 
     * @param int $productId ID del producto a verificar
     * @return bool True si el producto está en la wishlist, False en caso contrario
     */
    public function isInWishlist($productId) {
        // Verificar si hay un usuario logueado
        if (!isset($_SESSION['usuario'])) {
            return false;
        }

        $user = unserialize($_SESSION['usuario']);
        $userId = $user->getId();

        try {
            return $this->wishlistRepository->isInWishlist($userId, $productId);
        } catch (Exception $e) {
            error_log('Error al verificar wishlist: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Verifica si la solicitud actual es AJAX
     * 
     * @return bool True si es una solicitud AJAX, False en caso contrario
     */
    private function isAjaxRequest() {
        return (
            isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'
        ) || (
            isset($_POST['is_ajax']) && $_POST['is_ajax'] == '1'
        );
    }
    
    /**
     * Envía una respuesta JSON
     * 
     * @param array $data Datos a enviar como JSON
     */
    private function sendJsonResponse($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
