<?php
session_start(); 

// Verificar si se recibió un ID de producto
if (isset($_GET['id_product'])) {
    $id_product = $_GET['id_product'];
    $quantity = isset($_GET['quantity']) ? intval($_GET['quantity']) : 1;
    
    // Inicializar el carrito si no existe
    if (!isset($_SESSION['carrito'])) {
        $userId = isset($_SESSION['usuario']) ? unserialize($_SESSION['usuario'])->getId() : session_id();
        $_SESSION['carrito'] = serialize(new Cart($userId));
    }
    
    $cart = unserialize($_SESSION['carrito']);
    $cartRepository = new CartRepository($db);
    $cartController = new CartController($cartRepository, $cart);
    
    $cartController->addElement($id_product);
    
    // Guardar el carrito actualizado en la sesión
    $_SESSION['carrito'] = serialize($cart);
    
    // Si se solicita una redirección, redirigir
    if (!isset($_GET['redirect']) || $_GET['redirect'] !== 'false') {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
    
    // Si no se solicita redirección, devolver JSON
    header('Content-Type: application/json');
    echo json_encode(['success' => true]);
} else {
    // Si no se recibió un ID de producto, devolver error
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'No se especificó un ID de producto']);
}
