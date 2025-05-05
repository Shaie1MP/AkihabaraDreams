<?php
include '../app/includes/comprobarSesion.php';
include '../app/includes/comprobarDivisa.php';
include '../app/includes/desencriptarcookies.php';

$cart = unserialize($_SESSION['carrito'])->getCart();
$addresses = unserialize($_SESSION['usuario'])->getAddresses();
$countNull = 0;

foreach ($addresses as $item) {
    if (!$item) {
        $countNull++;
    }
}

if ($countNull >= 3) {
    throw new Exception('No tienes direcciones ahora mismo.');
}

if (isset($_COOKIE['tarjeta'])) {
    $cookie = unserialize($_COOKIE['tarjeta']);
    $number = decrypt($cookie['number']);
    $date = decrypt($cookie['date']);
    $cvc = decrypt($cookie['cvc']);
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar Compra - Akihabara Dreams</title>
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/normalize.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/body.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/navbar.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/checkout.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/language-switcher.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        function openModal() {
            document.querySelector('.modal-overlay').style.display = 'flex';
        }

        function closeModal() {
            event.preventDefault();
            document.querySelector('.modal-overlay').style.display = 'none';
        }
    </script>
    <script src="/Akihabara-Dreams/resources/js/validacion-tarjeta.js"></script>
</head>

<body>
    <?php
    include '../resources/commons/navbar.php';
    ?>

    <div class="checkout-container">
        <div class="checkout-header">
            <h1>Finalizar Compra</h1>
            <div class="checkout-steps">
                <div class="step active">
                    <div class="step-number">1</div>
                    <div class="step-text">Resumen</div>
                </div>
                <div class="step-line"></div>
                <div class="step">
                    <div class="step-number">2</div>
                    <div class="step-text">Pago</div>
                </div>
                <div class="step-line"></div>
                <div class="step">
                    <div class="step-number">3</div>
                    <div class="step-text">Confirmación</div>
                </div>
            </div>
        </div>

        <div class="checkout-content">
            <div class="order-summary">
                <h2>Resumen del Pedido</h2>

                <div class="cart-items">
                    <?php
                    $total = 0;

                    foreach ($cart as $item) {
                        $unityPrice = $item['product']->getPrice();
                        $totalItem = $unityPrice * $item['quantity'];
                        $total += $totalItem;

                        echo '<div class="cart-item">';
                        echo '<div class="item-image">';
                        echo '<img src="/Akihabara-Dreams/resources/images/productos/portadas/' . $item['product']->getMainPhoto() . '" alt="' . $item['product']->getProductName() . '">';
                        echo '</div>';
                        echo '<div class="item-details">';
                        echo '<h3>' . $item['product']->getProductName() . '</h3>';
                        echo '<div class="item-meta">';
                        echo '<div class="quantity-display">Cantidad: <span class="quantity-value">' . $item['quantity'] . '</span></div>';
                        echo '</div>';
                        echo '</div>';
                        echo '<div class="item-total">';

                        if ($symbol === '€') {
                            echo '<span>' . number_format($totalItem, 2) . '€</span>';
                        } else {
                            $totalConvertedItem = $totalItem * $convertion;
                            echo '<span>' . $symbol . number_format($totalConvertedItem, 2) . '</span>';
                        }

                        echo '</div>';
                        echo '</div>';
                    }
                    ?>
                </div>

                <div class="order-totals">
                    <div class="subtotal">
                        <span>Subtotal</span>
                        <span>
                            <?php
                            if ($symbol === '€') {
                                echo number_format($total, 2) . '€';
                            } else {
                                echo $symbol . number_format($total * $convertion, 2);
                            }
                            ?>
                        </span>
                    </div>
                    <div class="shipping">
                        <span>Gastos de envío</span>
                        <span>Gratis</span>
                    </div>
                    <div class="total">
                        <span>Total</span>
                        <span>
                            <?php
                            if ($symbol === '€') {
                                echo number_format($total, 2) . '€';
                            } else {
                                echo $symbol . number_format($total * $convertion, 2);
                            }
                            ?>
                        </span>
                    </div>
                </div>
            </div>

            <div class="shipping-info">
                <h2>Información de Envío</h2>

                <form id="order-form" action="/Akihabara-Dreams/pedidos/create" method="POST">
                    <div class="form-group">
                        <label for="shipping-address">
                            <i class="fas fa-shipping-fast"></i> Dirección de Envío
                        </label>
                        <select id="shipping-address" name="address">
                            <?php
                            foreach ($addresses as $address) {
                                if ($address !== null && $address !== '') {
                                    $selected = (isset($_COOKIE['defecto']) && $_COOKIE['defecto'] == $address) ? 'selected' : '';
                                    echo "<option value='$address' $selected>$address</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="billing-address">
                            <i class="fas fa-file-invoice"></i> Dirección de Facturación
                        </label>
                        <select id="billing-address" name="billing">
                            <?php
                            foreach ($addresses as $address) {
                                if ($address !== null && $address !== '') {
                                    $selected = (isset($_COOKIE['facturacion']) && $_COOKIE['facturacion'] == $address) ? 'selected' : '';
                                    echo "<option value='$address' $selected>$address</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <button type="button" class="btn-primary" onclick="openModal()">
                        <i class="fas fa-credit-card"></i> Proceder al Pago
                    </button>

                    <div class="modal-overlay" onclick="closeModal()">
                        <div class="modal-content" onclick="event.stopPropagation()">
                            <button class="close-modal" onclick="closeModal()">×</button>
                            <h3>Información de Pago</h3>

                            <div class="form-group">
                                <label for="card-number">
                                    <i class="far fa-credit-card"></i> Número de Tarjeta
                                </label>
                                <input type="text" id="card-number" name="card-number" placeholder="1234 5678 9012 3456"
                                    maxlength="19" required value="<?php echo isset($number) ? htmlspecialchars($number) : '' ?>">
                            </div>

                            <div class="payment-row">
                                <div class="form-group">
                                    <label for="card-expiration">
                                        <i class="far fa-calendar-alt"></i> Fecha de Expiración
                                    </label>
                                    <input type="text" id="card-expiration" name="card-expiration" placeholder="MM/AA"
                                        maxlength="5" required value="<?php echo isset($date) ? htmlspecialchars($date) : '' ?>">
                                </div>

                                <div class="form-group">
                                    <label for="card-cvc">
                                        <i class="fas fa-lock"></i> CVC
                                    </label>
                                    <input type="text" id="card-cvc" name="card-cvc" placeholder="123"
                                        maxlength="4" required value="<?php echo isset($cvc) ? htmlspecialchars($cvc) : '' ?>">
                                </div>
                            </div>

                            <div class="form-group checkbox-group">
                                <input type="checkbox" id="save-card" name="card-information">
                                <label for="save-card">Guardar información de la tarjeta</label>
                            </div>

                            <button type="submit" class="btn-primary">
                                <i class="fas fa-lock"></i> Pagar Ahora
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>