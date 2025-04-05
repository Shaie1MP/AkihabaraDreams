<?php
if (!empty($products)) {
    foreach ($products as $product) {
        echo '<div class="product">';
        echo '<div class="product-inner">';
        echo '<div class="product-front">';
        echo '<img src=/Akihabara-Dreams/resources/images/productos/portadas/' . strtolower($product->getPhoto()) . ' alt="' . $product->getName() . '" class="product-image">';
        echo '<div class="product-name-container">';
        echo '<h2 class="product-name">' . $product->getName() . '</h2>';
        echo '</div>';
        echo '</div>';
        echo '<div class="product-back">';
        echo '<p class="description">' . $product->getDescription() . '</p>';
        if ($symbol !== '€') {
            echo '<span class="price">' . $symbol . number_format($product->getPrice() * $convertion, 2) . '</span>';
        } else {
            echo '<span class="price">' . $product->getPrice() . '€</span>';
        }
        echo '<form action="/Akihabara-Dreams/carrito/add/' . $product->getId() . '" method="post">
                        <button type="submit" class="add-to-cart">Agregar al carrito</button>
                    </form>';
        echo '<form action="/Akihabara-Dreams/productos/info/' . $product->getId() . '" method="post">
                        <button type="submit" class="add-to-cart">Obtener más información</button>
                    </form>';
        echo '</div>
                </div>
            </div>';
    }
} else {
    echo "<p>Ahora mismo no hay productos disponibles</p>";
}

