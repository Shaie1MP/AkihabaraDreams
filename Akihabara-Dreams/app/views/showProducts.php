<?php
include '../app/includes/checkSession.php';
include '../app/includes/checkRole.php';
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos - Akihabara Dreams</title>
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
                <h1><?php echo __('admin_product_management')?></h1>
                <p><?php echo __('admin_shop_products')?></p>
            </div>

            <div class="admin-create-button">
                <a href="/Akihabara-Dreams/products/crear" class="admin-btn admin-btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus" style="margin-right: 0.5rem;">
                        <path d="M5 12h14"></path>
                        <path d="M12 5v14"></path>
                    </svg>
                    <?php echo __('admin_add_product')?>
                </a>
            </div>

            <div class="admin-table-container">
                <div class="admin-table-header">
                    <h2 class="admin-table-title"><?php echo __('admin_products_list')?></h2>
                </div>
                <?php
                include '../app/includes/generateProducts.php';
                ?>
            </div>
        </div>
    </div>

    <script src="/Akihabara-Dreams/resources/js/orderID.js"></script>
        

</body>

</html>