<nav class="navbar">
    <div class="navbar-container">
        <div>
            <button id="menu-toggle" class="menu-button" aria-label="Abrir menú">
                <img src="/Akihabara-Dreams/resources/images/commons/menu.png" alt="menu">
            </button>
        </div>
        <div class="navbar-logo-div">
            <a href="/Akihabara-Dreams/"><img src="/Akihabara-Dreams/resources/images/commons/logo-AD-3.png" alt="logo" class="img-logo"></a>
        </div>
        <div>
            <ul class="navbar-menu">
                <?php if (isset($_SESSION['usuario']) && $_SESSION['usuario'] == 'admin') {
                    echo "<li><a href='/Akihabara-Dreams/admin' class='navbar-link'>Administración</a></li>";
                } 
                ?>
                <li>
                    <a href="#" class="navbar-link search-link">
                        <img src="/Akihabara-Dreams/resources/images/commons/search.png" alt="Buscar" width="24" height="24">
                    </a>
                </li>
                <li><a href="/Akihabara-Dreams/catalogo" class="navbar-link">Catálogo</a></li>
                <li><a class="navbar-link" id="carrito">Carrito</a></li>
                <li>
                    <a href="/Akihabara-Dreams/micuenta" class="navbar-link"><?php echo isset($_SESSION['usuario']) ? htmlspecialchars(unserialize($_SESSION['usuario'])->getUserName()) : 'Cuenta'; ?></a>
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
                    <a href="/Akihabara-Dreams/" class="sidebar-link">
                        <span>INICIO</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="/Akihabara-Dreams/micuenta" class="sidebar-link">
                        <span>MI CUENTA</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="/Akihabara-Dreams/mangas" class="sidebar-link">
                        <span>MANGAS</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="/Akihabara-Dreams/figuras" class="sidebar-link">
                        <span>FIGURAS</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="/Akihabara-Dreams/merchandising" class="sidebar-link">
                        <span>MERCHANDISING</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="/Akihabara-Dreams/carrito" class="sidebar-link">
                        <span>CARRITO</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="/Akihabara-Dreams/promociones" class="sidebar-link">
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
                        <a href="/Akihabara-Dreams/logout.php" class="sidebar-link">
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
<div class="cart-notification" id="cart-notification"></div>