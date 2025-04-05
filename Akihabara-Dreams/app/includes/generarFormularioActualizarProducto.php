<form action="/Akihabara-Dreams/productos/update" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="name">Nombre del producto:</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($product->getName()) ?>" required>
    </div>
    <div class="form-group">
        <label for="description">Descripción:</label>
        <input type="text" id="description" name="description" value="<?= htmlspecialchars($product->getDescription()) ?>" required>
    </div>
    <div class="form-group">
        <label for="category">Categoría:</label>
        <input type="text" id="category" name="category" value="<?= htmlspecialchars($product->getCategory()) ?>" required>
    </div>
    <div class="form-group">
        <label for="stock">Inventario:</label>
        <input type="text" id="stock" name="stock" value="<?= htmlspecialchars($product->getStock()) ?>" required>
    </div>
    <div class="form-group">
        <label for="price">Precio (en euros):</label>
        <input type="number" id="price" name="price" step="0.01" min="0" value="<?= htmlspecialchars($product->getPrice()) ?>" required>
    </div>
    <div class="form-group">
        <label for="photo">Foto principal del producto (sustituir):</label>
        <input type="file" id="photo" name="photo" accept="image/*">
        <?php if ($product->getPhoto()): ?>
            <p>Portada actual: <?= htmlspecialchars($product->getPhoto()) ?></p>
            <input type="hidden" name="photo" value="<?php echo $product->getPhoto(); ?>">
        <?php endif; ?>
    </div>
    <div class="form-group">
        <label for="additionalPhotos">Fotos adicionales (añadir):</label>
        <input type="file" id="additionalPhotos" name="additionalPhotos[]" accept="image/*" multiple>

        <?php if (!empty($product->getAdditionalPhotos())): ?>
            <p>Fotos adicionales actuales:</p>
            <ul>
                <?php foreach ($product->getAdditionalPhotos() as $photo): ?>
                    <li><?= htmlspecialchars($photo) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
    <input type="hidden" name="id" value="<?php echo $product->getId(); ?>">
    <button type="submit">Actualizar Producto</button>
    <p><i>Nota: Los valores por defecto son los originales. Se sustituirá cualquier elemento introducido.</i></p>

</form>
