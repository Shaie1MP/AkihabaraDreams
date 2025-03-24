<link rel="stylesheet" href="../../resources/css/index.css">
<link rel="stylesheet" href="../../resources/css/navbar.css">
<link rel="stylesheet" href="../../resources/css/figures.css">
<link rel="stylesheet" href="../../resources/css/products.css">
<link rel="stylesheet" href="../../resources/css/footer.css">
<link rel="stylesheet" href="../../resources/css/pagination.css">

<?php
require_once "../config/database.php";
require_once "../controllers/productsController.php";
require_once "../repositories/productsRepository.php";
require_once "../models/product.php";

$repoProduct = new ProductsRepository($pdo);

// Obtener productos
$products = $repoProduct->getProducts();

include("../includes/header.php");
?>

<div class="search-bar">
    <input type="text" name="search" id="search" placeholder="Buscar merchan...">
    <div>
        <button type="submit" id="search-toggle" class="search-button" aria-label="Buscar">
            <img src="/Akihabara-Dreams/resources/images/commons/lupa.png" alt="menu">
        </button>
    </div>
</div>

<h1 class="section-title">MERCHANDISING</h1>
<div class="products-container" id="products-container">
    <?php
    // Mostrar todos los productos pero con data-attributes para la paginación
    $merchanCount = 0;
    foreach ($products as $product) {
        if ($product->getCategory() == 'merchandising') {
            $merchanCount++;
            echo '<div class="product-card" data-product-id="' . $product->getId() . '">';
            echo '<div class="product-image-container">';
            echo '<img src="/Akihabara-Dreams/resources/images/productos/portadas/' . $product->getPhoto() . '" alt="' . $product->getName() . '">';

            if ($product->getStock() <= 0) {
                echo '<span class="sold-out-label">Agotado</span>';
            }
            echo '</div>';

            echo '<h3 class="product-title">' . strtoupper($product->getName()) . '</h3>';
            echo '<p class="product-price">' . number_format($product->getPrice(), 2) . ' €</p>';
            echo '</div>';
        }
    }
    ?>
</div>

<div id="pagination-container" class="pagination"></div>

<div id="no-results-message" class="no-results-message" style="display: none;">
    No se encontraron productos que coincidan con tu búsqueda.
</div>

<script>
    const totalProducts = <?php echo $merchanCount; ?>;
</script>

<script src="../../resources/js/sidebar.js"></script>
<script src="../../resources/js/pagination.js"></script>
<script src="../../resources/js/product-search.js"></script>

<?php
include("../../src/includes/footer.php");
?>