<?php
$tempProductsRepo = new ProductsRepository($GLOBALS['connection']);

$allProducts = $tempProductsRepo->showProducts();

// Filtrar productos de la categoría "figuras"
$figureProducts = array_filter($allProducts, function($product) {
    return strtolower($product->getCategory()) === 'figuras';
});

// Limitar la cantidad de figuras a mostrar (por ejemplo, 5)
$figureProducts = array_slice($figureProducts, 0, 5);

if (count($figureProducts) > 0) {
    foreach ($figureProducts as $figure) {
        $outOfStock = $figure->getStock() <= 0;
        ?>
        <a href="/Akihabara-Dreams/productos/info/<?php echo $figure->getId(); ?>" class="product-link">
            <div class="manga-item">
                <img src="/Akihabara-Dreams/resources/images/productos/portadas/<?php echo $figure->getPhoto(); ?>" alt="<?php echo $figure->getName(); ?>">
                <?php if ($outOfStock): ?>
                    <span class="status-tag">Agotado</span>
                <?php endif; ?>
                <h3><?php echo $figure->getName(); ?></h3>
                <p class="price"><?php echo number_format($figure->getPrice(), 2); ?>€</p>
            </div>
        </a>
        <?php
    }
} else {
    echo '<p class="no-products">No hay figuras disponibles en este momento.</p>';
}
?>

