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

        <div class="product-detail-price">
            <?php if (method_exists($product, 'hasPromotion') && $product->hasPromotion()): ?>
                <div class="price-container">
                    <span class="precio-original"><?= number_format($product->getPrice(), 2) ?>€</span>
                    <span class="precio-descuento"><?= number_format($product->getDiscountedPrice(), 2) ?>€</span>
                    <span class="promocion-badge">-<?= $product->getDiscount() ?>%</span>
                </div>
            <?php else: ?>
                <div class="price-container">
                    <span class="product-price"><?= number_format($product->getPrice(), 2) ?>€</span>
                </div>
            <?php endif; ?>
        </div>

        <div class="tax-info">
            <?php echo __('tax-info'); ?>
        </div>

        <div class="stock-info">
            <?php echo __('product_status'); ?>:
            <?php if ($product->getStock() > 10): ?>
                <span class="in-stock"><?php echo __('product_status_in_stock'); ?> (<?php echo $product->getStock(); ?> <?php echo __('product_available'); ?>)</span>
            <?php elseif ($product->getStock() > 0): ?>
                <span class="low-stock"><?php echo __('product_status_low_stock'); ?> (<?php echo $product->getStock(); ?> <?php echo __('product_available'); ?>)</span>
            <?php else: ?>
                <span class="out-of-stock"><?php echo __('product_status_out_of_stock'); ?></span>
            <?php endif; ?>
        </div>

        <div class="quantity-label"><?php echo __('product_quantity'); ?>:</div>
        <div class="quantity-selector">
            <button class="quantity-decrease">−</button>
            <input type="text" value="1" min="1" id="product-quantity">
            <button class="quantity-increase">+</button>
        </div>

        <button class="add-to-cart" data-product-id="<?php echo $product->getId(); ?>">
            <?php echo __('product_add'); ?>
        </button>

        <button class="shop-pay-button" data-product-id="<?php echo $product->getId(); ?>">
            <?php echo __('product_buy_now'); ?>
        </button>

        <?php include '../app/includes/wishlist-button.php'; ?>

        <div class="more-payment-options">
            <a href="#"><?php echo __('product_more_payment'); ?></a>
        </div>

        <div class="product-meta">
            <h2><?php echo $product->getName(); ?></h2>

            <div class="meta-item">
                <div class="meta-item-label"><?php echo __('product_category'); ?>:</div>
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
        <h2><?php echo __('cart_title'); ?></h2>
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
                            echo '<form action="/Akihabara-Dreams/cart/eliminar/' . $item['product']->getProductId() . '" method="post">
                            <button class="remove-item" type="submit">' . __('cart_remove') . '</button>
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
            <a href="/Akihabara-Dreams/cart/vaciar"><button class="cart-button"><?php echo __('cart_empty'); ?></button></a>
            <a href="/Akihabara-Dreams/cart/guardar"><button class="cart-button"><?php echo __('cart_save'); ?></button></a>
            <a href="/Akihabara-Dreams/orders/realizar"><button class="cart-button"><?php echo __('order_realize'); ?></button></a>
        </div>
    </div>
</div>