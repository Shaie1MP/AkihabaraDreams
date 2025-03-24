
<link rel="stylesheet" href="../resources/css/navbar.css">
<link rel="stylesheet" href="../resources/css/index.css">
<link rel="stylesheet" href="../resources/css/products.css">


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

<div class="container">
    <!-- Sección de Usuarios -->
    <section class="section-users-section">
        <h2 class="section-title">Usuarios</h2>
        <div class="cards-container users-container">
            <?php foreach ($users as $user): ?>
                <div class="card user-card">
                    <img class="user-image" src="../resources/images/usuarios/<?php echo htmlspecialchars($user->getProfilePic()); ?>" alt="Imagen de <?php echo htmlspecialchars($user->getName()); ?>">
                    <div class="card-body">
                        <h3 class="user-name"><?php echo htmlspecialchars($user->getName()); ?></h3>
                        <p class="user-id">ID: <?php echo htmlspecialchars($user->getId()); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Sección de Productos -->
    <section class="section products-section">
        <h2 class="section-title">Productos</h2>
        <div class="cards-container products-container">
            <?php foreach ($products as $product): ?>
                <div class="card product-card">
                    <div class="product-image-container">
                        <img class="product-image" src="../resources/images/productos/portadas/<?php echo htmlspecialchars($product->getPhoto()); ?>" alt="Imagen de <?php echo htmlspecialchars($product->getName()); ?>">
                    </div>
                    <div class="card-body">
                        <h3><?php echo htmlspecialchars($product->getName()); ?></h3>
                        <p class="product-price"><?php echo number_format($product->getPrice(), 2); ?> €</p>
                        <p class="product-description"><?php echo htmlspecialchars($product->getDescription()); ?></p>
                        
                        <?php if (!empty($product->getAdditionalPhotos())): ?>
                            <div class="product-additional-images">
                                <?php foreach ($product->getAdditionalPhotos() as $additionalPhoto): ?>
                                    <img src="../resources/images/productos/adicionales/<?php echo htmlspecialchars($additionalPhoto); ?>" alt="Imagen adicional de <?php echo htmlspecialchars($product->getName()); ?>">
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Sección de Pedidos -->
    <section class="section orders-section">
        <h2 class="section-title">Pedidos</h2>
        <div class="cards-container orders-container">
            <?php foreach ($orders as $order): ?>
                <div class="card order-card">
                    <div class="card-header order-header">
                        <h3>Pedido #<?php echo htmlspecialchars($order->getOrderId()); ?></h3>
                        <span class="order-state <?php echo strtolower($order->getState()); ?>">
                            <?php echo htmlspecialchars($order->getState()); ?>
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="order-info">
                            <p><strong>Cliente ID:</strong> <?php echo htmlspecialchars($order->getUserId()); ?></p>
                            <p><strong>Fecha pedido:</strong> <?php echo htmlspecialchars($order->getOrderDate()); ?></p>
                            <p><strong>Fecha llegada:</strong> <?php echo htmlspecialchars($order->getArriveDate()); ?></p>
                            <p><strong>Dirección:</strong> <?php echo htmlspecialchars($order->getAddress()); ?></p>
                            <p><strong>Facturación:</strong> <?php echo htmlspecialchars($order->getBilling()); ?></p>
                        </div>
                        
                        <div class="order-details">
                            <h4>Detalles del pedido</h4>
                            <?php $total = 0; ?>
                            <?php foreach ($order->getOrderDetails() as $orderDetail): ?>
                                <?php $total += $orderDetail->getSubtotal(); ?>
                                <div class="order-item">
                                    <span><?php echo htmlspecialchars($orderDetail->getProductName()) . " x " . htmlspecialchars($orderDetail->getQuantity()); ?></span>
                                    <span><?php echo htmlspecialchars($orderDetail->getSubtotal()); ?> €</span>
                                </div>
                            <?php endforeach; ?>
                            <div class="order-total">
                                Total: <?php echo $total; ?> €
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Sección de Promociones -->
    <section class="section promotions-section">
        <h2 class="section-title">Promociones</h2>
        <div class="cards-container promotions-container">
            <?php foreach ($promotions as $promotion): ?>
                <div class="card promotion-card">
                    <div class="card-header">
                        <h3>Promoción #<?php echo htmlspecialchars($promotion->getPromotionId()); ?></h3>
                    </div>
                    <div class="card-body">
                        <div class="promotion-code"><?php echo htmlspecialchars($promotion->getCode()); ?></div>
                        <div class="promotion-discount"><?php echo htmlspecialchars($promotion->getDiscount()); ?>% OFF</div>
                        <p><?php echo htmlspecialchars($promotion->getDescription()); ?></p>
                        <div class="promotion-dates">
                            <span>Desde: <?php echo htmlspecialchars($promotion->getStartDate()); ?></span>
                            <span>Hasta: <?php echo htmlspecialchars($promotion->getEndDate()); ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Enlaces de navegación -->
    <div class="nav-links">
        <a href="views/login.php" class="nav-link">Login</a>
        <a href="views/insertProduct.php" class="nav-link">Agregar producto</a>
        <a href="views/insertPromotion.php" class="nav-link">Agregar promoción</a>
        <a href="views/register.php" class="nav-link">Register</a>
    </div>
</div>

<script src="../resources/js/carrousel.js"></script>
<script src="../resources/js/sidebar.js"></script>
