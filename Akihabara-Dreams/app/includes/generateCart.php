<div id="cartModal" class="cart-modal">
    <div class="cart-modal-content">
        <span class="close">×</span>
        <h2>Carrito de Compras</h2>
        <div id="cartItemsContainer" class="cart-items-container">

            <?php
            $cart = unserialize($_SESSION['carrito']);

            if (!empty($cart->getCart())) {
                $total = 0;
                
                foreach ($cart->getCart() as $item) {
                    if (isset($item['product']) && is_object($item['product'])) {
                        $itemPrice = $item['product']->getPrice();
                        $itemTotal = $itemPrice * $item['quantity'];
                        $total += $itemTotal;
                        $productId = $item['product']->getProductId();
                        
                        echo '<div class="cart-item" data-id="' . $productId . '">';
                        echo '<img src="/Akihabara-Dreams/resources/images/productos/portadas/' . htmlspecialchars($item['product']->getMainPhoto()) . '" alt="Imagen del producto">';
                        echo '<div class="cart-item-details">';
                        echo '<span>' . htmlspecialchars($item['product']->getProductName()) . ' x' . $item['quantity'] . '</span> ';

                        // Verificar si hay un precio con descuento
                        $productsRepository = new ProductsRepository($GLOBALS['connection']);
                        $fullProduct = $productsRepository->searchProduct($productId);
                        
                        if ($fullProduct->hasPromotion()) {
                            if (isset($symbol)) {
                                if ($symbol === '€') {
                                    echo '<div class="cart-item-price">';
                                    echo '<span class="precio-original">' . number_format($fullProduct->getPrice(), 2) . '€</span>';
                                    echo '<span class="precio-descuento">' . number_format($itemPrice, 2) . '€</span>';
                                    echo '<span class="promocion-badge">' . $fullProduct->getDiscount() . '% OFF</span>';
                                    echo '</div>';
                                } else {
                                    echo '<div class="cart-item-price">';
                                    echo '<span class="precio-original">' . $symbol . number_format($fullProduct->getPrice() * $convertion, 2) . '</span>';
                                    echo '<span class="precio-descuento">' . $symbol . number_format($itemPrice * $convertion, 2) . '</span>';
                                    echo '<span class="promocion-badge">' . $fullProduct->getDiscount() . '% OFF</span>';
                                    echo '</div>';
                                }
                            } else {
                                echo '<div class="cart-item-price">';
                                echo '<span class="precio-original">' . number_format($fullProduct->getPrice(), 2) . '€</span>';
                                echo '<span class="precio-descuento">' . number_format($itemPrice, 2) . '€</span>';
                                echo '<span class="promocion-badge">-' . $fullProduct->getDiscount() . '%</span>';
                                echo '</div>';
                            }
                        } else {
                            if (isset($symbol)) {
                                if ($symbol === '€') {
                                    echo ' <span class="cart-item-price">' . number_format($itemPrice, 2) . '€</span>';
                                } else {
                                    echo '<span class="cart-item-price">' . $symbol . number_format($itemPrice * $convertion, 2) . '</span>';
                                }
                            } else {
                                echo ' <span class="cart-item-price">' . number_format($itemPrice, 2) . '€</span>';
                            }
                        }
                        
                        echo '</div>';
                        echo '<button class="remove-item" data-id="' . $productId . '">Eliminar</button>';
                        echo '</div>';
                    }
                }
                
                // Mostrar el total
                echo '<div class="cart-total">';
                echo '<span>Total:</span>';
                if (isset($symbol)) {
                    if ($symbol === '€') {
                        echo '<span>' . number_format($total, 2) . '€</span>';
                    } else {
                        echo '<span>' . $symbol . number_format($total * $convertion, 2) . '</span>';
                    }
                } else {
                    echo '<span>' . number_format($total, 2) . '€</span>';
                }
                echo '</div>';
                
            } else {
                echo '<p>Tu carrito está vacío.</p>';
            }
            ?>

        </div>
        <div class="cart-footer">
            <a href="/Akihabara-Dreams/cart/vaciar"><button class="cart-button">Vaciar Carrito</button></a>
            <a href="/Akihabara-Dreams/cart/guardar"><button class="cart-button">Guardar Carrito</button></a>
            <a href="/Akihabara-Dreams/orders/realizar"><button class="cart-button">Realizar Pedido</button></a>
        </div>
    </div>
</div>
