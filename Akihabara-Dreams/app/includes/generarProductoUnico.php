<div class="product-container">
    <!-- Sección de imágenes -->
    <div class="product-images">
        <div class="main-image">
            <img src="/Akihabara-Dreams/resources/images/productos/portadas/<?php echo $product->getPhoto(); ?>" 
                 alt="<?php echo $product->getName(); ?>" class="game-image">
        </div>
        
        <?php if (!empty($product->getAdditionalPhotos())): ?>
        <div class="image-thumbnails">
            <div class="thumbnail active">
                <img src="/Akihabara-Dreams/resources/images/productos/portadas/<?php echo $product->getPhoto(); ?>" 
                     alt="<?php echo $product->getName(); ?>">
            </div>
            <?php foreach ($product->getAdditionalPhotos() as $index => $item): ?>
                <div class="thumbnail">
                    <img src="/Akihabara-Dreams/resources/images/productos/adicional/<?php echo strtolower($item); ?>" 
                         alt="<?php echo $product->getName(); ?> - Imagen <?php echo $index + 1; ?>">
                </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
    
    <!-- Sección de detalles -->
    <div class="product-details">
        <h1 class="product-title"><?php echo $product->getName(); ?></h1>
        
        <div class="product-price">
            <span class="current-price"><?php echo number_format($product->getPrice(), 2); ?>€</span>
        </div>
        
        <div class="tax-info">
            Impuestos incluidos. Los <a href="#">gastos de envío</a> se calculan en la pantalla de pago.
        </div>
        
        <div class="stock-info">
            Estado: 
            <?php if ($product->getStock() > 10): ?>
                <span class="in-stock">En stock (<?php echo $product->getStock(); ?> disponibles)</span>
            <?php elseif ($product->getStock() > 0): ?>
                <span class="low-stock">¡Quedan pocos! (<?php echo $product->getStock(); ?> disponibles)</span>
            <?php else: ?>
                <span class="out-of-stock">Agotado</span>
            <?php endif; ?>
        </div>
        
        <div class="quantity-label">Cantidad</div>
        <div class="quantity-selector">
            <button class="quantity-decrease">−</button>
            <input type="text" value="1" min="1" id="product-quantity">
            <button class="quantity-increase">+</button>
        </div>
        
        <button class="add-to-cart" data-product-id="<?php echo $product->getId(); ?>">
            Agregar al carrito
        </button>
        
        <button class="shop-pay-button" data-product-id="<?php echo $product->getId(); ?>">
            Comprar ahora
        </button>
        
        <div class="more-payment-options">
            <a href="#">Más opciones de pago</a>
        </div>
        
        <div class="product-meta">
            <h2><?php echo $product->getName(); ?></h2>
            
            <div class="meta-item">
                <div class="meta-item-label">Categoría:</div>
                <div class="meta-item-value"><?php echo $product->getCategory(); ?></div>
            </div>
        </div>
        
        <section class="description">
            <p><?php echo $product->getDescription(); ?></p>
        </section>
    </div>
</div>

<!-- Modal del carrito -->
<div id="cartModal" class="cart-modal">
    <div class="cart-modal-content">
        <span class="close">×</span>
        <h2>Carrito de Compras</h2>
        <div id="cartItemsContainer" class="cart-items-container">
            <?php
            if (isset($_SESSION['carrito'])) {
                $cart = unserialize($_SESSION['carrito']);

                if (!empty($cart->getCart())) {
                    foreach ($cart->getCart() as $item) {
                        if (isset($item['product']) && is_object($item['product'])) {
                            echo '<div class="cart-item">';
                            echo '<img src="/Akihabara-Dreams/resources/images/productos/portadas/' . htmlspecialchars($item['product']->getMainPhoto()) . '" alt="Imagen del producto">';
                            echo '<div class="cart-item-details">';
                            echo '<span>' . htmlspecialchars($item['product']->getProductName()) . ' x' . $item['quantity'] . '</span> ';

                            if (isset($symbol)) {
                                if ($symbol === '€') {
                                    echo ' <span class="cart-item-price">' . number_format($item['product']->getPrice(), 2) . '€</span>';
                                } else {
                                    echo '<span class="cart-item-price">' . $symbol . number_format($item['product']->getPrice() * $convertion, 2) . '</span>';
                                }
                            } else {
                                echo ' <span class="cart-item-price">' . number_format($item['product']->getPrice(), 2) . '€</span>';
                            }
                            
                            echo '</div>';
                            echo '<form action="/Akihabara-Dreams/carrito/eliminar/' . $item['product']->getProductId() . '" method="post">
                            <button class="remove-item" type="submit">Eliminar</button>
                            </form>';
                            echo '</div>';
                        }
                    }
                } else {
                    echo '<p>Tu carrito está vacío.</p>';
                }
            } else {
                echo '<p>Tu carrito está vacío.</p>';
            }
            ?>
        </div>
        <div class="cart-footer">
            <a href="/Akihabara-Dreams/carrito/vaciar"><button class="cart-button">Vaciar Carrito</button></a>
            <a href="/Akihabara-Dreams/carrito/guardar"><button class="cart-button">Guardar Carrito</button></a>
            <a href="/Akihabara-Dreams/pedidos/realizar"><button class="cart-button">Realizar Pedido</button></a>
        </div>
    </div>
</div>


