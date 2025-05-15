<?php
include '../app/includes/checkSession.php';
include '../app/includes/checkRole.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Producto a Promoción - Akihabara Dreams</title>
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/normalize.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/language-switcher.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/body.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/navbar.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/admin.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/adminTablas.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/promociones.css">
</head>

<body>
    <?php include '../resources/commons/navbar.php'; ?>
    
    <div class="admin-container">
        <!-- Sidebar de administración -->
        <?php include '../resources/commons/admin-sidebar.php'; ?>


        <!-- Contenido principal -->
        <div class="admin-content">
            <div class="admin-header">
                <h1><?php echo __('admin_add_product_to_promotion')?></h1>
                <?php if (isset($promotion)): ?>
                <p><?php echo __('admin_promotion_new_user_discount')?></p>
                <?php else: ?>
                <p><?php echo __('admin_error_no_promotion')?></p>
                <?php endif; ?>
            </div>

            <?php if (isset($promotion) && isset($availableProducts) && count($availableProducts) > 0): ?>
            <div class="admin-form-container">
                <form action="/Akihabara-Dreams/promotions/productos/agregar" method="post" class="admin-form">
                    <input type="hidden" name="promotion_id" value="<?= $promotion->getId() ?>">
                    
                    <div class="admin-form-group">
                        <label for="product_id"><?php echo __('admin_select_product')?>:</label>
                        <select id="product_id" name="product_id" required class="admin-select">
                            <option value=""><?php echo __('admin_select_product_placeholder')?></option>
                            <?php foreach ($availableProducts as $product): ?>
                                <option value="<?= $product->getId() ?>"><?= htmlspecialchars($product->getName()) ?> - <?= number_format($product->getPrice(), 2) ?> €</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="admin-form-actions">
                        <button type="submit" class="admin-btn admin-btn-primary"><?php echo __('admin_add_promotion')?></button>
                        <a href="/Akihabara-Dreams/promotions/productos/<?= $promotion->getId() ?>" class="admin-btn admin-btn-secondary"><?php echo __('admin_cancel_promotion')?></a>
                    </div>
                </form>
            </div>
            <?php elseif (isset($promotion) && isset($availableProducts) && count($availableProducts) === 0): ?>
            <div class="admin-message">
                <p><?php echo __('admin_no_products_available')?></p>
                <a href="/Akihabara-Dreams/promotions/productos/<?= $promotion->getId() ?>" class="admin-btn admin-btn-secondary">Volver</a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>