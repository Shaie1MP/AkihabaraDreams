<?php
// Verificar sesión y rol
include_once '../app/includes/checkSession.php';
include_once '../app/includes/checkRole.php';

include '../config/database.php'; 
include_once '../config/loader.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Akihabara Dreams</title>
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/normalize.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/language-switcher.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/body.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/navbar.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/admin.css">
</head>

<body>
    <?php
    include '../resources/commons/navbar.php';
    ?>
    

    <div class="admin-container">
        <!-- Sidebar de administración -->
        <?php include '../resources/commons/admin-sidebar.php'; ?>

        <!-- Contenido principal -->
        <div class="admin-content">
            <div class="admin-header">
                <h1><?php echo __('admin_panel') ?></h1>
                <p><?php echo __('admin_welcome') ?></p>
            </div>

            <!-- Tarjetas de estadísticas -->
            <div class="admin-stats">
                <div class="admin-stat-card">
                    <div class="admin-stat-header">
                        <span class="admin-stat-title"><?php echo __('admin_products') ?></span>
                        <div class="admin-stat-icon products">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-package">
                                <path d="m7.5 4.27 9 5.15"></path>
                                <path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"></path>
                                <path d="m3.3 7 8.7 5 8.7-5"></path>
                                <path d="M12 22V12"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="admin-stat-value">
                        <?php
                        try {
                            // Contador de productos
                            $productsRepository = new ProductsRepository($connection);
                            $productsController = new ProductsController($productsRepository);
                            $products = $productsController->getAllProducts();
                            echo is_array($products) ? count($products) : '0';
                        } catch (Exception $e) {
                            throw new Exception("Error al contar productos: " . $e->getMessage());
                        }
                        ?>
                    </h3>
                    <p class="admin-stat-description"><?php echo __('admin_total_products') ?></p>
                </div>

                <div class="admin-stat-card">
                    <div class="admin-stat-header">
                        <span class="admin-stat-title"><?php echo __('admin_users') ?></span>
                        <div class="admin-stat-icon users">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="admin-stat-value">
                        <?php
                        try {
                            // Contador de usuarios
                            $usersRepository = new UsersRepository($connection);
                            $usersController = new UsersController($usersRepository);
                            $users = $usersController->getAllUsers();
                            echo is_array($users) ? count($users) : '0';
                        } catch (Exception $e) {
                            throw new Exception("Error al contar usuarios: " . $e->getMessage());
                        }
                        ?>
                    </h3>
                    <p class="admin-stat-description"><?php echo __('admin_registered_users') ?></p>
                </div>

                <div class="admin-stat-card">
                    <div class="admin-stat-header">
                        <span class="admin-stat-title"><?php echo __('admin_orders') ?></span>
                        <div class="admin-stat-icon orders">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-bag">
                                <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"></path>
                                <path d="M3 6h18"></path>
                                <path d="M16 10a4 4 0 0 1-8 0"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="admin-stat-value">
                        <?php
                        try {
                            // Contador de pedidos
                            $ordersRepository = new OrdersRepository($connection);
                            $ordersController = new OrdersController($ordersRepository);
                            $orders = $ordersController->getAllOrders();
                            echo is_array($orders) ? count($orders) : '0';
                        } catch (Exception $e) {
                            throw new Exception("Error al contar pedidos: " . $e->getMessage());
                        }
                        ?>
                    </h3>
                    <p class="admin-stat-description"><?php echo __('admin_realized_orders') ?></p>
                </div>

                <div class="admin-stat-card">
                    <div class="admin-stat-header">
                        <span class="admin-stat-title"><?php echo __('admin_promotions') ?></span>
                        <div class="admin-stat-icon promotions">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-tag">
                                <path d="M12 2H2v10l9.29 9.29c.94.94 2.48.94 3.42 0l6.58-6.58c.94-.94.94-2.48 0-3.42L12 2Z"></path>
                                <path d="M7 7h.01"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="admin-stat-value">
                        <?php
                        try {
                            // Contador de promociones activas
                            $promotionsRepository = new PromotionsRepository($connection);
                            $promotions = $promotionsRepository->getActivePromotions();
                            echo is_array($promotions) ? count($promotions) : '0';
                        } catch (Exception $e) {
                            throw new Exception("Error al contar promociones: " . $e->getMessage());
                        }
                        ?>
                    </h3>
                    <p class="admin-stat-description"><?php echo __('admin_active_promotions') ?></p>
                </div>
            </div>
        </div>
    </div>
    

</body>

</html>
