<?php
include '../app/includes/checkSession.php';
include '../app/includes/checkRole.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Promoción - Akihabara Dreams</title>
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
                <h1><?php echo __('admin_edit_promotion')?></h1>
                <p><?php echo __('admin_modify_promotion')?></p>
            </div>

            <div class="admin-form-container">
                <form action="/Akihabara-Dreams/promotions/update" method="post" class="admin-form">
                    <input type="hidden" name="id" value="<?= $promotion->getId() ?>">
                    
                    <div class="admin-form-group">
                        <label for="code"><?php echo __('admin_promotion_code_form')?>:</label>
                        <input type="text" id="code" name="code" required value="<?= htmlspecialchars($promotion->getCode()) ?>">
                    </div>
                    
                    <div class="admin-form-group">
                        <label for="discount"><?php echo __('admin_promotion_discount_form')?>:</label>
                        <input type="number" id="discount" name="discount" min="1" max="100" required value="<?= $promotion->getDiscount() ?>">
                    </div>
                    
                    <div class="admin-form-group">
                        <label for="description"><?php echo __('admin_promotion_description_form')?>:</label>
                        <input type="text" id="description" name="description" required value="<?= htmlspecialchars($promotion->getDescription()) ?>">
                    </div>
                    
                    <div class="admin-form-group">
                        <label for="start_date"><?php echo __('admin_promotion_start_date')?>:</label>
                        <input type="date" id="start_date" name="start_date" required value="<?= $promotion->getStartDate() ?>">
                    </div>
                    
                    <div class="admin-form-group">
                        <label for="end_date"><?php echo __('admin_promotion_end_date')?>:</label>
                        <input type="date" id="end_date" name="end_date" required value="<?= $promotion->getEndDate() ?>">
                    </div>
                    
                    <div class="admin-form-actions">
                        <button type="submit" class="admin-btn admin-btn-primary"><?php echo __('admin_update_promotion')?></button>
                        <a href="/Akihabara-Dreams/promotions" class="admin-btn admin-btn-secondary"><?php echo __('admin_cancel_promotion')?></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>