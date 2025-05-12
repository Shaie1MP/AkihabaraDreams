<?php
// Verificar si hay un usuario logueado
if (!isset($_SESSION['usuario'])) {
    $_SESSION['error'] = "Debes iniciar sesión para acceder a tu lista de deseos";
    header('Location: /Akihabara-Dreams/login');
    exit;
}

$wishlistRepository = new WishlistRepository($connection);
$productsRepository = new ProductsRepository($connection);
$wishlistController = new WishlistController($wishlistRepository, $productsRepository);

switch ($action) {
    case 'add':
        $wishlistController->addToWishlist($idUrl);
        break;
        
    case 'remove':
        $wishlistController->removeFromWishlist($idUrl);
        break;
        
    case 'clear':
        $wishlistController->clearWishlist();
        break;
        
    case 'buy':
        $wishlistController->buyFromWishlist($idUrl);
        break;
        
    default:
        $wishlistController->showWishlist();
        break;
}
