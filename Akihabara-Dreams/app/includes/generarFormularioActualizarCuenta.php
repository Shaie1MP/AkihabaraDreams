<form action="/Akihabara-Dreams/micuenta/update" method="post" enctype="multipart/form-data">
    <h2><?php echo __('account_obligatory_info')?></h2>
    <div class="form-group">
        <label for="name"><?php echo __('account_name')?>:</label>
        <input type="text" id="name" name="name" value="<?php echo $user->getName(); ?>" required>
    </div>
    <div class="form-group">
        <label for="username"><?php echo __('account_username')?>:</label>
        <input type="text" id="username" name="username" value="<?php echo $user->getUserName(); ?>" required>
    </div>
    <div class="form-group">
        <label for="email"><?php echo __('account_email')?>:</label>
        <input type="email" id="email" name="email" value="<?php echo $user->getEmail(); ?>" required>
    </div>
    <div class="form-group">
        <label for="password"><?php echo __('account_password')?>:</label>
        <input type="password" id="password" name="password" required>
    </div>
    <div class="form-group">
        <label for="confirm_password"><?php echo __('account_confirm_password')?>:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>
    </div>
    <div class="form-group">
        <label for="address"><?php echo __('account_address')?>:</label>
        <textarea id="address" name="address" required><?php echo $user->getAddresses()[0] ?? ''; ?></textarea>
    </div>

    <h2><?php echo __('account_optional_info')?></h2>
    <div class="form-group">
        <label for="address2"><?php echo __('account_additional_address')?> 1:</label>
        <textarea id="address2" name="address2"><?php echo $user->getAddresses()[1] ?? ''; ?></textarea>
    </div>
    <div class="form-group">
        <label for="address3"><?php echo __('account_additional_address')?> 2:</label>
        <textarea id="address3" name="address3"><?php echo $user->getAddresses()[2] ?? ''; ?></textarea>
    </div>
    <div class="form-group">
        <label for="phone"><?php echo __('account_phone')?>:</label>
        <input type="tel" id="phone" name="phone" value="<?php echo $user->getPhone(); ?>">
    </div>
    <div class="form-group">
        <label for="profilePic"><?php echo __('account_profile_pic')?>:</label>
        <input type="file" id="profilePic" name="profilePic" accept="image/*">
        <?php if ($user->getProfilePic()): ?>
            <img src="/Akihabara-Dreams/resources/images/usuarios/<?php echo $user->getProfilePic(); ?>" 
     alt="Foto de perfil actual: <?php echo $user->getProfilePic(); ?>">
        <?php endif; ?>
    </div>

    <input type="hidden" name="id" value="<?php echo $user->getId(); ?>">
    <input type="hidden" name="actual_photo" value="<?php echo $user->getProfilePic(); ?>">
    <input type="hidden" name="role" value="<?php echo $user->getRole(); ?>">
    <button type="submit"><?php echo __('account_save_changes')?></button>
    <p><i><?php echo __('account_note')?></i></p>
</form>