<link rel="stylesheet" href="../../resources/css/index.css">
<link rel="stylesheet" href="../../resources/css/navbar.css">
<link rel="stylesheet" href="../../resources/css/figures.css">
<link rel="stylesheet" href="../../resources/css/products.css">
<link rel="stylesheet" href="../../resources/css/footer.css">


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
    <input type="text" name="search" id="search">
    <div>
        <button type="submit" id="search-toggle" class="search-button" aria-label="Buscar">
            <img src="/Akihabara-Dreams/resources/images/commons/lupa.png" alt="menu">
        </button>
    </div>
</div>

<script src="../../resources/js/sidebar.js"></script>

<?php
echo '<h1 class="section-title">FIGURAS</h1>';
echo '<div class="products-container">';
foreach ($products as $product) {
    if ($product->getCategory() == 'figuras') {
        echo '<div class="product-card">';
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
echo '</div>';

include("../../src/includes/footer.php");

?>