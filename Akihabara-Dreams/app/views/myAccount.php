<?php

include '../app/includes/checkSession.php';
include '../app/includes/checkCurrency.php';
$userSession = unserialize($_SESSION['usuario']);

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $userSession->getUsername(); ?></title>
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/normalize.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/language-switcher.css">
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
            <h1><?php echo __('account_info')?></h1>
            <div class="avatar">
                <img src="/Akihabara-Dreams/resources/images/usuarios/<?php echo $userSession->getProfilePic() ?>"
                    alt="Avatar del usuario">
            </div>
        </div>
        <div class="content">
            <div class="user-info">
                <div class="details">
                    <div class="detail-item">
                        <p><strong><?php echo __('account_name')?>:</strong></p>
                        <p><?php echo $userSession->getName(); ?></p>
                        <br>
                    </div>
                    <div class="detail-item">
                        <p><strong><?php echo __('account_username')?>:</strong></p>
                        <p><?php echo $userSession->getUserName(); ?></p>
                        <br>
                    </div>
                    <div class="detail-item">
                        <p><strong><?php echo __('account_email')?>:</strong></p>
                        <p><?php echo $userSession->getEmail(); ?></p>
                    </div>
                </div>
            </div>

            <div class="addresses">
                <h2><?php echo __('account_addresses')?></h2>
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
                    <p><?php echo __('account_no_addresses')?>.</p>
                <?php else: ?>
                    <?php foreach ($addresses as $index => $address): ?>
                        <?php if ($address !== null&& $address !== ''): ?>
                            <div class="address">
                                <p><?php echo __('account_address')?> <?php echo $index + 1; ?></p>
                                <address><?php echo htmlspecialchars($address); ?></address>
                                <div class="addressAction">
                                    <form action="/Akihabara-Dreams/cookies/defecto" method="post">
                                        <input type="hidden" name="address"
                                            value="<?php echo htmlspecialchars($address); ?>">
                                        <button type="submit"><?php echo __('account_default_address')?></button>
                                    </form>

                                    <form action="/Akihabara-Dreams/cookies/facturacion" method="post">
                                        <input type="hidden" name="address"
                                            value="<?php echo htmlspecialchars($address); ?>">
                                        <button type="submit"><?php echo __('account_billing_address')?></button>
                                    </form>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>

            </div>
            <div class="preferences">
                <h2><?php echo __('account_preferences')?></h2>
                <form class="currency-form" action="/Akihabara-Dreams/cookies/divisa" method="post">
                    <div class="currency-selector">
                        <label for="currency"><?php echo __('account_currency')?>:</label>
                        <select id="currency" name="currency">
                            <option value="eur" <?php echo ($currency === 'eur') ? 'selected' : ''; ?>><?php echo __('account_eur')?></option>
                            <option value="usd" <?php echo ($currency === 'usd') ? 'selected' : ''; ?>><?php echo __('account_usd')?></option>
                            <option value="gbp" <?php echo ($currency === 'gbp') ? 'selected' : ''; ?>><?php echo __('account_gbp')?></option>
                        </select>
                        <button type="submit"><?php echo __('account_save_changes')?></button>
                    </div>
                </form>
            </div>
        </div>

        <div class="actions">
            <a href="/Akihabara-Dreams/logout"><button><?php echo __('account_close_session')?></button></a>
            <a href="/Akihabara-Dreams/myaccount/actualizar"><button><?php echo __('account_edit_profile')?></button></a>
            <a href="/Akihabara-Dreams/orders/mispedidos"><button><?php echo __('account_view_orders')?></button></a>
            <a href="/Akihabara-Dreams/myaccount/borrar"><button><?php echo __('delete_account')?></button></a>
        </div>
    </div>

    <?php include '../resources/commons/footer.php'; ?>
        
</body>

</html>