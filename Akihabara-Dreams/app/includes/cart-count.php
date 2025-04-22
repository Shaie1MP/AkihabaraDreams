<?php
session_start();
header('Content-Type: application/json');

// Verificar si existe un carrito en la sesión
if (isset($_SESSION['carrito'])) {
    $cart = unserialize($_SESSION['carrito']);
    $count = 0;
    
    // Contar el número total de productos (sumando cantidades)
    if (method_exists($cart, 'getCart')) {
        foreach ($cart->getCart() as $item) {
            if (isset($item['quantity'])) {
                $count += $item['quantity'];
            }
        }
    }
    
    echo json_encode(['count' => $count]);
} else {
    echo json_encode(['count' => 0]);
}
