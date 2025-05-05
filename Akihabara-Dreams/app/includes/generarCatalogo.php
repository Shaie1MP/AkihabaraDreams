<?php
// Encabezado del catálogo - Ahora se generará fuera del grid de productos
echo '<div class="catalog-header">';
echo '<button class="filter-button"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"/></svg>' . __('filter') .'</button>';
echo '<div class="sort-dropdown">';
echo '<span>' . __('filter_order_by') .':</span>';
echo '<select id="sortSelect">';
echo '<option value="recent">' . __('filter_recent') .'</option>';
echo '<option value="old">' . __('filter_old') .'</option>';
echo '<option value="price-low">' . __('filter_price_low_high') .'</option>';
echo '<option value="price-high">' . __('filter_price_high_low') .'</option>';
echo '<option value="discount">' . __('filter_discount') .'</option>';
echo '</select>';
echo '</div>';

// Contador de productos
if (!empty($products)) {
    $count = count($products);
    echo '<span class="products-count">' . $count . ' ' . __('filter_products') .'</span>';
}
echo '</div>';

// Contenedor para los productos
echo '<div class="products-grid">';

// Generación de productos
if (!empty($products)) {
    foreach ($products as $product) {
        // Determinar si el producto está en promoción
        $isOnPromotion = $product->hasPromotion();
        
        // Determinar la categoría del producto
        $category = method_exists($product, 'getCategory') ? $product->getCategory() : '';
        
        // Determinar el rango de precio (usando el precio con descuento si está en promoción)
        $price = $isOnPromotion ? $product->getDiscountedPrice() : $product->getPrice();
        $priceRange = '';
        if ($price <= 20) {
            $priceRange = '0-20';
        } elseif ($price <= 50) {
            $priceRange = '20-50';
        } elseif ($price <= 100) {
            $priceRange = '50-100';
        } else {
            $priceRange = '100+';
        }
        
        // Determinar disponibilidad
        $stock = method_exists($product, 'getStock') ? $product->getStock() : 0;
        $availability = $stock > 0 ? 'in-stock' : 'out-of-stock';
        
        // Determinar descuento para filtrado
        $discount = $isOnPromotion ? $product->getDiscount() : 0;
        $discountRange = '';
        if ($discount > 0) {
            if ($discount <= 10) {
                $discountRange = '0-10';
            } elseif ($discount <= 25) {
                $discountRange = '10-25';
            } elseif ($discount <= 50) {
                $discountRange = '25-50';
            } else {
                $discountRange = '50+';
            }
        }
        
        echo '<div class="product" 
                 onclick="window.location.href=\'/Akihabara-Dreams/productos/info/' . $product->getId() . '\'"
                 data-category="' . htmlspecialchars($category) . '"
                 data-price="' . $priceRange . '"
                 data-availability="' . $availability . '"
                 data-discount="' . $discountRange . '">';
        
        // Etiqueta de promoción si aplica
        if ($isOnPromotion) {
            echo '<div class="promocion-badge">' . $product->getDiscount() . '% OFF</div>';
        }
        
        echo '<div class="product-inner">';
        
        // Contenedor de imagen
        echo '<div class="product-image-container">';
        echo '<img src="/Akihabara-Dreams/resources/images/productos/portadas/' . strtolower($product->getPhoto()) . '" alt="' . $product->getName() . '" class="product-image">';
        echo '</div>';
        
        // Contenido principal
        echo '<div class="product-content">';
        echo '<h2 class="product-name">' . $product->getName() . '</h2>';
        
        // Precio
        echo '<div class="price">';
        if ($isOnPromotion) {
            if ($symbol !== '€') {
                echo '<span class="precio-original">' . $symbol . number_format($product->getPrice() * $convertion, 2) . '</span>';
                echo '<span class="precio-descuento">' . $symbol . number_format($product->getDiscountedPrice() * $convertion, 2) . '</span>';
            } else {
                echo '<span class="precio-original">' . number_format($product->getPrice(), 2) . '€</span>';
                echo '<span class="precio-descuento">' . number_format($product->getDiscountedPrice(), 2) . '€</span>';
            }
            
            // Mostrar descripción de la promoción
            echo '<div class="promocion-descripcion">' . htmlspecialchars($product->getPromotionDescription()) . '</div>';
        } else {
            if ($symbol !== '€') {
                echo '<span>' . $symbol . number_format($product->getPrice() * $convertion, 2) . '</span>';
            } else {
                echo '<span>' . number_format($product->getPrice(), 2) . '€</span>';
            }
        }
        echo '</div>'; 
        
        echo '</div>'; 
        echo '</div>'; 
        echo '</div>'; 
    }
} else {
    echo '<div class="no-products"><p>' . __('product_not_available') .'</p></div>';
}

echo '</div>'; 
?>