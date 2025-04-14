<?php
// Encabezado del catálogo - Ahora se generará fuera del grid de productos
echo '<div class="catalog-header">';
echo '<button class="filter-button"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"/></svg> Filtrar</button>';
echo '<div class="sort-dropdown">';
echo '<span>Ordenar por:</span>';
echo '<select id="sortSelect">';
echo '<option value="recent">Fecha: reciente a antiguo(a)</option>';
echo '<option value="old">Fecha: antiguo a reciente</option>';
echo '<option value="price-low">Precio: menor a mayor</option>';
echo '<option value="price-high">Precio: mayor a menor</option>';
echo '</select>';
echo '</div>';

// Contador de productos
if (!empty($products)) {
    $count = count($products);
    echo '<span class="products-count">' . $count . ' productos</span>';
}
echo '</div>';

// Contenedor para los productos
echo '<div class="products-grid">';

// Generación de productos
if (!empty($products)) {
    foreach ($products as $product) {
        // Determinar si el producto está en oferta (ejemplo: si tiene un precio original mayor)
        $isOnSale = isset($product->getOriginalPrice) && $product->getOriginalPrice() > $product->getPrice();
        
        // Determinar la categoría del producto (asumiendo que existe un método getCategory)
        $category = method_exists($product, 'getCategory') ? $product->getCategory() : '';
        
        // Determinar el rango de precio
        $price = $product->getPrice();
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
        
        // Determinar disponibilidad (asumiendo que existe un método getStock)
        $stock = method_exists($product, 'getStock') ? $product->getStock() : 0;
        $availability = $stock > 0 ? 'in-stock' : 'out-of-stock';
        
        echo '<div class="product" 
                 onclick="window.location.href=\'/Akihabara-Dreams/productos/info/' . $product->getId() . '\'"
                 data-category="' . htmlspecialchars($category) . '"
                 data-price="' . $priceRange . '"
                 data-availability="' . $availability . '">';
        
        // Etiqueta de oferta si aplica
        if ($isOnSale) {
            echo '<div class="offer-badge">Oferta</div>';
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
        if ($isOnSale && isset($product->getOriginalPrice)) {
            if ($symbol !== '€') {
                echo '<span class="original-price">' . $symbol . number_format($product->getOriginalPrice() * $convertion, 2) . '</span>';
            } else {
                echo '<span class="original-price">' . $product->getOriginalPrice() . '€</span>';
            }
        }
        
        if ($symbol !== '€') {
            echo '<span>' . $symbol . number_format($product->getPrice() * $convertion, 2) . '</span>';
        } else {
            echo '<span>' . $product->getPrice() . '€</span>';
        }
        echo '</div>'; 
        
        echo '</div>'; 
        echo '</div>'; 
        echo '</div>'; 
    }
} else {
    echo '<div class="no-products"><p>Ahora mismo no hay productos disponibles</p></div>';
}

echo '</div>'; 
?>
