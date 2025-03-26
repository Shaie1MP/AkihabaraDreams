<link rel="stylesheet" href="../../resources/css/index.css">
<link rel="stylesheet" href="../../resources/css/figures.css">
<link rel="stylesheet" href="../../resources/css/navbar.css">
<link rel="stylesheet" href="../../resources/css/products.css">
<link rel="stylesheet" href="../../resources/css/footer.css">
<link rel="stylesheet" href="../../resources/css/pagination.css">

<?php
require_once "../config/database.php";
require_once "../controllers/productsController.php";
require_once "../repositories/productsRepository.php";
require_once "../models/product.php";
require_once "../repositories/promotionsRepository.php";
require_once "../models/promotion.php";

$repoProduct = new ProductsRepository($pdo);
$repoPromotion = new PromotionsRepository($pdo);

// Obtener promociones
$promotions = $repoPromotion->showPromotions();

include("../includes/header.php");
?>

<div class="search-bar">
    <input type="text" name="search" id="search" placeholder="Buscar productos...">
    <div>
        <button type="submit" id="search-toggle" class="search-button" aria-label="Buscar">
            <img src="/Akihabara-Dreams/resources/images/commons/lupa.png" alt="menu">
        </button>
    </div>
</div>

<h1 class="section-title">PROMOCIONES</h1>
<div class="products-container" id="products-container">
    <?php
    $stmt = $pdo->prepare("SELECT * FROM Products_With_Promotions");
    $stmt->execute();
    $productsWithPromotions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $promoCount = 0;
    foreach ($productsWithPromotions as $productData) {
        $promoCount++;

        $originalPrice = $productData['price'];
        $discountedPrice = $productData['discounted_price'];
        $discount = $productData['discount'];

        echo '<div class="product-card promotion-product" data-product-id="' . $productData['id_product'] . '">';
        echo '<div class="product-image-container">';
        echo '<img src="/Akihabara-Dreams/resources/images/productos/portadas/' . $productData['photo'] . '" alt="' . $productData['name'] . '">';

        if ($productData['stock'] <= 0) {
            echo '<span class="sold-out-label">Agotado</span>';
        }

        echo '<span class="discount-badge">-' . $discount . '%</span>';
        echo '</div>';

        echo '<h3 class="product-title">' . strtoupper($productData['name']) . '</h3>';
        echo '<div class="price-container">';
        echo '<p class="product-price original-price">' . number_format($originalPrice, 2) . ' €</p>';
        echo '<p class="product-price discounted-price">' . number_format($discountedPrice, 2) . ' €</p>';
        echo '</div>';
        echo '</div>';
    }
    ?>
</div>

<div id="pagination-container" class="pagination"></div>

<div id="no-results-message" class="no-results-message" style="display: none;">
    No se encontraron productos en promoción que coincidan con tu búsqueda.
</div>

<script>
    const totalProducts = <?php echo $promoCount; ?>;
</script>

<script src="../../resources/js/sidebar.js"></script>
<script src="../../resources/js/pagination.js"></script>
<script src="../../resources/js/product-search.js"></script>

<?php
include("../../src/includes/footer.php");
?>