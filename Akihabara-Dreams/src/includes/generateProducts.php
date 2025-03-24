<link rel="stylesheet" href="../resources/css/products.css">
<link rel="stylesheet" href="../resources/css/promotion-products.css">

<?php
function generateProductSection($products, $category, $itemsPerRow = 4, $rowsToShow = 2) {
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

function generatePromotionSection($pdo, $itemsPerRow = 4, $rowsToShow = 2) {
    echo '<h1 class="section-title">PROMOCIONES</h1>';
    
    $checkStmt = $pdo->query("SELECT COUNT(*) FROM Promotion");
    $totalPromotions = $checkStmt->fetchColumn();
    
    $checkStmt2 = $pdo->query("SELECT COUNT(*) FROM Product_promotions");
    $totalProductPromotions = $checkStmt2->fetchColumn();
    
    if ($totalPromotions == 0 || $totalProductPromotions == 0) {
        echo '<div class="debug-info" style="text-align: center; margin-bottom: 20px; color: #666;">';
        echo 'No hay promociones configuradas en la base de datos. ';
        echo 'Promociones: ' . $totalPromotions . ', Productos con promoción: ' . $totalProductPromotions;
        echo '</div>';
        return;
    }
    
    try {
        $stmt = $pdo->prepare("SELECT * FROM Products_With_Promotions LIMIT 1");
        $stmt->execute();
        $testResult = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$testResult) {
            throw new Exception("La vista no devuelve resultados");
        }
        
        $stmt = $pdo->prepare("SELECT * FROM Products_With_Promotions");
        $stmt->execute();
        $productsWithPromotions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        echo '<div class="debug-info" style="text-align: center; margin-bottom: 20px; color: #666;">';
        echo 'Error con la vista: ' . $e->getMessage() . '. Usando consulta directa.';
        echo '</div>';
    }
    
    $totalItems = count($productsWithPromotions);
    
    if ($totalItems == 0) {
        echo '<div class="debug-info" style="text-align: center; margin-bottom: 20px; color: #666;">';
        echo 'No se encontraron productos con promociones activas.';
        echo '</div>';
        return;
    }
    
    echo '<div class="products-container">';
    
    $itemsToShowInitially = $itemsPerRow * $rowsToShow;

    foreach ($productsWithPromotions as $index => $productData) {
        if ($index < $itemsToShowInitially) {
            $originalPrice = $productData['price'];
            $discountedPrice = $productData['discounted_price'];
            $discount = $productData['discount'];
            
            echo '<div class="product-card promotion-product">';
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
    }
    
    echo '</div>';
    
    if ($totalItems > $itemsToShowInitially) {
        echo '<div class="show-all-container">';
        echo '<a href="views/promociones.php" class="show-all-button">Ver Todas las Promociones</a>';
        echo '</div>';
    }
}

generateProductSection($products, 'figuras');
generateProductSection($products, 'mangas');
generateProductSection($products, 'merchandising');

generatePromotionSection($pdo);
?>