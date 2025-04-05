<div id="cartModal" class="cart-modal">
    <div class="cart-modal-content">
        <span class="close">×</span>
        <h2>Carrito de Compras</h2>
        <div id="cartItemsContainer" class="cart-items-container">

            <?php
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
            ?>

        </div>
        <div class="cart-footer">
            <a href="/Akihabara-Dreams/carrito/vaciar"><button class="cart-button">Vaciar Carrito</button></a>
            <a href="/Akihabara-Dreams/carrito/guardar"><button class="cart-button">Guardar Carrito</button></a>
            <a href="/Akihabara-Dreams/pedidos/realizar"><button class="cart-button">Realizar Pedido</button></a>
        </div>
    </div>
</div>

