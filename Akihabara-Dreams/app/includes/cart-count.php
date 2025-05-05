<?php
session_start();
header('Content-Type: application/json');

// Verificar si el carrito existe en la sesión
if (isset($_SESSION['carrito'])) {
    $cart = unserialize($_SESSION['carrito']);
    
    // Verificar si el carrito tiene un método getCount o similar
    if (method_exists($cart, 'getCount')) {
        $count = $cart->getCount();
    } elseif (method_exists($cart, 'getCart')) {
        // Si no tiene getCount pero tiene getCart, contar los elementos
        $cartItems = $cart->getCart();
        $count = count($cartItems);
    } else {
        // Si no podemos determinar el conteo, devolver 0
        $count = 0;
    }
} else {
    $count = 0;
}

// Devolver el conteo en formato JSON
echo json_encode(['count' => $count]);