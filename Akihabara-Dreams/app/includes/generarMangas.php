<?php
$tempProductsRepo = new ProductsRepository($GLOBALS['connection']);

$allProducts = $tempProductsRepo->showProducts();

// Filtrar productos de la categoría "mangas"
$mangaProducts = array_filter($allProducts, function($product) {
    return strtolower($product->getCategory()) === 'mangas';
});

// Limitar la cantidad de mangas a mostrar (por ejemplo, 5)
$mangaProducts = array_slice($mangaProducts, 1, 5);

if (count($mangaProducts) > 0) {
    foreach ($mangaProducts as $manga) {
        ?>
        <div class="manga-item">
            <img src="/Akihabara-Dreams/resources/images/productos/portadas/<?php echo $manga->getPhoto(); ?>" alt="<?php echo $manga->getName(); ?>">
            <h3><?php echo $manga->getName(); ?></h3>
            <p class="price"><?php echo number_format($manga->getPrice(), 2); ?>€</p>
            <a href="/Akihabara-Dreams/productos/info/<?php echo $manga->getId(); ?>" class="view-button">Ver detalles</a>
        </div>
        <?php
    }
} else {
    echo '<p class="no-products">No hay mangas disponibles en este momento.</p>';
}
?>