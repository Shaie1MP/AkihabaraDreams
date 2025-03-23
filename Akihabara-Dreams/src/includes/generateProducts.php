<link rel="stylesheet" href="../resources/css/products.css">
<link rel="stylesheet" href="../resources/css/product-carousel.css">

<?php
// Categorías a mostrar
$categories = ['figuras', 'mangas', 'merchandising'];

foreach ($categories as $category) {
    echo '<section class="category-section">';
    echo '<h1 class="section-title">' . strtoupper($category) . '</h1>';
    
    // Contenedor del carousel
    echo '<div class="product-carousel-container">';
    echo '<div class="product-carousel-track">';
    
    // Filtrar productos por categoría
    $categoryProducts = array_filter($products, function($product) use ($category) {
        return $product->getCategory() == $category;
    });
    
    // Si no hay productos en esta categoría, mostrar mensaje
    if (empty($categoryProducts)) {
        echo '<p class="no-products">No hay productos disponibles en esta categoría.</p>';
    } else {
        // Mostrar productos en el carousel
        foreach ($categoryProducts as $product) {
            echo '<div class="product-carousel-slide">';
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
            echo '</div>';
        }
    }
    
    echo '</div>'; // Cierre de product-carousel-track
    
    // Botones de navegación
    echo '<button class="product-carousel-button prev" aria-label="Anterior">&#10094;</button>';
    echo '<button class="product-carousel-button next" aria-label="Siguiente">&#10095;</button>';
    
    // Indicadores de posición (dots)
    echo '<div class="product-carousel-dots">';
    $i = 0;
    foreach ($categoryProducts as $product) {
        echo '<button class="product-carousel-dot ' . ($i === 0 ? 'active' : '') . '" data-index="' . $i . '" aria-label="Ir a producto ' . ($i + 1) . '"></button>';
        $i++;
    }
    echo '</div>'; // Cierre de product-carousel-dots
    
    echo '</div>'; // Cierre de product-carousel-container
    echo '</section>';
}
?>