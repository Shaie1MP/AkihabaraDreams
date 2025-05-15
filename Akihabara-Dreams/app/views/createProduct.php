<?php
include '../app/includes/checkSession.php';
include '../app/includes/checkRole.php';
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Producto - Akihabara Dreams</title>
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
                <h1><?php echo __('admin_create_product')?></h1>
                <p><?php echo __('admin_add_new_product')?></p>
            </div>

            <div class="admin-form-container">
                <form action="/Akihabara-Dreams/products/create" method="post" enctype="multipart/form-data" class="admin-form">
                    <div class="admin-form-group">
                        <label for="name"><?php echo __('admin_product_name_form')?>:</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="admin-form-group">
                        <label for="description"><?php echo __('admin_product_description_form')?>:</label>
                        <input type="text" id="description" name="description" required>
                    </div>
                    <div class="admin-form-group">
                        <label for="category"><?php echo __('admin_product_category_form')?>:</label>
                        <textarea id="category" name="category" rows="5" required></textarea>
                    </div>
                    <div class="admin-form-group">
                        <label for="stock"><?php echo __('admin_product_stock_form')?>:</label>
                        <input type="number" id="stock" name="stock" required>
                    </div>
                    <div class="admin-form-group">
                        <label for="price"><?php echo __('admin_product_price_form')?>:</label>
                        <input type="number" id="price" name="price" step="0.01" min="0" required>
                    </div>
                    <div class="admin-form-group">
                        <label for="photo"><?php echo __('admin_product_photo_form')?>:</label>
                        <input type="file" id="photo" name="photo" accept="image/*" required>
                    </div>
                    <div class="admin-form-group">
                        <label for="additionalPhotos"><?php echo __('admin_product_additional_photos_form')?>:</label>
                        <input type="file" id="additionalPhotos" name="additionalPhotos[]" accept="image/*" multiple>
                    </div>
                    <button type="submit" class="admin-btn admin-btn-primary"><?php echo __('admin_save_product')?></button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>