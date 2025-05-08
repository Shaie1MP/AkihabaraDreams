<?php
session_start();
header('Content-Type: application/json');

// Verificar si hay un usuario logueado
if (!isset($_SESSION['usuario'])) {
    echo json_encode(['success' => false, 'message' => 'No hay sesión de usuario']);
    exit;
}

// Obtener los parámetros
$productId = isset($_GET['id_product']) ? intval($_GET['id_product']) : 0;
$quantity = isset($_GET['quantity']) ? intval($_GET['quantity']) : 1;
$redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'true';

if ($productId <= 0) {
    echo json_encode(['success' => false, 'message' => 'ID de producto inválido']);
    exit;
}

try {
    // Cargar las clases necesarias
    include_once '../../config/database.php';
    include_once '../../config/loader.php';
    
    // Obtener el usuario de la sesión
    $user = unserialize($_SESSION['usuario']);
    
    // Crear o obtener el carrito
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
    
    // Añadir al carrito
    $cart->addProduct($cartProduct, $quantity);
    
    // Guardar el carrito en la sesión
    $_SESSION['carrito'] = serialize($cart);
    
    // Guardar en la base de datos si el usuario está logueado
    $cartRepository = new CartRepository($connection);
    $cartRepository->saveCartDatabase($cart);
    
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
