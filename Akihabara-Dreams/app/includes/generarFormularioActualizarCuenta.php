<form action="/Akihabara-Dreams/micuenta/update" method="post" enctype="multipart/form-data">
    <h2>Información Obligatoria</h2>
    <div class="form-group">
        <label for="name">Nombre:</label>
        <input type="text" id="name" name="name" value="<?php echo $user->getName(); ?>" required>
    </div>
    <div class="form-group">
        <label for="username">Nombre de usuario:</label>
        <input type="text" id="username" name="username" value="<?php echo $user->getUserName(); ?>" required>
    </div>
    <div class="form-group">
        <label for="email">Correo electrónico:</label>
        <input type="email" id="email" name="email" value="<?php echo $user->getEmail(); ?>" required>
    </div>
    <div class="form-group">
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
    </div>
    <div class="form-group">
        <label for="confirm_password">Confirmar contraseña:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>
    </div>
    <div class="form-group">
        <label for="address">Dirección:</label>
        <textarea id="address" name="address" required><?php echo $user->getAddresses()[0] ?? ''; ?></textarea>
    </div>

    <h2>Información Opcional</h2>
    <div class="form-group">
        <label for="address2">Dirección adicional 1:</label>
        <textarea id="address2" name="address2"><?php echo $user->getAddresses()[1] ?? ''; ?></textarea>
    </div>
    <div class="form-group">
        <label for="address3">Dirección adicional 2:</label>
        <textarea id="address3" name="address3"><?php echo $user->getAddresses()[2] ?? ''; ?></textarea>
    </div>
    <div class="form-group">
        <label for="phone">Teléfono:</label>
        <input type="tel" id="phone" name="phone" value="<?php echo $user->getPhone(); ?>">
    </div>
    <div class="form-group">
        <label for="profilePic">Foto de perfil:</label>
        <input type="file" id="profilePic" name="profilePic" accept="image/*">
        <?php if ($user->getProfilePic()): ?>
            <img src="/Akihabara-Dreams/resources/images/usuarios/<?php echo $user->getProfilePic(); ?>" 
     alt="Foto de perfil actual: <?php echo $user->getProfilePic(); ?>">
        <?php endif; ?>
    </div>

    <input type="hidden" name="id" value="<?php echo $user->getId(); ?>">
    <input type="hidden" name="actual_photo" value="<?php echo $user->getProfilePic(); ?>">
    <input type="hidden" name="role" value="<?php echo $user->getRole(); ?>">
    <button type="submit">Actualizar tus datos</button>
    <p><i>Nota: los campos vacíos obligatorios darán error. Los valores por defecto son los originales. Se sustituirá
            cualquier elemento introducido.</i></p>
</form>