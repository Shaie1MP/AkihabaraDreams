<?php
$userToUpdate = isset($userToUpdate) ? $userToUpdate : $user;
?>

<form action="/Akihabara-Dreams/usuarios/update" method="post" enctype="multipart/form-data" class="admin-form">
<div class="admin-form-section">
    <h2 class="admin-form-section-title">Información Obligatoria</h2>
    <div class="admin-form-group">
        <label for="name">Nombre:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($userToUpdate->getName()); ?>" required>
    </div>
    <div class="admin-form-group">
        <label for="username">Nombre de usuario:</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($userToUpdate->getUserName()); ?>" required>
    </div>
    <div class="admin-form-group">
        <label for="email">Correo electrónico:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($userToUpdate->getEmail()); ?>" required>
    </div>
    <div class="admin-form-group">
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
        <small>Introduce una nueva contraseña (mínimo 8 caracteres)</small>
    </div>
    <div class="admin-form-group">
        <label for="confirm_password">Confirmar contraseña:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>
    </div>
    <div class="admin-form-group">
        <label for="address">Dirección:</label>
        <textarea id="address" name="address" required><?php echo htmlspecialchars($userToUpdate->getAddress1() ?? ''); ?></textarea>
    </div>
</div>

<div class="admin-form-section">
    <h2 class="admin-form-section-title">Información Opcional</h2>
    <div class="admin-form-group">
        <label for="address2">Dirección adicional 1:</label>
        <textarea id="address2" name="address2"><?php echo htmlspecialchars($userToUpdate->getAddress2() ?? ''); ?></textarea>
    </div>
    <div class="admin-form-group">
        <label for="address3">Dirección adicional 2:</label>
        <textarea id="address3" name="address3"><?php echo htmlspecialchars($userToUpdate->getAddress3() ?? ''); ?></textarea>
    </div>
    <div class="admin-form-group">
        <label for="phone">Teléfono:</label>
        <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($userToUpdate->getPhone() ?? ''); ?>">
    </div>
    <div class="admin-form-group">
        <label for="profilePic">Foto de perfil:</label>
        <input type="file" id="profilePic" name="profilePic" accept="image/*">
        <?php if ($userToUpdate->getProfilePic()): ?>
            <div class="current-profile-pic">
                <p>Foto actual:</p>
                <img src="/Akihabara-Dreams/resources/images/usuarios/<?php echo htmlspecialchars($userToUpdate->getProfilePic()); ?>" 
                alt="Foto de perfil actual" style="max-width: 100px; max-height: 100px;">
            </div>
        <?php endif; ?>
    </div>
    <div class="admin-form-group">
        <label for="role">Rol</label>
        <select name="role" id="role">
            <option value="usuario" <?php echo ($userToUpdate->getRole() === 'usuario') ? 'selected' : ''; ?>>Usuario</option>
            <option value="admin" <?php echo ($userToUpdate->getRole() === 'admin') ? 'selected' : ''; ?>>Administrador</option>
        </select>
    </div>
</div>

<!-- Asegurarse de que el ID del usuario a actualizar se pasa correctamente -->
<input type="hidden" name="id" value="<?php echo $userToUpdate->getId(); ?>">
<input type="hidden" name="actual_photo" value="<?php echo htmlspecialchars($userToUpdate->getProfilePic()); ?>">
<button type="submit" class="admin-btn admin-btn-primary">Actualizar usuario</button>
<p class="admin-form-note">Nota: los campos vacíos obligatorios darán error. Los valores por defecto son los originales. Se sustituirá cualquier elemento introducido.</p>
</form>