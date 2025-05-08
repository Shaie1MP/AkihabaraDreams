<?php
include '../app/includes/checkSession.php';
include '../app/includes/checkCurrency.php';
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Pedidos - Akihabara Dreams</title>
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/normalize.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/language-switcher.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/information.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/body.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/navbar.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/footer.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/pedidos.css">
</head>

<body>
<?php
include '../resources/commons/navbar.php';
?>

    <div class="container">
        <h1><?php echo __('order_title')?></h1>
        <div id="orders-container">
            <?php
            include '../app/includes/generateMyOrders.php';
            ?>
        </div>
    </div>
</body>

</html>