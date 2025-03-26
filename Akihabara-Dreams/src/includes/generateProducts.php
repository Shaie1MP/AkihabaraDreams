<link rel="stylesheet" href="../resources/css/products.css">

<?php
// Obtener productos por categoría
function getProductsByCategory($pdo, $category, $limit = null) {
    $query = "SELECT * FROM Products WHERE category = :category";
    
    if ($limit) {
        $query .= " LIMIT :limit";
    }
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':category', $category);
    
    if ($limit) {
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    }
    
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Obtener productos en promoción
function getPromotionProducts($pdo, $limit = null) {
    $query = "SELECT * FROM view_promotion_products";
    
    if ($limit) {
        $query .= " LIMIT :limit";
    }
    
    $stmt = $pdo->prepare($query);
    
    if ($limit) {
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    }
    
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Generar HTML para productos
function generateProductsHTML($products, $showAll = false, $maxVisible = 8) {
    $html = '<div class="products-container">';
    $count = 0;
    
    foreach ($products as $product) {
        $isHidden = !$showAll && $count >= $maxVisible;
        $hiddenClass = $isHidden ? 'hidden-product' : '';
        
        $html .= '<div class="product-card ' . $hiddenClass . '">';
        $html .= '<div class="product-image-container">';
        $html .= '<a href="views/product.php?id=' . $product['id_product'] . '">';
        $html .= '<img src="../resources/images/productos/portadas/' . htmlspecialchars($product['main_photo']) . '" alt="' . htmlspecialchars($product['productName']) . '">';
        $html .= '</a>';
        
        if ($product['stock'] <= 0) {
            $html .= '<div class="sold-out-label">Agotado</div>';
        }
        
        $html .= '</div>';
        $html .= '<h3 class="product-title">' . htmlspecialchars($product['productName']) . '</h3>';
        
        // Verificar si hay promoción
        if (isset($product['discount'])) {
            $discountedPrice = $product['price'] * (1 - $product['discount'] / 100);
            $html .= '<div class="discount-badge">-' . $product['discount'] . '%</div>';
            $html .= '<div class="price-container">';
            $html .= '<span class="original-price">€' . number_format($product['price'], 2) . '</span>';
            $html .= '<span class="discounted-price">€' . number_format($discountedPrice, 2) . '</span>';
            $html .= '</div>';
        } else {
            $html .= '<div class="product-price">€' . number_format($product['price'], 2) . '</div>';
        }
        
        // Añadir botón de "Añadir al carrito"
        if ($product['stock'] > 0) {
            $html .= '<button class="add-to-cart-button" data-id="' . $product['id_product'] . '">Añadir al carrito</button>';
        } else {
            $html .= '<button class="add-to-cart-button" disabled>Agotado</button>';
        }
        
        $html .= '</div>';
        $count++;
    }
    
    $html .= '</div>';
    
    // Botón "Ver todos" si hay más productos que el límite visible
    if (!$showAll && count($products) > $maxVisible) {
        $html .= '<div class="show-all-container">';
        $html .= '<a href="views/' . strtolower($products[0]['category']) . '.php" class="show-all-button">Ver todos</a>';
        $html .= '</div>';
    }
    
    return $html;
}

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
                    
                    // Añadir botón de "Añadir al carrito"
                    if ($product->getStock() > 0) {
                        echo '<button class="add-to-cart-button" data-id="' . $product->getId() . '">Añadir al carrito</button>';
                    } else {
                        echo '<button class="add-to-cart-button" disabled>Agotado</button>';
                    }
                    
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
                
                // Añadir botón de "Añadir al carrito" para productos en promoción
                if ($productData['stock'] > 0) {
                    echo '<button class="add-to-cart-button" data-id="' . $productData['id_product'] . '">Añadir al carrito</button>';
                } else {
                    echo '<button class="add-to-cart-button" disabled>Agotado</button>';
                }
                
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

// Generar secciones de productos por categoría
$categories = ['Mangas', 'Figuras', 'Merchandising'];

/*foreach ($categories as $category) {
    $products = getProductsByCategory($pdo, $category, 8);
    
    if (!empty($products)) {
        echo '<section class="section">';
        echo '<h2 class="section-title">' . $category . '</h2>';
        echo generateProductsHTML($products);
        echo '</section>';
    }
}

// Generar sección de productos en promoción
$promotionProducts = getPromotionProducts($pdo, 8);

if (!empty($promotionProducts)) {
    echo '<section class="section">';
    echo '<h2 class="section-title">Promociones</h2>';
    echo generateProductsHTML($promotionProducts);
    echo '</section>';
}*/

generateProductSection($products, 'figuras');
generateProductSection($products, 'mangas');
generateProductSection($products, 'merchandising');

generatePromotionSection($pdo);
?>

