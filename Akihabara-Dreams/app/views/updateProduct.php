<?php
include '../app/includes/checkSession.php';
include '../app/includes/checkRole.php';
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Producto - Akihabara Dreams</title>
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
                <h1><?php echo __('admin_update_product')?></h1>
                <p><?php echo __('admin_modify_product')?></p>
            </div>

            <div class="admin-form-container">
                <?php include '../app/includes/generateFormUpdateProduct.php';?>
            </div>
        </div>
    </div>
        

</body>

</html>