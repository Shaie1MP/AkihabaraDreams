<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mangas - Akihabara Dreams</title>
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/normalize.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/footer.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/body.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/navbar.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/cart.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/search.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/pag.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/products.css">
</head>

<body>
    <?php
    include '../resources/commons/navbar.php';

    include '../resources/commons/search.html';
    ?>

    <main id="productList">
        <?php
        include '../app/includes/comprobarDivisa.php';
        ?>

        <?php
        $tempProductsRepo = new ProductsRepository($GLOBALS['connection']);

        $allProducts = $tempProductsRepo->showProducts();

        // Filtrar productos de la categoría "mangas"
        $mangaProducts = array_filter($allProducts, function ($product) {
            return strtolower($product->getCategory()) === 'mangas';
        });

        // Limitar la cantidad de mangas a mostrar (por ejemplo, 5)
        $mangaProducts = array_slice($mangaProducts, 0, 5);

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
    </main>
    <!-- <a href="https://boardgamegeek.com">Para pillar las imágenes</a> -->
    <div id="paginacion"></div>

    <script src="/Akihabara-Dreams/resources/js/search.js"></script>
    <script src="/Akihabara-Dreams/resources/js/pag.js"></script>


    <?php
    if (isset($_SESSION['usuario'])) {
        include '../app/includes/generarCarrito.php';
    } else {
        echo '<div id="cartModal" class="cart-modal">
    <div class="cart-modal-content">
        <span class="close">×</span>
        <p>Debes iniciar sesión para usar el carrito.</p>
        </div>
        </div>';
    }

    include '../resources/commons/footer.php';
    ?>
    <script src="/Akihabara-Dreams/resources/js/carrito.js"></script>
</body>

</html>