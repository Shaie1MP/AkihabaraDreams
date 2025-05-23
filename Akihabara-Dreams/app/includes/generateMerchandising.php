<?php
$tempProductsRepo = new ProductsRepository($GLOBALS['connection']);

$allProducts = $tempProductsRepo->showProducts();

// Filtrar productos de la categoría "merchandising"
$merchanProducts = array_filter($allProducts, function($product) {
    return strtolower($product->getCategory()) === 'merchandising' || strtolower($product->getCategory()) === 'merchandise';
});

// Limitar la cantidad de productos a mostrar (por ejemplo, 5)
$merchanProducts = array_slice($merchanProducts, 0, 5);

if (count($merchanProducts) > 0) {
    foreach ($merchanProducts as $merchan) {
        $outOfStock = $merchan->getStock() <= 0;
        ?>
        <a href="/Akihabara-Dreams/products/info/<?php echo $merchan->getId(); ?>" class="product-link">
            <div class="manga-item">
                <img src="/Akihabara-Dreams/resources/images/productos/portadas/<?php echo $merchan->getPhoto(); ?>" alt="<?php echo $merchan->getName(); ?>">
                <?php if ($outOfStock): ?>
                    <span class="status-tag">Agotado</span>
                <?php endif; ?>
                <h3><?php echo $merchan->getName(); ?></h3>
                <?php
                if ($symbol !== '€') {
                    echo '<p class="price">' . $symbol . number_format($merchan->getPrice() * $convertion, 2) . '</p>';
                } else {
                    echo '<p class="price">' . number_format($merchan->getPrice(), 2) . '€</p>';
                }
                ?>
            </div>
        </a>
        <?php
    }
} else {
    echo '<p class="no-products">No hay productos de merchandising disponibles en este momento.</p>';
}
?>

