<?php
include '../app/includes/checkSession.php';
include '../app/includes/checkRole.php';
include '../app/includes/checkCurrency.php';
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos - Akihabara Dreams</title>
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/normalize.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/language-switcher.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/body.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/navbar.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/admin.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/adminTablas.css">
</head>

<body>
    <?php include '../resources/commons/navbar.php'; ?>
    
    <div class="admin-container">
        <!-- Sidebar de administración -->
        <?php include '../resources/commons/admin-sidebar.php'; ?>

        <!-- Contenido principal -->
        <div class="admin-content">
            <div class="admin-header">
                <h1><?php echo __('admin_order_management')?></h1>
                <p><?php echo __('admin_shop_orders')?></p>
            </div>

            <div class="admin-orders-container" id="orders-container">
                <?php
                // Añadir código de depuración para verificar si hay pedidos
                if (!isset($orders) || empty($orders)) {
                    echo '<div style="padding: 1rem; text-align: center; grid-column: 1 / -1;">No hay pedidos para mostrar o la variable $orders no está definida.</div>';
                }
                include '../app/includes/generateOrders.php';
                ?>
            </div>
        </div>
    </div>

    <script src="../../resources/js/admin-orders.js"></script>
    

</body>
</html>