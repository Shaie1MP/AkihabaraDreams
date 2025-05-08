<?php
session_start();
header('Content-Type: application/json');

// Verificar si hay un usuario logueado y un carrito en la sesión
if (!isset($_SESSION['usuario']) || !isset($_SESSION['carrito'])) {
    echo json_encode(['success' => false, 'message' => 'No hay sesión de usuario o carrito']);
    exit;
}

// Obtener el ID del producto a eliminar
$productId = isset($_GET['id_product']) ? intval($_GET['id_product']) : 0;

if ($productId <= 0) {
    echo json_encode(['success' => false, 'message' => 'ID de producto inválido']);
    exit;
}

try {
    // Cargar las clases necesarias
    include_once '../../config/database.php';
    include_once '../../config/loader.php';
    
    // Obtener el carrito de la sesión
    $cart = unserialize($_SESSION['carrito']);
    
    // Eliminar el producto del carrito
    $cart->removeProduct($productId);
    
    // Guardar el carrito actualizado en la sesión
    $_SESSION['carrito'] = serialize($cart);
    
    // Si el usuario está logueado, actualizar también en la base de datos
    if (isset($_SESSION['usuario'])) {
        $user = unserialize($_SESSION['usuario']);
        $cartRepository = new CartRepository($connection);
        $cartRepository->saveCartDatabase($cart);
    }
    
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
