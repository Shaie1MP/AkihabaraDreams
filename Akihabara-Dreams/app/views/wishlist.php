<?php
include_once '../app/includes/checkSession.php';
include_once '../app/includes/checkCurrency.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Lista de Deseos - Akihabara Dreams</title>
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/normalize.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/language-switcher.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/body.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/navbar.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/carrito.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/wishlist.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/footer.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/notification.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/cart.css">

</head>

<body>
    <?php
    include '../resources/commons/navbar.php';
    
    // Incluir el carrito
    if(isset($_SESSION['usuario'])){
        include '../app/includes/generateCart.php';
    }
    ?>

    <div class="container">
        <div class="wishlist-container">
            <h1>Mi Lista de Deseos</h1>
            
            <?php if (empty($wishlistItems)): ?>
                <div class="empty-wishlist">
                    <p>Tu lista de deseos está vacía.</p>
                    <a href="/Akihabara-Dreams/catalog" class="btn-primary">Explorar Productos</a>
                </div>
            <?php else: ?>
                <div class="wishlist-actions">
                    <a href="/Akihabara-Dreams/wishlist/clear" class="btn-secondary" onclick="return confirm('¿Estás seguro de que quieres vaciar tu lista de deseos?')">Vaciar Lista de Deseos</a>
                </div>
                
                <div class="wishlist-items">
                    <?php foreach ($wishlistItems as $item): ?>
                        <div class="wishlist-item" data-id="<?php echo $item['id_product']; ?>">
                            <div class="wishlist-item-image">
                                <a href="/Akihabara-Dreams/products/info/<?php echo $item['id_product']; ?>">
                                    <img src="/Akihabara-Dreams/resources/images/productos/portadas/<?php echo htmlspecialchars($item['photo']); ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>">
                                </a>
                            </div>
                            
                            <div class="wishlist-item-details">
                                <h3>
                                    <a href="/Akihabara-Dreams/products/info/<?php echo $item['id_product']; ?>">
                                        <?php echo htmlspecialchars($item['product_name']); ?>
                                    </a>
                                </h3>
                                
                                <div class="wishlist-item-price">
                                    <?php
                                    // Verificar si hay un precio con descuento
                                    $productsRepository = new ProductsRepository($GLOBALS['connection']);
                                    $product = $productsRepository->searchProduct($item['id_product']);
                                    
                                    if ($product->hasPromotion()) {
                                        $discountedPrice = $product->getDiscountedPrice();
                                        
                                        if (isset($symbol)) {
                                            if ($symbol === '€') {
                                                echo '<span class="precio-original">' . number_format($item['price'], 2) . '€</span>';
                                                echo '<span class="precio-descuento">' . number_format($discountedPrice, 2) . '€</span>';
                                            } else {
                                                echo '<span class="precio-original">' . $symbol . number_format($item['price'] * $convertion, 2) . '</span>';
                                                echo '<span class="precio-descuento">' . $symbol . number_format($discountedPrice * $convertion, 2) . '</span>';
                                            }
                                        } else {
                                            echo '<span class="precio-original">' . number_format($item['price'], 2) . '€</span>';
                                            echo '<span class="precio-descuento">' . number_format($discountedPrice, 2) . '€</span>';
                                        }
                                        
                                        echo '<span class="promocion-badge">' . $product->getDiscount() . '% OFF</span>';
                                    } else {
                                        if (isset($symbol)) {
                                            if ($symbol === '€') {
                                                echo '<span>' . number_format($item['price'], 2) . '€</span>';
                                            } else {
                                                echo '<span>' . $symbol . number_format($item['price'] * $convertion, 2) . '</span>';
                                            }
                                        } else {
                                            echo '<span>' . number_format($item['price'], 2) . '€</span>';
                                        }
                                    }
                                    ?>
                                </div>
                                
                                <div class="wishlist-item-category">
                                    <span>Categoría: <?php echo htmlspecialchars($item['category']); ?></span>
                                </div>
                                
                                <div class="wishlist-item-stock">
                                    <?php if ($item['stock'] > 0): ?>
                                        <span class="stock-available">En stock (<?php echo $item['stock']; ?>)</span>
                                    <?php else: ?>
                                        <span class="stock-unavailable">Agotado</span>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="wishlist-item-date">
                                    <span>Añadido el: <?php echo date('d/m/Y', strtotime($item['date_added'])); ?></span>
                                </div>
                            </div>
                            
                            <div class="wishlist-item-actions">
                                <?php if ($item['stock'] > 0): ?>
                                    <a href="/Akihabara-Dreams/wishlist/buy/<?php echo $item['id_product']; ?>" class="btn-primary">Comprar Ahora</a>
                                <?php else: ?>
                                    <button class="btn-primary disabled" disabled>Agotado</button>
                                <?php endif; ?>
                                
                                <button class="btn-secondary remove-wishlist-item" data-id="<?php echo $item['id_product']; ?>">Eliminar</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div id="notification" style="display: none;"></div>

    <?php include '../resources/commons/footer.php' ?>

    <script src="/Akihabara-Dreams/resources/js/cart.js"></script>
    <script src="/Akihabara-Dreams/resources/js/wishlist.js"></script>
        
</body>
</html>
