<?php
// Verificar si hay una sesión iniciada
$isLoggedIn = isset($_SESSION['usuario']);
$userNav = null;

// Obtener el usuario de la sesión si existe
if ($isLoggedIn) {
    $userNav = unserialize($_SESSION['usuario']);
}

// Incluir el sistema de idiomas si no está incluido
if (!function_exists('__')) {
    include_once __DIR__ . '/../../app/includes/language.php';
}

// Incluir la clase User antes de deserializar
include_once __DIR__ . '/../../app/models/User.php';
?>
<nav class="navbar">
    <div class="navbar-container">
        <div>
            <button id="menu-toggle" class="menu-button" aria-label="Abrir menú">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-menu" style="color: white;">
                    <line x1="4" x2="20" y1="12" y2="12"></line>
                    <line x1="4" x2="20" y1="6" y2="6"></line>
                    <line x1="4" x2="20" y1="18" y2="18"></line>
                </svg>
            </button>
        </div>
        <div class="navbar-logo-div">
            <a href="/Akihabara-Dreams/"><img src="/Akihabara-Dreams/resources/images/commons/logo-AD-3.png" alt="logo" class="img-logo"></a>
        </div>
        <div>
            <ul class="navbar-menu">
                <?php if (isset($_SESSION['usuario'])) {
                    // Usar $userNav en lugar de crear una nueva variable $user
                    if ($userNav->getRole() == 'admin') {
                        echo "<li><a href='/Akihabara-Dreams/admin' class='navbar-link'>" . __('nav_admin') . "</a></li>";
                    }
                }
                ?>
                <li>
                    <a class="navbar-link" id="carrito">
                        <div class="cart-icon-container">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-cart" style="color: white;">
                                <circle cx="8" cy="21" r="1"></circle>
                                <circle cx="19" cy="21" r="1"></circle>
                                <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path>
                            </svg>
                            <span id="cart-counter" class="cart-counter"></span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="/Akihabara-Dreams/myaccount" class="navbar-link">
                        <?php echo isset($_SESSION['usuario']) ? htmlspecialchars($userNav->getUserName()) : __('nav_account'); ?>
                    </a>
                </li>
                <!-- Añadir selector de idioma -->
                <li>
                    <?php include __DIR__ . '/language-switcher.php'; ?>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Modal de navegación lateral -->
<div id="sidebar-modal" class="sidebar-modal">
    <div class="sidebar-content">
        <div class="sidebar-header">
            <h2><?php echo __('nav_menu'); ?></h2>
            <button id="close-sidebar" class="close-sidebar" aria-label="Cerrar menú">&times;</button>
        </div>
        <div class="sidebar-body">
            <ul class="sidebar-menu">
                <li class="sidebar-menu-item">
                    <a href="/Akihabara-Dreams/" class="sidebar-link">
                        <span class="sidebar-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-home">
                                <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                        </span>
                        <span><?php echo __('nav_home'); ?></span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="/Akihabara-Dreams/myaccount" class="sidebar-link">
                        <span class="sidebar-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user">
                                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </span>
                        <span><?php echo __('nav_account'); ?></span>
                    </a>
                </li>

                <div class="sidebar-category"><?php echo __('home_featured'); ?></div>

                <li class="sidebar-menu-item">
                    <a href="/Akihabara-Dreams/catalog" class="sidebar-link">
                        <span class="sidebar-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layout-grid">
                                <rect width="7" height="7" x="3" y="3" rx="1"></rect>
                                <rect width="7" height="7" x="14" y="3" rx="1"></rect>
                                <rect width="7" height="7" x="14" y="14" rx="1"></rect>
                                <rect width="7" height="7" x="3" y="14" rx="1"></rect>
                            </svg>
                        </span>
                        <span><?php echo __('nav_catalog'); ?></span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="/Akihabara-Dreams/mangas" class="sidebar-link">
                        <span class="sidebar-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-book-open">
                                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                                <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                            </svg>
                        </span>
                        <span><?php echo __('nav_mangas'); ?></span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="/Akihabara-Dreams/figures" class="sidebar-link">
                        <span class="sidebar-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trophy">
                                <path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path>
                                <path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"></path>
                                <path d="M4 22h16"></path>
                                <path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22"></path>
                                <path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22"></path>
                                <path d="M18 2H6v7a6 6 0 0 0 12 0V2Z"></path>
                            </svg>
                        </span>
                        <span><?php echo __('nav_figures'); ?></span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="/Akihabara-Dreams/merchandising" class="sidebar-link">
                        <span class="sidebar-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shirt">
                                <path d="M20.38 3.46 16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.47a1 1 0 0 0 .99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.47a2 2 0 0 0-1.34-2.23z"></path>
                            </svg>
                        </span>
                        <span><?php echo __('nav_merch'); ?></span>
                    </a>
                </li>

                <div class="sidebar-category"><?php echo __('nav_cart'); ?></div>

                <li class="sidebar-menu-item">
                    <a href="/Akihabara-Dreams/orders/realizar" class="sidebar-link">
                        <span class="sidebar-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-cart">
                                <circle cx="8" cy="21" r="1"></circle>
                                <circle cx="19" cy="21" r="1"></circle>
                                <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path>
                            </svg>
                        </span>
                        <span><?php echo __('nav_cart'); ?></span>
                    </a>
                </li>
                <div class="sidebar-category"><?php echo __('footer_contact'); ?></div>

                <li class="sidebar-menu-item">
                    <a href="/Akihabara-Dreams/contacto" class="sidebar-link">
                        <span class="sidebar-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mail">
                                <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                            </svg>
                        </span>
                        <span><?php echo __('nav_contact'); ?></span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="sidebar-footer">
            <?php if (!isset($_SESSION['usuario'])): ?>
                <a href="/Akihabara-Dreams/login" class="sidebar-footer-button"><?php echo __('nav_login'); ?></a>
                <p class="sidebar-footer-text"><?php echo __('nav_no_account'); ?> <a href="/Akihabara-Dreams/login" style="color: var(--primary-color);"><?php echo __('nav_register'); ?></a></p>
            <?php else: ?>
                <a href="/Akihabara-Dreams/logout" class="sidebar-footer-button"><?php echo __('nav_logout'); ?></a>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Overlay para oscurecer el fondo cuando el modal está abierto -->
<div id="overlay" class="overlay"></div>

<!-- Notificación de producto añadido al carrito -->
<div class="cart-notification" id="cart-notification"></div>