
<link rel="stylesheet" href="../resources/css/navbar.css">
<link rel="stylesheet" href="../resources/css/index.css">
<link rel="stylesheet" href="../resources/css/products.css">
<link rel="stylesheet" href="../resources/css/footer.css">

<?php
require_once 'config/database.php';
require_once "repositories/usersRepository.php";
require_once 'models/user.php';
require_once "repositories/productsRepository.php";
require_once "models/product.php";
require_once "models/order.php";
require_once "models/orderDetails.php";
require_once "repositories/ordersRepository.php";
require_once "models/promotion.php";
require_once "repositories/promotionsRepository.php";

$repoUser = new UsersRepository($pdo);
$repoProduct = new ProductsRepository($pdo);
$repoOrder = new OrdersRepository($pdo);
$repoPromotion = new PromotionsRepository($pdo);

// Prueba obtener usuarios
$users = $repoUser->showUsers();

// Obtener productos
$products = $repoProduct->getProducts();
$featuredProducts = array_slice($products, 0, 5);

// Obtener pedidos
$orders = $repoOrder->getOrders();

// Obtener promociones
$promotions = $repoPromotion->showPromotions();

include("../src/includes/header.php");
?>

<!-- Carrusel de Productos Destacados -->
<section class="section featured-section">
    <h2 class="section-title">Productos Destacados</h2>
    
    <div class="carousel-container">
        <div class="carousel-track">
            <?php foreach ($featuredProducts as $product): ?>
                <div class="carousel-slide">
                    <a href="views/product.php?id=<?php echo $product->getId(); ?>" class="featured-image-link">
                        <img class="featured-image" src="../resources/images/productos/portadas/<?php echo htmlspecialchars($product->getPhoto()); ?>" alt="<?php echo htmlspecialchars($product->getName()); ?>">
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        
        <button class="carousel-button prev" aria-label="Anterior">&#10094;</button>
        <button class="carousel-button next" aria-label="Siguiente">&#10095;</button>
        
        <div class="carousel-dots">
            <?php for ($i = 0; $i < count($featuredProducts); $i++): ?>
                <button class="carousel-dot <?php echo $i === 0 ? 'active' : ''; ?>" data-index="<?php echo $i; ?>" aria-label="Ir a slide <?php echo $i + 1; ?>"></button>
            <?php endfor; ?>
        </div>
    </div>
</section>

<?php include("../src/includes/generateProducts.php"); ?>

    <!-- Enlaces de navegación -->
    <div class="nav-links">
        <a href="views/login.php" class="nav-link">Login</a>
        <a href="views/insertProduct.php" class="nav-link">Agregar producto</a>
        <a href="views/insertPromotion.php" class="nav-link">Agregar promoción</a>
        <a href="views/register.php" class="nav-link">Register</a>
    </div>
</div>

<?php
include("../src/includes/footer.php");
?>

<script src="../resources/js/carrousel.js"></script>
<script src="../resources/js/sidebar.js"></script>
