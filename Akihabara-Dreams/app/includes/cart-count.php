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
    
    // Contar los productos en el carrito
    $count = 0;
    foreach ($cart->getCart() as $item) {
        $count += $item['quantity'];
    }
    
    echo json_encode(['count' => $count]);
} catch (Exception $e) {
    echo json_encode(['count' => 0, 'error' => $e->getMessage()]);
}
