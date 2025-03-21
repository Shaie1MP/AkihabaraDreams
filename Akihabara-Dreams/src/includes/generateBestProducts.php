
<link rel="stylesheet" href="../resources/css/products.css">
<?php
echo '<h1 class="section-title">NOVEDADES</h1>';
echo '<div class="products-container">';
    foreach ($products as $product) {
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
echo '</div>';
?>