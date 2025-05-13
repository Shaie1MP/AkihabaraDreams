<?php
session_start();
header('Content-Type: application/json');

// Verificar si hay un carrito en la sesión
if (!isset($_SESSION['carrito'])) {
    echo json_encode(['count' => 0]);
    exit;
}

try {
    // Obtener el carrito de la sesión
    $cart = unserialize($_SESSION['carrito']);
    
    // Verificar que el carrito es un objeto válido con el método getTotalItems
    if (!is_object($cart) || !method_exists($cart, 'getTotalItems')) {
        echo json_encode(['count' => 0, 'error' => 'Carrito inválido']);
        exit;
    }
    
    // Obtener el número de productos en el carrito
    $count = $cart->getTotalItems();
    
    echo json_encode(['count' => $count]);
} catch (Exception $e) {
    error_log('Error en cart-count.php: ' . $e->getMessage());
    echo json_encode(['count' => 0, 'error' => $e->getMessage()]);
}
