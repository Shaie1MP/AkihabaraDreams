<nav class="navbar">
    <div class="navbar-container">
        <div>
            <button id="menu-toggle" class="menu-button" aria-label="Abrir menú">
                <img src="/Akihabara-Dreams/resources/images/commons/menu.png" alt="menu">
            </button>
        </div>
        <div class="navbar-logo-div">
            <a href="/Akihabara-Dreams/src/"><img src="/Akihabara-Dreams/resources/images/commons/logo-AD-3.png" alt="logo" class="img-logo"></a>
        </div>
        <div>
            <ul class="navbar-menu">
                <li>
                    <a href="#" class="navbar-link search-link">
                        <img src="/Akihabara-Dreams/resources/images/commons/search.png" alt="Buscar" width="24" height="24">
                    </a>
                </li>
                <li>
                    <div class="cart-icon-container" id="cart-icon-container">
                        <img src="/Akihabara-Dreams/resources/images/commons/cart.png" alt="Carrito" class="cart-icon" width="24" height="24">
                        <span class="cart-count" id="cart-count">0</span>
                        
                        <!-- Mini carrito desplegable -->
                        <div class="mini-cart" id="mini-cart">
                            <div class="mini-cart-header">
                                <h3 class="mini-cart-title">Tu Carrito</h3>
                                <button class="mini-cart-close" id="mini-cart-close">&times;</button>
                            </div>
                            <div class="mini-cart-items" id="mini-cart-items">
                                <!-- Los items del carrito se cargarán dinámicamente con JavaScript -->
                            </div>
                            <div class="mini-cart-footer">
                                <div class="mini-cart-total">
                                    <span>Total:</span>
                                    <span id="mini-cart-total">€0.00</span>
                                </div>
                                <div class="mini-cart-buttons">
                                    <a href="/Akihabara-Dreams/src/views/cart.php" class="mini-cart-button view">Ver Carrito</a>
                                    <a href="/Akihabara-Dreams/src/views/checkout.php" class="mini-cart-button checkout">Pagar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <a href="/Akihabara-Dreams/src/views/myAccount.php" class="navbar-link">
                        <?php echo isset($_SESSION['user']) ? htmlspecialchars(unserialize($_SESSION['user'])->getUsername()) : 'Cuenta'; ?>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Modal de navegación lateral -->
<div id="sidebar-modal" class="sidebar-modal">
    <div class="sidebar-content">
        <div class="sidebar-header">
            <h2>MENU</h2>
            <button id="close-sidebar" class="close-sidebar" aria-label="Cerrar menú">&times;</button>
        </div>
        <div class="sidebar-body">
            <ul class="sidebar-menu">
                <li class="sidebar-menu-item">
                    <a href="/Akihabara-Dreams/src/" class="sidebar-link">
                        <span>INICIO</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="/Akihabara-Dreams/src/views/myAccount.php" class="sidebar-link">
                        <span>MI CUENTA</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="/Akihabara-Dreams/src/views/mangas.php" class="sidebar-link">
                        <span>MANGAS</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="/Akihabara-Dreams/src/views/figuras.php" class="sidebar-link">
                        <span>FIGURAS</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="/Akihabara-Dreams/src/views/merchandising.php" class="sidebar-link">
                        <span>MERCHANDISING</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="/Akihabara-Dreams/src/views/cart.php" class="sidebar-link">
                        <span>CARRITO</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="/Akihabara-Dreams/src/views/promociones.php" class="sidebar-link">
                        <span>PROMOCIONES</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="/Akihabara-Dreams/contacto" class="sidebar-link">
                        <span>CONTACTO</span>
                    </a>
                </li>
                <?php if (isset($_SESSION['user'])): ?>
                <li class="sidebar-menu-item">
                    <a href="/Akihabara-Dreams/src/controllers/logout.php" class="sidebar-link">
                        <span>CERRAR SESIÓN</span>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>

<!-- Overlay para oscurecer el fondo cuando el modal está abierto -->
<div id="overlay" class="overlay"></div>

<!-- Notificación de producto añadido al carrito -->
<div class="cart-notification" id="cart-notification">
    <span class="cart-notification-icon">✓</span>
    <span class="cart-notification-message">Producto añadido al carrito</span>
</div>

<!-- Incluir el CSS del carrito -->
<link rel="stylesheet" href="/Akihabara-Dreams/resources/css/cart.css">

