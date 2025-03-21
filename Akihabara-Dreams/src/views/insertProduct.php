<?php
require_once "../config/database.php";
require_once "../controllers/productsController.php";
require_once "../repositories/productsRepository.php";
require_once "../models/product.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"] ?? null;
    $description = $_POST["description"] ?? null;
    $price = $_POST["price"] ?? null;
    $stock = $_POST["stock"] ?? null;
    $photo = $_FILES["photo"] ?? null;
    
    $product = new Product(null, $name, $description, $price, $stock, $photo);

    $repo = new ProductsRepository($pdo);
    $controller = new ProductsController($repo);
    
    try {
        $controller->insertProduct($product);
        echo "Se ha añadido el producto.";
    } catch (Exception $e) {
        echo "Error al añadir el producto: " . $e->getMessage();
    }
}
?>

<link rel="stylesheet" href="../../resources/css/form.css">
<link rel="stylesheet" href="../../resources/css/index.css">


<div class="form-container">
    <div class="form-header">
        <h1>Agregar Producto</h1>
    </div>
    
    <?php if (isset($message)): ?>
        <div class="form-message <?php echo $success ? 'success' : 'error'; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>
    
    <form method="POST" enctype="multipart/form-data">
        <div class="form-row">
            <div class="form-group">
                <label for="name" class="required-field">Nombre del producto</label>
                <input type="text" id="name" name="name" required>
            </div>
            
            <div class="form-group">
                <label for="price" class="required-field">Precio</label>
                <input type="number" id="price" name="price" step="0.01" required>
            </div>

            <div class="form-group">
                <label for="description">Descripción</label>
                <textarea id="description" name="description" rows="4"></textarea>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="stock">Stock disponible</label>
                <input type="number" id="stock" name="stock" min="0">
            </div>
        </div>
        
        <div class="form-group">
            <label for="photo">Imagen principal</label>
            <input type="file" id="photo" name="photo" accept="image/*">
        </div>
        
        <div class="form-group">
            <label for="additionalPhotos">Imágenes adicionales</label>
            <input type="file" id="additionalPhotos" name="additionalPhotos[]" accept="image/*" multiple>
        </div>
        
        <div class="form-actions">
            <button type="submit">Guardar producto</button>
            <a href="/Akihabara-Dreams/src/index.php" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
