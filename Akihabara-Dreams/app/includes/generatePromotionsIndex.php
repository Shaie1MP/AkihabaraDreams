<?php
$promotionsRepository = new PromotionsRepository($GLOBALS['connection']);
$productsWithPromotions = $promotionsRepository->getProductsWithPromotions();

// Limitar a 5 productos para mostrar en la página principal
$productsWithPromotions = array_slice($productsWithPromotions, 0, 5);

if (count($productsWithPromotions) > 0) {
    foreach ($productsWithPromotions as $product) {
        $outOfStock = $product->getStock() <= 0;
?>
        <a href="/Akihabara-Dreams/products/info/<?php echo $product->getId(); ?>" class="product-link">
            <div class="manga-item">
                <div class="product-image-container">
                    <img src="/Akihabara-Dreams/resources/images/productos/portadas/<?php echo $product->getPhoto(); ?>" alt="<?php echo $product->getName(); ?>">
                    <?php if ($product->hasPromotion()): ?>
                        <div class="promocion-badge">-<?php echo $product->getDiscount(); ?>%</div>
                    <?php endif; ?>
                    <?php if ($outOfStock): ?>
                        <span class="status-tag">Agotado</span>
                    <?php endif; ?>
                </div>
                <h3><?php echo $product->getName(); ?></h3>
                <?php if ($product->hasPromotion()): ?>
                    <div class="product-price">
                        <?php
                        if ($symbol !== '€') {
                            echo '<span class="precio-original">' . $symbol . number_format($product->getPrice() * $convertion, 2) . '</span>';
                            echo '<span class="precio-descuento">' . $symbol . number_format($product->getDiscountedPrice() * $convertion, 2) . '</span>';
                        } else {
                            echo '<span class="precio-original">' . number_format($product->getPrice(), 2) . '€</span>';
                            echo '<span class="precio-descuento">' . number_format($product->getDiscountedPrice(), 2) . '€</span>';
                        }
                        ?>
                    </div>
                    <p class="promocion-descripcion"><?php echo htmlspecialchars($product->getPromotionDescription()); ?></p>
                <?php else: ?>
                    <?php
                    if ($symbol !== '€') {
                        echo '<p class="price">' . $symbol . number_format($product->getPrice() * $convertion, 2) . '</p>';
                    } else {
                        echo '<p class="price">' . number_format($product->getPrice(), 2) . '€</p>';
                    }
                    ?>
                <?php endif; ?>
            </div>
        </a>
<?php
    }
} else {
    echo '<p class="no-products">No hay productos en promoción en este momento.</p>';
}
?>