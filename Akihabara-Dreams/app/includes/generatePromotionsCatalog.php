<?php
// Verificar si el producto tiene promoción y aplicar el estilo correspondiente
function mostrarPromocion($product) {
    if ($product->hasPromotion()) {
        echo '<div class="promocion-badge">-' . $product->getDiscount() . '%</div>';
        
        // Mostrar precios (original y con descuento)
        echo '<div class="product-price">';
        echo '<span class="precio-original">' . number_format($product->getPrice(), 2) . '€</span>';
        echo '<span class="precio-descuento">' . number_format($product->getDiscountedPrice(), 2) . '€</span>';
        echo '</div>';
        
        // Mostrar descripción de la promoción
        echo '<div class="promocion-descripcion">' . htmlspecialchars($product->getPromotionDescription()) . '</div>';
    } else {
        // Precio normal sin promoción
        echo '<div class="product-price">';
        echo '<span>' . number_format($product->getPrice(), 2) . '€</span>';
        echo '</div>';
    }
}
?>