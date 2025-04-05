<?php
$tempProductsRepo = new ProductsRepository($GLOBALS['connection']);

$allProducts = $tempProductsRepo->showProducts();

// Filtrar productos de la categoría "mangas"
$figureProducts = array_filter($allProducts, function($product) {
    return strtolower($product->getCategory()) === 'figuras';
});

// Limitar la cantidad de mangas a mostrar (por ejemplo, 5)
$figureProducts = array_slice($figureProducts, 1, 5);

if (count($figureProducts) > 0) {
    foreach ($figureProducts as $figure) {
        ?>
        <div class="manga-item">
            <img src="/Akihabara-Dreams/resources/images/productos/portadas/<?php echo $figure->getPhoto(); ?>" alt="<?php echo $figure->getName(); ?>">
            <h3><?php echo $figure->getName(); ?></h3>
            <p class="price"><?php echo number_format($figure->getPrice(), 2); ?>€</p>
            <a href="/Akihabara-Dreams/productos/info/<?php echo $figure->getId(); ?>" class="view-button">Ver detalles</a>
        </div>
        <?php
    }
} else {
    echo '<p class="no-products">No hay mangas disponibles en este momento.</p>';
}
?>