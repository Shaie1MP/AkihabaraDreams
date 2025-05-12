<?php
session_start();
header('Content-Type: application/json');

// Verificar si hay un usuario logueado
if (!isset($_SESSION['usuario'])) {
    echo json_encode(['count' => 0]);
    exit;
}

try {
    // Cargar las clases necesarias
    include_once '../../config/database.php';
    include_once '../../config/loader.php';
    
    // Obtener el usuario de la sesión
    $user = unserialize($_SESSION['usuario']);
    $userId = $user->getId();
    
    // Obtener el número de productos en la wishlist
    $wishlistRepository = new WishlistRepository($connection);
    $count = $wishlistRepository->getWishlistCount($userId);
    
    echo json_encode(['count' => $count]);
} catch (Exception $e) {
    error_log('Error en wishlist-count.php: ' . $e->getMessage());
    echo json_encode(['count' => 0, 'error' => $e->getMessage()]);
}
