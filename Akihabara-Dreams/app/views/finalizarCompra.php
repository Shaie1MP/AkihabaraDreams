<?php
include '../app/includes/comprobarSesion.php';
include '../app/includes/comprobarDivisa.php';
include '../app/includes/desencriptarcookies.php';

$cart = unserialize($_SESSION['carrito'])->getCart();
$addresses = unserialize($_SESSION['usuario'])->getAddresses();
$countNull=0;

foreach($addresses as $item){
    if(!$item){
        $countNull++;
    }
}

if($countNull >= 3){
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
    <title>Procesar Pedido</title>
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/normalize.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/body.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/navbar.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/adminTablas.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/shopping.css">
    <script>
        function openModal() {
            document.querySelector('.modal-overlay').style.display = 'flex';
        }

        function closeModal() {
            event.preventDefault();
            document.querySelector('.modal-overlay').style.display = 'none';
        }
    </script>
</head>

<body>
    <?php
    include '../resources/commons/navbar.php';
    ?>
    <div class="container">
        <h1>Resumen del Pedido</h1>
        <table class="order-table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio por Unidad</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;

                foreach ($cart as $item) {
                    $unityPrice = $item['product']->getPrice();
                    $totalItem = $unityPrice * $item['quantity'];
                    $total += $totalItem;

                    echo "<tr>";
                    echo "<td><ul><li>" . $item['product']->getProductName() . "</li></ul></td>";
                    echo "<td>" . $item['quantity'] . "</td>";

                    if ($symbol === '€') {
                        echo '<td class="cart-item-price">' . number_format($unityPrice, 2) . '€</td>';
                        echo '<td class="cart-item-price">' . number_format($totalItem, 2) . '€</td>';
                    } else {
                        $convertedPrice = $unityPrice * $convertion;
                        $totalConvertedItem = $totalItem * $convertion;
                        echo '<td class="cart-item-price">' . $symbol . number_format($convertedPrice, 2) . '</td>';
                        echo '<td class="cart-item-price">' . $symbol . number_format($totalConvertedItem, 2) . '</td>';
                    }

                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <div class="total-bar">
            <span>Total a Pagar:</span>
            <span class="total-price">
                <?php
                if ($symbol === '€') {
                    echo number_format($total, 2) . '€';
                } else {
                    echo $symbol . number_format($total * $convertion, 2);
                }
                ?>
            </span>
        </div>

        <form id="order-form" action="/Akihabara-Dreams/pedidos/create" method="POST">
            <div class="address-section">
                <div class="pepito">
                    <label for="shipping-address">Dirección de Envío:</label>
                    <select id="shipping-address" name="address">
                        <?php
                        foreach ($addresses as $address) {
                            if ($address !== null && $address !== '') {
                                $selected = ($_COOKIE['defecto'] == $address) ? 'selected' : '';
                                echo "<option value='$address' $selected>$address</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="pepito">
                    <label for="billing-address">Dirección de Facturación:</label>
                    <select id="billing-address" name="billing">
                        <?php
                        foreach ($addresses as $address) {
                            if ($address !== null&& $address !== '') {
                                $selected = ($_COOKIE['facturacion'] == $address) ? 'selected' : '';
                                echo "<option value='$address' $selected>$address</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <button type="button" class="btn-accept" onclick="openModal()">Aceptar y Proceder al Pago</button>

                <div class="modal-overlay" onclick="closeModal()">
                    <div class="modal-content" onclick="event.stopPropagation()">
                        <button class="close-modal" onclick="closeModal()">×</button>
                        <label for="card-number">Número de Tarjeta:</label>
                        <input type="text" id="card-number" name="card-number" placeholder="1234 5678 9012 3456"
                            required
                            value="<?php echo isset($number) ? htmlspecialchars($number) : '' ?>">

                        <label for="card-expiration">Fecha de Expiración:</label>
                        <input type="text" id="card-expiration" name="card-expiration" placeholder="MM/AA" required
                            value="<?php echo isset($date) ? htmlspecialchars($date) : '' ?>">

                        <label for="card-cvc">CVC:</label>
                        <input type="text" id="card-cvc" name="card-cvc" placeholder="123" required
                            value="<?php echo isset($cvc) ? htmlspecialchars($cvc) : '' ?>">

                        <p class="checkbox"><input type="checkbox" name="card-information">Guardar información de la
                            tarjeta</p>
                        <button type="submit" class="btn-accept">Pagar</button>
                    </div>
                </div>

            </div>
        </form>
    </div>
</body>

</html>