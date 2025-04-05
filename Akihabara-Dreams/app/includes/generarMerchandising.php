<?php
$tempProductsRepo = new ProductsRepository($GLOBALS['connection']);

$allProducts = $tempProductsRepo->showProducts();

// Filtrar productos de la categoría "mangas"
$merchanProducts = array_filter($allProducts, function($product) {
    return strtolower($product->getCategory()) === 'merchandising';
});

// Limitar la cantidad de mangas a mostrar (por ejemplo, 5)
$merchanProducts = array_slice($merchanProducts, 1, 5);

if (count($merchanProducts) > 0) {
    foreach ($merchanProducts as $merchan) {
        ?>
        <div class="manga-item">
            <img src="/Akihabara-Dreams/resources/images/productos/portadas/<?php echo $merchan->getPhoto(); ?>" alt="<?php echo $merchan->getName(); ?>">
            <h3><?php echo $merchan->getName(); ?></h3>
            <p class="price"><?php echo number_format($merchan->getPrice(), 2); ?>€</p>
            <a href="/Akihabara-Dreams/productos/info/<?php echo $merchan->getId(); ?>" class="view-button">Ver detalles</a>
        </div>
        <?php
    }
} else {
    echo '<p class="no-products">No hay mangas disponibles en este momento.</p>';
}
?>