<?php
include '../app/includes/checkSession.php';
include '../app/includes/checkRole.php';
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Usuario - Akihabara Dreams</title>
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
                <h1><?php echo __('admin_create_user'); ?></h1>
                <p><?php echo __('admin_add_new_user'); ?></p>
            </div>

            <div class="admin-form-container">
                <form action="/Akihabara-Dreams/users/create" method="post" enctype="multipart/form-data" class="admin-form">
                    <div class="admin-form-section">
                        <h2 class="admin-form-section-title"><?php echo __('admin_obligatory_info'); ?></h2>
                        <div class="admin-form-group">
                            <label for="name"><?php echo __('admin_user_name_form'); ?>:</label>
                            <input type="text" id="name" name="name" required>
                        </div>
                        <div class="admin-form-group">
                            <label for="username"><?php echo __('admin_user_username_form'); ?>:</label>
                            <input type="text" id="username" name="username" required>
                        </div>
                        <div class="admin-form-group">
                            <label for="email"><?php echo __('admin_user_email_form'); ?>:</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="admin-form-group">
                            <label for="password"><?php echo __('admin_user_password_form'); ?>:</label>
                            <input type="password" id="password" name="password" required>
                        </div>
                        <div class="admin-form-group">
                            <label for="confirm_password"><?php echo __('admin_user_confirm_password_form'); ?>:</label>
                            <input type="password" id="confirm_password" name="confirm_password" required>
                        </div>
                        <div class="admin-form-group">
                            <label for="address"><?php echo __('admin_user_address_form'); ?>:</label>
                            <textarea id="address" name="address" required></textarea>
                        </div>
                    </div>

                    <div class="admin-form-section">
                        <h2 class="admin-form-section-title"><?php echo __('admin_optional_info'); ?></h2>
                        <div class="admin-form-group">
                            <label for="address2"><?php echo __('admin_user_additional_address1_form'); ?>:</label>
                            <textarea id="address2" name="address2"></textarea>
                        </div>
                        <div class="admin-form-group">
                            <label for="address3"><?php echo __('admin_user_additional_address2_form'); ?>:</label>
                            <textarea id="address3" name="address3"></textarea>
                        </div>
                        <div class="admin-form-group">
                            <label for="phone"><?php echo __('admin_user_phone_form'); ?>:</label>
                            <input type="tel" id="phone" name="phone">
                        </div>
                        <div class="admin-form-group">
                            <label for="profilePic"><?php echo __('admin_user_profile_pic_form'); ?>:</label>
                            <input type="file" id="profilePic" name="profilePic" accept="image/*">
                        </div>
                        <div class="admin-form-group">
                            <label for="role"><?php echo __('admin_user_role_form'); ?></label>
                            <select name="role" id="role">
                                <option value="usuario"><?php echo __('admin_user_role_user'); ?></option>
                                <option value="admin"><?php echo __('admin_user_role_admin'); ?></option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="admin-btn admin-btn-primary"><?php echo __('admin_register_user'); ?></button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>