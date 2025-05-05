<?php
session_start();

// Verificar si se recibió el ID del producto
if (!isset($_GET['id_product'])) {
    header('Location: /Akihabara-Dreams/');
    exit;
}

$productId = $_GET['id_product'];

// Verificar si el carrito existe en la sesión
if (!isset($_SESSION['carrito'])) {
    header('Location: /Akihabara-Dreams/');
    exit;
}

$cart = unserialize($_SESSION['carrito']);

// Eliminar el producto del carrito
if (method_exists($cart, 'removeProduct')) {
    $cart->removeProduct($productId);
    $_SESSION['carrito'] = serialize($cart);
}

// Determinar a dónde redirigir
$redirect = isset($_GET['redirect']) && $_GET['redirect'] === 'true';
$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/Akihabara-Dreams/';

if ($redirect) {
    // Redirigir a la página anterior
    header('Location: ' . $referer);
    exit;
} else {
    // Devolver JSON para peticiones AJAX
    header('Content-Type: application/json');
    echo json_encode(['success' => true]);
}