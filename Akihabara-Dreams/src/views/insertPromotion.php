<?php
require_once "../config/database.php";
require_once "../controllers/promotionsController.php";
require_once "../repositories/promotionsRepository.php";
require_once "../models/promotion.php";
require_once "../repositories/productsRepository.php";
require_once "../models/product.php";

// Obtener todos los productos para mostrarlos en el formulario
$productRepo = new ProductsRepository($pdo);
$products = $productRepo->getProducts();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $code = $_POST["code"] ?? null;
    $discount = $_POST["discount"] ?? null;
    $description = $_POST["description"] ?? null;
    $start_date = $_POST["start_date"] ?? null;
    $end_date = $_POST["end_date"] ?? null;
    
    $productIds = $_POST["products"] ?? [];
    
    $promotion = new Promotion(null, $code, $discount, $description, $start_date, $end_date);

    $repo = new PromotionsRepository($pdo);
    $controller = new PromotionsController($repo);
    
    try {
        $controller->insertPromotion($promotion, $productIds);
        echo "Se ha añadido la promoción y se ha aplicado a " . count($productIds) . " productos.";
    } catch (Exception $e) {
        echo "Error al añadir la promoción: " . $e->getMessage();
    }
}
?>

<link rel="stylesheet" href="../../resources/css/form.css">
<link rel="stylesheet" href="../../resources/css/index.css">

<div class="form-container">
    <div class="form-header">
        <h1>Agregar Promoción</h1>
    </div>
    
    <?php if (isset($message)): ?>
        <div class="form-message <?php echo $success ? 'success' : 'error'; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>
    
    <form method="POST" enctype="multipart/form-data">
        <div class="form-row">
            <div class="form-group">
                <label for="code" class="required-field">Código</label>
                <input type="text" id="code" name="code" required>
            </div>
            
            <div class="form-group">
                <label for="discount" class="required-field">Descuento</label>
                <input type="number" id="discount" name="discount" step="1" required>
            </div>

            <div class="form-group">
                <label for="description">Descripción</label>
                <textarea id="description" name="description" rows="4"></textarea>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="start_date">Fecha de inicio</label>
                <input type="date" id="start_date" name="start_date">
            </div>
        </div>
        
        <div class="form-group">
            <label for="end_date">Fecha de fin</label>
            <input type="date" id="end_date" name="end_date">
        </div>

        <div class="form-group">
            <h3>Selecciona los productos para esta promoción:</h3>
            <div class="promotions-checkbox">
                <?php foreach ($products as $product): ?>
                    <div>
                        <input type="checkbox" name="products[]" value="<?php echo $product->getId(); ?>" id="product_<?php echo $product->getId(); ?>">
                        <label for="product_<?php echo $product->getId(); ?>">
                            <?php echo htmlspecialchars($product->getName()); ?> - 
                            <?php echo number_format($product->getPrice(), 2); ?>€
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit">Agregar</button>
            <a href="/Akihabara-Dreams/src/index.php" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>