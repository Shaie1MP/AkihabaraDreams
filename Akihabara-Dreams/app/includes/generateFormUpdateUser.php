<?php
$userToUpdate = isset($userToUpdate) ? $userToUpdate : $user;
?>

<form action="/Akihabara-Dreams/users/update" method="post" enctype="multipart/form-data" class="admin-form">
<div class="admin-form-section">
    <h2 class="admin-form-section-title"><?php echo __('admin_obligatory_info'); ?></h2>
    <div class="admin-form-group">
        <label for="name"><?php echo __('admin_user_name_form'); ?>:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($userToUpdate->getName()); ?>" required>
    </div>
    <div class="admin-form-group">
        <label for="username"><?php echo __('admin_user_username_form'); ?>:</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($userToUpdate->getUserName()); ?>" required>
    </div>
    <div class="admin-form-group">
        <label for="email"><?php echo __('admin_user_email_form'); ?>:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($userToUpdate->getEmail()); ?>" required>
    </div>
    <div class="admin-form-group">
        <label for="password"><?php echo __('admin_user_password_form'); ?>:</label>
        <input type="password" id="password" name="password" required>
        <small><?php echo __('admin_user_new_password'); ?></small>
    </div>
    <div class="admin-form-group">
        <label for="confirm_password"><?php echo __('admin_user_confirm_password_form'); ?>:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>
    </div>
    <div class="admin-form-group">
        <label for="address"><?php echo __('admin_user_address_form'); ?>:</label>
        <textarea id="address" name="address" required><?php echo htmlspecialchars($userToUpdate->getAddress1() ?? ''); ?></textarea>
    </div>
</div>

<div class="admin-form-section">
    <h2 class="admin-form-section-title"><?php echo __('admin_obligatory_info'); ?></h2>
    <div class="admin-form-group">
        <label for="address2"><?php echo __('admin_user_additional_address1_form'); ?>:</label>
        <textarea id="address2" name="address2"><?php echo htmlspecialchars($userToUpdate->getAddress2() ?? ''); ?></textarea>
    </div>
    <div class="admin-form-group">
        <label for="address3"><?php echo __('admin_user_additional_address2_form'); ?>:</label>
        <textarea id="address3" name="address3"><?php echo htmlspecialchars($userToUpdate->getAddress3() ?? ''); ?></textarea>
    </div>
    <div class="admin-form-group">
        <label for="phone"><?php echo __('admin_user_phone_form'); ?>:</label>
        <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($userToUpdate->getPhone() ?? ''); ?>">
    </div>
    <div class="admin-form-group">
        <label for="profilePic"><?php echo __('admin_user_profile_pic_form'); ?>:</label>
        <input type="file" id="profilePic" name="profilePic" accept="image/*">
        <?php if ($userToUpdate->getProfilePic()): ?>
            <div class="current-profile-pic">
                <p><?php echo __('admin_user_actual_photo_form'); ?>:</p>
                <img src="/Akihabara-Dreams/resources/images/usuarios/<?php echo htmlspecialchars($userToUpdate->getProfilePic()); ?>" 
                alt="Foto de perfil actual" style="max-width: 100px; max-height: 100px;">
            </div>
        <?php endif; ?>
    </div>
    <div class="admin-form-group">
        <label for="role"><?php echo __('admin_user_role_form'); ?></label>
        <select name="role" id="role">
            <option value="usuario" <?php echo ($userToUpdate->getRole() === 'usuario') ? 'selected' : ''; ?>><?php echo __('admin_user_role_user'); ?></option>
            <option value="admin" <?php echo ($userToUpdate->getRole() === 'admin') ? 'selected' : ''; ?>><?php echo __('admin_user_role_admin'); ?></option>
        </select>
    </div>
</div>

<!-- Asegurarse de que el ID del usuario a actualizar se pasa correctamente -->
<input type="hidden" name="id" value="<?php echo $userToUpdate->getId(); ?>">
<input type="hidden" name="actual_photo" value="<?php echo htmlspecialchars($userToUpdate->getProfilePic()); ?>">
<button type="submit" class="admin-btn admin-btn-primary"><?php echo __('admin_update_user'); ?></button>
<p class="admin-form-note"><?php echo __('admin_default_note'); ?></p>
</form>