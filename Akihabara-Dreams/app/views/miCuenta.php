<?php

include '../app/includes/comprobarSesion.php';
include '../app/includes/comprobarDivisa.php';
$userSession = unserialize($_SESSION['usuario']);

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $userSession->getUsername(); ?></title>
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/normalize.css">

    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/body.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/cart.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/navbar.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/footer.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/information.css">
</head>

<body>

    <?php include '../resources/commons/navbar.php'; ?>

    <div class="container">
        <div class="header">
            <h1>Información de la cuenta</h1>
            <div class="avatar">
                <img src="/Akihabara-Dreams/resources/images/usuarios/<?php echo $userSession->getProfilePic() ?>"
                    alt="Avatar del usuario">
            </div>
        </div>
        <div class="content">
            <div class="user-info">
                <div class="details">
                    <div class="detail-item">
                        <p><strong>Nombre:</strong></p>
                        <p><?php echo $userSession->getName(); ?></p>
                        <br>
                    </div>
                    <div class="detail-item">
                        <p><strong>Nombre de Usuario:</strong></p>
                        <p><?php echo $userSession->getUserName(); ?></p>
                        <br>
                    </div>
                    <div class="detail-item">
                        <p><strong>Correo:</strong></p>
                        <p><?php echo $userSession->getEmail(); ?></p>
                    </div>
                </div>
            </div>

            <div class="addresses">
                <h2>Direcciones</h2>
                <?php
                $addresses = $userSession->getAddresses();
                $foundedAddress = false;
                
                foreach ($addresses as $address) {
                    if ($address !== null) {
                        $foundedAddress = true;
                        break;
                    }
                }

                if (!$foundedAddress): ?>
                    <p>No tienes direcciones ahora mismo.</p>
                <?php else: ?>
                    <?php foreach ($addresses as $index => $address): ?>
                        <?php if ($address !== null&& $address !== ''): ?>
                            <div class="address">
                                <p>Dirección <?php echo $index + 1; ?></p>
                                <address><?php echo htmlspecialchars($address); ?></address>
                                <div class="addressAction">
                                    <form action="/Akihabara-Dreams/cookies/defecto" method="post">
                                        <input type="hidden" name="address"
                                            value="<?php echo htmlspecialchars($address); ?>">
                                        <button type="submit">Dirección por defecto</button>
                                    </form>

                                    <form action="/Akihabara-Dreams/cookies/facturacion" method="post">
                                        <input type="hidden" name="address"
                                            value="<?php echo htmlspecialchars($address); ?>">
                                        <button type="submit">Dirección de facturación</button>
                                    </form>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>

            </div>
            <div class="preferences">
                <h2>Preferencias</h2>
                <form class="currency-form" action="/Akihabara-Dreams/cookies/divisa" method="post">
                    <div class="currency-selector">
                        <label for="currency">Elige tu divisa:</label>
                        <select id="currency" name="currency">
                            <option value="eur" <?php echo ($currency === 'eur') ? 'selected' : ''; ?>>EUR - Euro</option>
                            <option value="usd" <?php echo ($currency === 'usd') ? 'selected' : ''; ?>>USD - Dólar estadounidense</option>
                            <option value="gbp" <?php echo ($currency === 'gbp') ? 'selected' : ''; ?>>GBP - Libra esterlina</option>
                        </select>
                        <button type="submit">Guardar Preferencias</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="actions">
            <a href="/Akihabara-Dreams/logout"><button>Cerrar Sesión</button></a>
            <a href="/Akihabara-Dreams/micuenta/actualizar"><button>Editar Datos</button></a>
            <a href="/Akihabara-Dreams/pedidos/mispedidos"><button>Ver Mis Pedidos</button></a>
            <a href="/Akihabara-Dreams/micuenta/borrar"><button>Borrar Cuenta</button></a>
        </div>
    </div>

    <?php include '../resources/commons/footer.php'; ?>
</body>

</html>