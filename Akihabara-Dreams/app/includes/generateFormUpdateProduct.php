<form action="/Akihabara-Dreams/products/update" method="post" enctype="multipart/form-data" class="admin-form">
    <div class="admin-form-group">
        <label for="name"><?php echo __('admin_product_name_form')?>:</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($product->getName()) ?>" required>
    </div>
    <div class="admin-form-group">
        <label for="description"><?php echo __('admin_product_description_form')?>:</label>
        <input type="text" id="description" name="description" value="<?= htmlspecialchars($product->getDescription()) ?>" required>
    </div>
    <div class="admin-form-group">
        <label for="category"><?php echo __('admin_product_category_form')?>:</label>
        <input type="text" id="category" name="category" value="<?= htmlspecialchars($product->getCategory()) ?>" required>
    </div>
    <div class="admin-form-group">
        <label for="stock"><?php echo __('admin_product_stock_form')?>:</label>
        <input type="text" id="stock" name="stock" value="<?= htmlspecialchars($product->getStock()) ?>" required>
    </div>
    <div class="admin-form-group">
        <label for="price"><?php echo __('admin_product_price_form')?>:</label>
        <input type="number" id="price" name="price" step="0.01" min="0" value="<?= htmlspecialchars($product->getPrice()) ?>" required>
    </div>
    <div class="admin-form-group">
        <label for="photo"><?php echo __('admin_product_photo_form')?>:</label>
        <input type="file" id="photo" name="photo" accept="image/*">
        <?php if ($product->getPhoto()): ?>
            <p><?php echo __('admin_product_name_form')?>: <?= htmlspecialchars($product->getPhoto()) ?></p>
            <img src="/Akihabara-Dreams/resources/images/productos/portadas/<?php echo $product->getPhoto(); ?>" alt="Portada actual" style="max-width: 100px; margin-top: 0.5rem;">
            <input type="hidden" name="photo" value="<?php echo $product->getPhoto(); ?>">
        <?php endif; ?>
    </div>
    <div class="admin-form-group">
        <label for="additionalPhotos"><?php echo __('admin_product_additional_photos_form')?>:</label>
        <input type="file" id="additionalPhotos" name="additionalPhotos[]" accept="image/*" multiple>

        <?php if (!empty($product->getAdditionalPhotos())): ?>
            <p><?php echo __('admin_product_actual_additional_photos_form')?>:</p>
            <ul>
                <?php foreach ($product->getAdditionalPhotos() as $photo): ?>
                    <li><?= htmlspecialchars($photo) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
    <input type="hidden" name="id" value="<?php echo $product->getId(); ?>">
    <button type="submit" class="admin-btn admin-btn-primary"><?php echo __('admin_update_product')?></button>
    <p class="admin-form-note"><?php echo __('admin_default_note')?></p>
</form>