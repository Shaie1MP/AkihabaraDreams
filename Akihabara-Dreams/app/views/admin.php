<?php
include '../app/includes/checkSession.php';
include '../app/includes/checkRole.php';
?>

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
        <div class="admin-sidebar">
            <div class="admin-sidebar-header">
                <h2><?php echo __('admin_dashboard')?></h2>
            </div>
            <ul class="admin-sidebar-menu">
                <li class="admin-sidebar-item">
                    <a href="/Akihabara-Dreams/admin" class="admin-sidebar-link active">
                        <span class="admin-sidebar-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layout-dashboard">
                                <rect width="7" height="9" x="3" y="3" rx="1"></rect>
                                <rect width="7" height="5" x="14" y="3" rx="1"></rect>
                                <rect width="7" height="9" x="14" y="12" rx="1"></rect>
                                <rect width="7" height="5" x="3" y="16" rx="1"></rect>
                            </svg>
                        </span>
                        <?php echo __('admin_dashboard')?>
                    </a>
                </li>
                <li class="admin-sidebar-item">
                    <a href="/Akihabara-Dreams/products" class="admin-sidebar-link">
                        <span class="admin-sidebar-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-package">
                                <path d="m7.5 4.27 9 5.15"></path>
                                <path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"></path>
                                <path d="m3.3 7 8.7 5 8.7-5"></path>
                                <path d="M12 22V12"></path>
                            </svg>
                        </span>
                        <?php echo __('admin_products')?>
                    </a>
                </li>
                <li class="admin-sidebar-item">
                    <a href="/Akihabara-Dreams/users" class="admin-sidebar-link">
                        <span class="admin-sidebar-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                        </span>
                        <?php echo __('admin_users')?>
                    </a>
                </li>
                <li class="admin-sidebar-item">
                    <a href="/Akihabara-Dreams/promotions" class="admin-sidebar-link">
                        <span class="admin-sidebar-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-tag">
                                <path d="M12 2H2v10l9.29 9.29c.94.94 2.48.94 3.42 0l6.58-6.58c.94-.94.94-2.48 0-3.42L12 2Z"></path>
                                <path d="M7 7h.01"></path>
                            </svg>
                        </span>
                        <?php echo __('admin_promotions')?>
                    </a>
                </li>
                <li class="admin-sidebar-item">
                    <a href="/Akihabara-Dreams/orders" class="admin-sidebar-link">
                        <span class="admin-sidebar-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-bag">
                                <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"></path>
                                <path d="M3 6h18"></path>
                                <path d="M16 10a4 4 0 0 1-8 0"></path>
                            </svg>
                        </span>
                        <?php echo __('admin_orders')?>
                    </a>
                </li>
                <li class="admin-sidebar-item">
                    <a href="/Akihabara-Dreams/" class="admin-sidebar-link">
                        <span class="admin-sidebar-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-store">
                                <path d="m2 7 4.41-4.41A2 2 0 0 1 7.83 2h8.34a2 2 0 0 1 1.42.59L22 7"></path>
                                <path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"></path>
                                <path d="M15 22v-4a2 2 0 0 0-2-2h-2a2 2 0 0 0-2 2v4"></path>
                                <path d="M2 7h20"></path>
                                <path d="M22 7v3a2 2 0 0 1-2 2v0a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 16 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 12 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 8 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 4 12v0a2 2 0 0 1-2-2V7"></path>
                            </svg>
                        </span>
                        <?php echo __('admin_go_shop')?>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Contenido principal -->
        <div class="admin-content">
            <div class="admin-header">
                <h1><?php echo __('admin_panel')?></h1>
                <p><?php echo __('admin_welcome')?></p>
            </div>

            <!-- Tarjetas de estadísticas -->
            <div class="admin-stats">
                <div class="admin-stat-card">
                    <div class="admin-stat-header">
                        <span class="admin-stat-title"><?php echo __('admin_products')?></span>
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
                        // incluir código para contar productos
                        echo "120";
                        ?>
                    </h3>
                    <p class="admin-stat-description"><?php echo __('admin_total_products')?></p>
                </div>

                <div class="admin-stat-card">
                    <div class="admin-stat-header">
                        <span class="admin-stat-title"><?php echo __('admin_users')?></span>
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
                        // incluir código para contar usuarios
                        echo "45";
                        ?>
                    </h3>
                    <p class="admin-stat-description"><?php echo __('admin_registered_users')?></p>
                </div>

                <div class="admin-stat-card">
                    <div class="admin-stat-header">
                        <span class="admin-stat-title"><?php echo __('admin_orders')?></span>
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
                        // incluir código para contar pedidos
                        echo "78";
                        ?>
                    </h3>
                    <p class="admin-stat-description"><?php echo __('admin_realized_orders')?></p>
                </div>

                <div class="admin-stat-card">
                    <div class="admin-stat-header">
                        <span class="admin-stat-title"><?php echo __('admin_promotions')?></span>
                        <div class="admin-stat-icon promotions">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-tag">
                                <path d="M12 2H2v10l9.29 9.29c.94.94 2.48.94 3.42 0l6.58-6.58c.94-.94.94-2.48 0-3.42L12 2Z"></path>
                                <path d="M7 7h.01"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="admin-stat-value">
                        <?php
                        // incluir código para contar promociones activas
                        echo "15";
                        ?>
                    </h3>
                    <p class="admin-stat-description"><?php echo __('admin_active_promotions')?></p>
                </div>
            </div>

            <!-- Acciones rápidas -->
            <div class="admin-quick-actions">
                <h2><?php echo __('admin_quick_actions')?></h2>
                <div class="admin-actions-grid">
                    <a href="/Akihabara-Dreams/products/crear" class="admin-action-card">
                        <div class="admin-action-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-circle">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="M8 12h8"></path>
                                <path d="M12 8v8"></path>
                            </svg>
                        </div>
                        <h3 class="admin-action-title"><?php echo __('admin_add_product')?></h3>
                    </a>
                    <a href="/Akihabara-Dreams/promotions/crear" class="admin-action-card">
                        <div class="admin-action-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-tag">
                                <path d="M12 2H2v10l9.29 9.29c.94.94 2.48.94 3.42 0l6.58-6.58c.94-.94.94-2.48 0-3.42L12 2Z"></path>
                                <path d="M7 7h.01"></path>
                            </svg>
                        </div>
                        <h3 class="admin-action-title"><?php echo __('admin_add_promotion')?></h3>
                    </a>
                    <a href="/Akihabara-Dreams/users/crear" class="admin-action-card">
                        <div class="admin-action-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-plus">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <line x1="19" x2="19" y1="8" y2="14"></line>
                                <line x1="22" x2="16" y1="11" y2="11"></line>
                            </svg>
                        </div>
                        <h3 class="admin-action-title"><?php echo __('admin_add_user')?></h3>
                    </a>
                    <a href="/Akihabara-Dreams/orders" class="admin-action-card">
                        <div class="admin-action-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clipboard-list">
                                <rect width="8" height="4" x="8" y="2" rx="1" ry="1"></rect>
                                <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                                <path d="M12 11h4"></path>
                                <path d="M12 16h4"></path>
                                <path d="M8 11h.01"></path>
                                <path d="M8 16h.01"></path>
                            </svg>
                        </div>
                        <h3 class="admin-action-title"><?php echo __('admin_show_orders')?></h3>
                    </a>
                </div>
            </div>

            <!-- Actividad reciente -->
            <div class="admin-recent-activity">
                <h2><?php echo __('admin_recent_activitie')?></h2>
                <ul class="admin-activity-list">
                    <li class="admin-activity-item">
                        <div class="admin-activity-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-tag">
                                <path d="M12 2H2v10l9.29 9.29c.94.94 2.48.94 3.42 0l6.58-6.58c.94-.94.94-2.48 0-3.42L12 2Z"></path>
                                <path d="M7 7h.01"></path>
                            </svg>
                        </div>
                        <div class="admin-activity-content">
                            <h4 class="admin-activity-title"><?php echo __('admin_new_promotion_created')?></h4>
                            <p class="admin-activity-time"><?php echo __('admin_an_hour_ago')?></p>
                        </div>
                    </li>
                    <li class="admin-activity-item">
                        <div class="admin-activity-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-bag">
                                <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"></path>
                                <path d="M3 6h18"></path>
                                <path d="M16 10a4 4 0 0 1-8 0"></path>
                            </svg>
                        </div>
                        <div class="admin-activity-content">
                            <h4 class="admin-activity-title"><?php echo __('admin_new_order_placed')?></h4>
                            <p class="admin-activity-time"><?php echo __('admin_two_hours_ago')?></p>
                        </div>
                    </li>
                    <li class="admin-activity-item">
                        <div class="admin-activity-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user">
                                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </div>
                        <div class="admin-activity-content">
                            <h4 class="admin-activity-title"><?php echo __('admin_new_user_registered')?></h4>
                            <p class="admin-activity-time"><?php echo __('admin_five_hours_ago')?></p>
                        </div>
                    </li>
                    <li class="admin-activity-item">
                        <div class="admin-activity-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-package">
                                <path d="m7.5 4.27 9 5.15"></path>
                                <path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"></path>
                                <path d="m3.3 7 8.7 5 8.7-5"></path>
                                <path d="M12 22V12"></path>
                            </svg>
                        </div>
                        <div class="admin-activity-content">
                            <h4 class="admin-activity-title"><?php echo __('admin_new_product_added')?></h4>
                            <p class="admin-activity-time"><?php echo __('admin_one_day_ago')?></p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</body>

</html>

