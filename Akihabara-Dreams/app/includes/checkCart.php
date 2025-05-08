<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['carrito'])) {
    $cartSession = new Cart(unserialize($_SESSION['usuario'])->getId());
    $_SESSION['carrito'] = serialize($cartSession);
} else {
    $cartSession = unserialize($_SESSION['carrito']);
    
    if (!$cartSession instanceof Cart) {
        $cartSession = new Cart(unserialize($_SESSION['usuario'])->getId());
        $_SESSION['carrito'] = serialize($cartSession);
    }
}