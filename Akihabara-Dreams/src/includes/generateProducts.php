<link rel="stylesheet" href="../resources/css/products.css">
<?php
function generateProductSection($products, $category, $itemsPerRow = 5, $rowsToShow = 2) {
    echo '<h1 class="section-title">' . strtoupper($category) . '</h1>';
    echo '<div class="products-container">';
    
    $count = 0;
    $totalItems = 0;
    
    foreach ($products as $product) {
        if ($product->getCategory() == $category) {
            $totalItems++;
        }
    }

    $itemsToShowInitially = $itemsPerRow * $rowsToShow;
    
    foreach ($products as $product) {
        if ($product->getCategory() == $category) {
            $count++;

            if ($count <= $itemsToShowInitially) {
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
    }
    echo '</div>';

    if ($totalItems > $itemsToShowInitially) {
        echo '<div class="show-all-container">';
        echo '<a href="views/' . $category . '.php" class="show-all-button">Ver Todos</a>';
        echo '</div>';
    }
}

generateProductSection($products, 'figuras');
generateProductSection($products, 'mangas');
generateProductSection($products, 'merchandising');
?>