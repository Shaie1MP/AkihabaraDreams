<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['usuario'])) {
    echo json_encode(['success' => false, 'message' => 'No hay sesión de usuario']);
    exit;
}

$productId = isset($_GET['id_product']) ? intval($_GET['id_product']) : 0;
$quantity = isset($_GET['quantity']) ? intval($_GET['quantity']) : 1;
$redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'true';

if ($productId <= 0) {
    echo json_encode(['success' => false, 'message' => 'ID de producto inválido']);
    exit;
}

try {
    include_once '../../config/database.php';
    include_once '../../config/loader.php';

    $user = unserialize($_SESSION['usuario']);
    
    // Crear u obtener el carrito
    if (!isset($_SESSION['carrito'])) {
        $cart = new Cart($user->getId());
    } else {
        $cart = unserialize($_SESSION['carrito']);
    }
    
    // Obtener el producto
    $productsRepository = new ProductsRepository($connection);
    $product = $productsRepository->searchProduct($productId);
    
    // Verificar stock
    if ($product->getStock() < $quantity) {
        echo json_encode([
            'success' => false, 
            'message' => 'No hay suficiente stock disponible. Stock actual: ' . $product->getStock()
        ]);
        exit;
    }
    
    // Crear el producto para el carrito
    $cartProduct = new CartProduct(
        $productId,
        $product->getName(),
        $product->hasPromotion() ? $product->getDiscountedPrice() : $product->getPrice(),
        $product->getPhoto()
    );

    $cart->addProduct($cartProduct, $quantity);

    $_SESSION['carrito'] = serialize($cart);
    
    // Guardar en la base de datos si el usuario está logueado
    $cartRepository = new CartRepository($connection);
    $cartRepository->saveCartDatabase($cart);
    
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
